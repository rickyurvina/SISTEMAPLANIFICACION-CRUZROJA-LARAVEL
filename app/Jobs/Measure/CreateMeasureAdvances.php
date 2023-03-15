<?php

namespace App\Jobs\Measure;

use App\Abstracts\Job;
use App\Models\Measure\Calendar;
use App\Models\Measure\MeasureAdvances;
use App\Models\Measure\Period;
use App\Models\Poa\PoaActivity;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateMeasureAdvances extends Job
{

    protected $poaProgramActivity;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($poaProgramActivity)
    {
        $this->poaProgramActivity = $poaProgramActivity;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $poaActivity = $this->poaProgramActivity;
        $currentYear = $poaActivity->program->poa->year;
        $scores = $poaActivity->measure->scores;
        $calendar = $poaActivity->measure->calendar;
        $periods = Period::whereIn('id', $scores->pluck('period_id')->toArray())->get();
        foreach ($periods as $period) {
            $yearOfPeriod = $period->start_date->format('Y');
            if ($currentYear == $yearOfPeriod) {
                switch ($calendar) {
                    case  $calendar->frequency == Calendar::FREQUENCY_MONTHLY:
                        self::calendarMonthly($poaActivity, $period);
                        break;
                    case  $calendar->frequency == Calendar::FREQUENCY_QUARTERLY:
                        self::calendarQuarterly($poaActivity, $period);
                        break;
                    case  $calendar->frequency == Calendar::FREQUENCY_SEMESTER:
                        self::calendarSemester($poaActivity, $period);
                        break;
                    case  $calendar->frequency == Calendar::FREQUENCY_YEARLY:
                        self::calendarYearly($poaActivity, $period);
                        break;
                }
            }
        }
    }

    public function calendarYearly($poaActivity, $period)
    {
        for ($i = 1; $i <= 12; $i++) {
            MeasureAdvances::create(
                [
                    'aggregation_type' => $poaActivity->aggregation_type,
                    'period_id' => $period->id,
                    'measurable_type' => PoaActivity::class,
                    'measurable_id' => $this->poaProgramActivity->id,
                    'unit_id' => $poaActivity->measure->unit_id,
                ]
            );
        }
    }

    public function calendarMonthly($poaActivity, $period)
    {
        MeasureAdvances::create(
            [
                'aggregation_type' => $poaActivity->aggregation_type,
                'period_id' => $period->id,
                'measurable_type' => PoaActivity::class,
                'measurable_id' => $this->poaProgramActivity->id,
                'unit_id' => $poaActivity->measure->unit_id,
            ]
        );
    }

    public function calendarQuarterly($poaActivity, $period)
    {
        for ($i = 1; $i <= 3; $i++) {
            MeasureAdvances::create(
                [
                    'aggregation_type' => $poaActivity->aggregation_type,
                    'period_id' => $period->id,
                    'measurable_type' => PoaActivity::class,
                    'measurable_id' => $this->poaProgramActivity->id,
                    'unit_id' => $poaActivity->measure->unit_id,
                ]
            );
        }
    }

    public function calendarSemester($poaActivity, $period)
    {
        for ($i = 1; $i <= 6; $i++) {
            MeasureAdvances::create(
                [
                    'aggregation_type' => $poaActivity->aggregation_type,
                    'period_id' => $period->id,
                    'measurable_type' => PoaActivity::class,
                    'measurable_id' => $this->poaProgramActivity->id,
                    'unit_id' => $poaActivity->measure->unit_id,
                ]
            );
        }
    }
}
