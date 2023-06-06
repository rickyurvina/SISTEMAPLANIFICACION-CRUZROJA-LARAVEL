<?php

namespace App\Http\Livewire\Indicators;

use App\Http\Livewire\Components\Modal;
use App\Jobs\Indicators\Indicator\UpdateIndicator;
use App\Jobs\Indicators\Indicator\UpdateIndicatorGroped;
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
        $results = null, $indicator_sources_id = null,
        $indicatorId = null, $user_id = null,
        $frequency = null, $state = null,
        $start_date = null, $end_date = null, $oldSumGoals = null,
        $progress = null, $goalValueTotal = null,
        $actualValueTotal = null,
        $indicatorsSelected = [], $category = null;

    public ?Collection $indicatorUnits = null, $users = null, $indicatorSource = null, $thresholds = null, $indicators = null;

    public $selectedThreshold = null, $selectedType = null, $indicator = null;

    public array $periods = [], $data = [],
        $min = [], $max = [], $freq = [];

    public $indicatorableId;
    public bool $selfGoals = false;
    public $indicatorableType;
    public $hasCategory = true;
    public $minThreshold = 0, $maxThreshold = 0;
    public $modelIndicator;
    public $idsIndicators;

    protected $listeners = ['open' => 'openFromIndicators', 'loadIndicatorEditData' => 'loadIndicator'];

    public function rules()
    {
        return [
            'indicatorId' => 'required',
            'name' => 'required|max:500',
            'code' => ['required', 'alpha_dash', 'alpha_num', 'max:5', 'morph_exists_indicator:indicatorableType'],
            'user_id' => 'required|integer',
            'start_date' => 'date',
            'end_date' => 'date',
            'base_line' => 'nullable',
            'type' => 'required',
            'indicator_units_id' => 'integer',
            'indicator_sources_id' => 'exclude_unless:is_manual,true|required',
            'selectedType' => 'required',
            'baseline_year' => 'nullable',
            'results' => 'required|string|max:500',
            'frequency' => 'required',
            'selectedThreshold' => 'required',
            'category' => 'required',
            'indicatorsSelected' => 'required_if:type,==,Grouped',
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
//        $this->loadIndicator($indicatorId);
        $this->emit('toggleIndicatorEditModal');
    }

    public function mount()
    {
        $this->thresholds = Threshold::all();
        $this->indicatorUnits = IndicatorUnits::get();
        $this->users = User::get();
        $this->indicatorSource = IndicatorSource::get();
        $this->modelIndicator = new Indicator;

    }

    public function loadIndicator($indicatorId)
    {
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
        $this->category = $this->indicator->category;
        $this->selectedType = $this->indicator->threshold_type;
        $this->start_date = Carbon::parse($this->indicator->start_date)->format('Y-m');
        $this->end_date = Carbon::parse($this->indicator->end_date)->format('Y-m');
        if ($this->indicator->goals_closed == 'closed' || $this->indicator->progressIndicator() > 0) {
            $this->progress = 1;
        }
        if ($this->type == Indicator::TYPE_MANUAL) {
            $this->selectedThreshold = $this->indicator->thresholds_id;
            $this->updatedSelectedThreshold($this->selectedThreshold);
            foreach ($this->indicator->indicatorGoals as $goal) {
                $this->freq[$goal->period - 1] = $goal->goal_value ?? null;
                $this->min[$goal->period - 1] = $goal->min >> null;
                $this->max[$goal->period - 1] = $goal->max ?? null;
            }
            $this->base_line = $this->indicator->base_line;
            $this->indicator_sources_id = $this->indicator->indicator_sources_id;
            $this->baseline_year = $this->indicator->baseline_year;
            $this->oldSumGoals = $this->indicator->indicatorGoals->sum('goal_value');
            $this->updated('frequency', 0);
            if ($this->indicator->goals_closed == Indicator::GOALS_CLOSED) {
                $this->state = 1;
            }
        } else {
            self::getChildrenIndicatorOfModel();

            $this->indicators = Indicator::when($this->indicator_units_id, function ($q) {
                $q->where('indicator_units_id', $this->indicator_units_id);
            })->when($this->idsIndicators, function ($q) {
                $q->whereIn('id', $this->idsIndicators);
            })->when($this->selectedType, function ($q) {
                $q->where('threshold_type', $this->selectedType);
            })->when($this->frequency, function ($q) {
                $q->where('frequency', $this->frequency);
            })->where('id', '!=', $this->indicatorId)->get();
            $this->start_date = Carbon::parse($this->indicator->start_date)->format('Y-m');
            $this->end_date = Carbon::parse($this->indicator->end_date)->format('Y-m');
            $this->indicatorsSelected = $this->indicator->indicatorParent()->pluck('child_indicator')->toArray();
            self::updatedIndicatorsSelected();
        }
    }

    public function updatedSelectedType()
    {
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
        $this->updatedSelectedThreshold($this->selectedThreshold);
    }

    public function updatedSelectedThreshold($threshold)
    {
        $threshold_properties = $this->indicator->threshold_properties ?? null;
        $threshold_type = $this->indicator->threshold_type ?? null;
        if (isset($threshold_properties) && $this->selectedType == $threshold_type && $this->selectedThreshold == $this->indicator->thresholds_id) {
            $this->minThreshold = $threshold_properties[1]['min'];
            $this->maxThreshold = $threshold_properties[1]['max'];
        } else {
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

        if (isset($this->selectedType) && isset($this->frequency) && isset($this->start_date) && isset($this->end_date)) {

            $startDate = $this->start_date . "-01";
            $endDate = $this->end_date . "-28";
            if ($endDate > $startDate) {
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
                    $this->data = $this->modelIndicator->calcQuarterly($this->periods, $count, $this->frequency);

                } else if ($this->frequency == 12) {
                    $count = $startPeriod;
                    $this->data = $this->modelIndicator->calcMonthly($this->periods, $startPeriod, $this->frequency);

                } else if ($this->frequency == 1) {
                    $this->data = $this->modelIndicator->calcYear($this->periods, $this->frequency);

                } else if ($this->frequency == 3) {
                    if ($startPeriod == 1) {
                        $count = 1;
                    } else if ($startPeriod == 5) {
                        $count = 2;
                    } else if ($startPeriod == 9) {
                        $count = 3;
                    }
                    $this->data = $this->modelIndicator->calcFourMonths($this->periods, $count, $this->frequency);
                }
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
            'indicatorsSelected',
            'indicators',
            'data',
            'periods',
            'min',
            'max',
            'freq',
            'selectedType',
            'indicator',
            'indicatorId',
            'state',
            'oldSumGoals',
            'progress',
            'goalValueTotal',
            'actualValueTotal',
            'selectedThreshold',
            'category',
        ]);
    }

    public function editIndicator()
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
            'id' => $this->indicator->id,
            'name' => $this->name,
            'code' => $this->code,
            'user_id' => $this->user_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'base_line' => $this->base_line,
            'indicator_units_id' => $this->indicator_units_id,
            'indicator_sources_id' => $this->indicator_sources_id,
            'thresholds_id' => $this->selectedThreshold,
            'threshold_type' => $this->selectedType,
            'baseline_year' => $this->baseline_year,
            'results' => $this->results,
            'frequency' => $this->frequency,
            'minThreshold' => $this->minThreshold,
            'maxThreshold' => $this->maxThreshold,
            'freq' => $this->freq,
            'min' => $this->min,
            'max' => $this->max,
            'goals_closed' => $this->state,
            'oldSumGoals' => $this->oldSumGoals,
            'child_indicator' => $this->indicatorsSelected,
            'total_goal_value' => $this->goalValueTotal,
            'total_actual_value' => $this->actualValueTotal,
            'category' => $this->category,
        ];
        if ($this->type != Indicator::TYPE_GROUPED) {
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
        return view('livewire.indicators.indicator-edit');
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
}
