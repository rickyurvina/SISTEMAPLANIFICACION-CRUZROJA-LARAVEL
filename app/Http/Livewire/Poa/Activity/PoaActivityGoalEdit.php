<?php

namespace App\Http\Livewire\Poa\Activity;

use App\Jobs\Poa\UpdatePoaActivityGoal;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Poa\Poa;
use App\Traits\Jobs;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PoaActivityGoalEdit extends Component
{
    use Jobs;

    public $activityId = null;
    public $goals = [];
    public $activity;
    public $indicatorUnit;
    public $readOnlyGoal = false;
    public $readOnlyProgress = false;

    public function rules()
    {
        return
            [
                'goals.*.goals' => 'nullable|numeric|min:0',
                'goals.*.actual' => 'nullable|numeric|min:0',
                'goals.*.men' => 'nullable|numeric|min:0',
                'goals.*.women' => 'nullable|numeric|min:0',
            ];
    }

    public function mount($activity, $readOnly = false)
    {
        if ($activity->program->poa->phase->isActive(\App\States\Poa\Planning::class)) {
            $this->readOnlyProgress = true;
        } else {
            $this->readOnlyGoal = true;
        }
        if ($activity->program->poa->isClosed()) {
            $this->readOnlyGoal = true;
            $this->readOnlyProgress = true;
        }
        $this->goals = [];
        $this->activityId = $activity->id;
        $poaActivityDetails = $activity->measureAdvances;
        $count = 1;
        $this->indicatorUnit = $activity->measure->unit;
        foreach ($poaActivityDetails as $poaActivityDetail) {
            if ($count<=12){
                $element = [];
                $element['id'] = $poaActivityDetail->id;
                $element['year'] = now()->format('Y');
                $element['monthName'] = Indicator::FREQUENCIES[12][$count];
                $element['goal'] = $poaActivityDetail->goal;
                $element['actual'] = $poaActivityDetail->actual;
                $element['men'] = $poaActivityDetail->men;
                $element['women'] = $poaActivityDetail->women;
                array_push($this->goals, $element);
                $count++;
            }
        }
    }

    /**
     * @return float|int
     */
    public function getTotalProperty(): float|int
    {
        return array_sum(array_column($this->goals, 'goal'));
    }

    /**
     * @return float|int
     */
    public function getProgressProperty(): float|int
    {
        if ($this->indicatorUnit->is_for_people === true) {
            return array_sum(array_column($this->goals, 'men')) + array_sum(array_column($this->goals, 'women'));
        } else {
            return array_sum(array_column($this->goals, 'actual'));
        }
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('livewire.poa.activity.poa-activity-goal-edit');
    }

    /**
     * Update Activity indicator goals
     */
    public function submitGoals()
    {
        $this->validate();
        $response = $this->ajaxDispatch(new UpdatePoaActivityGoal($this->activityId, $this->goals));
        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 1, ['type' => __('general.poa_activity_goal')]))->success()->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

    public function updatedGoals()
    {
        foreach ($this->goals as $index => $item) {
            $goal = (float)$item['goal'];
            $progress = (float)$item['actual'];
            $men = (float)$item['men'];
            $women = (float)$item['women'];
            if ($goal < 0) {
                $newItem = ['goal' => ''];
                $item = array_replace($item, $newItem);
                $this->goals[$index] = $item;
                flash('Solo se aceptan valores positivos')->warning()->livewire($this);
            }
            if ($men < 0) {
                $newItem = ['men' => ''];
                $item = array_replace($item, $newItem);
                $this->goals[$index] = $item;
                flash('Solo se aceptan valores positivos')->warning()->livewire($this);
            }
            if ($women < 0) {
                $newItem = ['women' => ''];
                $item = array_replace($item, $newItem);
                $this->goals[$index] = $item;
                flash('Solo se aceptan valores positivos')->warning()->livewire($this);
            }

            if ($progress < 0) {
                $newItem = ['actual' => ''];
                $item = array_replace($item, $newItem);
                $this->goals[$index] = $item;
                flash('Solo se aceptan valores positivos')->warning()->livewire($this);
            }
        }
    }
}
