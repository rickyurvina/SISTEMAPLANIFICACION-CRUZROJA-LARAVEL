<?php

namespace App\Listeners\Measure;

use App\Events\Measure\MeasureUpdated;
use App\Models\Measure\Calendar;
use App\Models\Measure\Measure;
use App\Models\Measure\Score;
use Illuminate\Support\Facades\DB;

class DeleteMeasureScore
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
     * @param \App\Events\Measure\MeasureUpdated $event
     * @return void
     */
    public function handle(MeasureUpdated $event)
    {
        try {
            DB::beginTransaction();
            if (isset($event->measure->getChanges()['series']) || isset($event->measure->getChanges()['scoring_type_id']) || isset($event->measure->getChanges()['calendar_id']) || isset($event->measure->getChanges()['scoring_type_id'])) {
                $event->measure->scores->each->forceDelete();
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
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
