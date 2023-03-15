<?php

namespace App\Jobs\Indicators\Indicator;

use App\Abstracts\Job;
use App\Models\Indicators\GoalIndicator\GoalIndicators;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Indicators\Threshold\Threshold;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreateIndicator extends Job
{
    protected $request;

    protected $indicator;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return Exception
     */
    public function handle()
    {
        DB::transaction(function () {
            $result = array();
            if ($this->request->threshold_type == Threshold::ASCENDING) {
                $result[0] = ['state' => Threshold::DANGER, 'max' => $this->request->maxAD];
                $result[1] = ['state' => Threshold::WARNING, 'min' => $this->request->minAW, 'max' => $this->request->maxAW];
                $result[2] = ['state' => Threshold::SUCCESS, 'min' => $this->request->minAS];
            } else {
                if ($this->request->threshold_type == Threshold::DESCENDING) {
                    $result[0] = ['state' => Threshold::DANGER, 'max' => $this->request->maxDD];
                    $result[1] = ['state' => Threshold::WARNING, 'min' => $this->request->minDW, 'max' => $this->request->maxDW];
                    $result[2] = ['state' => Threshold::SUCCESS, 'min' => $this->request->minDS];
                } else {
                    if ($this->request->threshold_type == Threshold::TOLERANCE) {
                        $result[0] = ['state' => Threshold::DANGER, 'max' => $this->request->maxTD];
                        $result[1] = ['state' => Threshold::WARNING, 'min' => $this->request->minTW, 'max' => $this->request->maxTW];
                        $result[2] = ['state' => Threshold::SUCCESS, 'min' => $this->request->minTS];
                    }
                }
            }

            $this->indicator = Indicator::create($this->request->except('start_date', 'end_date', 'goals_closed'));

            if ($this->request->goals_closed) {
                $this->indicator->goals_closed = Indicator::GOALS_CLOSED;
            }
            $startDate = $this->request->start_date;
            $endDate = $this->request->end_date;
            $lastDayofMonth = Carbon::parse($endDate)->endOfMonth()->toDateString();
            $endDate = $lastDayofMonth;
            $dates = $this->indicator->calcStartEndDateF($startDate, $endDate, $this->request->frequency);
            $this->indicator->start_date = $this->request->start_date;
            $this->indicator->end_date = $this->request->end_date;
            $this->indicator->f_start_date = $dates['f_start_date'];
            $this->indicator->f_end_date = $dates['f_end_date'];
            $this->indicator->threshold_properties = $result;

            if ($this->request->frequency == 1) {//si es anual
                $periods = $this->indicator->numberOfPeriods('P1Y', '+0 year');
                for ($i = 0; $i < count($periods); $i++) {
                    $date = DateTime::createFromFormat("d-m-Y", $periods[$i]);
                    $d = date("d-m-Y", strtotime($periods[$i] . "+ " . 11 . " month"));
                    $d = date("d-m-Y", strtotime($d . "+ " . 30 . " day"));
                    GoalIndicators::create([
                        'goal_value' => $this->request->freq[$i] ?? null,
                        'indicators_id' => $this->indicator->id,
                        'min' => $this->request->min[$i] ?? null,
                        'max' => $this->request->max[$i] ?? null,
                        'period' => $i + 1,
                        'user_updated' => auth()->user()->id,
                        'start_date' => Carbon::createFromFormat('d-m-Y', $periods[$i])->format('Y-m-d'),
                        'end_date' => Carbon::createFromFormat('d-m-Y', $d)->format('Y-m-d'),
                        'year' => $date->format("Y"),
                    ]);
                }
            } else {
                if ($this->request->frequency == 2) {//si es semestral
                    $periods = $this->indicator->numberOfPeriods('P6M', '+0 month');
                    for ($i = 0; $i < count($periods); $i++) {
                        $date = DateTime::createFromFormat("d-m-Y", $periods[$i]);
                        $d = date("d-m-Y", strtotime($periods[$i] . "+ " . 6 . " month"));
                        $d = date("d-m-Y", strtotime($d . "- " . 1 . " day"));
                        GoalIndicators::create([
                            'goal_value' => $this->request->freq[$i] ?? null,
                            'indicators_id' => $this->indicator->id,
                            'min' => $this->request->min[$i] ?? null,
                            'max' => $this->request->max[$i] ?? null,
                            'period' => $i + 1,
                            'user_updated' => auth()->user()->id,
                            'start_date' => Carbon::createFromFormat('d-m-Y', $periods[$i])->format('Y-m-d'),
                            'end_date' => Carbon::createFromFormat('d-m-Y', $d)->format('Y-m-d'),
                            'year' => $date->format("Y"),
                        ]);
                    }
                } else {
                    if ($this->request->frequency == 4) {//si es trimestral
                        $periods = $this->indicator->numberOfPeriods('P3M', '+0 month');
                        for ($i = 0; $i < count($periods); $i++) {
                            $date = DateTime::createFromFormat("d-m-Y", $periods[$i]);
                            $d = date("d-m-Y", strtotime($periods[$i] . "+ " . 3 . " month"));
                            $d = date("d-m-Y", strtotime($d . "- " . 1 . " day"));
                            GoalIndicators::create([
                                'goal_value' => $this->request->freq[$i] ?? null,
                                'indicators_id' => $this->indicator->id,
                                'min' => $this->request->min[$i] ?? null,
                                'max' => $this->request->max[$i] ?? null,
                                'period' => $i + 1,
                                'user_updated' => auth()->user()->id,
                                'start_date' => Carbon::createFromFormat('d-m-Y', $periods[$i])->format('Y-m-d'),
                                'end_date' => Carbon::createFromFormat('d-m-Y', $d)->format('Y-m-d'),
                                'year' => $date->format("Y"),
                            ]);
                        }
                    } else {
                        if ($this->request->frequency == 12) {
                            $periods = $this->indicator->numberOfPeriods('P1M', '+0 month');
                            for ($i = 0; $i < count($periods); $i++) {
                                $date = DateTime::createFromFormat("d-m-Y", $periods[$i]);
                                $d = date("d-m-Y", strtotime($periods[$i] . "+ " . 1 . " month"));
                                $d = date("d-m-Y", strtotime($d . "- " . 1 . " day"));
                                GoalIndicators::create([
                                    'goal_value' => $this->request->freq[$i] ?? null,
                                    'indicators_id' => $this->indicator->id,
                                    'min' => $this->request->min[$i] ?? null,
                                    'max' => $this->request->max[$i] ?? null,
                                    'period' => $i + 1,
                                    'user_updated' => auth()->user()->id,
                                    'start_date' => Carbon::createFromFormat('d-m-Y', $periods[$i])->format('Y-m-d'),
                                    'end_date' => Carbon::createFromFormat('d-m-Y', $d)->format('Y-m-d'),
                                    'year' => $date->format("Y"),
                                ]);
                            }
                        } else {
                            if ($this->request->frequency == 3) {//si es cuatimestral
                                $periods = $this->indicator->numberOfPeriods('P4M', '+0 month');
                                for ($i = 0; $i < count($periods); $i++) {
                                    $date = DateTime::createFromFormat("d-m-Y", $periods[$i]);
                                    $d = date("d-m-Y", strtotime($periods[$i] . "+ " . 4 . " month"));
                                    $d = date("d-m-Y", strtotime($d . "- " . 1 . " day"));
                                    GoalIndicators::create([
                                        'goal_value' => $this->request->freq[$i] ?? null,
                                        'indicators_id' => $this->indicator->id,
                                        'min' => $this->request->min[$i] ?? null,
                                        'max' => $this->request->max[$i] ?? null,
                                        'period' => $i + 1,
                                        'user_updated' => auth()->user()->id,
                                        'start_date' => Carbon::createFromFormat('d-m-Y', $periods[$i])->format('Y-m-d'),
                                        'end_date' => Carbon::createFromFormat('d-m-Y', $d)->format('Y-m-d'),
                                        'year' => $date->format("Y"),
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
            $this->indicator->total_goal_value = $this->indicator->indicatorGoals->sum('goal_value');
            $this->indicator->save();
        });
        return $this->indicator;

    }
}
