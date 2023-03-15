<?php

namespace App\Http\Livewire\Poa\Reschedulings;

use App\Models\Auth\User;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaRescheduling;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectRescheduling;
use App\Traits\Jobs;
use Livewire\Component;
use function view;

class PoaApproveRescheduling extends Component
{
    use Jobs;

    public $description;
    public $state;
    public $phase;
    public $status;
    public $approvedId;
    public $poa;
    public $rescheduling;
    protected $listeners = ['openApproveRescheduling'];

    public function openApproveRescheduling(int $id)
    {
        $this->rescheduling = PoaRescheduling::find($id);
        $this->description = $this->rescheduling->description;
        $this->state = $this->rescheduling->state;
        $this->phase = $this->rescheduling->phase;
        $this->poa = $this->rescheduling->poa;
    }

    public function render()
    {
        return view('livewire.poa.reschedulings.poa-approve-rescheduling');
    }

    public function approve()
    {
        $this->poa->phase = $this->phase;
        if ($this->state) {
            $this->poa->status = $this->state;
        }
        $this->rescheduling->status = PoaRescheduling::STATUS_APPROVED;
        $this->rescheduling->approved_id = user()->id;
        $this->rescheduling->save();
        $this->poa->save();
        flash('Aprobado satisfactoriamente')->success();
        return redirect()->route('poa.rescheduling', $this->poa->id);
    }

    public function resetForm()
    {
        $this->rescheduling->approved_id = null;
    }
}
