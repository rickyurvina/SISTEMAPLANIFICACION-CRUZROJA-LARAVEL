<?php

namespace App\Http\Livewire\Process\PlanChanges\ChangesActivities;

use App\Models\Process\ChangesActivities;
use Livewire\Component;

class EditChangesActivities extends Component
{
    public $changeActivity;

    protected $listeners = ['openEditActivity'];

    public function render()
    {
        return view('livewire.process.planChanges.changesActivities.edit-changes-activities');
    }
    public function openEditActivity($id)
    {
        $this->changeActivity = ChangesActivities::find($id);
    }
    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
