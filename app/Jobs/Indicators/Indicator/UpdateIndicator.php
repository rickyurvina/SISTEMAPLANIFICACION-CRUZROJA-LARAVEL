<?php

namespace App\Jobs\Indicators\Indicator;

use App\Abstracts\Job;
use App\Models\Auth\User;
use App\Models\Indicators\GoalIndicator\GoalIndicators;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Indicators\Indicator\IndicatorParentChild;
use App\Models\Indicators\Threshold\Threshold;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateIndicator extends Job
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
     * @return void
     */
    public function handle()
    {
        try {
            DB::transaction(function () {
                $result = array();

                $result[0] = ['state' => Threshold::DANGER, 'max' => $this->request->minThreshold];
                $result[1] = ['state' => Threshold::WARNING, 'min' => $this->request->minThreshold, 'max' => $this->request->maxThreshold];
                $result[2] = ['state' => Threshold::SUCCESS, 'min' => $this->request->maxThreshold];

                $this->indicator = Indicator::find($this->request->id);
                $this->indicator->indicatorGoals->each->delete();
                $this->indicator->update($this->request->except('start_date', 'end_date', 'goals_closed'));

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
                $totalGoalValue = 0;
                $user = auth()->user();

                if ($this->request->frequency == 1) {//si es anual
                    $periods = $this->indicator->numberOfPeriods('P1Y', '+0 year');
                    for ($i = 0; $i < count($periods); $i++) {
                        $date = DateTime::createFromFormat("d-m-Y", $periods[$i]);
                        $d = date("d-m-Y", strtotime($periods[$i] . "+ " . 11 . " month"));
                        $d = date("d-m-Y", strtotime($d . "+ " . 30 . " day"));
                        if (empty($this->request->freq[$i])) {
                            $goalValue = null;
                        } else {
                            $goalValue = $this->request->freq[$i];
                        }
                        self::goalIndicatorCreate($goalValue, $periods, $user, $i, $date, $d);
                        $totalGoalValue += $goalValue;
                    }
                } else if ($this->request->frequency == 2) {//si es semestral
                    $periods = $this->indicator->numberOfPeriods('P6M', '+0 month');
                    for ($i = 0; $i < count($periods); $i++) {
                        $date = DateTime::createFromFormat("d-m-Y", $periods[$i]);
                        $d = date("d-m-Y", strtotime($periods[$i] . "+ " . 6 . " month"));
                        $d = date("d-m-Y", strtotime($d . "- " . 1 . " day"));
                        if (empty($this->request->freq[$i])) {
                            $goalValue = null;
                        } else {
                            $goalValue = $this->request->freq[$i];
                        }
                        self::goalIndicatorCreate($goalValue, $periods, $user, $i, $date, $d);
                        $totalGoalValue += $goalValue;
                    }
                } else if ($this->request->frequency == 4) {//si es trimestral
                    $periods = $this->indicator->numberOfPeriods('P3M', '+0 month');
                    for ($i = 0; $i < count($periods); $i++) {
                        $date = DateTime::createFromFormat("d-m-Y", $periods[$i]);
                        $d = date("d-m-Y", strtotime($periods[$i] . "+ " . 3 . " month"));
                        $d = date("d-m-Y", strtotime($d . "- " . 1 . " day"));
                        if (empty($this->request->freq[$i])) {
                            $goalValue = null;
                        } else {
                            $goalValue = $this->request->freq[$i];
                        }
                        self::goalIndicatorCreate($goalValue, $periods, $user, $i, $date, $d);

                        $totalGoalValue += $goalValue;

                    }
                } else if ($this->request->frequency == 12) {
                    $periods = $this->indicator->numberOfPeriods('P1M', '+0 month');
                    for ($i = 0; $i < count($periods); $i++) {
                        $date = DateTime::createFromFormat("d-m-Y", $periods[$i]);
                        $d = date("d-m-Y", strtotime($periods[$i] . "+ " . 1 . " month"));
                        $d = date("d-m-Y", strtotime($d . "- " . 1 . " day"));
                        if (empty($this->request->freq[$i])) {
                            $goalValue = null;
                        } else {
                            $goalValue = $this->request->freq[$i];
                        }
                        self::goalIndicatorCreate($goalValue, $periods, $user, $i, $date, $d);

                        $totalGoalValue += $goalValue;

                    }
                } else if ($this->request->frequency == 3) {//si es trimestral
                    $periods = $this->indicator->numberOfPeriods('P4M', '+0 month');
                    for ($i = 0; $i < count($periods); $i++) {
                        $date = DateTime::createFromFormat("d-m-Y", $periods[$i]);
                        $d = date("d-m-Y", strtotime($periods[$i] . "+ " . 4 . " month"));
                        $d = date("d-m-Y", strtotime($d . "- " . 1 . " day"));
                        if (empty($this->request->freq[$i])) {
                            $goalValue = null;
                        } else {
                            $goalValue = $this->request->freq[$i];
                        }
                        self::goalIndicatorCreate($goalValue, $periods, $user, $i, $date, $d);

                        $totalGoalValue += $goalValue;
                    }
                }
                $this->indicator->total_goal_value = $totalGoalValue;

                $this->indicator->save();

                //actualiza los agrupados
                $indicatorsGroped = IndicatorParentChild::where('child_indicator', $this->indicator->id)->get();
                $SumGoals = GoalIndicators::where('indicators_id', $this->indicator->id)->get()->sum('goal_value');

                foreach ($indicatorsGroped as $iGroped) {
                    $indicator = Indicator::find($iGroped->parent_indicator);
                    $rss = $indicator->total_goal_value;
                    $rss = $rss - $this->request->oldSumGoals + $SumGoals;
                    $indicator->total_goal_value = $rss;
                    $indicator->save();
                }
            });
            return $this->indicator;
        } catch (\Exception $e) {
            return throw new \Exception($e->getMessage());
        }
    }

    public function goalIndicatorCreate($goalValue,$periods, $user, $i, $date, $d)
    {
        GoalIndicators::create([
            'goal_value' => $goalValue,
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
