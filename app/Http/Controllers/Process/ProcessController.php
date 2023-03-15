<?php

namespace App\Http\Controllers\Process;

use App\Abstracts\Http\Controller;
use App\Http\Requests\Process\ProcessRequest;
use App\Jobs\Process\CreateProcess;
use App\Jobs\Process\CreateProcessInputs;
use App\Jobs\Process\CreateProcessOutputs;
use App\Jobs\Process\DeleteProcess;
use App\Jobs\Process\UpdateProcess;
use App\Models\Admin\Department;
use App\Models\Auth\User;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Process\Activity;
use App\Models\Process\Process;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public $search = '';

    public function index(): View
    {
        if (user()->can('process-view-process') || user()->can('process-manage-process')) {
            return view('modules.process.processes.index');
        } else {
            abort(403);
        }
    }

    public function showProcess(Department $department)
    {
        if (user()->can('process-view-process-information') || user()->isMemberOfDepartment($department->id)) {
            return view('modules.process.processes.showProcess', ['department' => $department]);
        } else {
            abort(403);
        }
    }

    /**
     * /**
     * Store a newly created resource in storage.
     *
     * @param ProcessRequest $request
     * @return RedirectResponse
     */
    public function store(ProcessRequest $request): RedirectResponse
    {
        $response = $this->ajaxDispatch(new CreateProcess($request));
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.module_process', 1)]))->success();
        } else {
            flash($response['message'])->error();
        }
        return redirect()->route('processes.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Process $process
     * @return View
     */
    public function edit(Process $process): View
    {
        $users = User::collect();
        $indicators = Indicator::collect();
        $activities = Activity::where('process_id', $process->id)->paginate();
        $products = config('constants.catalog.PRODUCTS');
        return view('modules.process.processes.edit', compact('process', 'users', 'indicators', 'activities', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProcessRequest $request
     * @param Process $process
     * @return RedirectResponse
     */
    public function update(ProcessRequest $request, Process $process): RedirectResponse
    {
        $response = $this->ajaxDispatch(new UpdateProcess($request, $process));
        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.module_process', 1)]))->success();
        } else {
            flash($response['message'])->error();
        }
        return redirect()->route('processes.edit', compact('process'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Process $process
     * @return RedirectResponse
     */
    public function destroy(Process $process): RedirectResponse
    {
        $response = $this->ajaxDispatch(new DeleteProcess($process));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.module_process', 1)]))->success();
        } else {
            flash($response['message'])->error();
        }
        return redirect()->route('processes.index');
    }

    public function showInformation(Process $process, $page)
    {
        if (user()->can('process-view-process-information')) {
            $users = User::get();
            $process->load(['activitiesProcess', 'indicators', 'risks']);
            $userDepartments = Department::whereHas('users', function (Builder $query) use ($process) {
                $query->where('id', $process->owner_id);
            })->get();
            return view('modules.process.plan.information', ['process' => $process, 'subMenu' => 'showInformation', 'page' => $page, 'users' => $users, 'userDepartments' => $userDepartments]);
        } else {
            abort(403);
        }
    }

    public function showRisks(Process $process, $page)
    {
        if (user()->can('process-manage-risks-process') || user()->can('process-view-risks-process')) {
            $users = User::get();
            $process->load(['activitiesProcess', 'indicators', 'risks']);
            $userDepartments = Department::whereHas('users', function (Builder $query) use ($process) {
                $query->where('id', $process->owner_id);
            })->get();
            return view('modules.process.plan.risks', ['process' => $process, 'subMenu' => 'showRisks', 'page' => $page, 'users' => $users, 'userDepartments' => $userDepartments]);

        } else {
            abort(403);
        }
    }

    public function showPlanChanges(Process $process, $page)
    {
        if (user()->can('process-manage-changes') || user()->can('process-view-changes')) {
            $users = User::get();
            $process->load(['activitiesProcess', 'indicators', 'risks']);
            $userDepartments = Department::whereHas('users', function (Builder $query) use ($process) {
                $query->where('id', $process->owner_id);
            })->get();
            return view('modules.process.plan.planChanges', ['process' => $process, 'subMenu' => 'showPlanChanges', 'page' => $page, 'users' => $users, 'userDepartments' => $userDepartments]);

        } else {
            abort(403);
        }
    }

    public function showFiles(Process $process, $page)
    {
        if (user()->can('process-manage-files-process') || user()->can('process-view-files-process')) {
            $users = User::get();
            $process->load(['activitiesProcess', 'indicators', 'risks']);
            $userDepartments = Department::whereHas('users', function (Builder $query) use ($process) {
                $query->where('id', $process->owner_id);
            })->get();
            return view('modules.process.plan.files', ['process' => $process, 'subMenu' => 'showFiles', 'page' => $page, 'users' => $users, 'userDepartments' => $userDepartments]);

        } else {
            abort(403);
        }
    }

    public function showIndicators(Process $process, $page)
    {
        if (user()->can('process-view-indicators') || user()->can('process-manage-indicators') || user()->can('process-view-risks-process')) {
            $users = User::get();
            $process->load(['activitiesProcess', 'indicators', 'risks']);
            $userDepartments = Department::whereHas('users', function (Builder $query) use ($process) {
                $query->where('id', $process->owner_id);
            })->get();
            return view('modules.process.plan.indicators', ['process' => $process, 'subMenu' => 'showIndicators', 'page' => $page, 'users' => $users, 'userDepartments' => $userDepartments]);

        } else {
            abort(403);
        }
    }

    public function showActivities(Process $process, $page)
    {
        if (user()->can('process-manage-activities-process') || user()->can('process-view-activities-process')) {
            abort(403);
        } else {
            $users = User::get();
            $process->load(['activitiesProcess', 'indicators', 'risks']);
            $userDepartments = Department::whereHas('users', function (Builder $query) use ($process) {
                $query->where('id', $process->owner_id);
            })->get();
            return view('modules.process.plan.activities', ['process' => $process, 'subMenu' => 'showActivities', 'page' => $page, 'users' => $users, 'userDepartments' => $userDepartments]);

        }
    }

    public function showConformities(Process $process, $page)
    {
        if (user()->can('process-view-conformities') || user()->can('process-manage-conformities') || user()->can('process-close-conformities')) {
            $users = User::get();
            $process->load(['activitiesProcess', 'indicators', 'risks']);
            $userDepartments = Department::whereHas('users', function (Builder $query) use ($process) {
                $query->where('id', $process->owner_id);
            })->get();
            return view('modules.process.plan.conformities', ['process' => $process, 'subMenu' => 'showConformities', 'page' => $page, 'users' => $users, 'userDepartments' => $userDepartments]);
        } else {
            abort(403);
        }
    }
}