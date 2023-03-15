<?php

namespace App\Http\Livewire\Indicators;

use App\Models\Auth\User;
use App\Models\Indicators\GoalIndicator\GoalIndicators;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Indicators\Indicator\IndicatorParentChild;
use App\Models\Indicators\Sources\IndicatorSource;
use App\Models\Indicators\Units\IndicatorUnits;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Collection;
use Livewire\Component;

class Indicators extends Component
{
    public $type, $code, $name, $base_line, $baseline_year, $indicator_units_id,
        $results, $responsible, $calculation_method, $hierarchies,
        $indicatorIdEdit, $indicatorUnitsId, $user_id, $frequency, $labelPeriod, $period,
        $isUpdating, $indicatorId, $actual_value, $state, $sumGoals, $start_date, $end_date, $goalLabel;
    public Collection $indicatorUnits;
    public Collection $users;
    public Collection $indicatorSource;
    public Indicator $indicator;

    protected $listeners = ['rednerIndicators' => 'render'];


    public function render()
    {
        $indicators = Indicator::collect();
        return view('livewire.indicators.indicators', compact('indicators'));
    }

    public function registerAdvance($id)
    {
        $this->indicator = Indicator::find($id);
        $this->sumGoals = $this->indicator->goalsRegister();
        $startDate = Carbon::now();
        $startDate = $this->calcStartEndDateF($startDate, $this->indicator->frequency);
        foreach ($this->indicator->indicatorGoals as $goal) {
            $startDateGoal = date("d-m-Y", strtotime($goal->start_date));
            if ($startDate == $startDateGoal) {
                $this->period = $goal->period;
                $this->goalLabel = $goal->goal_value;
                $this->labelPeriod = 'Avance';
                $this->actual_value = $goal->actual_value ?? null;
                break;
            }
        }
        $this->name = $this->indicator->name;
        $this->code = $this->indicator->code;
        $this->base_line = $this->indicator->base_line;
        $this->indicatorId = $id;

        $this->frequency = $this->indicator->getFrequency();
        $this->indicatorUnits = IndicatorUnits::get();
    }

    public function saveAdvance()
    {
        $goal_indicator = GoalIndicators::where('period', $this->period)->where('indicators_id', $this->indicatorId)->first();
        $goal_indicator->actual_value = $this->actual_value;
        $indicatorChild=IndicatorParentChild::where('child_indicator',$this->indicatorId )->get();
        if (!empty($indicatorChild)){
            foreach ($indicatorChild as $child){
                $parentIndicator=Indicator::find($child->parent_indicator);
                $oldValue=$parentIndicator->total_actual_value;
                $parentIndicator->total_actual_value=$oldValue+$this->actual_value;
                $parentIndicator->save();
            }
        }
        $goal_indicator->save();
        $this->emit('toggleIndicatorEditModal');
    }

    public function calcStartEndDateF($startDate_, $frequency)
    {
        $ts1 = strtotime($startDate_);
        $month1 = intval(date('m', $ts1));
        $startDate = Carbon::parse($startDate_)->startOfMonth()->toDateString();

        //Si es semesral
        if ($frequency == 2) {
            if ($month1 <= 6) {
                $mount = $month1 - 1;
                $startDate = date("d-m-Y", strtotime($startDate . "- " . $mount . " month"));
            } else {
                $startDate = date("d-m-Y", strtotime($startDate . "- " . $month1 . " month"));
                $startDate = date("d-m-Y", strtotime($startDate . "+ " . 7 . " month"));
            }
        } else if ($frequency == 1) {//si es anual
            $mount = $month1 - 1;
            $startDate = date("d-m-Y", strtotime($startDate . "- " . $mount . " month"));
        } else if ($frequency == 4) {//Si es trimtestral
            if ($month1 <= 3) {
                $mount = $month1 - 1;
                $startDate = date("d-m-Y", strtotime($startDate . "- " . $mount . " month"));
            } else if ($month1 > 3 && $month1 <= 6) {
                $startDate = date("d-m-Y", strtotime($startDate . "- " . $month1 . " month"));
                $startDate = date("d-m-Y", strtotime($startDate . "+ " . 4 . " month"));

            } else if ($month1 > 6 && $month1 <= 9) {
                $startDate = date("d-m-Y", strtotime($startDate . "- " . $month1 . " month"));
                $startDate = date("d-m-Y", strtotime($startDate . "+ " . 7 . " month"));
            } else if ($month1 > 9 && $month1 <= 12) {
                $startDate = date("d-m-Y", strtotime($startDate . "- " . $month1 . " month"));
                $startDate = date("d-m-Y", strtotime($startDate . "+ " . 10 . " month"));
            }

        } else if ($frequency == 3) {//Si es cuatrimetstal
            if ($month1 <= 4) {
                $mount = $month1 - 1;
                $startDate = date("d-m-Y", strtotime($startDate . "- " . $mount . " month"));
            } else if ($month1 > 4 && $month1 <= 8) {
                $startDate = date("d-m-Y", strtotime($startDate . "- " . $month1 . " month"));
                $startDate = date("d-m-Y", strtotime($startDate . "+ " . 5 . " month"));

            } else if ($month1 > 9) {
                $startDate = date("d-m-Y", strtotime($startDate . "- " . $month1 . " month"));
                $startDate = date("d-m-Y", strtotime($startDate . "+ " . 9 . " month"));
            }
        } else if ($frequency == 12) {
            $startDate = Carbon::now()->startOfMonth();
            $startDate = date("d-m-Y", strtotime($startDate));
        }
        return $startDate;
    }
}
