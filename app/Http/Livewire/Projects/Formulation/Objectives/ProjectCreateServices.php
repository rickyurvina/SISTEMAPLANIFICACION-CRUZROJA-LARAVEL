<?php

namespace App\Http\Livewire\Projects\Formulation\Objectives;

use App\Abstracts\TableComponent;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Catalogs\ProjectLineAction;
use Livewire\WithPagination;

class ProjectCreateServices extends TableComponent
{

    use WithPagination;

    public $resultId = null;
    public $result = null;
    public $project_services = null;
    public $servicesSelect = [];
    public $existing_services = [];
    public array $auxServices = [];

    protected $listeners = ['loadServices'];

    public function loadServices($id)
    {
        $this->resultId = $id;
        $this->result = Task::find($id);
        if ($this->result) {
            if (isset($this->result->services)) {
                $this->existing_services = $this->result->services->pluck('id');
                $this->auxServices = array();
                foreach ($this->existing_services as $index => $ind) {
                    $this->auxServices[$index] = $ind;
                }
            }
        }
        $this->dispatchBrowserEvent('updateSelector');
    }

    public function render()
    {
        $linesAction = ProjectLineAction::with('services')->get();
        return view('livewire.projects.formulation.objectives.project-create-services', compact('linesAction'));
    }

    public function updatedServicesSelect()
    {
        $this->result->services()->sync($this->servicesSelect);
        flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.project', 1)]))->success()->livewire($this);
        $this->emit('servicesCreated');
        $this->result->refresh();
    }

    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->resultId = null;
        $this->result = null;
        $this->project_services = null;
        $this->servicesSelect = [];
        $this->existing_services = [];
        $this->auxServices = [];
    }

}
