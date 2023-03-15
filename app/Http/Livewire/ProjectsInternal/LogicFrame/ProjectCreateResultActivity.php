<?php

namespace App\Http\Livewire\ProjectsInternal\LogicFrame;

use App\Http\Livewire\Projects\CRUD\Projects;
use App\Models\Auth\User;
use App\Models\Poa\PoaIndicatorConfig;
use App\Models\Process\Activity;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Objectives\ProjectObjectives;
use App\Models\Projects\Project;
use App\Notifications\ActivityDueNotification;
use App\Notifications\OverDueActivityNotification;
use App\Traits\Jobs;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Thomasjohnkane\Snooze\Traits\SnoozeNotifiable;

class ProjectCreateResultActivity extends Component
{
    use Jobs, SnoozeNotifiable;

    public $project;
    public $users;
    public $name = null;
    public $code = null;
    public $objectiveId = null;
    public $objective;
    public $milestoneId;
    public $milestone;

    protected $listeners = ['loadObjective'];

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
                        ->where('type', 'project')
                        ->when($this->objective, function ($query) {
                            return $query->where('objective_id', $this->objective->id);
                        })
                        ->where('deleted_at', null)
                ],
                'name' => 'required|max:500|min:3',
            ];
    }


    public function loadObjective($id, $milestoneId = null)
    {
        $this->objectiveId = $id;
        $this->objective = ProjectObjectives::find($id);
        if ($milestoneId) {
            $this->milestoneId = $milestoneId;
            $this->milestone = Task::find($milestoneId);
            $this->code = $this->milestone->code;
            $this->name = $this->milestone->text;
        }
    }

    public function render()
    {
        return view('livewire.projectsInternal.logic_frame.project-create-result-activity');
    }

    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset([
            'code',
            'name',
            'objectiveId',
            'objective',
            'milestoneId',
            'milestone',
        ]);
    }

    /**
     * Store POA program activity
     *
     */
    public function submit()
    {
        date_default_timezone_set('America/Guayaquil');
        $this->validate();
        $parent = $this->objective->project->tasks->where('parent', 'root')->first();

        $data = [
            'id' => $this->milestoneId,
            'code' => $this->code,
            'text' => $this->name,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
            'duration' => 4,
            'type' => 'project',
            'weight' => 0,
            'color' => $this->objective->color,
            'progress' => 0,
            'parent' => $parent->id,
            'sortorder' => 1,
            'project_id' => $this->objective->project->id,
            'objective_id' => $this->objectiveId,
            'company_id' => session('company_id'),
            'status' => Task::STATUS_PROGRAMMED,
        ];

        $response = $this->ajaxDispatch(new \App\Jobs\Projects\ProjectCreateResultActivity($data));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.milestone', 1)]))->success()->livewire($this);
            $this->resetForm();
            $this->emit('activityCreated');
            $this->emit('toggleCreateActivity');
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

}
