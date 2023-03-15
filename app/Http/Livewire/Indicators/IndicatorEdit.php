<?php

namespace App\Http\Livewire\Indicators;

use App\Http\Livewire\Components\Modal;
use App\Jobs\Indicators\Indicator\UpdateIndicator;
use App\Jobs\Indicators\Indicator\UpdateIndicatorGroped;
use App\Models\Auth\User;
use App\Models\Indicators\GoalIndicator\GoalIndicators;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Indicators\Sources\IndicatorSource;
use App\Models\Indicators\Threshold\Threshold;
use App\Models\Indicators\Units\IndicatorUnits;
use App\Scopes\Company;
use App\Traits\Jobs;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Collection;

class IndicatorEdit extends Modal
{
    use Jobs;

    public $type = null, $code = null,
        $name = null, $base_line = null,
        $baseline_year = null, $indicator_units_id = null,
        $results = null, $indicator_sources_id = null, $type_of_aggregation = null,
        $indicatorIdEdit = null, $user_id = null,
        $frequency = null, $state = null,
        $start_date = null, $end_date = null, $oldSumGoals = null,
        $progress = null, $goalValueTotalEdit = null,
      $actualValueTotalEdit = null,
        $indicatorsSelected = [], $category = null, $national = false;

    public ?Collection $indicatorUnits = null, $users = null, $indicatorSource = null, $thresholds = null, $indicatorsEdit = null;

    public $selectedThreshold = null, $selectedType = null, $indicator = null;

    public $maxAD = 0, $minAW = 0,
        $maxAW = 0, $minAS = 0,
        $maxDD = 0, $minDW = 0,
        $maxDW = 0, $minDS = 0,
        $maxTD = 0, $minTW = 0,
        $maxTW = 0, $minTS = 0;
    public array $periods = [], $data = [],
        $min = [], $max = [], $freq = [];

    public $indicatorableId;
    public bool $selfGoals = false;
    public $self_managed = false;
    public $indicatorId;
    public $indicatorableType;

    protected $listeners = ['open' => 'openFromIndicators', 'openEditModal' => 'loadIndicator', 'loadIndicatorEditData' => 'loadIndicator'];

    public function rules()
    {
        return [
            'indicatorId' => 'required',
            'name' => 'required|max:500',
            'code' => ['required', 'alpha_dash', 'alpha_num', 'max:5', 'morph_exists_indicator:indicatorableType'],
            'user_id' => 'required|integer',
            'start_date' => 'date',
            'end_date' => 'date|after:start_date',
            'base_line' => 'nullable',
            'type' => 'required',
            'indicator_units_id' => 'integer',
            'indicator_sources_id' => 'exclude_unless:is_manual,true|required',
            'selectedType' => 'required',
            'baseline_year' => 'nullable',
            'results' => 'required|string|max:500',
            'frequency' => 'required',
            'selectedThreshold' => 'required',
            'type_of_aggregation' => 'required',
            'category' => 'required',
            'indicatorableId' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'code.morph_exists_indicator' => 'El código del indicador ya existe.',
        ];
    }

    public function show(...$arg)
    {
        parent::show();
    }

    public function openFromIndicators($indicatorId)
    {
        $this->loadIndicator($indicatorId);
        $this->emit('toggleIndicatorEditModal');
    }

    public function loadIndicator($indicatorId)
    {
        $this->thresholds = Threshold::all();
        $this->indicator = Indicator::withoutGlobalScope(Company::class)->find($indicatorId);
        $this->indicatorId = $indicatorId;
        $this->frequency = $this->indicator->frequency;
        $this->indicatorableId = $this->indicator->indicatorable_id;
        $this->indicatorableType = $this->indicator->indicatorable_type;
        $this->type = $this->indicator->type;
        $this->name = $this->indicator->name;
        $this->base_line = $this->indicator->base_line;
        $this->baseline_year = $this->indicator->baseline_year;
        $this->code = $this->indicator->code;
        $this->user_id = $this->indicator->user_id;
        $this->results = $this->indicator->results;
        $this->selectedThreshold = $this->indicator->thresholds_id;
        $this->indicator_units_id = $this->indicator->indicator_units_id;
        $this->type_of_aggregation = $this->indicator->type_of_aggregation;
        $this->category = $this->indicator->category;
        $this->national = $this->indicator->national;
        $this->self_managed = $this->indicator->self_managed;
        $this->selectedType = $this->indicator->threshold_type;
        $this->start_date = Carbon::parse($this->indicator->start_date)->format('Y-m');
        $this->end_date = Carbon::parse($this->indicator->end_date)->format('Y-m');
        $this->indicatorIdEdit = $indicatorId;
        if ($this->indicator->goals_closed == 'closed' || $this->indicator->progressIndicator() > 0) {
            $this->progress = 1;
        }
        if (count($this->indicator->indicatorParents) == 0) {
            $this->selectedThreshold = $this->indicator->thresholds_id;
            $this->updatedSelectedThreshold($this->selectedThreshold);
            foreach ($this->indicator->indicatorGoals as $goal) {
                $this->freq[$goal->period] = $goal->goal_value ?? null;
                $this->min[$goal->period] = $goal->min >> null;
                $this->max[$goal->period] = $goal->max ?? null;
            }
            $this->base_line = $this->indicator->base_line;
            $this->indicator_sources_id = $this->indicator->indicator_sources_id;
            $this->baseline_year = $this->indicator->baseline_year;
//            $this->oldSumGoals = GoalIndicators::where('indicators_id', $this->indicator->id)->get()->sum('goal_value');
            $this->oldSumGoals = $this->indicator->indicatorGoals->sum('goal_value');
            $this->updated('frequency', 0);
            if ($this->indicator->goals_closed == Indicator::GOALS_CLOSED) {
                $this->state = 1;
            }
        } else {
            $this->updated('', 0);
            $this->start_date = Carbon::parse($this->indicator->start_date)->format('Y-m');
            $this->end_date = Carbon::parse($this->indicator->end_date)->format('Y-m');
            $this->indicatorsSelected = $this->indicator->indicatorParent()->pluck('child_indicator')->toArray();
            $this->updated('indicatorsSelected', 0);
        }

        $this->indicatorUnits = IndicatorUnits::get();
        $this->users = User::get();
        $this->indicatorSource = IndicatorSource::get();

    }

    public function updatedselectedType()
    {
        $this->updatedSelectedThreshold($this->selectedThreshold);
    }

    public function updatedSelectedThreshold($threshold)
    {
        $threshold_properties = $this->indicator->threshold_properties ?? null;
        $threshold_type = $this->indicator->threshold_type ?? null;
        if (isset($threshold_properties) && $this->selectedType == $threshold_type && $this->selectedThreshold == $this->indicator->thresholds_id) {
            if ($threshold_type == Threshold::ASCENDING) {
                $this->maxAD = $threshold_properties[0]['max'];
                $this->minAW = $threshold_properties[1]['min'];
                $this->maxAW = $threshold_properties[1]['max'];
                $this->minAS = $threshold_properties[2]['min'];
            } else if ($threshold_type == Threshold::DESCENDING) {
                $this->maxDD = $threshold_properties[0]['max'];
                $this->minDW = $threshold_properties[1]['min'];
                $this->maxDW = $threshold_properties[1]['max'];
                $this->minDS = $threshold_properties[2]['min'];
            } else if ($threshold_type == Threshold::TOLERANCE) {
                $this->maxTD = $threshold_properties[0]['max'];
                $this->minTW = $threshold_properties[1]['min'];
                $this->maxTW = $threshold_properties[1]['max'];
                $this->minTS = $threshold_properties[2]['min'];
            }
        } else {
            $thresholdFind = Threshold::find($threshold);
            $this->maxAD = $thresholdFind->properties[0][3];
            $this->minAW = $thresholdFind->properties[1][3];
            $this->maxAW = $thresholdFind->properties[2][3];
            $this->minAS = $thresholdFind->properties[3][3];
            $this->maxDD = $thresholdFind->properties[4][3];
            $this->minDW = $thresholdFind->properties[5][3];
            $this->maxDW = $thresholdFind->properties[6][3];
            $this->minDS = $thresholdFind->properties[7][3];
            $this->maxTD = $thresholdFind->properties[8][3];
            $this->minTW = $thresholdFind->properties[9][3];
            $this->maxTW = $thresholdFind->properties[10][3];
            $this->minTS = $thresholdFind->properties[11][3];
        }
    }

    public $foo;

    public function dehydrateFoo($value)
    {
        //
//        $this->indicatorsSelected = null;
        $this->indicatorsEdit = null;
    }

    public function updated($name, $value)
    {
        if ($name == "self_managed" && $value == false) {
            $this->reset(['freq', 'min', 'max']);
        }

        if ($name == "selectedType") {
            $this->reset(
                [
                    'start_date',
                    'end_date',
                    'frequency',
                    'min',
                    'max',
                    'freq',
                    'periods',
                    'data',
                ]
            );
        }

        if ($this->type == Indicator::TYPE_GROUPED) {
            $this->indicatorsEdit = Indicator::when($this->indicator_units_id, function ($q) {
                $q->where('indicator_units_id', $this->indicator_units_id);
            })->when($this->selectedType, function ($q) {
                $q->where('threshold_type', $this->selectedType);
            })->when($this->type_of_aggregation, function ($q) {
                $q->where('type_of_aggregation', $this->type_of_aggregation);
            })->when($this->frequency, function ($q) {
                $q->where('frequency', $this->frequency);
            })->where('type', '!=', 'Grouped')
                ->get()
                ->pluck('name', 'id');
        }

        if (!is_null($this->indicatorsSelected)) {
            if (count($this->indicatorsSelected) > 0) {
                $this->goalValueTotalEdit = 0;
                $this->actualValueTotalEdit = 0;
                $sumGoal = GoalIndicators::when($this->indicatorsSelected, function ($q) {
                    $q->whereIn('indicators_id', $this->indicatorsSelected);
                })->get()->sum('goal_value');
                $sumActual = GoalIndicators::when($this->indicatorsSelected, function ($q) {
                    $q->whereIn('indicators_id', $this->indicatorsSelected);
                })->get()->sum('actual_value');

                $this->goalValueTotalEdit = $sumGoal;
                $this->actualValueTotalEdit = $sumActual;

            }
        }


        if (isset($this->selectedType) && isset($this->frequency) && isset($this->start_date) && isset($this->end_date)) {
            $dateValidation = '01-01-2020';
            $this->validate(
                [
                    'start_date' => 'date|after:' . $dateValidation,
                    'end_date' => 'after:start_date|date'
                ]);
            $startDate = $this->start_date . "-01";
            $endDate = $this->end_date . "-28";
            $indicator = new Indicator;
            $dates = $indicator->calcStartEndDateF($startDate, $endDate, $this->frequency);
            $this->periods = $indicator->calcNumberOfPeriods($indicator, $this->frequency, $dates['f_start_date'], $dates['f_end_date']);
            $startPeriod = $indicator->calcNumberOfPeriodStartC($startDate, $endDate, $this->frequency);
            $count = 0;
            if ($this->frequency == 2) {
                $this->calcSemester($this->periods, $startPeriod == 1 ? 1 : 2);
            } else if ($this->frequency == 4) {
                if ($startPeriod == 1) {
                    $count = 1;
                } else if ($startPeriod == 4) {
                    $count = 2;
                } else if ($startPeriod == 7) {
                    $count = 3;
                } else {
                    $count = 4;
                }
                $this->calcQuarterly($this->periods, $count);
            } else if ($this->frequency == 12) {
                $count = $startPeriod;
                $this->calcMonthly($this->periods, $count);
            } else if ($this->frequency == 1) {
                $this->calcYear($this->periods);
            } else if ($this->frequency == 3) {
                if ($startPeriod == 1) {
                    $count = 1;
                } else if ($startPeriod == 5) {
                    $count = 2;
                } else if ($startPeriod == 9) {
                    $count = 3;
                }
                $this->calcFourMonths($this->periods, $count);
            }
        }
    }

    function calcYear($periods)
    {
        $this->data = [];
        for ($i = 0; $i < count($periods); $i++) {
            $date = DateTime::createFromFormat("d-m-Y", $periods[$i]);
            $count = 1;
            $this->data[] = [
                'frequency' => Indicator::FREQUENCIES[$this->frequency][$count] . " (" . ($date->format("Y")) . ")",
            ];
        }
    }

    public function calcSemester($periods, $count)
    {
        $this->data = [];
        for ($i = 0; $i < count($periods); $i++) {
            $date = DateTime::createFromFormat("d-m-Y", $periods[$i]);
            $this->data[] = [
                'frequency' => Indicator::FREQUENCIES[$this->frequency][$count] . " (" . ($date->format("Y")) . ")",
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
        for ($i = 0; $i < count($periods); $i++) {
            $date = DateTime::createFromFormat("d-m-Y", $periods[$i]);
            $this->data[] = [
                'frequency' => Indicator::FREQUENCIES[$this->frequency][$count] . " (" . (($date->format("Y"))) . ")",
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
        for ($i = 0; $i < count($periods); $i++) {
            $date = DateTime::createFromFormat("d-m-Y", $periods[$i]);
            $this->data[] = [
                'frequency' => Indicator::FREQUENCIES[$this->frequency][$count] . " (" . (($date->format("Y"))) . ")",
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
        for ($i = 0; $i < count($periods); $i++) {
            $date = DateTime::createFromFormat("d-m-Y", $periods[$i]);
            $this->data[] = [
                'frequency' => Indicator::FREQUENCIES[$this->frequency][$count] . " (" . (($date->format("Y"))) . ")",
            ];
            $count++;
            if ($count > 3) {
                $count = 1;
            }
        }
    }


    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset([
            'name',
            'code',
            'user_id',
            'start_date',
            'end_date',
            'base_line',
            'indicator_units_id',
            'indicator_sources_id',
            'baseline_year',
            'results',
            'frequency',
            'selectedThreshold',
            'type_of_aggregation',
            'indicatorsSelected',
            'indicatorsEdit',
            'data',
            'periods',
            'min',
            'max',
            'freq',
            'selectedType',
            'indicator',
            'indicatorIdEdit',
            'state',
            'oldSumGoals',
            'progress',
            'goalValueTotalEdit',
            'actualValueTotalEdit',
            'selectedThreshold',
            'category',
            'self_managed',
        ]);
    }

    public function editIndicator()
    {

        $this->validate();

        $data = [
            'id' => $this->indicator->id,
            'name' => $this->name,
            'code' => $this->code,
            'user_id' => $this->user_id,
            'start_date' => $this->start_date.'-01',
            'end_date' => $this->end_date.'-28',
            'base_line' => $this->base_line,
            'indicator_units_id' => $this->indicator_units_id,
            'indicator_sources_id' => $this->indicator_sources_id,
            'thresholds_id' => $this->selectedThreshold,
            'threshold_type' => $this->selectedType,
            'baseline_year' => $this->baseline_year,
            'results' => $this->results,
            'frequency' => $this->frequency,
            'type_of_aggregation' => $this->type_of_aggregation,
            'maxAD' => $this->maxAD,
            'minAW' => $this->minAW,
            'maxAW' => $this->maxAW,
            'minAS' => $this->minAS,
            'maxDD' => $this->maxDD,
            'minDW' => $this->minDW,
            'maxDW' => $this->maxDW,
            'maxTD' => $this->maxTD,
            'minTW' => $this->minTW,
            'maxTW' => $this->maxTW,
            'minTS' => $this->minTS,
            'freq' => $this->freq,
            'min' => $this->min,
            'max' => $this->max,
            'goals_closed' => $this->state,
            'oldSumGoals' => $this->oldSumGoals,
            'child_indicator' => $this->indicatorsSelected,
            'total_goal_value' => $this->goalValueTotalEdit,
            'total_actual_value' => $this->actualValueTotalEdit,
            'category' => $this->category,
            'national' => $this->national,
            'self_managed' => $this->self_managed,
        ];
        if (count($this->indicator->indicatorParents) == 0) {
            $response = $this->ajaxDispatch(new UpdateIndicator($data));
        } else {
            $response = $this->ajaxDispatch(new UpdateIndicatorGroped($data));
        }

        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.indicators', 1)]))->success()->livewire($this);
            $this->emit('renderPlanDetailIndicators');
            $this->resetForm();
        } else {
            flash($response['message'])->error()->livewire($this);
        }

        $this->emit('loadIndicatorUpdated');
        $this->emit('toggleIndicatorEditModal');
        $this->emit('renderIndicators');

    }

    public function render()
    {
        $this->dispatchBrowserEvent('loadIndicators');
        return view('livewire.indicators.indicator-edit');
    }
}
