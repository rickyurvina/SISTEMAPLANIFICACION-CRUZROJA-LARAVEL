<?php

namespace App\Http\Controllers\Project;

use App\Abstracts\Http\Controller;
use App\Events\Projects\Activities\TaskUpdatedCreateGoals;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request, Project $project): JsonResponse
    {
        $task = new Task();
        $task->text = $request->text;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->duration = $request->duration;
        if ($request->type === 'task') {
            $task->status = Task::STATUS_PROGRAMMED;
        }
//        $task->owner = $request->owner;
        $task->type = $request->type;
//        $task->progress = $request->has("progress") ? $request->progress : 0;
        $task->parent = $request->parent;
        $task->sortorder = Task::max("sortorder") + 1;
        $task->project_id = $project->id;
        $task->project_id = $project->id;

        $task->company_id = session('company_id');

        $task->save();

        return response()->json([
            "action" => 'inserted',
            "tid" => $task->id
        ]);
    }

    private function updateParent($parent)
    {
        $tasks = Task::where('parent', $parent)->get();
//        $progress = 0;
//        foreach ($tasks as $item) {
//            $progress += $item->progress * $item->weight;
//        }
        $parentProject = Task::find($parent);
//        $parentProject->progress = $progress;
        $project = $parentProject->parent;
        $parentProject->save();

//        $parentProjects = Task::where('parent', $project)->get();
//        $progress = 0;
//        foreach ($parentProjects as $item) {
//            $progress += $item->progress * $item->weight / 100;
//        }
//        Task::where('id', $project)->update(['progress' => $progress]);
    }

    public function update(Request $request, Project $project, Task $task): JsonResponse
    {
        $task->text = $request->text;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        if ($task->duration != $request->duration && $task->type == 'task') {
            TaskUpdatedCreateGoals::dispatch($task);
        }
        $task->duration = $request->duration;
//        $task->owner = strlen($request->owner)>2 ? $request->owner : null ;
        $task->owner_id = $request->owner_id;
//        $task->type = $request->type;
//        $task->progress = $request->has("progress") ? $request->progress : 0;
        $task->parent = $request->parent;
        $task->open = $request->open;
        $task->save();

        if ($request->type == 'task') {
            $this->updateParent($task->parent);
        }

        if ($request->has("target")) {
            $this->updateOrder($task->id, $request->target);
        }
        $project->duration = $project->tasks->where('parent', '=', 'root')->first()->duration;
        $project->save();

        return response()->json([
            "action" => 'updated',
        ]);
    }

    public function delete(Project $project, Task $task): JsonResponse
    {
        $task->delete();
        return response()->json([
            "action" => 'deleted',
        ]);
    }

    private function updateOrder($taskId, $target)
    {
        $nextTask = false;
        $targetId = $target;

        if (strpos($target, "next:") === 0) {
            $targetId = substr($target, strlen("next:"));
            $nextTask = true;
        }

        if ($targetId == "null")
            return;

        $target = Task::find($targetId);
        $targetOrder = $target->sortorder;
        if ($nextTask)
            $targetOrder++;

        Task::where([
            ["sortorder", ">=", $targetOrder],
            ['project_id', '=', $target->project_id]
        ])->increment("sortorder");

        $updatedTask = Task::find($taskId);
        $updatedTask->sortorder = $targetOrder;
        $updatedTask->save();
    }
}
