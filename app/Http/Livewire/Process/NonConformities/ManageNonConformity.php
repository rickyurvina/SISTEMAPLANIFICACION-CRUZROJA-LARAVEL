<?php

namespace App\Http\Livewire\Process\NonConformities;

use App\Models\Process\NonConformities;
use Livewire\Component;
use function view;

class ManageNonConformity extends Component
{
    public $nonConformity;
    public $closingVerification;
    public $efficiencyVerification;
    public $state;
    public $stateWillClosed;

    protected $listeners = ['openManage'];

    public function render()
    {
        return view('livewire.process.non-conformities.manage-non-conformity');
    }

    public function openManage(int $id)
    {
        $this->nonConformity = NonConformities::find($id);
        $this->closingVerification = $this->nonConformity->closing_verification;
        $this->efficiencyVerification = $this->nonConformity->efficiency_verification;
        $state = $this->nonConformity->state;
        if ($state == NonConformities::TYPE_OPEN) {
            $this->state = false;
        } else if (NonConformities::TYPE_WILL_CLOSED) {
            $this->stateWillClosed = true;
        } else {
            $this->state = true;
        }
    }

    public function closeModal()
    {
        $this->reset(
            [
                'nonConformity',
                'closingVerification',
                'efficiencyVerification',
            ]);
    }

    public function updatedClosingVerification()
    {
        $this->nonConformity->closing_verification = $this->closingVerification;
        $this->nonConformity->verification_close_date = $this->nonConformity->closing_verification == true ? now() : NULL;
        $this->nonConformity->save();
    }

    public function updatedEfficiencyVerification()
    {
        $this->nonConformity->efficiency_verification = $this->efficiencyVerification;
        $this->nonConformity->verification_effectiveness_date = $this->nonConformity->efficiency_verification == true ? now() : NULL;
        $this->nonConformity->save();
    }

    public function updatedState()
    {
        if ($this->state == false) {
            $state = NonConformities::TYPE_OPEN;
        } else {
            $state = NonConformities::TYPE_CLOSED;
            $this->stateWillClosed = false;
        }
        $this->nonConformity->state = $state;
        $this->nonConformity->save();
    }

    public function updatedStateWillClosed()
    {
        if ($this->stateWillClosed == false) {
            $state = NonConformities::TYPE_OPEN;
        } else {
            $state = NonConformities::TYPE_WILL_CLOSED;
        }
        $this->nonConformity->state = $state;
        $this->nonConformity->save();
    }
}
