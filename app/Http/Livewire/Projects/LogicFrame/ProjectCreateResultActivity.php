<?php

namespace App\Http\Livewire\Projects\LogicFrame;

use App\Models\Auth\User;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectMemberSubsidiary;
use App\Traits\Jobs;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Thomasjohnkane\Snooze\Traits\SnoozeNotifiable;

class ProjectCreateResultActivity extends Component
{
    use Jobs, SnoozeNotifiable;

    public $resultId;
    public $result;
    public $results;
    public $project;
    public $users;
    public $resultName;
    public $code;
    public $text;
    public $description;
    public $owner_id;
    public $internal = false;
    public $dateCalendar = null;
    public array $usersArray = [];
    public $typeOfAggregation = 'sum';

    public $listeners = ['openCreateModal'];

    public function rules()
    {
        return
            [
                'code' => [
                    'required',
                    'max:5',
                    'alpha_num',
                    'alpha_dash',
                    Rule::unique('prj_tasks')
                        ->when($this->resultId, function ($query) {
                            return $query->where('parent', $this->resultId);
                        })
                        ->where('type', 'task')
                        ->where('deleted_at', null)
                ],
                'text' => 'required|max:200|min:3',
                'resultId' => 'required',
                'description' => 'max:1500',
                'typeOfAggregation' => 'required',
            ];
    }

    public function mount(Project $project, int $resultId = null)
    {
        if ($resultId) {
            $this->resultId = $resultId;
            $this->result = Task::find($resultId);
        }
        $this->results = Task::where('project_id', $project->id)
            ->where('type', 'project')
            ->where('parent', '!=', 'root')
            ->get();
        $projectSubsidiaries = ProjectMemberSubsidiary::where('project_id', $this->project->id)->collect();
        $this->users = User::enabled()->with('companies')->get();
        $this->usersArray = [];
        foreach ($this->users as $user) {
            $userCompanies = $user->companies()->get();
            foreach ($userCompanies as $userCompany) {
                foreach ($projectSubsidiaries as $projectSubsidiary) {
                    if ($userCompany->id == $projectSubsidiary->company_id) {
                        if (User::isMember($user->id, $this->project->id))
                            array_push($this->usersArray, $user);
                    }
                }
            }
        }
        $this->usersArray=array_unique($this->usersArray);
    }

    public function render()
    {
        return view('livewire.projects.logic_frame.project-create-result-activity');
    }

    public function openCreateModal($payload)
    {
        $this->dateCalendar = $payload['date'];
        if (isset($payload['internal'])) {
            $this->internal = true;
        }
        $this->emit('toggleCreateActivity');
    }

    public function updatedResultId($value)
    {
        foreach ($this->results as $result) {
            if ($result['id'] == $value) {
                $this->resultName = $result['text'];
            }
        }
    }

    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->resetValidation();
        $this->reset(
            [
                'code',
                'text',
                'owner_id',
                'resultName',
                'resultId',
                'description',
            ]
        );
        $this->emit('activityCreated');
    }

    /**
     * Store POA program activity
     *
     */
    public function submitActivity()
    {
        date_default_timezone_set('America/Guayaquil');
        $this->validate();
        if ($this->dateCalendar) {
            $date = $this->dateCalendar;
        } else {
            $date = now();
        }
        $result = Task::find($this->resultId);
        $carbon_date = Carbon::parse($date)->addDays(1);
        $carbon_date->addHours(8);
        $data = [
            'code' => $this->code,
            'text' => $this->text,
            'description' => $this->description,
            'parent' => $result->id,
            'progress' => 0,
            'duration' => 1,
            'start_date' => $date,
            'end_date' => $carbon_date,
            'type' => 'task',
            'sortorder' => Task::max("sortorder") + 1,
            'color' => $result->color,
            'weight' => 0,
            'status' => Task::STATUS_PROGRAMMED,
            'project_id' => $this->project->id,
            'company_id' => session('company_id'),
            'owner_id' => $this->owner_id,
            'aggregation_type' => $this->typeOfAggregation,
        ];
        $response = $this->ajaxDispatch(new \App\Jobs\Projects\ProjectCreateResultActivity($data));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.activities', 1)]))->success()->livewire($this);
            $this->emit('toggleCreateActivity');
            $user = User::find($this->owner_id);
            if ($user) {
                $notificationArray = [];
                if ($this->owner_id) {
                    {
                        $notificationArray[0] = [
                            'via' => ['database'],
                            'database' => [
                                'username' => $user->name,
                                'title' => __('general.activity_assignment'),
                                'description' => __($user->name . ' ' . ('general.you_have_been_assigned_for_the_activity') . ' ' .
                                    $this->text . 'general.in_the_project' . ' ' . $this->project->name . (trans('general.with_execution_date')) . ' ' . $this->project->star_date),
                                'url' => route('projects.index'),
                                'salutation' => trans('general.salutation'),
                            ]];
                        $notificationArray[1] = [
                            'via' => ['mail'],
                            'mail' => [
                                'subject' => __('general.activity_assignment'),
                                'greeting' => __('general.dear_user'),
                                'line' => __($user->name . ' ' . ('general.you_have_been_assigned_for_the_activity') . ' ' .
                                    $this->text . 'general.in_the_project' . ' ' . $this->project->name . (trans('general.with_execution_date')) . ' ' . $this->project->star_date),
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
                        //TODO Hacer configurable frecuencia
//                        if ($carbon_date->diffInDays(now()) >= 15) {
//                            $user->notifyAt(new ActivityDueNotification(), $carbon_date->subDays(15));
//                        } elseif ($carbon_date->diffInDays(now()) >= 7) {
//                            $user->notifyAt(new ActivityDueNotification(), $carbon_date->subDays(7));
//                        } elseif ($carbon_date->diffInDays(now()) >= 3) {
//                            $user->notifyAt(new ActivityDueNotification(), $carbon_date->subDays(3));
//                        } else {
//                            $user->notifyAt(new ActivityDueNotification(), $carbon_date->subDay());
//                        }
//                        if ($carbon_date > now()) {
//                            $user->notifyAt(new OverDueActivityNotification(), now());
//                            $user->notifyAt(new OverDueActivityNotification(), now()->addWeek());
//                        }
                    }
                } else {
                    flash($response['message'])->error()->livewire($this);
                }
            }
            if ($this->dateCalendar && $this->internal != true) {
                return redirect()->route('projects.calendar', $this->project->id);
            } else if ($this->project->type === Project::TYPE_INTERNAL_DEVELOPMENT && $this->dateCalendar) {
                return redirect()->route('projects.calendarInternal', $this->project->id);
            } else if ($this->project->type === Project::TYPE_INTERNAL_DEVELOPMENT) {
                return redirect()->route('projects.activities_resultsInternal', $this->project->id);
            } else {
                return redirect()->route('projects.activities_results', $this->project->id);
            }
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }
}
