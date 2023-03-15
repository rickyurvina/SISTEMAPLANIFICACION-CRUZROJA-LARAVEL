<?php

namespace App\Http\Livewire\Poa\Reschedulings;

use App\Models\Poa\Poa;
use App\Models\Poa\PoaRescheduling;
use App\Traits\Jobs;
use Livewire\Component;
use function view;

class PoaEditRescheduling extends Component
{
    use Jobs;

    public $description;
    public $state;
    public $phase;
    public $status;
    public $approvedId;
    public $rescheduling;
    public $arrayStates = array();
    protected $listeners = ['openEditRescheduling'];

    public function openEditRescheduling(int $id)
    {
        $this->rescheduling = PoaRescheduling::find($id);
        $this->description = $this->rescheduling->description;
        $this->state = $this->rescheduling->state;
        $this->phase = $this->rescheduling->phase;
        $this->updatedPhase();
    }

    public function render()
    {
        return view('livewire.poa.reschedulings.poa-edit-rescheduling');
    }

    public function resetForm()
    {
        $this->reset([
            'description',
            'state',
            'phase',
            'status',
        ]);
    }

    public function edit()
    {
        $data = $this->validate([
            'description' => 'required',
            'phase' => 'required',
            'state' => 'required_if:phase,==,PLANIFICACIÓN',
        ]);
        $data += [
            'id' => $this->rescheduling->id,
            'phase' => $this->phase,
            'state' => $this->state,
            'status' => PoaRescheduling::STATUS_OPENED,
        ];
        $response = $this->ajaxDispatch(new \App\Jobs\Poa\PoaEditRescheduling($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.rescheduling', 0)]))->success();
        } else {
            flash(trans_choice('messages.error', 1, $response['message']))->error();
        }
        return redirect()->route('poa.rescheduling', $this->rescheduling->poa_id);

    }


    public function updatedPhase()
    {
        $rss = array();
        switch ($this->phase) {
            case Poa::PHASE_PLANNING:
                $rss = Poa::STATUSES_PHASE_PLANNING;
                break;
            case Poa::PHASE_EXECUTION:
                $this->reset(['state']);
                break;
        }
        $this->arrayStates = $rss;
    }
}
