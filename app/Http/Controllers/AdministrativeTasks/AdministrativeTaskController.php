<?php

namespace App\Http\Controllers\AdministrativeTasks;

use App\Abstracts\Http\Controller;
use App\Models\AdministrativeTasks\AdministrativeTask;
use App\Models\Projects\Project;
use Illuminate\Database\Eloquent\Builder;
use function flash;
use function redirect;
use function view;

class AdministrativeTaskController extends Controller
{
    public $search = '';
    public array $selectedProjects = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project = null)
    {
        if (user()->cannot('manage-administrativeTasks-project' && 'view-administrativeTasks-project')) {
            abort(403);
        } else {
            $administrativeTasks = AdministrativeTask::where('project_id', $project->id)->collect();
            return view('modules.administrativeTask.administrativeTask', compact('administrativeTasks', 'project'))->with('page', 'admintask');
        }
    }

    public function indexAdmin()
    {
        return view('modules.administrativeTask.generalAdministrativeTask')->with('page', 'admintask');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexInternal(Project $project = null)
    {
        //
        $administrativeTasks = AdministrativeTask::collect();
        return view('modules.administrativeTask.administrativeTaskInternal', compact('administrativeTasks', 'project'))->with('page', 'admintask');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\AdministrativeTasks\AdministrativeTask $administrativeTask
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\AdministrativeTasks\AdministrativeTask $administrativeTask
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $administrativeTask_id)
    {
        //

        $task = AdministrativeTask::find($administrativeTask_id);
        $data = [
            'id' => $administrativeTask_id
        ];
        $response = $this->ajaxDispatch(new \App\Jobs\AdministrativeTasks\DeleteAdministrativeTask($data));
        if ($response['success']) {
            flash('messages.success.deleted', 0)->success();
            return redirect()->route('projects.administrativeTasks', $task->project->id);

        } else {
            flash($response['message'])->error();
            return redirect()->route('projects.administrativeTasks', $task->project->id);
        }
    }

    public function destroyAdmin(int $administrativeTask_id)
    {

        $task = AdministrativeTask::find($administrativeTask_id);
        $data = [
            'id' => $administrativeTask_id
        ];
        $response = $this->ajaxDispatch(new \App\Jobs\AdministrativeTasks\DeleteAdministrativeTask($data));
        if ($response['success']) {
            flash('messages.success.deleted', 0)->success();
            return redirect()->route('admin.administrativeTasks');

        } else {
            flash($response['message'])->error();
            return redirect()->route('admin.administrativeTasks');
        }
    }
}
