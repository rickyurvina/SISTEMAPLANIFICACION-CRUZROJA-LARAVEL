<?php

namespace App\Listeners\Measure;

use App\Events\Measure\MeasureCreated;
use App\Models\Measure\Measure;

class UpdateMeasureWeight
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
     * @param MeasureCreated $event
     *
     * @return void
     */
    public function handle(MeasureCreated $event)
    {
        $measures = Measure::where([
            ['indicatorable_id', '=', $event->measure->indicatorable_id],
            ['indicatorable_type', '=', $event->measure->indicatorable_type],
        ])->get();
        $measures->each(function ($item) {
            $item->weight = 1;
            $item->save();
        });
    }
}
