<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Company;
use App\Models\Admin\Department;
use App\Models\Auth\User;
use Livewire\Component;

class UserAssignDepartments extends Component
{
    public $departments = [];
    public $companies = [];
    public $user;
    public $existingDepartments = [];
    public $companyDepartments = [];
    public $userDepartmentsIds = [];
    public $idCompany;

    protected $listeners = [
        'openUserAssignDepartments',
    ];

    public function render()
    {
        return view('livewire.admin.user-assign-departments');
    }

    public function openUserAssignDepartments($idUser = null)
    {
        if ($idUser) {
            $this->user = User::find($idUser);
            $this->existingDepartments = $this->user->departments->pluck('id')->toArray();
            $companiesIds = $this->user->companies->pluck('id')->toArray();
            $companies = Company::whereIn('id', $companiesIds)->get();
            $this->companies = $companies->toArray();
            $departmentCompany = $this->user->departments;
            $this->companyDepartments = [];
            foreach ($departmentCompany as $item) {
                $company = $companies->where('id', $item['company_id'])->first();
                $element = [];
                $element['company_id'] = $item['company_id'];
                $element['company'] = $company->name;
                $element['department'] = $item['name'];
                $element['department_id'] = $item['id'];
                array_push($this->companyDepartments, $element);
            }
        }
    }

    public function update()
    {
        try {
            \DB::beginTransaction();
            $company = [];
            $department = [];
            $contCompany = 0;
            if (isset($this->companyDepartments)) {
                foreach ($this->companyDepartments as $element) {
                    if (array_search($element['company_id'], array_column($company, 'company_id')) === false) {
                        $company[$contCompany++] = $element['company_id'];
                    }
                    if (array_search($element['department_id'], array_column($department, 'department_id')) === false) {
                        $department[$element['department_id']] = ['company_id' => $element['company_id']];
                    }
                }
                $this->user->departments()->sync($department);
            }
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.users', 1)]))->success();
            \DB::commit();
            return redirect(route('users.index'));
        } catch (\Exception $exception) {
            flash(trans_choice('messages.error.updated', 0, ['type' => trans_choice('general.users', 1)]))->error()->livewire($this);
            \DB::rollBack();
        }
    }

    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->reset(['existingDepartments', 'user', 'companies']);
        $this->resetErrorBag();
        $this->resetValidation();
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

    public function removeCompanyDepartment($department)
    {
        unset($this->companyDepartments[$department]);
    }
}
