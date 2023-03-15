<?php

namespace App\Http\Livewire\Admin;

use App\Jobs\Auth\CreateUser;
use App\Models\Admin\Company;
use App\Models\Admin\Department;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Common\Catalog;
use App\Traits\Jobs;
use App\Traits\Uploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserCreateModal extends Component
{
    use WithFileUploads, Jobs, Uploads;

    public $companySelect = [];
    public $password = null;
    public $password_confirmation = null;
    public $existingCompanies = [];

    public $file = null;
    public $files = [];
    public $companyDepartments = [];
    public $observation = null;
    public $name = null;
    public $surname = null;
    public $email = null;
    public $phone = null;
    public $birth = null;
    public $gender = null;
    public $businessPhone = null;
    public $jobTitle = null;
    public $photo = null;
    public $personalNotes = null;
    public $workExperience = null;
    public $contractStart = null;
    public $contractEnd = null;
    public $contractType = null;
    public $employerCost = null;
    public $department = null;
    public $idCompany;
    public $companies = [];
    public $departments = [];
    public $roles = [];
    public $userRolesIds = [];
    public $userDepartmentsIds = [];

    public $competenceItems = [];
    public $skillItems = [];
    public $date = null;
    public $enabled;

    protected $listeners = [
        'competenceAdded',
        'skillAdded',
        'loadForm' => 'render',
    ];

    protected $rules = [
        'name' => 'required',
        'surname' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'password' => 'required|confirmed',
        'employerCost' => 'nullable|numeric',
        'companyDepartments' => 'required',
    ];

    public function mount()
    {
        $this->roles = Role::notSuperAdmin()->get();
        $this->userRolesIds = [];
        foreach ($this->roles as $rol) {
            $element = [];
            $element['id'] = $rol['id'];
            $element['name'] = $rol['name'];
            $element['selected'] = null;
            array_push($this->userRolesIds, $element);
        }
        //$this->companies = Company::with('settings')->get()->toArray();
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
        $this->emit('refreshDropdown');
        return view('livewire.admin.user-create-modal', compact('genders'));
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
                'name',
                'surname',
                'jobTitle',
                'email',
                'businessPhone',
                'phone',
                'gender',
                'birth',
                'photo',
                'personalNotes',
                'workExperience',
                'contractType',
                'employerCost',
                'contractStart',
                'contractEnd',
                'competenceItems',
                'skillItems',
                'department',
            ]
        );
    }

    public function submit()
    {
        $this->validate();
        $data = [
            'name' => $this->name,
            'surname' => $this->surname,
            'password' => $this->password,
            'job_title' => $this->jobTitle,
            'email' => $this->email,
            'business_phone' => $this->businessPhone,
            'personal_phone' => $this->phone,
            'gender' => $this->gender,
            'date_birth' => $this->birth,
            'photo' => $this->photo,
            'personal_notes' => $this->personalNotes,
            'enabled' => 1,
            'work_experience' => $this->workExperience,
            'contract_type' => $this->contractType,
            'employer_cost' => $this->employerCost != 0 ? $this->employerCost : null,
            'contract_start' => $this->contractStart,
            'contract_end' => $this->contractEnd,
            'competencies' => $this->competenceItems,
            'working_skills' => $this->skillItems,
            'company_id' => $this->idCompany?$this->idCompany:session('company_id'),
            'department' => $this->department,
            'companyDepartments' => $this->companyDepartments,
            'userRolesIds' => $this->userRolesIds,
            'files' => $this->files
        ];
        $response = $this->ajaxDispatch(new CreateUser($data));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.users', 1)]))->success();
            return redirect()->route('users.index');

        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->emit('toggleUserAddModal');
    }

    public function competenceAdded($elements)
    {
        $this->competenceItems = $elements;
    }

    public function skillAdded($elements)
    {
        $this->skillItems = $elements;
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

    public function addFile()
    {
        $this->validate(
            [
                'file' => 'required',
                'observation' => 'required',
                'date' => 'required',
            ]
        );
        $fileElement = [];
        $fileElement['name'] = substr($this->file, 5);
        $fileElement['file'] = $this->file;
        $fileElement['observation'] = $this->observation;
        $fileElement['date'] = $this->date . "-01";
        $fileElement['user_id'] = Auth::id();
        array_push($this->files, $fileElement);
        $this->observation = '';
        $this->dispatchBrowserEvent('fileReset');
    }

    public function removeFile($name)
    {
        array_splice($this->files, array_search($name, array_column($this->files, 'name')), 1);
    }

    public function removeCompanyDepartment($department)
    {
        array_splice($this->companyDepartments, array_search($department, array_column($this->companyDepartments, 'department_id')), 1);
    }
}
