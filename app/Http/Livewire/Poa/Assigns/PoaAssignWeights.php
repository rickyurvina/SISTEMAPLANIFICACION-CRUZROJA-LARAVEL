<?php

namespace App\Http\Livewire\Poa\Assigns;

use App\Models\Poa\Poa;
use Exception;
use Illuminate\Support\Collection;
use Livewire\Component;
use function __;
use function flash;
use function view;

class PoaAssignWeights extends Component
{
    public $sumWeights = null;
    public $poa;
    public ?Collection $programs = null;
    public array $weights = [];

    protected $listeners = ['loadPrograms', 'renderWeights' => 'loadPrograms'];

    public function loadPrograms($id)
    {
        $this->poa = Poa::with('programs')->find($id);
        $this->programs = $this->poa->programs;
        $this->sumWeights = 0;
        $this->weights = [];
        foreach ($this->programs as $program) {
            $this->weights[] = number_format($program->weight, 2) ;
            $this->sumWeights += $program->weight;
        }
        $this->sumWeights = round($this->sumWeights, 2);
    }

    public function submitAssign()
    {
        try {
            foreach ($this->programs as $index => $program) {
                $program->weight = $this->weights[$index];
                $program->save();
            }
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.assign_weights', 0)]))->success()->livewire($this);
            $this->resetForm();
            $this->emit('toggleAssignWeight');
        } catch (Exception $e) {
            flash($e->getMessage())->error()->livewire($this);
        }
    }

    public function updatedWeights()
    {
        $this->sumWeights = 0;
        foreach ($this->weights as $weight) {
            $this->sumWeights += $weight > 0 ? $weight : 0;
        }
        $this->sumWeights = round($this->sumWeights, 2);
    }

    public function render()
    {
        return view('livewire.poa.assigns.poa-assign-weights', [
            'programs' => $this->programs
        ]);
    }

    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
