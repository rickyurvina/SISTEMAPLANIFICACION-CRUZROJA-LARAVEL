<?php

namespace App\Http\Livewire\Measure;

use App\Events\Measure\MeasureGroupedCreated;
use App\Http\Livewire\Components\Modal;
use App\Models\Auth\User;
use App\Models\Indicators\Sources\IndicatorSource;
use App\Models\Indicators\Units\IndicatorUnits;
use App\Models\Measure\Calendar;
use App\Models\Measure\Measure;
use App\Models\Measure\ScoringType;
use App\Models\Strategy\PlanDetail;
use App\Traits\Jobs;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class MeasureEdit extends Modal
{
    use Jobs;

    public $type = 'Manual',
        $code = null,
        $name = null,
        $baseLine = null,
        $baseLineYear = null,
        $indicatorUnitId = null,
        $indicatorUnitName = null,
        $results = null,
        $responsible = null,
        $indicatorSourceId = null,
        $indicatorSourceName = null,
        $typeOfAggregation = 'sum',
        $userId = null,
        $userName = null,
        $calendarId = null,
        $calendarName = null,
        $calendarFrequency = null,
        $category = null,
        $national = false,
        $dataType = 'number',
        $scoringTypeId = null,
        $scoringTypeName = null,
        $scoringType = null,
        $scoringConfig = null,
        $isYesGood = null,
        $higherBetter = null,
        $series = [],
        $element = null,
        $measure,
        $goalsClosed = false,
        $measureId;

    public ?Collection $indicatorUnits = null, $users = null, $indicatorSources = null, $calendars = null, $scoring = null, $groupedMeasures = null;

    public $indicatorableType;

    public $indicatorableId;

    public function rules()
    {
        return [
            'measureId' => ['required'],
            'code' => ['required', 'alpha_dash', 'alpha_num', 'max:5', 'morph_exists_measure:indicatorableType'],
            'type' => 'required',
            'name' => 'required',
            'category' => 'required',
            'userId' => 'required|integer',
            'typeOfAggregation' => 'required',
            'dataType' => 'required',
            'scoringTypeId' => 'required',
            'calendarId' => 'required',
            'groupedMeasures' => 'required_if:type,Agrupado',
        ];
    }

    public function messages()
    {
        return [
            'code.morph_exists_measure' => 'El código del indicador ya existe.',
        ];
    }


    public function show(...$arg)
    {
        if (is_int($arg[0])) {
            $this->measure = Measure::find($arg[0]);
            if ($this->measure) {
                $this->measureId = $this->measure->id;
            }
            parent::show();
            $this->indicatorUnits = IndicatorUnits::get();
            $this->users = User::get();
            $this->indicatorSources = IndicatorSource::get();
            $this->calendars = Calendar::get();
            $this->scoring = ScoringType::orderBy('id')->get();
            $this->init();
        }
    }

    public function render()
    {
        return view('livewire.measure.measure-edit');
    }

    private function init()
    {
        $this->name = $this->measure->name;
        $this->code = $this->measure->code;
        $this->type = $this->measure->type;
        $this->userId = $this->measure->user_id;
        $this->baseLineYear = $this->measure->baseline_year;
        $this->baseLine = $this->measure->base_line;
        $this->indicatorSourceId = $this->measure->source_id;
        $this->results = $this->measure->description;
        $this->calendarId = $this->measure->calendar_id;
        $this->calendarName = $this->calendars->find($this->calendarId)->name;
        $this->indicatorableId = $this->measure->indicatorable->id;
        $this->indicatorableType = $this->measure->indicatorable::class;
        $this->category = $this->measure->category;
        $this->national = $this->measure->is_mandatory;
        $this->goalsClosed = $this->measure->goals_closed;
        $this->calendarFrequency = 'monthly';
        $scoringModel = $this->scoring->find($this->measure->scoring_type_id);
        $this->scoringTypeId = $scoringModel->id;
        $this->scoringTypeName = $scoringModel->name;
        $this->scoringType = $scoringModel->code;
        $this->scoringConfig = $scoringModel->config;
        $this->series = array_fill(1, count($this->scoringConfig), null);
        foreach ($this->series as $index => $item) {
            $this->series[$index] = $this->measure->series[$index];
        }
        $this->groupedMeasures = collect([]);
        $this->typeOfAggregation = $this->measure->aggregation_type;
        $this->indicatorUnitId = $this->measure->unit_id;
        $this->indicatorUnitName = $this->measure->unit->name;
        $this->dataType = $this->measure->data_type;
        if ($this->type == Measure::TYPE_GROUPED) {
            $this->groupedMeasures = $this->measure->group->pluck('id');
        }

    }

    public function updatedCalendarId($value)
    {
        $this->calendarName = $this->calendars->firstWhere('id', $value)->name;
        $this->calendarFrequency = $this->calendars->firstWhere('id', $value)->frequency;
    }

    public function updatedScoringTypeId($value)
    {
        $scoringModel = $this->scoring->firstWhere('id', $value);
        $this->scoringTypeName = $scoringModel->name;
        $this->scoringType = $scoringModel->code;
        $this->scoringConfig = $scoringModel->config;
        $this->indicatorUnitId = null;
        $this->indicatorUnitName = null;

        if ($this->scoringType == ScoringType::TYPE_YES_NO) {
            $this->isYesGood = 1;
            $this->typeOfAggregation = 'number-of-yeses';
            $this->series = [];
        } else {
            $this->series = array_fill(1, count($this->scoringConfig), null);
            $this->typeOfAggregation = 'sum';
        }

        if ($this->scoringType == ScoringType::TYPE_GOAL_ONLY) {
            $this->higherBetter = 1;
        }
    }

    public function updatedIndicatorUnitId($value)
    {
        $this->indicatorUnitName = $this->indicatorUnits->firstWhere('id', $value)->name;
    }

    public function updatedType($value)
    {
        self::init();
        if ($value == Measure::TYPE_GROUPED && !$this->element) {
            $this->element = PlanDetail::where(
                'id', $this->indicatorableId
            )->with(['measures', 'children.measures'])->first();
        }
    }

    public function measureSelected($value)
    {
        if (!$this->groupedMeasures->contains($value)) {
            $this->groupedMeasures->push($value);
        }
    }

    public function measureUnSelected($id)
    {
        $this->groupedMeasures = $this->groupedMeasures->filter(function ($value, $key) use ($id) {
            return $value['id'] != $id;
        });
    }

    public function isSelected($id)
    {
        return $this->groupedMeasures->contains('id', $id);
    }

    public function resetInputs()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset([
            'name',
            'code',
            'type',
            'results',
            'baseLineYear',
            'baseLine',
            'typeOfAggregation',
            'indicatorUnitId',
            'indicatorSourceId',
            'calendarId',
            'scoringTypeId',
            'dataType',
            'isYesGood',
            'higherBetter',
            'series',
            'category',
            'userId',
            'calendarName',
            'indicatorableId',
            'indicatorableType',
            'calendarFrequency',
            'groupedMeasures',
            'typeOfAggregation',
            'indicatorUnitName',
            'element',
            'show',
            'national',
            'goalsClosed',
        ]);
    }

    public function save()
    {
        $this->withValidator(function (Validator $validator) {
            $validator->sometimes('series.*', 'required|numeric', function ($input) {
                return $input->scoringType != ScoringType::TYPE_YES_NO;
            });
        })->validate();

        $data = [
            'name' => $this->name,
            'code' => $this->code,
            'type' => $this->type,
            'description' => $this->results,
            'baseline_year' => $this->baseLineYear == "" ? null : $this->baseLineYear,
            'base_line' => $this->baseLine ?? null,
            'aggregation_type' => $this->typeOfAggregation,
            'unit_id' => $this->indicatorUnitId,
            'source_id' => $this->indicatorSourceId,
            'calendar_id' => $this->calendarId,
            'user_id' => $this->userId,
            'scoring_type_id' => $this->scoringTypeId,
            'category' => $this->category,
            'is_mandatory' => $this->national,
            'national' => $this->national,
            'data_type' => $this->dataType,
            'yes_good' => $this->isYesGood,
            'higher_better' => $this->higherBetter,
            'series' => $this->series,
            'goals_closed' => $this->goalsClosed,
        ];

        try {
            DB::beginTransaction();;
            $this->measure->update($data);
            if ($this->type == Measure::TYPE_GROUPED) {
                $this->measure->group->each->forceDelete();
                $this->measure->group()->attach($this->groupedMeasures->pluck('id'));
                MeasureGroupedCreated::dispatch($this->measure);
            }
            DB::commit();
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.indicators', 1)]))->success()->livewire($this);
            $this->emit('renderPlanDetailIndicators');
            $this->resetInputs();
            $this->show = false;
        } catch (\Exception $exception) {
            DB::rollBack();
            flash($exception->getMessage())->error()->livewire($this);
        }

    }
}
