<?php

namespace App\Listeners\Projects;

use App\Events\Projects\ProjectSubsidiaryUpdated;
use App\Models\Projects\Activities\Task;

class CreateDeleteTasksOfProject
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
     * @param ProjectSubsidiaryUpdated $event
     * @return void
     */
    public function handle(ProjectSubsidiaryUpdated $event)
    {
        //
        $project = $event->project;
        $subsidiaries = $project->subsidiaries->where('company_id', '!=', $project->company_id);
        $primaryTasks = Task::where('project_id', $project->id)->where('type', 'task')->get();
        foreach ($subsidiaries->pluck('company_id') as $item) {
            $existTask = Task::withoutGlobalScope(\App\Scopes\Company::class)->where('project_id', $project->id)->where('company_id', $item)->where('type', 'task')->get();
            if ($existTask->count() <= 0) {
                foreach ($primaryTasks as $task) {
                    $random = self::searchRandomInTasks($task);
                        Task::create([
                            'code' => $random,
                            'text' => $task->text,
                            'description' => $task->description,
                            'duration' => $task->duration,
                            'progress' => $task->progress,
                            'start_date' => $task->start_date,
                            'end_date' => $task->end_date,
                            'parent' => $task->parent,
                            'type' => $task->type,
                            'sortorder' => $task->sortorder,
                            'open' => $task->open,
                            'color' => $task->color,
                            'status' => $task->status,
                            'impact' => $task->impact,
                            'complexity' => $task->complexity,
                            'amount' => $task->amount,
                            'weight' => $task->weight,
                            'project_id' => $task->project_id,
                            'company_id' => $item,
                            'owner' => $task->owner,
                            'indicator_id' => $task->indicator_id,
                            'taskable_id' => $task->taskable_id,
                            'taskable_type' => $task->taskable_type,
                            'objective_id' => $task->objective_id,
                            'owner_id' => $task->owner_id,
                        ]);
                }
            }
        }
    }

    public function searchRandomInTasks($task)
    {
        $random = rand(0, 999);
        $codeTasks = Task::where('parent', $task->parent)->pluck('code')->toArray();
        if (in_array($random, $codeTasks)) {
            self::searchRandomInTasks($task);
        } else {
            return $random;
        }
    }
}
