<?php

namespace App\Http\Livewire\Projects\Formulation\Objectives;

use App\Jobs\Projects\CreateProjectObjective;
use App\Models\Projects\Objectives\ProjectObjectives;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ProjectCreateSpecificObjective extends Component
{

    use Jobs;

    public $projectId = null;

    public $code;
    public $name;
    public $description;
    public $objective;
    public $objectiveId;
    public $color;
    public $isEditing = false;

    protected $listeners = ['editObjective'];

    public function mount($id = null)
    {
        if ($id) {
            $this->projectId = $id;
        }
    }

    public function rules()
    {
        if ($this->objectiveId){
            return
                [
                    'code' => [
                        'required',
                        'max:5',
                        'alpha_num',
                        'alpha_dash',
                        Rule::unique('prj_project_objectives')->where('prj_project_id', $this->projectId)
                            ->where('deleted_at', null)->ignore($this->objectiveId)
                    ],
                    'name' => 'required|max:500|min:3',
                ];
        }else{
            return
                [
                    'code' => [
                        'required',
                        'max:5',
                        'alpha_num',
                        'alpha_dash',
                        Rule::unique('prj_project_objectives')->where('prj_project_id', $this->projectId)
                            ->where('deleted_at', null)
                    ],
                    'name' => 'required|max:500|min:3',
                    'description' => 'max:2000',
                ];
        }
    }

    public function submit()
    {
        $this->validate();

        if ($this->isEditing) {

            $data = [
                'id' => $this->objectiveId,
                'code' => $this->code,
                'name' => $this->name,
                'description' => $this->description,
                'color' => $this->color,
                'prj_project_id' => $this->projectId,
            ];
            $response = $this->ajaxDispatch(new CreateProjectObjective($data));
            $this->reset([
                'objective',
                'isEditing',
            ]);
        } else {
            $data = [
                'code' => $this->code,
                'name' => $this->name,
                'description' => $this->description,
                'color' => config('constants.catalog.COLOR_PALETTE')[array_rand(config('constants.catalog.COLOR_PALETTE'), 1)],
                'prj_project_id' => $this->projectId,
            ];

            $response = $this->ajaxDispatch(new CreateProjectObjective($data));
        }


        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.objectives', 1)]))->success()->livewire($this);
            $this->reset(['code', 'name', 'description']);
            $this->emit('objectiveCreated');
            $this->emit('toggleCreateObjective');
        } else {
            flash($response['message'])->error()->livewire($this);
        }

    }

    public function render()
    {
        return view('livewire.projects.formulation.objectives.project-create-specific-objective');
    }

    public function editObjective(int $id = null)
    {
        if ($id) {
            $this->objective = ProjectObjectives::find($id);
            $this->code = $this->objective->code;
            $this->name = $this->objective->name;
            $this->color = $this->objective->color;
            $this->description = $this->objective->description;
            $this->objectiveId = $this->objective->id;
            $this->projectId = $this->objective->prj_project_id;
            $this->isEditing = true;
        }

    }
}
