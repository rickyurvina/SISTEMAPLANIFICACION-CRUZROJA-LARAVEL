<?php

namespace App\Http\Livewire\Projects\CRUD;

use App\Http\Livewire\Components\Modal;
use App\Models\Common\Catalog;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectMemberSubsidiary;
use App\Models\Projects\ProjectReferentialBudget;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use App\Models\Strategy\PlanTemplate;

class CreateProject extends Modal
{

    public string $name = '';

    public $type;

    public array $projectTypes;

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'type' => 'required',
    ];

    public function mount()
    {
        $this->projectTypes = config('constants.catalog.PROJECT_TYPES');
        $this->type = array_key_first($this->projectTypes);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $this->validate();

        $cantidad = Project::all()->count();

        $phase = '';

        switch ($this->type) {
            case($this->type == Project::TYPE_MISSIONARY_PROJECT || $this->type == Project::TYPE_EMERGENCY):
                $phase = Project::PHASE_START_UP;
                break;
            case ($this->type == Project::TYPE_INTERNAL_DEVELOPMENT || $this->type == Project::TYPE_INVESTMENT):
                $phase = Project::PHASE_PLANNING;
                break;
        }

        Project::create([
            'name' => $this->name,
            'type' => $this->type,
            'code' => str_pad($cantidad + 1, 5, "0", STR_PAD_LEFT),
            'status' => Project::STATE_IN_PROCESS,
            'state' => Project::STATE_DRAFT,
            'phase' => $phase,
            'company_id' => session('company_id'),
            'year' => now()->year,
        ]);

        $this->emit('project-created');
        $this->name = '';
        flash(trans_choice('general.project', 1) . ' ' . trans('general.created'))->success()->livewire($this);
        $this->type = array_key_first($this->projectTypes);
        $this->show = false;
    }

    public function render()
    {
        $this->dispatchBrowserEvent('loadTypes');
        return view('livewire.projects.crud.create-project');
    }
}
