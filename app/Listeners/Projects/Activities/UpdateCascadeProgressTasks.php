<?php

namespace App\Listeners\Projects\Activities;

use App\Events\Projects\Activities\TaskDetailUpdated;

class UpdateCascadeProgressTasks
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
     * @param TaskDetailUpdated $event
     * @return void
     */
    public function handle(TaskDetailUpdated $event)
    {
        $taskDetail = $event->taskDetail;
        $task = $taskDetail->task;
        $project = $task->project;
        $parent = $task->parentOfTask()->first();
        $goalTask = $task->goals->sum('goal');
        $advanceTask = $task->goals->sum('progress');
        $task->goal = $goalTask;
        $task->advance = $advanceTask;

        $task->save();
        $parentGoal = $parent->childs->sum('goal');
        $parentAdvance = $parent->childs->sum('advance');
        $parent->goal = $parentGoal;
        $parent->advance = $parentAdvance;

        $parent->save();
        $results = $project->tasks->where('parent', '!=', 'root')->where('type', 'project');
        $goalProject = 0;
        $advanceProject = 0;
        foreach ($results as $result) {
            $goalProject += $result->goal;
            $advanceProject += $result->advance;
        }
        if (isset($taskDetail->getChanges()['progress'])){
            if ($taskDetail->task->indicator) {
                $indicator = $taskDetail->task->indicator;
                $oldTask = $indicator->total_actual_value;
                $oldTask = $oldTask + $taskDetail->getChanges()['progress'];
                $indicator->total_actual_value = $oldTask;
                $indicator->save();
            }
        }
    }
}
