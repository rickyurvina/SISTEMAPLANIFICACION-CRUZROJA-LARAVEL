<?php

namespace App\Listeners\Projects\Activities;

use App\Events\Projects\Activities\TaskUpdatedCreateGoals;
use App\Models\Projects\Activities\Task;
use Illuminate\Support\Facades\DB;

class UpdateDurationTask
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
     * @param \App\Events\Projects\Activities\TaskUpdatedCreateGoals $event
     * @return void
     * @throws \Exception
     */
    public function handle(TaskUpdatedCreateGoals $event)
    {
        try {
            DB::beginTransaction();
            $task = Task::findOrFail($event->task->id);
            $startDate = $task->start_date;
            $endDate = $task->end_date;
            if ($startDate < $endDate) {
                $hours = $startDate->diffInHours($endDate);
                $task->update(['duration' => $hours]);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

}
