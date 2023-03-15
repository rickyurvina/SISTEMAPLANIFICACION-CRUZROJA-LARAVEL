<?php

namespace App\Http\Livewire\Indicators;

use App\Http\Livewire\Components\Modal;
use App\Jobs\Indicators\Indicator\CreateIndicator;
use App\Jobs\Indicators\Indicator\CreateIndicatorGrouped;
use App\Models\Auth\User;
use App\Models\Indicators\GoalIndicator\GoalIndicators;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Indicators\Sources\IndicatorSource;
use App\Models\Indicators\Threshold\Threshold;
use App\Models\Indicators\Units\IndicatorUnits;
use App\Traits\Jobs;
use DateTime;
use Illuminate\Support\Collection;

class IndicatorCreate extends Modal
{
    use Jobs;

    public $type = null, $code = null, $name = null, $base_line = null, $baseline_year = null, $indicator_units_id = null,
        $results = null, $responsible = null, $indicator_sources_id = null, $type_of_aggregation = null, $user_id = null,
        $frequency = null, $labelPeriod = null, $period = null,
        $indicatorId = null, $state = null, $start_date = null, $end_date = null, $goalValueTotal = null, $actualValueTotal = null, $category = null,
        $national = false;

    public ?Collection $indicatorUnits = null, $indicators = null, $users = null, $indicatorSource = null, $thresholds = null;

    public $selectedThreshold = null, $selectedType = null, $indicator = null;


    public $maxAD = 0, $minAW = 0, $maxAW = 0, $minAS = 0, $maxDD = 0, $minDW = 0, $maxDW = 0, $minDS = 0, $maxTD = 0, $minTW = 0, $maxTW = 0, $minTS = 0;

    public $is_manual = false;

    public array $periods = [], $data = [], $min = [], $max = [], $freq = [], $indicatorsSelected = [];

    public $indicatorableType;

    public $indicatorableId;
    public $self_managed = false;
    public $hasCategory = false;


    public function rules()
    {
        return [
            'indicatorableId' => 'required',
            'code' => ['required', 'alpha_dash', 'alpha_num', 'max:5', 'morph_exists_indicator:indicatorableType'],
            'type' => 'required',
            'category' => 'required',
            'name' => 'required|max:500',
            'user_id' => 'required|integer',
            'results' => 'required|string|max:500',
            'indicator_units_id' => 'required|integer',
            'selectedThreshold' => 'required',
            'type_of_aggregation' => 'required',
            'indicator_sources_id' => 'exclude_unless:is_manual,true|required',
            'start_date' => 'date',
            'end_date' => 'date|after:start_date',
            'selectedType' => 'required',
            'baseline_year' => 'nullable',
            'frequency' => 'required',
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
        $this->indicatorableType = $arg[0];
        $this->indicatorableId = $arg[1];
        $this->category = $arg[2] ?? null;
        if ($this->category != null) {
            $this->hasCategory = true;
        }
        parent::show();
    }

    public function mount()
    {
        $this->resetInputs();
        $this->thresholds = Threshold::all();
        $this->indicatorUnits = IndicatorUnits::get();
        $this->users = User::get();
        $this->indicatorSource = IndicatorSource::get();
        $this->emit('toggleIndicatorCreateModal');
    }

    public function render()
    {
        $this->dispatchBrowserEvent('loadIndicators');
        return view('livewire.indicators.indicator-create');
    }

    public function updated($name, $value)
    {
        if ($name == "self_managed" && $value == false) {
            $this->reset(['freq', 'min', 'max']);
        }
        if ($name == "type") {
            if ($this->type == 'Manual') {
                $this->is_manual = true;
            } else {
                $this->is_manual = false;
            }
            $this->reset([
                'name',
                'code',
                'user_id',
                'start_date',
                'end_date',
                'base_line',
                'indicator_units_id',
                'indicator_sources_id',
                'selectedType',
                'baseline_year',
                'results',
                'frequency',
                'selectedThreshold',
                'type_of_aggregation',
                'actualValueTotal',
                'goalValueTotal',
                'indicators',
                'indicatorsSelected',
                'indicator',
                'data',
                'periods',
                'min',
                'max',
                'freq',
                'national',
                'self_managed',
            ]);
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
            $this->indicators = Indicator::when($this->indicator_units_id, function ($q) {
                $q->where('indicator_units_id', $this->indicator_units_id);
            })->when($this->type_of_aggregation, function ($q) {
                $q->where('type_of_aggregation', $this->type_of_aggregation);
            })->when($this->selectedType, function ($q) {
                $q->where('threshold_type', $this->selectedType);
            })->when($this->frequency, function ($q) {
                $q->where('frequency', $this->frequency);
            })->where('type', '!=', 'Grouped')->get();

        }

        if ($this->indicatorsSelected) {
            $this->goalValueTotal = 0;
            $this->actualValueTotal = 0;
            $sumGoal = GoalIndicators::when($this->indicatorsSelected, function ($q) {
                $q->whereIn('indicators_id', $this->indicatorsSelected);
            })->get()->sum('goal_value');
            $sumActual = GoalIndicators::when($this->indicatorsSelected, function ($q) {
                $q->whereIn('indicators_id', $this->indicatorsSelected);
            })->get()->sum('actual_value');
            $this->goalValueTotal = $sumGoal;
            $this->actualValueTotal = $sumActual;
        }


        if (isset($this->selectedType) && isset($this->frequency) && isset($this->start_date) && isset($this->end_date) && $this->is_manual) {
            $dateValidation = '01-01-2020';
            $this->validate(
                [
                    'start_date' => 'date|after:' . $dateValidation,
                    'end_date' => 'after:start_date|date'
                ]);
            $indicator = new Indicator;
            $startDate = $this->start_date . "-01";
            $endDate = $this->end_date . "-28";
            $dates = $indicator->calcStartEndDateF($startDate, $endDate, $this->frequency);
            $this->periods = $indicator->calcNumberOfPeriods($indicator, $this->frequency, $dates['f_start_date'], $dates['f_end_date']);
            $startPeriod = $indicator->calcNumberOfPeriodStartC($startDate, $endDate, $this->frequency);
            $count = 0;
            if ($this->frequency == 2) {
                $this->calcSemester($this->periods, $startPeriod == 1 ? 1 : 2);
            }
            if ($this->frequency == 4) {
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
            }
            if ($this->frequency == 12) {
                $this->calcMonthly($this->periods, $startPeriod);
            }
            if ($this->frequency == 1) {
                $this->calcYear($this->periods);
            }
            if ($this->frequency == 3) {
                if ($startPeriod == 1) {
                    $count = 1;
                } else {
                    if ($startPeriod == 5) {
                        $count = 2;
                    } else {
                        if ($startPeriod == 9) {
                            $count = 3;
                        }
                    }
                }
                $this->calcFourMonths($this->periods, $count);
            }
        }
        if ($name = 'show' && $this->show == false) {
            $this->resetInputs();
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

    public function resetInputs()
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
            'selectedType',
            'baseline_year',
            'results',
            'frequency',
            'selectedThreshold',
            'type_of_aggregation',
            'actualValueTotal',
            'goalValueTotal',
            'indicators',
            'indicatorsSelected',
            'indicator',
            'data',
            'periods',
            'min',
            'max',
            'freq',
            'national',
            'type',
            'self_managed',
        ]);
    }

    public function updatedSelectedType()
    {
        $this->updatedSelectedThreshold($this->selectedThreshold);
    }

    public function updatedSelectedThreshold($threshold)
    {
        if ($this->selectedThreshold && $this->selectedType) {
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

    public function save()
    {
        $this->validate();
        $data = [
            'name' => $this->name,
            'code' => $this->code,
            'user_id' => $this->user_id,
            'start_date' => $this->start_date . "-01",
            'end_date' => $this->end_date . "-28",
            'type' => $this->type,
            'indicator_units_id' => $this->indicator_units_id,
            'threshold_type' => $this->selectedType,
            'thresholds_id' => $this->selectedThreshold,
            'results' => $this->results,
            'baseline_year' => $this->baseline_year,
            'base_line' => $this->base_line,
            'frequency' => $this->frequency,
            'type_of_aggregation' => $this->type_of_aggregation,
            'total_goal_value' => $this->goalValueTotal,
            'indicator_sources_id' => $this->indicator_sources_id,
            'total_actual_value' => $this->actualValueTotal,
            'company_id' => session('company_id'),
            'child_indicator' => $this->indicatorsSelected,
            'maxAD' => $this->maxAD,
            'minAW' => $this->minAW,
            'maxAW' => $this->maxAW,
            'minAS' => $this->minAS,
            'maxDD' => $this->maxDD,
            'minDW' => $this->minDW,
            'maxDW' => $this->maxDW,
            'minDS' => $this->minDS,
            'maxTD' => $this->maxTD,
            'minTW' => $this->minTW,
            'maxTW' => $this->maxTW,
            'minTS' => $this->minTS,
            'indicatorable_type' => $this->indicatorableType,
            'indicatorable_id' => $this->indicatorableId,
            'min' => $this->min,
            'max' => $this->max,
            'freq' => $this->freq,
            'category' => $this->category,
            'national' => $this->national,
            'self_managed' => $this->self_managed,
        ];

        if ($this->type == Indicator::TYPE_MANUAL) {
            $response = $this->ajaxDispatch(new CreateIndicator($data));
        } elseif ($this->type == Indicator::TYPE_GROUPED) {
            $response = $this->ajaxDispatch(new CreateIndicatorGrouped($data));
        }
        if ($response['success']) {
            if ($this->user_id){
                $user=User::find($this->user_id);
                if ($user){
                    $notificationArray = [];
                    $notificationArray[0] = [
                        'via' => ['database'],
                        'database' => [
                            'username' => $user->name,
                            'title' => trans('indicator_responsable'),
                            'description' => __('ha sido asignado como responsable del indicador ' . $this->name),
                            'salutation' => trans('general.salutation'),
                            'url' => route('projects.index'),
                        ]];
                    $notificationArray[1] = [
                        'via' => ['mail'],
                        'mail' => [
                            'subject' => (trans('indicator_responsable')),
                            'greeting' => __('general.dear_user'),
                            'line' => __('Ha sido asignado como responsable del indicador ' . $this->name),
                            'salutation' => trans('general.salutation'),
                            'url' => ('projects.index'),
                        ]
                    ];
                    foreach ($notificationArray as $notification) {
                        $notificationData = [
                            'user' => $user,
                            'notificationArray' => $notification,
                        ];
                      $this->ajaxDispatch(new \App\Jobs\Notifications\SendNotification($notificationData));
                    }
                }
            }

            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.indicators', 1)]))->success()->livewire($this);
            $this->emit('renderPlanDetailIndicators');
            $this->emit('indicatorCreated');
            $this->resetInputs();
        } else {
            flash($response['message'],)->error()->livewire($this);
        }

        $this->show = false;
    }


}
