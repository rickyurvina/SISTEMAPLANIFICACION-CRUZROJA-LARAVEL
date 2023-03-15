<?php

namespace App\Http\Livewire\Admin;

use App\Jobs\Auth\UpdateUser;
use App\Models\Admin\Company;
use App\Models\Admin\Department;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Common\Catalog;
use App\Traits\Jobs;
use App\Traits\Uploads;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserEditModal extends Component
{
    use WithFileUploads, Uploads, Jobs;

    public $companySelect = [];
    public $password = null;
    public $password_confirmation = null;
    public $existingCompanies = [];
    public $enabled;
    public $userRolesIds = [];
    public $fileEdit;
    public $filesEdit = [];
    public $companyDepartments = [];
    public $observationEdit;

    public $idCompany;
    public $idContactEdit;
    public $contact;

    public $name;
    public $surname;
    public $email;
    public $phone;
    public $birth;
    public $gender;
    public $department;
    public $businessPhone;
    public $jobTitle;
    public $photo;
    public $personalNotes;
    public $workExperience;
    public $contractStart;
    public $contractEnd;
    public $contractType;
    public $employerCost;
    public $companies = [];
    public $departments = [];
    public $roles = [];
    public $userDepartmentsIds = [];
    public $user;

    public $competenceItems = [];
    public $skillItems = [];

    public $date = null;

    protected $listeners = [
        'competenceEdited',
        'skillEdited',
        'openUserEditModal' => 'edit',
    ];

    protected $rules = [

        'name' => 'required',
        'surname' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'password' => 'confirmed',
//        'companyDepartments' => 'required',
    ];


    public function mount()
    {
        $this->roles = Role::notSuperAdmin()->get()->toArray();
        $this->companies = Company::get()->toArray();
    }

    public function companySelection()
    {
        $this->departments = [];
        $this->departments = Department::where('company_id', $this->idCompany)->get();
        $this->userDepartmentsIds = [];
        foreach ($this->departments as $department) {
            $element = [];
            $element['id'] = $department['id'];
            $element['name'] = $department['name'];
            $element['selected'] = null;
            array_push($this->userDepartmentsIds, $element);
        }
    }

    public function edit($idUser = null)
    {
        $this->resetForm();
        if ($idUser) {
            $this->idContactEdit = $idUser;
            //$user = User::withoutGlobalScope(Company::class)->find($idUser);
            $user = User::find($idUser);
            $this->userRolesIds = $user->roles->pluck('id');
            $this->name = $user->name;
            $this->surname = $user->surname;
            $this->email = $user->email;
            $this->phone = $user->personal_phone;
            $this->birth = $user->date_birth;
            $this->businessPhone = $user->business_phone;
            $this->jobTitle = $user->job_title;
            $this->photo = $user->photo;
            $this->personalNotes = $user->personal_notes;
            $this->gender = $user->gender;
            $this->department = $user->departments->first()->id ?? null;
            $this->employerCost = $user->employer_cost;
            $this->workExperience = $user->work_experience;
            $this->contractType = $user->contract_type;
            $this->contractStart = $user->contract_start;
            $this->contractEnd = $user->contract_end;
            $this->competenceItems = $user->competencies;
            $this->skillItems = $user->working_skills;
            $this->emit('loadEditedData', 'competence', $this->competenceItems);
            $this->emit('loadEditedData', 'skill', $this->skillItems);
            $this->genders = Catalog::catalogName('genders')->first()->details;
            //$this->departments = Department::all();
            $this->filesEdit = [];
            foreach ($user->media as $item) {
                $fileElement = [];
                $fileElement['id'] = $item->id;
                $fileElement['name'] = $item->filename;
                $fileElement['file'] = null;
                $fileElement['observation'] = $item->comments;
                $fileElement['date'] = $item->date;
                $fileElement['delete'] = false;
                array_push($this->filesEdit, $fileElement);
            }
            $userRolesIds = $user->roles->pluck('id')->toArray();
            $this->userRolesIds = [];
            foreach ($this->roles as $rol) {
                $element = [];
                $element['id'] = $rol['id'];
                $element['name'] = $rol['name'];
                $element['selected'] = in_array($rol['id'], $userRolesIds) ? $rol['id'] : null;
                array_push($this->userRolesIds, $element);
            }
            $this->enabled = $user->enabled;
            //$this->companySelect = $user->companies->pluck('id', 'name')->toArray();
            $departmentCompany = $user->departments;
            $this->companyDepartments = [];
            foreach ($departmentCompany as $item) {
                $company = Company::where('id', $item['company_id'])->get()->toArray();
                $element = [];
                $element['company_id'] = $item['company_id'];
                $element['company'] = $company[0]['name'];
                $element['department'] = $item['name'];
                $element['department_id'] = $item['id'];
                array_push($this->companyDepartments, $element);
            }
            $this->user = $user;
        }
    }

    public function update()
    {
        $this->validate();
        if ($this->employerCost == '') {
            $this->employerCost = null;
        }
        $data = [
            'name' => $this->name,
            'surname' => $this->surname,
            'job_title' => $this->jobTitle,
            'email' => $this->email,
            'business_phone' => $this->businessPhone,
            'personal_phone' => $this->phone,
            'gender' => $this->gender,
            'date_birth' => $this->birth,
            'photo' => $this->photo,
            'personal_notes' => $this->personalNotes,
            'enabled' => $this->enabled,
            'work_experience' => $this->workExperience,
            'contract_type' => $this->contractType,
            'employer_cost' => $this->employerCost != 0 ? $this->employerCost : null,
            'contract_start' => $this->contractStart,
            'contract_end' => $this->contractEnd,
            'competencies' => $this->competenceItems,
            'working_skills' => $this->skillItems,
        ];
        if ($this->password) {
            $data['password'] = $this->password;
        }
        $response = $this->ajaxDispatch(new UpdateUser($this->user, $data));
        $id = $response['data']->id;
        $user = User::find($id);
        $company = [];
        $department = [];
        $contCompany = 0;
        foreach ($this->companyDepartments as $element) {
            if (array_search($element['company_id'], array_column($company, 'company_id')) === false) {
                $company[$contCompany++] = $element['company_id'];
            }
            if (array_search($element['department_id'], array_column($department, 'department_id')) === false) {
                $department[$element['department_id']] = ['company_id' => $element['company_id']];
            }

        }
        $user->companies()->Sync($company);
        $user->departments()->sync($department);
        $roles = [];
        foreach ($this->userRolesIds as $rol) {
            if ($rol['selected']) {
                $element = [];
                $element['role_id'] = $rol['id'];
                array_push($roles, $element);
            }
        }
        $user->roles()->Sync($roles);

        foreach ($this->filesEdit as $item) {
            if ($item['file']) {
                $media = $this->getMedia($item['file'], 'contact', null, $item['observation'])->id;
                $user->attachMedia($media, 'file');
            } else {
                if ($item['delete']) {
                    $user->detachMedia($item['id']);
                }
            }
        }
        $this->date = null;

        flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.users', 1)]))->success();
        return $this->redirect(route('users.index'));
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->emit('toggleUserEditModal');
    }

    public function render()
    {
        $this->existingCompanies = [];
        foreach ($this->companies as $company) {
            $element = [];
            $element['id'] = $company['id'];
            $element['name'] = $company['name'];
            if (in_array($company['id'], $this->companySelect)) {
                $element['selected'] = true;
            }
            array_push($this->existingCompanies, $element);
        }
        $genders = Catalog::catalogName('genders')->first()->details;
        $departments = Department::all();
        $this->emit('refreshDropdown');
        return view('livewire.admin.user-edit-modal', compact('genders', 'departments'));
    }

    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function competenceEdited($elements)
    {
        $this->competenceItems = $elements;
    }

    public function skillEdited($elements)
    {
        $this->skillItems = $elements;
    }

    public function removeEditFile($name)
    {
        $key = array_search($name, array_column($this->filesEdit, 'name'));
        if ($this->filesEdit[$key]['file']) {
            $removedElement = array_splice($this->filesEdit, array_search($name, array_column($this->filesEdit, 'id')), 1);
        } else {
            $this->filesEdit[$key]['delete'] = true;
        }
    }

    public function addDepartment()
    {

        $this->validate(
            [
                'idCompany' => 'required',
                'userDepartmentsIds.*.id' => 'required',
            ]
        );
        foreach ($this->userDepartmentsIds as $deparment) {
            if ($deparment['selected']) {
                $element = [];
                $foundCompanyKey = array_search($this->idCompany, array_column($this->companies, 'id'));
                $foundCompany = $this->companies[$foundCompanyKey];
                if (array_search($deparment['id'], array_column($this->companyDepartments, 'department_id')) === false) {
                    $element['company_id'] = $this->idCompany;
                    $element['company'] = $foundCompany['name'];
                    $element['department'] = $deparment['name'];
                    $element['department_id'] = $deparment['id'];
                    array_push($this->companyDepartments, $element);
                }
            }
        }
    }

    public function addEditFile()
    {
        $this->validate(
            [
                'fileEdit' => 'required',
                'observationEdit' => 'required',
                'date' => 'required',
            ]
        );
        $fileElement = [];
        $fileElement['id'] = substr($this->fileEdit, 5);
        $fileElement['name'] = $this->fileEdit->getClientOriginalName();
        $fileElement['file'] = $this->fileEdit;
        $fileElement['observation'] = $this->observationEdit;
        $fileElement['delete'] = false;
        array_push($this->filesEdit, $fileElement);
        $this->observationEdit = '';
        $this->dispatchBrowserEvent('fileReset');
    }

    public function removeCompanyDepartment($department)
    {
        array_splice($this->companyDepartments, array_search($department, array_column($this->companyDepartments, 'department_id')), 1);
    }
}
