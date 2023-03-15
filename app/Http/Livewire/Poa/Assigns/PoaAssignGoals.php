<?php

namespace App\Http\Livewire\Poa\Assigns;

use App\Models\Indicators\Indicator\Indicator;
use App\Models\Poa\PoaProgram as Program;
use App\Traits\Jobs;
use Livewire\Component;
use function view;

class PoaAssignGoals extends Component
{
    use Jobs;
    protected $listeners = ['loadProgram'];

    public $goals = [];

    public $elementos = [];

    public ?Program $program = null;

    public $poa;
    public $poaActivityId;

    public function loadProgram($programId)
    {
        $this->program = Program::with(
            [
                'poaActivities.measure.unit',
                'poaActivities.measureAdvances',
                'poa'
            ])->find($programId);
        $this->poa = $this->program->poa;
        $poaActivities = $this->program->poaActivities;

        foreach ($poaActivities as $poaActivity) {
            $key = $poaActivity->measure->name;
            $icon = $poaActivity->measure->unit->getIcon();
            $key2 = $poaActivity->name;
            $count = 1;
            foreach ($poaActivity->measureAdvances as $goalPoaActivity) {
                $element = [];
                $element['id'] = $goalPoaActivity->id;
                $element['year'] =  $this->program->poa->year;
                $element['monthName'] = Indicator::FREQUENCIES[12][$count];
                $element['goal'] = $goalPoaActivity->goal;
                $element['icon'] = $icon;
                if ($goalPoaActivity->goal > 0) {
                    $this->goals[$goalPoaActivity->id] = ['goal' => $goalPoaActivity->goal];
                }
                if (!array_key_exists($key, $this->elementos)) {
                    $this->elementos[$key][$key2][] = $element;
                } else {
                    $this->elementos[$key][$key2][] = $element;
                }
                $count++;
            }
        }
    }

    public function render()
    {
        return view('livewire.poa.assigns.poa-assign-goals');
    }

    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->goals = [];
        $this->elementos = [];
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
