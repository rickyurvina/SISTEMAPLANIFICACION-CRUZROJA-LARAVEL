<?php

namespace App\Http\Livewire\Poa\Reschedulings;

use App\Models\Auth\User;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaRescheduling;
use App\Traits\Jobs;
use Livewire\Component;
use function view;

class PoaCreateRescheduling extends Component
{
    use Jobs;

    public $description;
    public $state;
    public $phase;
    public $status;
    public $approvedId;
    public $poa;
    public $arrayStates = array();

    public function mount($poaId)
    {
        $this->poa = Poa::find($poaId);
    }

    public function render()
    {
        return view('livewire.poa.reschedulings.poa-create-rescheduling');
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

    public function create()
    {
        $data = $this->validate([
            'description' => 'required',
            'phase' => 'required',
            'state' => 'required_if:phase,==,PLANIFICACIÓN',
        ]);
        $data += [
            'phase' => $this->phase,
            'state' => $this->state,
            'status' => PoaRescheduling::STATUS_OPENED,
            'poa_id' => $this->poa->id,
            'user_id' => user()->id,
        ];
        $response = $this->ajaxDispatch(new \App\Jobs\Poa\PoaCreateRescheduling($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 1, ['type' => trans('general.rescheduling')]))->success();
        } else {
            flash($response['message'])->error();
        }
        return redirect()->route('poa.rescheduling', $this->poa->id);
    }

    public function updatedPhase()
    {
        $rss = array();
        switch ($this->phase) {
            case Poa::PHASE_PLANNING:
                $rss = Poa::STATUSES_PHASE_PLANNING;
                break;
            case Poa::PHASE_EXECUTION || Poa::PHASE_CLOSED:
                $this->reset(['state']);
                break;
        }
        $this->arrayStates = $rss;
    }
}
