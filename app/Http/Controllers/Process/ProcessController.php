<?php

namespace App\Http\Controllers\Process;

use App\Abstracts\Http\Controller;
use App\Http\Middleware\Azure\Azure;
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(Azure $azure)
    {
        $this->middleware('azure');
        $this->middleware('permission:process-manage');
        $this->middleware('permission:process-view|process-manage',
            [
                'only' => [
                    'index',
                    'showProcess',
                    'showInformation',
                    'showRisks',
                    'showPlanChanges',
                ]]);
        $this->middleware('permission:process-view-files|process-manage-files', ['only' => ['showFiles']]);
        $this->middleware('permission:process-view-evaluations|process-manage-evaluations', ['only' => ['showActivities']]);
        $this->middleware('permission:process-view-files|process-manage-files', ['only' => ['showFiles']]);
        $this->middleware('permission:process-view-activities|process-manage-activities', ['only' => ['showActivities']]);
        $this->middleware('permission:process-view-risks|process-manage-risks', ['only' => ['showRisks']]);
        $this->middleware('permission:process-view-conformities|process-close-conformities', ['only' => ['showConformities']]);
    }

    public function index(): View
    {
        return view('modules.process.processes.index');
    }

    public function showProcess(Department $department)
    {
        return view('modules.process.processes.showProcess', ['department' => $department]);
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
        $users = User::get();
        $process->load(['activitiesProcess', 'indicators', 'risks']);
        $userDepartments = Department::whereHas('users', function (Builder $query) use ($process) {
            $query->where('id', $process->owner_id);
        })->get();
        return view('modules.process.plan.information', ['process' => $process, 'subMenu' => 'showInformation', 'page' => $page, 'users' => $users, 'userDepartments' => $userDepartments]);
    }

    public function showRisks(Process $process, $page)
    {
        $users = User::get();
        $process->load(['activitiesProcess', 'indicators', 'risks']);
        $userDepartments = Department::whereHas('users', function (Builder $query) use ($process) {
            $query->where('id', $process->owner_id);
        })->get();
        return view('modules.process.plan.risks', ['process' => $process, 'subMenu' => 'showRisks', 'page' => $page, 'users' => $users, 'userDepartments' => $userDepartments]);
    }

    public function showPlanChanges(Process $process, $page)
    {
        $users = User::get();
        $process->load(['activitiesProcess', 'indicators', 'risks']);
        $userDepartments = Department::whereHas('users', function (Builder $query) use ($process) {
            $query->where('id', $process->owner_id);
        })->get();
        return view('modules.process.plan.planChanges', ['process' => $process, 'subMenu' => 'showPlanChanges', 'page' => $page, 'users' => $users, 'userDepartments' => $userDepartments]);
    }

    public function showFiles(Process $process, $page)
    {
        $users = User::get();
        $process->load(['activitiesProcess', 'indicators', 'risks']);
        $userDepartments = Department::whereHas('users', function (Builder $query) use ($process) {
            $query->where('id', $process->owner_id);
        })->get();
        return view('modules.process.plan.files', ['process' => $process, 'subMenu' => 'showFiles', 'page' => $page, 'users' => $users, 'userDepartments' => $userDepartments]);
    }

    public function showIndicators(Process $process, $page)
    {
        $users = User::get();
        $process->load(['activitiesProcess', 'indicators', 'risks']);
        $userDepartments = Department::whereHas('users', function (Builder $query) use ($process) {
            $query->where('id', $process->owner_id);
        })->get();
        return view('modules.process.plan.indicators', ['process' => $process, 'subMenu' => 'showIndicators', 'page' => $page, 'users' => $users, 'userDepartments' => $userDepartments]);
    }

    public function showActivities(Process $process, $page)
    {
        $users = User::get();
        $process->load(['activitiesProcess', 'indicators', 'risks']);
        $userDepartments = Department::whereHas('users', function (Builder $query) use ($process) {
            $query->where('id', $process->owner_id);
        })->get();
        return view('modules.process.plan.activities', ['process' => $process, 'subMenu' => 'showActivities', 'page' => $page, 'users' => $users, 'userDepartments' => $userDepartments]);
    }

    public function showConformities(Process $process, $page)
    {
        $users = User::get();
        $process->load(['activitiesProcess', 'indicators', 'risks']);
        $userDepartments = Department::whereHas('users', function (Builder $query) use ($process) {
            $query->where('id', $process->owner_id);
        })->get();
        return view('modules.process.plan.conformities', ['process' => $process, 'subMenu' => 'showConformities', 'page' => $page, 'users' => $users, 'userDepartments' => $userDepartments]);
    }
}