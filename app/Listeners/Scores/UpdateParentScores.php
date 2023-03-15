<?php

namespace App\Listeners\Scores;

use App\Events\ScoreUpdate;

class UpdateParentScores
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
     * @param  \App\Events\ScoreUpdate  $event
     * @return void
     */
    public function handle(ScoreUpdate $event)
    {
        //
        $score=$event->score;
    }
}
