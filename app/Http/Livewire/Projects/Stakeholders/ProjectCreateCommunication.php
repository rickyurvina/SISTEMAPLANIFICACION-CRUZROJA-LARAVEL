<?php

namespace App\Http\Livewire\Projects\Stakeholders;

use App\Models\Auth\User;
use App\Models\Projects\Project;
use App\Models\Projects\Stakeholders\ProjectCommunicationMatrix;
use App\Traits\Jobs;
use App\Traits\Uploads;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectCreateCommunication extends Component
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
    public $frequency_number = null;
    public $frequency_limit = null;
    public $users;
    public $stakeholders;


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
        return view('livewire.projects.stakeholders.project-create-communication');
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

    public function save()
    {
        $this->validate();

        $data =
            [
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'frequency' => $this->frequency,
                'state' => ProjectCommunicationMatrix::NO_DELIVERED,
                'color' => config('constants.catalog.COLOR_PALETTE')[array_rand(config('constants.catalog.COLOR_PALETTE'), 1)],
                'information_type' => $this->information_type,
                'format_information_presentation' => $this->format_information_presentation,
                'user_id' => $this->user_id,
                'frequency_number' => $this->frequency_number,
                'prj_project_stakeholder_id' => $this->prj_project_stakeholder_id,
            ];

        $dateUntil = Carbon::parse(isset($this->frequency_limit) ? Carbon::parse($this->frequency_limit) : Carbon::parse('31-12-' . now()->year));
        $dateActivity = isset($this->start_date) ? Carbon::parse($this->start_date) : now();

        while ($dateActivity->lte($dateUntil)) {


            if ($this->frequency) {
                $data['start_date'] = $dateActivity;
                $data['end_date'] = $dateActivity;
                $this->validate([
                    'frequency' => 'required',
                    'frequency_number' => 'required',
                    'frequency_limit' => 'required|after:end_date',
                ]);
                $response = $this->ajaxDispatch(new \App\Jobs\Projects\ProjectCreateCommunication($data));
                switch ($data['frequency']) {
                    case ProjectCommunicationMatrix::DAILY:
                        $dateActivity->addDays($data['frequency_number']);
                        if ($dateActivity->isSaturday()) {
                            $dateActivity->addDays(2);
                            break;
                        }
                        if ($dateActivity->isSunday()) {
                            $dateActivity->addDays(1);
                        }
                        break;
                    case  ProjectCommunicationMatrix::WEEKLY:
                        $dateActivity->addWeeks($data['frequency_number']);
                        break;
                    case  ProjectCommunicationMatrix::MONTHLY:
                        $dateActivity->addMonths($data['frequency_number']);
                        break;
                }
            } else {
                $response = $this->ajaxDispatch(new \App\Jobs\Projects\ProjectCreateCommunication($data));
                break;
            }
        }

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.communication', 0)]))->success();
            $user = User::find($this->user_id);
            if ($user) {
                $notificationArray = [];
                $notificationArray[0] = [
                    'via' => ['database'],
                    'database' => [
                        'username' => $user->name,
                        'title' => __('general.communication_activity_assignment'),
                        'description' => __(('general.dear') . ' ' . $user->name . ' ' . ('general.you_have_been_assigned_for_the_activity') . ' ' .
                            $this->information_type . 'general.in_the_communication_plan' . ' ' . ('general.with_execution_date') . ' ' . $this->start_date),
                        'url' => route('projects.index'),
                    ]];
                $notificationArray[1] = [
                    'via' => ['mail'],
                    'mail' => [
                        'subject' => (__('general.communication_activity_assignment')),
                        'greeting' => __('general.dear_user'),
                        'line' => __(('general.dear') . ' ' . $user->name . ' ' . ('general.you_have_been_assigned_for_the_activity') . ' ' .
                            $this->information_type . 'general.in_the_communication_plan' . ' ' . ('general.with_execution_date') . ' ' . $this->start_date),
                        'salutation' => trans('general.salutation'),
                        'url' => ('projects.index'),
                    ]
                ];
                foreach ($notificationArray as $notification) {
                    $notificationData = [
                        'user' => $user,
                        'notificationArray' => $notification,
                    ];
                    $this->ajaxDispatch(new \App\Jobs\Notifications\SendNotification($notificationData));
                }
            }

        } else {
            flash($response['message'])->error()->livewire($this);
        }
        return redirect()->route('projects.communication', $this->project);

    }
}
