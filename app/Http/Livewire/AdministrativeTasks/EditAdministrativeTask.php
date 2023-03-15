<?php

namespace App\Http\Livewire\AdministrativeTasks;

use App\Models\AdministrativeTasks\AdministrativeSubTask;
use App\Models\AdministrativeTasks\AdministrativeTask;
use App\Models\Auth\User;
use App\Models\Projects\Project;
use App\Traits\Jobs;
use App\Traits\Uploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use function view;

class EditAdministrativeTask extends Component
{
    use WithFileUploads, Jobs, Uploads;

    public $project;
    public $name;
    public $status;
    public $user_id;
    public $priority;
    public $start_date;
    public $end_date;
    public $description;
    public $type;
    public $task;
    public $users;
    public array $subTasks = [];
    public array $NewsubTasks = [];
    public $activitySubTasks;
    public $advanceSubTasks = 0;


    protected $listeners = [
        'openEditAdminTask',
        'subTasksEdited',
    ];

    public function openEditAdminTask(int $id)
    {
        $this->task = AdministrativeTask::with(['subTasks'])->find($id);
        $this->description = $this->task->description;
        $this->status = $this->task->status;
        $this->priority = $this->task->priority;
        $this->name = $this->task->name;
        $this->start_date = $this->task->start_date;
        $this->end_date = $this->task->end_date;
        $this->user_id = $this->task->user_id;
        $this->activitySubTasks = $this->task->subTasks;
        foreach ($this->activitySubTasks as $subTask) {
            if ($subTask->status == 'Completada') {
                $this->subTasks += [$subTask->id => $subTask->id];
            }
        }
        if ($this->activitySubTasks && $this->activitySubTasks->count() > 0)
            $this->advanceSubTasks = intval($this->activitySubTasks->where('status', AdministrativeSubTask::STATUS_FINISHED)->count() / $this->activitySubTasks->count() * 100);

    }

    public function mount(Project $project = null)
    {
        if ($project) {
            $this->project = $project;
        }
        $this->users = User::get();
    }

    public function render()
    {
        return view('livewire.administrativeTasks.edit-administrative-task');
    }

    public function subTasksEdited($elements)
    {
        $this->NewsubTasks = $elements;
        foreach ($this->NewsubTasks as $element) {
            $data = [
                'administrative_task_id' => $this->task->id,
                'name' => $element,
                'status' => AdministrativeSubTask::STATUS_PENDING,
            ];
            AdministrativeSubTask::create($data);
        }
        $this->emit('deleteElements');
        $this->openEditAdminTask($this->task->id);
    }

    public function resetForm()
    {
        $this->reset([
            'name',
            'status',
            'user_id',
            'priority',
            'start_date',
            'end_date',
            'description',
        ]);
    }

    public function updatedSubTasks()
    {
        foreach ($this->subTasks as $subTaskCompleted) {
            AdministrativeSubTask::where('id', $subTaskCompleted)
                ->update(['status' => AdministrativeSubTask::STATUS_FINISHED]);
        }

        AdministrativeSubTask::where('administrative_task_id', $this->task->id)
            ->whereNotIn('id', $this->subTasks)
            ->update(['status' => AdministrativeSubTask::STATUS_PENDING]);
        $this->openEditAdminTask($this->task->id);
    }

    public function deleteSubTask(int $id)
    {
        $data = [
            'id' => $id
        ];
        $this->ajaxDispatch(new \App\Jobs\AdministrativeTasks\DeleteAdministrativeSubTask($data));
        $this->openEditAdminTask($this->task->id);
    }


    public function updateTask()
    {
        $data = $this->validate([
            'name' => 'required',
            'user_id' => 'required',
            'priority' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|after:start_date',
        ]);
        $data += [
            'id' => $this->task->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'type' => 'admt',
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'priority' => $this->priority,
            'description' => $this->description,
        ];
        if ($this->status == AdministrativeTask::STATUS_FINISHED) {
            $this->task->loadMedia(['file']);
            $media = $this->task->media;
            if (count($media) > 0) {
                $response = $this->ajaxDispatch(new \App\Jobs\AdministrativeTasks\EditAdministrativeTask($data));
                if ($response['success']) {
                    flash('messages.success.added', 1)->success();
                } else {
                    flash('messages.error', 1)->error();
                }
                return redirect()->route('projects.administrativeTasks', $this->project->id);
            }else{
                flash('Para completar la actividad se debe subir al menos un archivo')->error()->livewire($this);
            }
        }else{
            $response = $this->ajaxDispatch(new \App\Jobs\AdministrativeTasks\EditAdministrativeTask($data));
            if ($response['success']) {
                flash('Actualizado Exitosamente')->success()->livewire($this);
                $this->emit('closeModalEditAdministrativeTask');
                $this->emit('administrativeAdded');
                $this->resetForm();
            } else {
                flash('messages.error', 1)->error();
            }
        }
    }

}
