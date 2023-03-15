<?php

namespace App\Listeners\Projects\Activities;

use App\Events\Projects\Activities\TaskUpdatedCreateGoals;
use App\Models\Measure\Measure;
use App\Models\Measure\MeasureAdvances;
use App\Models\Measure\Period;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Activities\TaskDetails;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\DB;

class CreateTaskGoals
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
     * @param TaskUpdatedCreateGoals $event
     * @return void
     * @throws \Exception
     */
    public function handle(TaskUpdatedCreateGoals $event)
    {
        //
        $task = $event->task;

        try {
            DB::beginTransaction();
            if ($task->start_date && $task->end_date && $task->measure_id) {
                $numberMonths = $this->numberOfPeriods('P1M', '+0 month', $task);
                self::deleteMeasureAdvances($task);
                $measure = Measure::find($task->attributesToArray()['measure_id']);
                $calendar = $measure->calendar;
                foreach ($numberMonths as $item) {
                    $period = Period::whereCalendarId($calendar->id)
                        ->whereDate('start_date', '<=', $item)
                        ->whereDate('end_date', '>=', $item)
                        ->first();
                    if ($period) {
                        MeasureAdvances::create(
                            [
                                'aggregation_type' => $task->aggregation_type,
                                'period_id' => $period->id,
                                'measurable_type' => Task::class,
                                'measurable_id' => $task->id,
                                'period' => $item,
                                'unit_id' => $measure->unit_id,
                            ]
                        );
                    }
                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @param $task
     * @return void
     * @throws \Exception
     */
    public function deleteMeasureAdvances($task)
    {
        $measureAdvances = MeasureAdvances::where('measurable_id', $task->id)
            ->where('measurable_type', Task::class)->get();
        if ($measureAdvances) {
            try {
                DB::beginTransaction();
                $measureAdvances->each->forceDelete();
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollback();
                throw  new \Exception($exception->getMessage());
            }
        }
    }

    function numberOfPeriods($frequency = null, $modify = null, $task)
    {
        $begin = new DateTime($task->start_date);
        $end = new DateTime($task->end_date);
        $end = $end->modify($modify);
        $interval = new DateInterval($frequency);
        $daterange = new DatePeriod($begin, $interval, $end);
        $result = array();
        $i = 0;
        foreach ($daterange as $date) {
            $result[$i] = $date->format("Y-m-d");
            $i++;
        }
        return $result;
    }
}
