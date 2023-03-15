<?php

namespace App\Http\Livewire\Projects\Reschedulings;

use App\Models\Auth\User;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectRescheduling;
use App\Traits\Jobs;
use Livewire\Component;

class ProjectCreateRescheduling extends Component
{
    use Jobs;

    public $description;
    public $state;
    public $phase;
    public $status;
    public $approvedId;
    public $project;
    public $arrayStates = array();

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.projects.reschedulings.project-create-rescheduling');
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
            'state' => 'required',
            'phase' => 'required',
        ]);
        $data += [
            'phase' => $this->phase,
            'state' => $this->state,
            'status' => ProjectRescheduling::STATUS_OPENED,
            'prj_project_id' => $this->project->id,
            'user_id' => user()->id,
        ];
        $response = $this->ajaxDispatch(new \App\Jobs\Projects\ProjectCreateRescheduling($data));
        if ($this->project->responsible_id) {
            $user = User::find($this->project->responsible_id);
            if ($user) {
                if ($response['success']) {
                    $notificationArray = [];
                    $notificationArray[0] = [
                        'via' => ['database'],
                        'database' => [
                            'username' => $user->name,
                            'title' => trans('general.generated_rescheduling'),
                            'description' => 'Se ha generado una solicitud de reprogramación en el proyecto ' . $this->project->name,
                            'url' => route('projects.reschedulings', $this->project->id),
                            'salutation' => trans('general.salutation'),
                        ]];
                    $notificationArray[1] = [
                        'via' => ['mail'],
                        'mail' => [
                            'subject' => trans('general.generated_rescheduling'),
                            'greeting' => __('general.dear_user'),
                            'line' => 'Se ha generado una solicitud de reprogramación en el proyecto ' . $this->project->name,
                            'salutation' => trans('general.salutation'),
                            'url' => route('projects.reschedulings', $this->project->id),
                        ]
                    ];
                    foreach ($notificationArray as $notification) {
                        $notificationData = [
                            'user' => $user,
                            'notificationArray' => $notification,
                        ];
                        $notificationResponse = $this->ajaxDispatch(new \App\Jobs\Notifications\SendNotification($notificationData));
                    }
                    flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.rescheduling', 0)]))->success();
                } else {
                    flash(trans_choice('messages.error', 1, $response['message']))->error();
                }
            }
        }
        return redirect()->route('projects.reschedulings', $this->project->id);
    }

    public function updatedPhase()
    {
        $rss = array();
        switch ($this->phase) {
            case Project::PHASE_START_UP:
                $rss = Project::STATUSES_START_UP;
                break;
            case Project::PHASE_PLANNING:
                $rss = Project::STATUSES_PLANNING;
                break;
            case Project::PHASE_IMPLEMENTATION:
                $rss = Project::STATUSES_IMPLEMENTATION;
                break;
        }
        $this->arrayStates = $rss;
    }
}
