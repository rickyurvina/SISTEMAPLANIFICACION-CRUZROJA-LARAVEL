<?php

namespace App\Http\Livewire\Projects\Formulation\Objectives;

use App\Models\Projects\Activities\Task;
use App\Models\Projects\Objectives\ProjectObjectives;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ProjectCreateResultsModal extends Component
{
    public int $objectiveId;
    public $objective;
    public $name = null;
    public $description = null;
    public $code = null;
    protected $listeners = ['loadResults'];

    public function rules()
    {
        return
            [
                'code' => [
                    'required',
                    'max:5',
                    'alpha_num',
                    'alpha_dash',
                    Rule::unique('prj_tasks')->where('project_id', $this->objective->project->id)
                        ->where('type', 'project')
                        ->where('objective_id', $this->objective->id)
                        ->where('deleted_at', null)
                ],
                'name' => 'required|max:500|min:3',
                'description' => 'max:2000',
            ];
    }

    public function loadResults($id)
    {
        $this->objectiveId = $id;
        $this->objective = ProjectObjectives::find($id);
    }

    public function render()
    {
        return view('livewire.projects.formulation.objectives.project-create-results-modal');
    }

    public function submit()
    {
        $this->validate();
        $parent = $this->objective->project->tasks->where('parent', 'root')->first();
        $result = Task::create([
            'code' => $this->code,
            'text' => $this->name,
            'description' => $this->description,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
            'duration' => 4,
            'type' => 'project',
            'color' => $this->objective->color,
            'progress' => 0,
            'parent' => $parent->id,
            'weight' => 0,
            'sortorder' => 1,
            'project_id' => $this->objective->project->id,
            'objective_id' => $this->objectiveId,
            'company_id' => session('company_id'),
            'status' => Task::STATUS_PROGRAMMED,
        ]);

        if ($result) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.result', 1)]))->success()->livewire($this);
            $this->reset(['code', 'name','description']);
            $this->emit('toggleCreateResult');
            $this->emit('resultCreated');
        } else {
            flash('Error')->error()->livewire($this);
        }

    }
}
