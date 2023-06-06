<?php

namespace App\Listeners\Projects\Activities;

use App\Events\Projects\Activities\TaskCreated;
use App\Models\Projects\Activities\Task;
use Exception;
use Illuminate\Support\Facades\DB;
use function session;

class DuplicateActivity
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\Projects\Activities\TaskCreated $event
     * @return Task
     */
    public function handle(TaskCreated $event)
    {
        //
        try {
            DB::beginTransaction();
            $task = $event->task;
            $project = $task->project;
            if ($task->project->company_id == $task->company_id) {
                $subsidiaries = $project->subsidiaries;
                if ($subsidiaries->count() > 1) {
                    foreach ($subsidiaries->where('company_id', '<>', session('company_id')) as $company) {
                        $searchTask = Task::where('code', $task->code)
                            ->where('project_id', $project->id)
                            ->where('company_id', $company->company_id)->pluck('id');
                        $random = self::searchRandomInTasks($task);
                        if ($searchTask->count() < 1) {
                            $newTask = $task->replicate();
                            $newTask->company_id = $company->company_id;
                            $newTask->code = $random;
                            $newTask->save();
                        }
                    }
                }
            }
            DB::commit();
            return $task;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }

    }

    public function searchRandomInTasks($task)
    {
        $random = rand(0, 999);
        $codeTasks = Task::where('parent', $task->parent)
            ->where('company_id', $task->company_id)
            ->where('project_id', $task->project->id)
            ->pluck('code')->toArray();
        if (in_array($random, $codeTasks)) {
            self::searchRandomInTasks($task);
        } else {
            return $random;
        }
    }
}
