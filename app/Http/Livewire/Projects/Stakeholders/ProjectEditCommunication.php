<?php

namespace App\Http\Livewire\Projects\Stakeholders;

use App\Models\Projects\Project;
use App\Models\Projects\Stakeholders\ProjectCommunicationMatrix;
use App\Traits\Jobs;
use App\Traits\Uploads;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectEditCommunication extends Component
{
    use WithFileUploads, Jobs, Uploads;

    public $project;

    public $start_date = null;
    public $end_date = null;
    public $frequency = null;
    public $color = null;
    public $information_type = null;
    public $format_information_presentation = null;
    public $user_id = null;
    public $prj_project_stakeholder_id = null;

    public $users;
    public $stakeholders;
    public $projectCommunication;

    protected $listeners = ['open'];

    protected $rules =
        [
            'start_date' => 'required',
            'end_date' => 'required|after:start_date',
            'information_type' => 'required',
            'format_information_presentation' => 'required',
            'user_id' => 'required',
            'prj_project_stakeholder_id' => 'required',
        ];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->users = $project->members;
        $this->stakeholders = $project->stakeholders;
    }

    public function render()
    {
        return view('livewire.projects.stakeholders.project-edit-communication');
    }

    public function open($id)
    {
        $this->projectCommunication = ProjectCommunicationMatrix::find($id);
        $this->start_date = $this->projectCommunication->start_date;
        $this->end_date = $this->projectCommunication->end_date;
        $this->color = $this->projectCommunication->color;
        $this->information_type = $this->projectCommunication->information_type;
        $this->format_information_presentation = $this->projectCommunication->format_information_presentation;
        $this->user_id = $this->projectCommunication->user_id;
        $this->prj_project_stakeholder_id = $this->projectCommunication->prj_project_stakeholder_id;
    }

    public function save()
    {
        $this->validate();

        $data =
            [
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'state' => ProjectCommunicationMatrix::NO_DELIVERED,
                'color' => config('constants.catalog.COLOR_PALETTE')[array_rand(config('constants.catalog.COLOR_PALETTE'), 1)],
                'information_type' => $this->information_type,
                'format_information_presentation' => $this->format_information_presentation,
                'user_id' => $this->user_id,
                'prj_project_stakeholder_id' => $this->prj_project_stakeholder_id,
            ];

        $response = $this->ajaxDispatch(new \App\Jobs\Projects\ProjectEditCommunication($this->projectCommunication->id,$data));

        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 1, ['type' => trans_choice('general.communication', 0)]))->success();
        } else {
            flash($response['message'])->error()->livewire($this);

        }
        return redirect()->route('projects.communication', $this->project);

    }

    public function resetForm()
    {
        $this->reset([
            'start_date',
            'end_date',
            'frequency',
            'information_type',
            'format_information_presentation',
            'user_id',
            'prj_project_stakeholder_id',
        ]);
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->emit('toggleProjectCreateCommunication');
    }
}
