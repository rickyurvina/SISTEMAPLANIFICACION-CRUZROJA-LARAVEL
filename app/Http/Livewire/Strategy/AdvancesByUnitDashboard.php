<?php

namespace App\Http\Livewire\Strategy;

use App\Models\Indicators\Units\IndicatorUnits;
use App\Models\Measure\Measure;
use App\Models\Measure\MeasureAdvances;
use App\Models\Measure\Period;
use App\Models\Measure\ScoringType;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdvancesByUnitDashboard extends Component
{
    public $resultsByUnit = [];

    protected $listeners = ['period-changed' => 'mount'];

    public function mount(int $periodId)
    {

        if ($periodId) {
            $period = Period::find($periodId);
            $periods = Period::query()->with(
                [
                    'measureAdvances.measurable'
                ])
                ->orderBy('start_date', 'desc')
                ->whereDate('start_date', '>=', $period->start_date)
                ->whereDate('end_date', '<=', $period->end_date)
                ->get();
            $measureAdvances = MeasureAdvances::whereIn('period_id', $periods->pluck('id'))
                ->get()->groupBy('unit_id');
            $indicatorUnits = IndicatorUnits::get();
            foreach ($indicatorUnits as $unit) {
                $this->resultsByUnit[$unit->abbreviation]['goal'] = 0;
                $this->resultsByUnit[$unit->abbreviation]['actual'] = 0;
                $this->resultsByUnit[$unit->abbreviation]['progress'] = 0;
            }

            $plan = Plan::with(['planDetails'])->type(Plan::TYPE_STRATEGY)->active()->first();
            $tree = PlanDetail::where('plan_id', $plan->id)->pluck('id');
            $measuresPlan = Measure::with(
                [
                    'scoringType',
                    'scores'
                ])
                ->whereIn('indicatorable_id', $tree)
                ->where('indicatorable_type', PlanDetail::class)
                ->get();
            $measureGroupByScoringType = $measuresPlan->groupBy('scoring_type_id');

            foreach ($measureGroupByScoringType as $index => $measures) {
                $measuresGroupByUnit = $measures->groupBy('unit_id');
                $scoreType = ScoringType::find($index);
                $indexGoal = collect($scoreType->config)->where('label', 'Meta')->keys()->first();
                foreach ($measuresGroupByUnit as $unit_ => $measureUnit) {
                    $scores = $measureUnit->pluck('scores')->collapse()
                        ->whereIn('period_id', $periods->pluck('id')
                            ->toArray());
                    $thresholds = $scores->pluck('thresholds');
                    $unit = $indicatorUnits->find($unit_);
                    $this->resultsByUnit[$unit->abbreviation]['goal'] = array_sum(array_column($thresholds->toArray(), $indexGoal));
                }
            }

            foreach ($measureAdvances as $index => $unitIdGroup) {
                $unit = $indicatorUnits->find($index);
                $this->resultsByUnit[$unit->abbreviation]['actual'] = $unitIdGroup->sum('actual');
                $progress = 0;
                if ($this->resultsByUnit[$unit->abbreviation]['goal'] > 0) {
                    $progress = $this->resultsByUnit[$unit->abbreviation]['actual'] / $this->resultsByUnit[$unit->abbreviation]['goal'] * 100;
                    $this->resultsByUnit[$unit->abbreviation]['progress'] = number_format(floatval($progress), 0);
                }
            }
        }

    }

    public function render()
    {
        return view('livewire.strategy.advances-by-unit-dashboard');
    }
}
