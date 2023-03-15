<?php

namespace App\Http\Controllers\Admin;

use App\Abstracts\Http\Controller;
use App\Http\Requests\Admin\DepartmentRequest;
use App\Jobs\Admin\CreateDepartment;
use App\Jobs\Admin\DeleteDepartment;
use App\Jobs\Admin\UpdateDepartment;
use App\Models\Admin\Company;
use App\Models\Admin\Department;
use App\Models\Auth\User;
use App\Models\Strategy\PlanDetail;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        if (user()->can('admin-crud-admin') && user()->can('admin-read-admin') || user()->can('admin-manage-departments')) {
            $departments = Department::collect();
            return view('modules.admin.departments.index', compact('departments'));
        }else{
            abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        if (user()->can('admin-crud-admin')) {
            $companies = Company::collect();
            $departments = Department::where('enabled', 1)->get();
            $allPrograms = PlanDetail::get();
            $programs = [];
            foreach ($allPrograms as $program) {
                $programTemplateId = PlanRegisteredTemplateDetails::where('program', true)
                    ->where('id', $program->plan_registered_template_detail_id)
                    ->first();
                if ($programTemplateId) {
                    $elements = array_push($programs, $program);
                }
            }
            $users = User::all();
            return view('modules.admin.departments.create', compact('companies', 'departments', 'programs', 'users'));
        }else{
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DepartmentRequest $request
     * @return RedirectResponse
     */
    public function store(DepartmentRequest $request): RedirectResponse
    {
        $response = $this->ajaxDispatch(new CreateDepartment($request));
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.department', 1)]))->success();
            return redirect()->route('departments.index');
        } else {
            flash($response['message'])->error();
            return redirect()->route('departments.create');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Department $department
     * @param DepartmentRequest $request
     * @return RedirectResponse
     */
    public function update(Department $department, DepartmentRequest $request): RedirectResponse
    {
        $response = $this->ajaxDispatch(new UpdateDepartment($request, $department));

        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.department', 1)]))->success();
            return redirect()->route('departments.index');
        } else {
            flash($response['message'])->error();
            return redirect()->route('departments.edit');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Department $department
     * @return View
     */
    public function edit(Department $department): View
    {
        if (user()->can('admin-crud-admin')) {
            $departments = Department::enabled()->get();
            $allPrograms = PlanDetail::get();
            $programs = [];
            foreach ($allPrograms as $program) {
                $programTemplateId = PlanRegisteredTemplateDetails::where('program', true)
                    ->where('id', $program->plan_registered_template_detail_id)
                    ->first();
                if ($programTemplateId) {
                    $elements = array_push($programs, $program);
                }
            }
            if (isset($department->programs)) {
                $existing_departments = $department->programs->pluck('id');
                $selected_programs = array();
                foreach ($existing_departments as $index => $ind) {
                    $selected_programs[$index] = $ind;
                }
            }

            $users = User::all();
            return view('modules.admin.departments.edit', compact('department', 'departments', 'programs', 'users'), ['selected_programs' => $selected_programs]);
        }else{
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Department $department
     * @return RedirectResponse
     */
    public function destroy(Department $department): RedirectResponse
    {
        $response = $this->ajaxDispatch(new DeleteDepartment($department));

        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.department', 1)]))->success();
        } else {
            flash($response['message'])->error();
        }
        return redirect()->route('departments.index');
    }
}
