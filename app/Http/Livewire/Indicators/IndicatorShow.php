<?php

namespace App\Http\Livewire\Indicators;

use App\Models\Auth\User;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Indicators\Sources\IndicatorSource;
use App\Models\Indicators\Threshold\Threshold;
use App\Models\Indicators\Units\IndicatorUnits;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Collection;
use Livewire\Component;

class IndicatorShow extends Component
{
    public $type, $code, $name, $base_line, $baseline_year, $indicator_units_id,
        $results, $responsible, $calculation_method,
        $indicatorIdEdit, $indicatorUnitsId, $user_id, $frequency, $labelPeriod, $period,
        $isUpdating, $indicatorId, $state, $start_date, $end_date, $threshold_type, $score;
    public Collection $indicatorUnits;
    public Collection $users;
    public Collection $indicatorSource;
    public Collection $thresholds;
    public $selectedThreshold = null;
    public $selectedType = null;
    public $indicator = null;
    public $minAW = 0;
    public $maxAW = 0;
    public array $periods = [];
    public array $data = [];
    public array $dataScore = [];
    public array $min = [];
    public array $max = [];
    public array $freq = [];
    protected $listeners = ['open' => 'loadIndicator'];

    public function loadIndicator($indicatorId)
    {
        $this->thresholds = Threshold::all();
        $this->indicator = Indicator::find($indicatorId);
        if (count($this->indicator->indicatorParents) == 0) {
            $this->selectedThreshold = $this->indicator->thresholds_id;
            $this->updatedSelectedThreshold($this->selectedThreshold);
            foreach ($this->indicator->indicatorGoals as $goal) {
                $this->freq[$goal->period] = $goal->goal_value ?? null;
                $this->min[$goal->period] = $goal->min >> null;
                $this->max[$goal->period] = $goal->max ?? null;
            }
            $this->minAW = $this->indicator->threshold_properties[1]['min'];
            $this->maxAW = $this->indicator->threshold_properties[1]['max'];
            //datos para
            $dates = $this->indicator->calcStartEndDateF($this->indicator->start_date, $this->indicator->end_date, $this->indicator->frequency);
            $periods = $this->indicator->calcNumberOfPeriods($this->indicator, $this->indicator->frequency, $dates['f_start_date'], $dates['f_end_date']);

            $startPeriod = $this->indicator->calcNumberOfPeriodStartC($this->indicator->startDate, $this->indicator->endDate, $this->indicator->frequency);

            if ($this->indicator->frequency == 2) {
                $this->calcSemester($startPeriod == 1 ? 1 : 2);
            }
            if ($this->indicator->frequency == 4) {
                if ($startPeriod == 1) {
                    $count = 1;
                }
                if ($startPeriod == 4) {
                    $count = 2;
                }
                if ($startPeriod == 7) {
                    $count = 3;
                } else {
                    $count = 4;
                }
                $this->calcQuarterly($periods, $count);
            }
            if ($this->indicator->frequency == 12) {
                $this->calcMonthly($periods, $startPeriod);
            }
            if ($this->indicator->frequency == 1) {
                $this->calcYear($periods);
            }
            if ($this->indicator->frequency == 3) {
                if ($startPeriod == 1) {
                    $count = 1;
                } else if ($startPeriod == 5) {
                    $count = 2;
                } else if ($startPeriod == 9) {
                    $count = 3;
                }
                $this->calcFourMonths($periods, $count);
            }
            $properties = $this->indicator->threshold_properties;
            $min = $properties[1]['min'];
            $max = $properties[1]['max'];
            $this->dataScore = [];
            if ($this->indicator->goalsRegister()>0){
                $this->dataScore[] = [
                    'score' => $this->indicator->progressIndicator()/ $this->indicator->goalsRegister()*100,
                    'min'=>$min,
                    'max'=>$max
                ];
            }

        }else{
            $this->dataScore = [];
            $this->dataScore[] = [
                'score' => $this->indicator->total_actual_value / $this->indicator->total_goal_value * 100,
                'min'=>62,
                'max'=>80
            ];
        }

        $this->indicatorIdEdit = $indicatorId;
        $this->indicatorUnits = IndicatorUnits::get();
        $this->users = User::get();
        $this->indicatorSource = IndicatorSource::get();


        $this->dispatchBrowserEvent('updateChartData1', ['data' => $this->data]);
        $this->dispatchBrowserEvent('updateChartData2', ['data' => $this->dataScore]);

        $this->emit('toggleIndicatorShowModal');
    }

    function calcYear($periods)
    {
        $this->data = [];
        foreach ($this->indicator->indicatorGoals as $index => $goal) {
            $date = DateTime::createFromFormat("d-m-Y", $periods[$index]);
            $count = 1;
            $this->data[] = [
                'frequency' => Indicator::FREQUENCIES[$this->frequency][$count] . " (" . ($date->format("Y")) . ")",
                'value' => $goal->goal_value,
                'actual' => $goal->actual_value,
                'year' => $goal->year,
                'progress' => $goal->progress()

            ];
        }
    }

    public function calcSemester($count)
    {
        $this->data = [];
        foreach ($this->indicator->indicatorGoals as $index => $goal) {
            $this->data[] = [
                'frequency' => Indicator::FREQUENCIES[$this->indicator->frequency][$count] . " (" . ($goal->year) . ")",
                'value' => $goal->goal_value,
                'actual' => $goal->actual_value,
                'year' => $goal->year,
                'progress' => $goal->progress()
            ];
            $count++;
            if ($count > 2) {
                $count = 1;
            }
        }
    }

    public function calcMonthly($periods, $count)
    {
        $this->data = [];
        foreach ($this->indicator->indicatorGoals as $index => $goal) {
            $date = DateTime::createFromFormat("d-m-Y", $periods[$index]);
            $this->data[] = [
                'frequency' => Indicator::FREQUENCIES[$this->indicator->frequency][$goal->start_date->month] . " (" . (($date->format("Y"))) . ")",
                'value' => $goal->goal_value,
                'actual' => $goal->actual_value,
                'year' => $goal->year,
                'progress' => $goal->progress()
            ];
            $count++;
            if ($count > 12) {
                $count = 1;
            }
        }
    }

    public function calcQuarterly($periods, $count)
    {
        $this->data = [];
        foreach ($this->indicator->indicatorGoals as $index => $goal) {
            $date = DateTime::createFromFormat("d-m-Y", $periods[$index]);
            $this->data[] = [
                'frequency' => Indicator::FREQUENCIES[$this->indicator->frequency][$count] . " (" . (($date->format("Y"))) . ")",
                'value' => $goal->goal_value,
                'actual' => $goal->actual_value,
                'year' => $goal->year,
                'progress' => $goal->progress()
            ];
            $count++;
            if ($count > 4) {
                $count = 1;
            }
        }
    }

    public function calcFourMonths($periods, $count)
    {
        $this->data = [];
        foreach ($this->indicator->indicatorGoals as $index => $goal) {
            $date = DateTime::createFromFormat("d-m-Y", $periods[$index]);
            $this->data[] = [
                'frequency' => Indicator::FREQUENCIES[$this->indicator->frequency][$count] . " (" . (($date->format("Y"))) . ")",
                'value' => $goal->goal_value,
                'actual' => $goal->actual_value,
                'year' => $goal->year,
                'progress' => $goal->progress()
            ];
            $count++;
            if ($count > 3) {
                $count = 1;
            }
        }
    }

    public function render()
    {
        return view('livewire.indicators.indicator-show');
    }
}
