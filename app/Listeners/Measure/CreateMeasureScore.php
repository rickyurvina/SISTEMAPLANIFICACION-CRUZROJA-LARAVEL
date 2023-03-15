<?php

namespace App\Listeners\Measure;

use App\Events\Measure\MeasureCreated;
use App\Models\Measure\Calendar;
use App\Models\Measure\Measure;
use App\Models\Measure\Score;

class CreateMeasureScore
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
        $calendars = Calendar::where('frequency', $event->measure->calendar->frequency)->with('periods')->get();
        foreach ($calendars as $calendar) {
            foreach ($calendar->periods as $period) {
                Score::create([
                    'color' => 'gray',
                    'data_type' => $event->measure->data_type,
                    'thresholds' => $event->measure->series,
                    'period_id' => $period->id,
                    'scoreable_type' => Measure::class,
                    'scoreable_id' => $event->measure->id,
                ]);
            }
        }
    }
}
