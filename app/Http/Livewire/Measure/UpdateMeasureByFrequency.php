<?php

namespace App\Http\Livewire\Measure;

use App\Abstracts\TableComponent;
use App\Models\Measure\Measure;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use App\Models\Strategy\PlanTemplate;
use App\Traits\Jobs;
use Livewire\Component;

class UpdateMeasureByFrequency extends TableComponent
{
    use  Jobs;

    public $search = '';
    public $planDetailsIds;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => ''],
        'sortDirection' => ['except' => '']
    ];

    public function mount()
    {
        $plan = Plan::type(PlanTemplate::PLAN_STRATEGY_CRE)->first();
        $this->planDetailsIds = PlanDetail::where('plan_id', $plan->id)->pluck('id');

    }

    public function render()
    {
        $measures = Measure::with(['scores','indicatorable'])->where('indicatorable_type', PlanDetail::class)
            ->whereIn('indicatorable_id', $this->planDetailsIds)
            ->when($this->sortField, function ($q) {
                $q->orderBy($this->sortField, $this->sortDirection);
            })->when($this->search, function ($query) {
                $query->where('code', 'iLIKE', '%' . $this->search . '%')
                    ->orWhere('name', 'iLIKE', '%' . $this->search . '%');
            })->orderBy('id')
            ->paginate(setting('default.list_limit', '25'));

        return view('livewire.measure.update-measure-by-frequency',compact('measures'));
    }
}
