<?php

namespace App\Http\Livewire\Strategy;

use App\Models\Measure\Calendar;
use App\Models\Measure\Period;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use Illuminate\Support\Collection;
use Livewire\Component;

class ReportIndicatorsStrategy extends Component
{
    public array $selectedObjectives = [];
    public array $selectedPrograms = [];
    public array $selectedPlans = [];
    public ?Collection $listOfObjectives = null;
    public $search = '';

    protected $listeners = ['period-changed' => 'render'];

    public function updatedSelectedPlans()
    {
        $planRegistered = PlanRegisteredTemplateDetails::with(['planDetails'])->whereIn('plan_id', $this->selectedPlans)
            ->where('indicators', true)->pluck('id');
        $this->listOfObjectives = PlanDetail::whereIn('plan_registered_template_detail_id', $planRegistered)->get();
    }

    public function filter()
    {
        $this->emit('toggleDropDownFilter');
    }

    public function cleanFilter($type)
    {
        $this->reset([
            'selectedPlans',
            'selectedObjectives',
        ]);
        $this->filter();
    }

    public function render()
    {
        $search = $this->search;
        $selectedObjectives = $this->selectedObjectives;
        $plans = Plan::with(['planDetails.measures.unit',
            'planDetails' => function ($q) use ($selectedObjectives) {
                $q->when($selectedObjectives, function ($query) use ($selectedObjectives) {
                    $query->whereIn('plan_details.id', $selectedObjectives);
                });
            },
            'planDetails.measures' => function ($q) use ($search) {
                $q->when($search != '', function ($q) use ($search) {
                    $q->where('msr_measures.name', 'iLIKE', '%' . $search . '%');
                });

            }])->when($this->selectedPlans, function ($q) {
            $q->whereIn('id', $this->selectedPlans);
        })->Incompany()->get();

        $count = $plans->pluck('planDetails')->collapse()->pluck('measures')->collapse()->count();

        $count > 0 ? $existIndicators = true : $existIndicators = false;
        return view('livewire.strategy.report-indicators-strategy',
            [
                'plans' => $plans,
                'existIndicators' => $existIndicators,
                'periodId' => self::periodId(),
            ]);
    }

    private function periodId()
    {
        if (session()->exists('periodId') && session('periodId') != null) {
            return session('periodId');
        } else {
            $period = Period::where([
                ['start_date', '<=', now()->format('Y-m-d')],
                ['end_date', '>=', now()->format('Y-m-d')],
            ])->whereRelation('calendar', 'frequency', Calendar::FREQUENCY_MONTHLY)->first();
            session(['periodId' => $period->id]);
            return $period->id;
        }
    }

}
