<?php

namespace App\Listeners\Strategy;

use App\Events\Strategy\PlanDetailCreated;
use App\Models\Measure\Calendar;
use App\Models\Measure\Score;

class CreatePlanDetailScore
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
     * @param PlanDetailCreated $event
     *
     * @return void
     */
    public function handle(PlanDetailCreated $event)
    {
        $calendars = Calendar::whereIn('frequency', Calendar::CALENDARS)
            ->with('periods')
            ->get();
        foreach ($calendars as $calendar) {
            foreach ($calendar->periods as $period) {
                Score::create([
                    'color' => 'gray',
                    'thresholds' => [],
                    'period_id' => $period->id,
                    'scoreable_type' => $event->item::class,
                    'scoreable_id' => $event->item->id,
                ]);
            }
        }
    }
}
