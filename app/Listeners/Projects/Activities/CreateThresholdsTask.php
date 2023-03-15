<?php

namespace App\Listeners\Projects\Activities;

use App\Events\Projects\Activities\TaskCreated;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Configuration\ProjectThreshold;

class CreateThresholdsTask
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
     * @param  \App\Events\Projects\Activities\TaskCreated  $event
     * @return void
     */
    public function handle(TaskCreated $event)
    {
        //
        $task = $event->task;
        $properties =
            [
                'time' =>
                    [
                        'min' => 50,
                        'max' => 70
                    ],
                'progress' =>
                    [
                        'min' => 50,
                        'max' => 70
                    ],
            ];
        $data =
            [
                'description' => 'Umbral de medida de la actividad ' . $task->text,
                'progress_physic' => 0,
                'thresholdable_id' => $task->id,
                'thresholdable_type' => Task::class,
                'properties' => $properties
            ];
        ProjectThreshold::create($data);
    }
}
