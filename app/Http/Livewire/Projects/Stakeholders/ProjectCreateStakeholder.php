<?php

namespace App\Http\Livewire\Projects\Stakeholders;

use App\Jobs\Projects\ProjectDeleteStakeholderAction;
use App\Jobs\Projects\ProjectUpdateStakeholder;
use App\Models\Auth\User;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Project;
use App\Models\Projects\Stakeholders\ProjectStakeholder;
use App\Models\Projects\Stakeholders\ProjectStakeholderActions;
use App\Traits\Jobs;
use App\Traits\Uploads;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Plank\Mediable\Media;

class ProjectCreateStakeholder extends Component
{
    use WithFileUploads, Jobs, Uploads;

    public $file = null;
    public $files = [];
    public $observation = null;

    public $user_id = null, $prj_project_id = null, $state = null, $priority = null, $name = null, $description = null,
        $frequency = null, $interest_level = null, $influence_level = null, $positive_impact = null, $negative_impact = null,
        $strategy = null, $owner = null, $start_date_action = null,
        $closing_date = null, $state_action = null, $stakeHolderId = null, $task_id;

    public $frequency_limit = null;
    public $frequency_number = null;

    public ?Collection $users = null;

    public $isUpdating = false;

    public ?ProjectStakeholder $projectStakeholder = null;
    public ?Collection $projectStakeholderActions = null;
    public array $status = [];
    public array $frequencies = [];

    public $names = null;
    public $surnames = null;
    public $email = null;
    public $personalNotes = null;
    public $phone = null;
    public $project;

    public $results;
    public $rule;

    protected $listeners = ['createStakeholder' => 'mount', 'open' => 'mount'];

    protected $rules = [
        'user_id' => 'required',
        'prj_project_id' => 'required',
        'priority' => 'required',
        'interest_level' => 'required',
        'influence_level' => 'required',
    ];

    public function mount($id = null, $stakeholderId = null)
    {
        $this->status =
            [
                ProjectStakeholderActions::OPEN => ProjectStakeholderActions::OPEN,
                ProjectStakeholderActions::CLOSED => ProjectStakeholderActions::CLOSED,
            ];
        $this->frequencies =
            [
                ProjectStakeholder::DAILY => ProjectStakeholder::DAILY,
                ProjectStakeholder::MONTHLY => ProjectStakeholder::MONTHLY,
                ProjectStakeholder::WEEKLY => ProjectStakeholder::WEEKLY,
            ];

        $this->prj_project_id = $id;
        $this->project = Project::find($id);
        $this->users = User::get();
        if (!is_null($stakeholderId)) {
            $this->isUpdating = true;
            $this->stakeHolderId = $stakeholderId;
        }
        if ($this->isUpdating) {
            $this->projectStakeholder = ProjectStakeholder::with([
                'actions.responsible',
                'interested',
                'project',
            ])->find($this->stakeHolderId);
            $this->user_id = $this->projectStakeholder->user_id;
            $this->state = $this->projectStakeholder->state;
            $this->priority = $this->projectStakeholder->priority;
            $this->description = $this->projectStakeholder->description;
            $this->interest_level = $this->projectStakeholder->interest_level;
            $this->influence_level = $this->projectStakeholder->influence_level;
            $this->positive_impact = $this->projectStakeholder->positive_impact;
            $this->negative_impact = $this->projectStakeholder->negative_impact;
            $this->strategy = $this->projectStakeholder->strategy;
            $this->projectStakeholderActions = $this->projectStakeholder->actions;
            $this->results = Task::where('project_id', $this->project->id)->where('parent', '!=', 'root')->where('type', 'project')->get();
            $this->rule = ['task_id' => 'required'];
        }
    }

    public function render()
    {
        return view('livewire.projects.stakeholders.project-create-stakeholder');
    }


    public function saveAction()
    {
        if ($this->project->phase == Project::PHASE_START_UP) {
            $this->validate(
                [
                    'name' => 'required',
                    'task_id' => 'required',
                    'start_date_action' => 'required',
                    'closing_date' => 'required|after:start_date_action',
                ]
            );
        } else {
            $this->validate(
                [
                    'name' => 'required',
                    'owner' => 'required',
                    'task_id' => 'required',
                    'start_date_action' => 'required',
                    'closing_date' => 'required|after:start_date_action',
                ]
            );
        }

        $data = [
            'name' => $this->name,
            'prj_project_stakeholder_id' => $this->stakeHolderId,
            'start_date' => $this->start_date_action,
            'end_date' => $this->closing_date,
            'frequency' => $this->frequency,
            'state' => ProjectStakeholder::OPEN,
            'user_id' => $this->owner,
            'task_id' => $this->task_id,
            'frequency_number' => $this->frequency_number,
            'color' => config('constants.catalog.COLOR_PALETTE')[array_rand(config('constants.catalog.COLOR_PALETTE'), 1)],
        ];


        $dateUntil = Carbon::parse(isset($this->frequency_limit) ? Carbon::parse($this->frequency_limit) : Carbon::parse('31-12-' . now()->year));
        $dateActivity = isset($this->start_date_action) ? Carbon::parse($this->start_date_action) : now();
        while ($dateActivity->lte($dateUntil)) {
            $data['start_date'] = $dateActivity;
            if (is_null($this->frequency)) {
                $response = $this->ajaxDispatch(new \App\Jobs\Projects\ProjectCreateStakeholderAction($data));
                break;
            } else {
                $this->validate(
                    [
                        'frequency_number' => 'required',
                        'frequency_limit' => 'required|after:start_date_action',
                    ]
                );
            }
            $response = $this->ajaxDispatch(new \App\Jobs\Projects\ProjectCreateStakeholderAction($data));
            switch ($data['frequency']) {
                case ProjectStakeholder::DAILY:
                    $dateActivity->addDays($data['frequency_number']);
                    if ($dateActivity->isSaturday()) {
                        $dateActivity->addDays(2);
                        break;
                    }
                    if ($dateActivity->isSunday()) {
                        $dateActivity->addDays(1);
                    }
                    break;
                case  ProjectStakeholder::WEEKLY:
                    $dateActivity->addWeeks($data['frequency_number']);
                    break;
                case  ProjectStakeholder::MONTHLY:
                    $dateActivity->addMonths($data['frequency_number']);
                    break;
            }

        }


        if ($response['success']) {
            $user = User::find($this->owner);
            if ($user) {
                $notificationArray = [];
                $notificationArray[0] = [
                    'via' => ['database'],
                    'database' => [
                        'username' => $user->name,
                        'title' => __('Cruz Roja '),
                        'description' => __('Ha sido asigando como propietario de la acción ' . $this->name . ' del actor clave ' . $this->projectStakeholder->interested->getFullName() . '.'),
                        'url' => route('projects.stakeholder', ['project' => $this->project]),
                    ]];
                $notificationArray[1] = [
                    'via' => ['mail'],
                    'mail' => [
                        'subject' => (__('general.action_assign')),
                        'greeting' => __('general.dear_user'),
                        'line' => __('Ha sido asigando como propietario de la acción ' . $this->name . ' del actor clave' . $this->projectStakeholder->interested->getFullName() . '.'),
                        'salutation' => trans('general.salutation'),
                        'url' => route('projects.stakeholder', ['project' => $this->project]),
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
            flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.action', 0)]))->success()->livewire($this);
            $this->showList();
        } else {
            flash($response['message'])->error()->livewire($this);
        }
        $this->reset(
            [
                'name',
                'owner',
                'task_id',
                'start_date_action',
                'closing_date'
            ]
        );

    }

    public function showList()
    {
        $this->projectStakeholderActions = $this->projectStakeholder->actions;
        $this->mount($this->prj_project_id);
    }

    public function deleteAction($id)
    {
        $action = ProjectStakeholderActions::find($id);
        if ($action->state != \App\Models\Projects\Stakeholders\ProjectStakeholderActions::CLOSED) {
            $response = $this->ajaxDispatch(new ProjectDeleteStakeholderAction($id));
            if ($response['success']) {
                flash(trans_choice('messages.success.deleted', 1, ['type' => trans_choice('general.action', 0)]))->success()->livewire($this);
                $this->showList();
            } else {
                flash($response['message'])->error()->livewire($this);
                $this->showList();
            }
        } else {
            flash(trans('general.action_cannot_be_deleted'))->error()->livewire($this);
            $this->showList();
        }
    }

    public function createStakeholder()
    {
        $this->validate();

        if ($this->interest_level == ProjectStakeholder::LOW && $this->influence_level == ProjectStakeholder::HIGH) {
            $this->strategy = ProjectStakeholder::KEEP_SATISFIED;
        }
        if ($this->interest_level == ProjectStakeholder::LOW && $this->influence_level == ProjectStakeholder::LOW) {
            $this->strategy = ProjectStakeholder::MONITOR;
        }
        if ($this->interest_level == ProjectStakeholder::HIGH && $this->influence_level == ProjectStakeholder::LOW) {
            $this->strategy = ProjectStakeholder::KEEP_INFORMED;
        }
        if ($this->interest_level == ProjectStakeholder::HIGH && $this->influence_level == ProjectStakeholder::HIGH) {
            $this->strategy = ProjectStakeholder::MANAGE_CAREFULLY;
        }


        $data = [
            'id' => $this->stakeHolderId ?? null,
            'user_id' => $this->user_id,
            'prj_project_id' => $this->prj_project_id,
            'priority' => $this->priority,
            'interest_level' => $this->interest_level,
            'influence_level' => $this->influence_level,
            'positive_impact' => $this->positive_impact,
            'negative_impact' => $this->negative_impact,
            'strategy' => $this->strategy,
        ];
        if ($this->isUpdating) {
            $response = $this->ajaxDispatch(new ProjectUpdateStakeholder($data));
        } else {
            $response = $this->ajaxDispatch(new \App\Jobs\Projects\ProjectCreateStakeholder($data));
        }

        if ($response['success']) {
            $id = $response['data']->id;
            $projectStakeholder = ProjectStakeholder::find($id);
            foreach ($this->files as $item) {
                $media = $this->getMedia($item['file'], 'stakeholder', null, $item['observation'])->id;
                $projectStakeholder->attachMedia($media, 'file');
            }
            $this->reset(
                [
                    'files',
                    'file',
                    'observation'
                ]
            );

            $this->stakeHolderId = $response['data']->id;
            if (!$this->isUpdating) {
                flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.stakeholder', 0)]))->success();
            } else {
                flash(trans_choice('messages.success.updated', 1, ['type' => trans_choice('general.stakeholder', 0)]))->success();
            }
            $this->emit('stakeholderCreated', $this->prj_project_id);
            $this->isUpdating = true;
            $user = User::find($this->user_id);
            if ($user) {
                $notificationArray = [];
                $notificationArray[0] = [
                    'via' => ['database'],
                    'database' => [
                        'username' => $user->name,
                        'title' => __('Cruz Roja '),
                        'description' => __('Ha sido asignado como actor clave en el proyecto ' . $this->project->name . '.'),
                        'url' => route('projects.stakeholder', ['project' => $this->project]),
                    ]];
                $notificationArray[1] = [
                    'via' => ['mail'],
                    'mail' => [
                        'subject' => (__('general.role_assign')),
                        'greeting' => __('general.dear_user'),
                        'line' => __('Ha sido asignado como actor clave en el proyecto ' . $this->project->name . '.'),
                        'salutation' => trans('general.salutation'),
                        'url' => route('projects.stakeholder', ['project' => $this->project]),
                    ]
                ];
                foreach ($notificationArray as $notification) {
                    $notificationData = [
                        'user' => $user,
                        'users' => $this->project->members,
                        'notificationArray' => $notification,
                    ];
                    $this->ajaxDispatch(new \App\Jobs\Notifications\SendNotification($notificationData));
                }
            }

            if ($this->project->type == Project::TYPE_MISSIONARY_PROJECT || $this->project->type == Project::TYPE_EMERGENCY) {
                return redirect()->route('projects.stakeholder', $this->project->id);
            } else {
                return redirect()->route('projects.stakeholderInternal', $this->project->id);
            }

        } else {
            flash($response['message'])->error()->livewire($this);

        }
    }


    public function deleteMedia($id)
    {
        Media::find($id)->delete();
        $this->projectStakeholder->loadMedia(['file']);
    }

    public function download($id)
    {
        $media = Media::find($id);
        return response()->streamDownload(
            function () use ($media) {
                $stream = $media->stream();
                while ($bytes = $stream->read(1024)) {
                    echo $bytes;
                }
            },
            $media->basename,
            [
                'Content-Type' => $media->mime_type,
                'Content-Length' => $media->size
            ]
        );
    }


    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(
            [
                'user_id',
                'state',
                'priority',
                'name',
                'description',
                'frequency',
                'interest_level',
                'influence_level',
                'positive_impact',
                'negative_impact',
                'strategy',
                'owner',
                'start_date_action',
                'closing_date',
                'state_action',
                'files',
                'observation',
                'file',
                'isUpdating',
            ]
        );
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->emit('toggleProjectCreateStakeholder');
    }

    public function addFile()
    {
        $this->validate([
            'file' => 'required|file',
            'observation' => 'required',
        ]);
        $fileElement = [];
        $fileElement['name'] = substr($this->file, 5);
        $fileElement['file'] = $this->file;
        $fileElement['observation'] = $this->observation;
        array_push($this->files, $fileElement);
        $this->observation = '';
        $this->dispatchBrowserEvent('fileReset');
    }

    public function removeFile($name)
    {
        array_splice($this->files, array_search($name, array_column($this->files, 'name')), 1);
    }
}
