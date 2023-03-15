<?php

namespace App\Jobs\Projects;

use App\Abstracts\Job;
use App\Models\Projects\Activities\Task;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateProjectActivityWeight extends Job
{

    protected bool $projectActivityWeightResult;
    protected $task;
    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Task $task, $request)
    {
        //
        $this->task = $task;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        try {
            DB::beginTransaction();
            $this->updateWeight();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            $this->projectActivityWeightResult = false;
            throw new Exception($exception->getMessage());
        }
        return $this->projectActivityWeightResult;
    }

    public function updateWeight()
    {
        $tasks = Task::where('parent', $this->task->parent)->get();
        $tasksProject = Task::where('project_id', $this->task->project_id)->where('type','task')->get();
        $minCost = $tasksProject->min('amount') ?? 0;
        $maxCost = $tasksProject->max('amount') ?? 0;
        $minDuration = $tasksProject->min('duration');
        $maxDuration = $tasksProject->max('duration');
        $differenceCost = $maxCost - $minCost;
        $differenceDuration = $maxDuration - $minDuration;
        $allActivitiesHasCost = true;
        foreach ($tasksProject as $item) {
            if ($item->amount == null) {
                $allActivitiesHasCost = false;
                break;
            }
        }
        if (!$differenceCost || !$differenceDuration || $allActivitiesHasCost == false) {
            Task::where('parent', $this->task->parent)
                ->update(['weight' => 1 / $tasks->count()]);
        } else {
            foreach ($tasks as $item) {
                $normalizedCost = 1 + (($item->amount - $minCost) * 2 / $differenceCost);
                $normalizedDuration = 1 + (($item->duration - $minDuration) * 2 /$differenceDuration);
                $index = $normalizedCost + $item->complexity + $normalizedDuration;
                Task::where('id', $item->id)
                    ->update(['weight' => $index]);
            }
        }
        DB::commit();
        $updatedTasks = Task::where('parent', $this->task->parent)->get();
        $totalIndex = $updatedTasks->sum('weight');
        if ($totalIndex > 0) {
            foreach ($updatedTasks as $item) {
                $weight = $item->weight / $totalIndex;
                Task::where('id', $item->id)
                    ->update(['weight' => $weight]);
            }
        }
    }
}
