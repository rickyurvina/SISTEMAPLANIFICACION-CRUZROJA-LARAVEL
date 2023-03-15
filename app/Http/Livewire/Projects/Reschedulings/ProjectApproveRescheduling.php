<?php

namespace App\Http\Livewire\Projects\Reschedulings;

use App\Models\Auth\User;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectRescheduling;
use App\Traits\Jobs;
use Livewire\Component;

class ProjectApproveRescheduling extends Component
{
    use Jobs;

    public $description;
    public $state;
    public $phase;
    public $status;
    public $approvedId;
    public $project;
    public $rescheduling;

    protected $listeners = ['openApproveRescheduling'];

    public function openApproveRescheduling(int $id)
    {
        $this->rescheduling = ProjectRescheduling::find($id);
        $this->description = $this->rescheduling->description;
        $this->state = $this->rescheduling->state;
        $this->phase = $this->rescheduling->phase;
        $this->project = $this->rescheduling->project;
    }

    public function render()
    {
        return view('livewire.projects.reschedulings.project-approve-rescheduling');
    }

    public function approve()
    {
        $this->project->phase = $this->phase;
        $this->project->status = $this->state;
        $this->rescheduling->status = ProjectRescheduling::STATUS_APPROVED;
        $this->rescheduling->approved_id = user()->id;
        $this->rescheduling->save();
        $this->project->save();
        flash('Aprobado satisfactoriamente')->success();
        $notificationArray = [];
        foreach ($this->project->members as $projectMember) {
            $member = User::find($projectMember->user_id);
            if ($member) {
                $notificationArray[0] = [
                    'via' => ['database'],
                    'database' => [
                        'username' => $member->name,
                        'title' => __('general.rescheduling_approved'),
                        'description' => 'El estado del proyecto ' . $this->project->name . ' ha cambiado a ' . $this->phase . '.',
                        'url' => route('projects.reschedulings', $this->project->id),
                        'salutation' => trans('general.salutation'),
                    ]];
                $notificationArray[1] = [
                    'via' => ['mail'],
                    'mail' => [
                        'subject' => trans('general.rescheduling_approved'),
                        'greeting' => __('general.dear_user'),
                        'line' => 'El estado del proyecto ' . $this->project->name . ' ha cambiado a ' . $this->phase . '.',
                        'salutation' => trans('general.salutation'),
                        'url' => route('projects.reschedulings', $this->project->id),
                    ]
                ];
                foreach ($notificationArray as $notification) {
                    $notificationData = [
                        'user' => $member,
                        'notificationArray' => $notification,
                    ];
                    $this->ajaxDispatch(new \App\Jobs\Notifications\SendNotification($notificationData));
                }
            }

        }
        if ($this->state == Project::STATE_GENERAL_CANCELLED) {
            $projectResponsable = User::find($this->project->responsible_id);
            $notificationArray[0] = [
                'via' => ['database'],
                'database' => [
                    'username' => $projectResponsable->name,
                    'title' => __('general.project_cancelled'),
                    'description' => 'El estado del proyecto ' . $this->project->name . ' ha cambiado a ' . $this->phase . '.',
                    'url' => route('projects.reschedulings', $this->project->id),
                    'salutation' => trans('general.salutation'),
                ]];
            $notificationArray[1] = [
                'via' => ['mail'],
                'mail' => [
                    'subject' => trans('general.project_cancelled'),
                    'greeting' => __('general.dear_user'),
                    'line' => 'El estado del proyecto ' . $this->project->name . ' ha cambiado a ' . $this->phase . '.',
                    'salutation' => trans('general.salutation'),
                    'url' => route('projects.reschedulings', $this->project->id),
                ]
            ];
            foreach ($notificationArray as $notification) {
                $notificationData = [
                    'user' => $projectResponsable,
                    'notificationArray' => $notification,
                ];
                $notificationResponse = $this->ajaxDispatch(new \App\Jobs\Notifications\SendNotification($notificationData));
            }
        }
        return redirect()->route('projects.reschedulings', $this->project->id);
    }

    public function resetForm()
    {
        $this->rescheduling->approved_id = null;
    }
}
