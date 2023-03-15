<?php

namespace App\Listeners\Projects\Activities;

use App\Events\Projects\Activities\TaskColorUpdated;
use App\Listeners\Exception;
use Illuminate\Support\Facades\DB;

class UpdateChildsColor
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
     * @param \App\Events\Projects\Activities\TaskColorUpdated $event
     * @return void
     */
    public function handle(TaskColorUpdated $event)
    {

        try {
            DB::beginTransaction();
            $task = $event->task;
            $task->childs()->update(['color' => $task->color]);
            DB::commit();
            return $task;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
