<?php

namespace App\Listeners\Projects;

use App\Events\Projects\ProjectColorUpdated;

class UpdatedColorResults
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
     * @param  ProjectColorUpdated  $event
     * @return void
     */
    public function handle(ProjectColorUpdated $event)
    {
        //
        $objective=$event->objective;
        $results=$objective->results;

        $results->each(function ($item) use ($objective){
            $item->update(['color'=>$objective->color]);
        });
    }
}
