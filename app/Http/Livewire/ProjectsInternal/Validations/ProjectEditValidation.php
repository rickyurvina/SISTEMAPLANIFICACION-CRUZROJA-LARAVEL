<?php

namespace App\Http\Livewire\ProjectsInternal\Validations;

use App\Jobs\Projects\ProjectSaveValidations;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectStateValidations;
use App\Traits\Jobs;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use function view;

class ProjectEditValidation extends Component
{
    use Jobs;

    public  $tableFields;
    public array $modelRelations=[];
    public $relations;
    public $project_id;
    public $project;
    public $user_id;
    public $status;
    public $state;
    public $settings;
    public $validations;
    public $validation;
    public $validationId;
    public $departmentsSelect = [];
    public $relationsSelect = [];
    public $fieldsSelect = [];

    protected $listeners = ['openEditValidation'];

    public function openEditValidation(int $id)
    {
        $this->validation = ProjectStateValidations::find($id);
        $this->status = $this->validation->status;
        $this->settings = $this->validation->settings;
        $this->validations = $this->validation->validations;
        $this->project_id = $this->validation->prj_project_id;
        $this->user_id = $this->validation->user_id;
        $this->state = $this->validation->state;
        $this->validationId=$id;
    }

    public function mount(Project $project)
    {
        $this->tableFields = $this->project->getTableColumns();
        $this->relations=[];
        foreach ($this->project->getRelations() as $relation => $items) {
            $model = get_class($this->project->{$relation}());

            //$relations[] = [ $relation];
            array_push($this->modelRelations,$relation);
        }
        $this->relations=$this->modelRelations;
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.projects.validations.project-edit-validation');
    }

    public function resetForm()
    {
        $this->reset([
//            'departments',
//            'relations',
//            'fields',
//            'departmentsSelect'
        ]);
    }

    public function save()
    {
        $dataValidations=[];
        foreach ($this->departmentsSelect as $department) {
            $dataValidations += [
                $department =>
                    array(
                        'description' => null,
                        'value' => 0,
                        'user_id' => null
                    ),
            ];
        }
        $dataSettings=[
            'fields'=>[],
            'relations'=>[]
        ];
        foreach ($this->fieldsSelect as $fieldSelect)
        {
           array_push($dataSettings['fields'],$fieldSelect);
        }
        foreach ($this->relationsSelect as $relationSelect)
        {
            array_push($dataSettings['relations'],$relationSelect);
        }

        $data=[
            'id'=>$this->validationId,
            'state'=>$this->state,
            'status'=>$this->status,
            'validations'=>$dataValidations,
            'settings'=>$dataSettings,
            'prj_project_id'=>$this->project_id,
            'user_id'=>$this->user_id,
        ];
        $response = $this->ajaxDispatch(new \App\Jobs\Projects\ProjectSaveValidations($data));
        if ($response['success']) {
           flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.rescheduling', 0)]))->success();
        } else {
           flash(trans_choice('messages.error', 1, $response['message']))->error();
        }
        return redirect()->route('projects.validations', $this->project->id);
    }


}
