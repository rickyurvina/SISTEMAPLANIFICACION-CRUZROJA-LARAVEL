<?php

namespace App\Listeners\Projects;

use App\Events\Projects\ProjectActivityWeightChanged;
use App\Traits\Jobs;

class UpdateProjectActivityWeight
{
    use Jobs;
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
     * @param  ProjectActivityWeightChanged  $event
     * @return void
     */
    public function handle(ProjectActivityWeightChanged $event)
    {
        //
        $task=$event->task;
        $data=[
            'cost'=>$task->amout ?? 0,
            'complexity'=>$task->complexity,
            'duration'=>$task->duration,
        ];
        $this->ajaxDispatch(new \App\Jobs\Projects\UpdateProjectActivityWeight($task, $data));

    }
}
