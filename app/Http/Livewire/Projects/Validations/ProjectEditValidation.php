<?php

namespace App\Http\Livewire\Projects\Validations;

use App\Jobs\Projects\ProjectSaveValidations;
use App\Models\Admin\Department;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectStateValidations;
use App\Traits\Jobs;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use function view;

class ProjectEditValidation extends Component
{
    use Jobs;

    public $tableFields;
    public array $modelRelations = [];
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
    public $departments;
    public $existing_departments = [];
    public $existingDepartments = [];
    public $existingFields = [];
    public $existingRelations = [];
    public $existing_fields = [];
    public $existing_relations = [];


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
        $this->validationId = $id;
        if (isset($this->validations)) {
            foreach ($this->validations as $validation) {
                array_push($this->existing_departments, (int)$validation['id']);
            }
        }
        if (isset($this->settings['fields'])) {
            foreach ($this->settings['fields'] as $settingFields) {
                    array_push($this->existing_fields, $settingFields);
            }
        }
        if (isset($this->settings['relations'])) {
            foreach ($this->settings['relations'] as $settingRelations) {
                    array_push($this->existing_relations, $settingRelations);
            }
        }
        $this->existingDepartments = $this->existing_departments;
        $this->existingFields = $this->existing_fields;
        $this->existingRelations = $this->existing_relations;
    }

    public function mount(Project $project)
    {
        $this->tableFields = $this->project->getTableColumns();
        $this->relations = [];
        $this->departments = Department::get();
        foreach (Project::VALIDATIONS_RELATIONS as $item) {
            //$relations[] = [ $relation];
            array_push($this->modelRelations, $item);
        }
        $this->relations = $this->modelRelations;
        $this->project = $project;
    }

    public function render()
    {
        $this->emit('refreshDropdown');
        return view('livewire.projects.validations.project-edit-validation');
    }

    public function resetForm()
    {
        $this->reset([
            'existingDepartments',
            'existingRelations',
            'existingFields',
        ]);
        $this->existing_departments=[];
        $this->existing_fields=[];
        $this->existing_relations=[];
        $this->modelRelations=[];
        $this->mount( $this->project);
    }

    public function save()
    {
        $dataValidations = [];
        foreach ($this->departmentsSelect as $department) {
            $dept = $this->departments->find($department);
            $dataValidations += [
                $dept->name =>
                    array(
                        'id' => $dept->id,
                        'description' => null,
                        'value' => 0,
                        'user_id' => null
                    ),
            ];
        }
        $dataSettings = [
            'fields' => [],
            'relations' => []
        ];
        foreach ($this->fieldsSelect as $fieldSelect) {
            array_push($dataSettings['fields'], $fieldSelect);
        }
        foreach ($this->relationsSelect as $relationSelect) {
            array_push($dataSettings['relations'], $relationSelect);
        }

        $data = [
            'id' => $this->validationId,
            'state' => $this->state,
            'status' => $this->status,
            'validations' => $dataValidations,
            'settings' => $dataSettings,
            'prj_project_id' => $this->project_id,
            'user_id' => $this->user_id,
        ];
        $response = $this->ajaxDispatch(new \App\Jobs\Projects\ProjectSaveValidations($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 1, ['type' => trans_choice('general.validation', 0)]))->success();
        } else {
            flash(trans_choice('messages.error', 1, $response['message']))->error();
        }
        return redirect()->route('projects.validations', $this->project->id);
    }

    public function updatedDepartmentsSelect()
    {
        $this->existingDepartments=[];
        foreach ($this->departmentsSelect as $item)
        {
            array_push( $this->existingDepartments,$item);

        }
    }
    public function updatedFieldsSelect()
    {
        $this->existingFields=[];
        foreach ($this->fieldsSelect as $item)
        {
            array_push( $this->existingFields,$item);

        }
    }
    public function updatedRelationsSelect()
    {
        $this->existingRelations=[];
        foreach ($this->relationsSelect as $item)
        {
            array_push( $this->existingRelations,$item);

        }
    }

}
