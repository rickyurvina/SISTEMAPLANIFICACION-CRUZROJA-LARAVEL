<?php

namespace App\Http\Livewire\Indicators;

use App\Http\Livewire\Components\Modal;
use App\Jobs\Indicators\Indicator\CreateIndicator;
use App\Jobs\Indicators\Indicator\CreateIndicatorGrouped;
use App\Jobs\Notifications\SendNotification;
use App\Models\Auth\User;
use App\Models\Indicators\GoalIndicator\GoalIndicators;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Indicators\Sources\IndicatorSource;
use App\Models\Indicators\Threshold\Threshold;
use App\Models\Indicators\Units\IndicatorUnits;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Objectives\ProjectObjectives;
use App\Models\Projects\Project;
use App\Traits\Jobs;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rules\In;

class IndicatorCreate extends Modal
{
    use Jobs;

    public $type = null, $code = null, $name = null,
        $base_line = null, $baseline_year = null, $indicator_units_id = null,
        $results = null, $responsible = null, $indicator_sources_id = null,
        $user_id = null, $frequency = null, $labelPeriod = null,
        $period = null, $indicatorId = null, $state = null,
        $start_date = null, $end_date = null, $goalValueTotal = null,
        $actualValueTotal = null, $category = null;

    public ?Collection $indicatorUnits = null, $indicators = null, $users = null,
        $indicatorSource = null, $thresholds = null;

    public $selectedThreshold = null, $selectedType = null, $indicator = null;

    public $minThreshold = 0, $maxThreshold = 0;

    public $is_manual = false;

    public array $periods = [], $data = [], $min = [],
        $max = [], $freq = [], $indicatorsSelected = [];

    public $indicatorableType;
    public $indicatorableId;
    public $hasCategory = false;
    public $modelIndicator;
    public $model;
    public $idsIndicators;

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
            'indicator_sources_id' => 'exclude_unless:is_manual,true|required',
            'start_date' => 'date',
            'end_date' => 'date',
            'selectedType' => 'required',
            'baseline_year' => 'nullable',
            'frequency' => 'required',
            'indicatorsSelected' => 'required_if:type,==,Grouped',
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
        self::getChildrenIndicatorOfModel();
    }

    public function mount()
    {
        $this->resetInputs();
        $this->thresholds = Threshold::all();
        $this->indicatorUnits = IndicatorUnits::get();
        $this->users = User::get();
        $this->indicatorSource = IndicatorSource::get();
        $this->modelIndicator = new Indicator;
        $this->emit('toggleIndicatorCreateModal');
    }

    public function render()
    {
        return view('livewire.indicators.indicator-create');
    }

    public function updatedType()
    {
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
        ]);


    }

    public function updatedIndicatorsSelected()
    {
        $this->goalValueTotal = 0;
        $this->actualValueTotal = 0;
        $indicatorsSel = Indicator::whereIn('id', $this->indicatorsSelected)->get();
        $sumGoal = $indicatorsSel->sum('total_goal_value');
        $sumActual = $indicatorsSel->sum('total_actual_value');
        $this->goalValueTotal = $sumGoal;
        $this->actualValueTotal = $sumActual;
    }

    public function updated($name, $value)
    {
        if (isset($this->selectedType) && isset($this->frequency) && isset($this->start_date) && isset($this->end_date) && $this->is_manual) {
            $startDate = $this->start_date . "-01";
            $endDate = $this->end_date . "-28";
            if ($endDate > $startDate) {
                $dates = $this->modelIndicator->calcStartEndDateF($startDate, $endDate, $this->frequency);
                $this->periods = $this->modelIndicator->calcNumberOfPeriods($this->modelIndicator, $this->frequency, $dates['f_start_date'], $dates['f_end_date']);
                $startPeriod = $this->modelIndicator->calcNumberOfPeriodStartC($startDate, $endDate, $this->frequency);
                $count = 0;
                if ($this->frequency == 2) {
                    $this->data = $this->modelIndicator->calcSemester($this->periods, $startPeriod == 1 ? 1 : 2, $this->frequency);
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
                    $this->data = $this->modelIndicator->calcQuarterly($this->periods, $count, $this->frequency);
                }
                if ($this->frequency == 12) {
                    $this->data = $this->modelIndicator->calcMonthly($this->periods, $startPeriod, $this->frequency);
                }
                if ($this->frequency == 1) {
                    $this->data = $this->modelIndicator->calcYear($this->periods, $this->frequency);
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
                    $this->data = $this->modelIndicator->calcFourMonths($this->periods, $count, $this->frequency);
                }
            }
        }
        if ($this->type == Indicator::TYPE_GROUPED) {
            $this->indicators = Indicator::when($this->indicator_units_id, function ($q) {
                $q->where('indicator_units_id', $this->indicator_units_id);
            })->when($this->idsIndicators, function ($q) {
                $q->whereIn('id', $this->idsIndicators);
            })->when($this->selectedType, function ($q) {
                $q->where('threshold_type', $this->selectedType);
            })->when($this->frequency, function ($q) {
                $q->where('frequency', $this->frequency);
            })->get();
        }
    }

    public function updatedShow()
    {
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset([
            'name',
            'code',
            'user_id',
            'start_date', 'start_date',
            'end_date',
            'base_line',
            'indicator_units_id',
            'indicator_sources_id',
            'selectedType',
            'baseline_year',
            'results',
            'frequency',
            'selectedThreshold',
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
            'type',
            'minThreshold',
            'maxThreshold',
        ]);
    }

    public function updatedSelectedType()
    {
        $this->reset(
            [
                'frequency',
                'min',
                'max',
                'freq',
                'periods',
                'data',
            ]
        );
        $this->updatedSelectedThreshold($this->selectedThreshold);
    }

    public function updatedSelectedThreshold($threshold)
    {
        if ($this->selectedThreshold && $this->selectedType) {
            $thresholdFind = Threshold::find($threshold);
            if ($this->selectedType == Indicator::TYPE_ASCENDING) {
                $this->minThreshold = $thresholdFind->properties[1][3];
                $this->maxThreshold = $thresholdFind->properties[2][3];
            } elseif ($this->selectedType == Indicator::TYPE_DESCENDING) {
                $this->minThreshold = $thresholdFind->properties[5][3];
                $this->maxThreshold = $thresholdFind->properties[6][3];
            } elseif ($this->selectedType == Indicator::TYPE_TOLERANCE) {
                $this->minThreshold = $thresholdFind->properties[9][3];
                $this->maxThreshold = $thresholdFind->properties[10][3];
            }
        }
    }

    public function save()
    {
        $this->validate();
        $this->start_date = $this->start_date . "-01";
        $this->end_date = $this->end_date . "-28";
        $this->validate(
            [
                'start_date' => 'date',
                'end_date' => 'date|after:start_date',
            ]
        );
        $data = [
            'name' => $this->name,
            'code' => $this->code,
            'user_id' => $this->user_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'type' => $this->type,
            'indicator_units_id' => $this->indicator_units_id,
            'threshold_type' => $this->selectedType,
            'thresholds_id' => $this->selectedThreshold,
            'results' => $this->results,
            'baseline_year' => $this->baseline_year,
            'base_line' => $this->base_line,
            'frequency' => $this->frequency,
            'total_goal_value' => $this->goalValueTotal,
            'indicator_sources_id' => $this->indicator_sources_id,
            'total_actual_value' => $this->actualValueTotal,
            'company_id' => session('company_id'),
            'child_indicator' => $this->indicatorsSelected,
            'minThreshold' => $this->minThreshold,
            'maxThreshold' => $this->maxThreshold,
            'indicatorable_type' => $this->indicatorableType,
            'indicatorable_id' => $this->indicatorableId,
            'min' => $this->min,
            'max' => $this->max,
            'freq' => $this->freq,
            'category' => $this->category,
        ];

        if ($this->type == Indicator::TYPE_MANUAL) {
            $response = $this->ajaxDispatch(new CreateIndicator($data));
        } elseif ($this->type == Indicator::TYPE_GROUPED) {
            $response = $this->ajaxDispatch(new CreateIndicatorGrouped($data));
        }
        if ($response['success']) {
            self::notify();
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.indicators', 1)]))->success()->livewire($this);
            $this->emit('renderPlanDetailIndicators');
            $this->emit('indicatorCreated');
            $this->resetInputs();
        } else {
            flash($response['message'],)->error()->livewire($this);
        }
        $this->show = false;
    }

    public function notify()
    {
        if ($this->user_id) {
            $user = User::find($this->user_id);
            if ($user) {
                $notificationArray = [];
                $notificationArray[0] = [
                    'via' => ['database'],
                    'database' => [
                        'username' => $user->name,
                        'title' => trans('indicator_responsable'),
                        'description' => __('Ha sido asignado como responsable del indicador ' . $this->name),
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
                    $this->ajaxDispatch(new SendNotification($notificationData));
                }
            }
        }
    }

    public function getChildrenIndicatorOfModel()
    {
        if ($this->indicatorableType == Project::class) {
            $tasks = Task::where('project_id', $this->indicatorableId)
                ->get()->pluck('id')->toArray();
            $idsTasks = Indicator::where('indicatorable_type', Task::class)
                ->whereIn('indicatorable_id', $tasks)->get()->pluck('id')->toArray();
            $objectives = ProjectObjectives::where('prj_project_id', $this->indicatorableId)
                ->get()->pluck('id')->toArray();
            $idsObjectives = Indicator::where('indicatorable_type', ProjectObjectives::class)
                ->whereIn('indicatorable_id', $objectives)->get()->pluck('id')->toArray();
            $idsProjects = Indicator::where('indicatorable_type', Project::class)
                ->where('indicatorable_id', $this->indicatorableId)->get()->pluck('id')->toArray();
            $this->idsIndicators = array_merge($idsTasks, $idsObjectives);
            $this->idsIndicators = array_merge($this->idsIndicators, $idsProjects);
        }
    }
}
