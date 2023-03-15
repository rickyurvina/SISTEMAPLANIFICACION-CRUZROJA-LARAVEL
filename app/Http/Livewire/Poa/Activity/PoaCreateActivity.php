<?php

namespace App\Http\Livewire\Poa\Activity;

use App\Jobs\Poa\CreatePoaActivity;
use App\Models\Auth\User;
use App\Models\Common\CatalogGeographicClassifier;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Indicators\Units\IndicatorUnits;
use App\Models\Measure\Measure;
use App\Models\Poa\PoaActivity;
use App\Models\Poa\PoaActivityTemplate;
use App\Models\Poa\PoaIndicatorConfig;
use App\Models\Poa\PoaProgram;
use App\Scopes\Company;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PoaCreateActivity extends Component
{
    use Jobs;

    public $poaId = null;

    public $poaProgramId = null;

    public $poaProgramName = '';

    public $programIndicators = [];

    public $poaActivityName = null;

//    public $poaActivityCode = null;

    public $poaActivityUserInChargeId = null;

    public $poaActivityIndicatorId = null;

    public $poaActivityIndicatorName = '';

    public $poaActivityCost = null;

    public $poaActivityImpact = null;

    public $poaActivityComplexity = null;
    public $programs;
    public $program;
    public $locations = [];
    public $typeLocation;
    public $selectedLocationId = null;
    public $selectedLocationName = '';
    public $limitLocation = 10;
    public $searchLocation = '';
    public $users;
    public $measure;
    public $indicatorUnits;
    public $unitSelected;
    public $activityTemplates = [];
    public $selectedTemplate = null;
    public $code = null;
    public $typeOfAggregation = 'sum';
    public $programIdSelected = null;

    protected $listeners = ['loadIndicators'];

    public function mount(int $poaId)
    {
        $this->poaId = $poaId;
        $this->programs = PoaProgram::with(['planDetail', 'poaActivities'])->where('poa_id', $poaId)->get();
        $this->users = User::enabled()->get();
        $this->indicatorUnits = IndicatorUnits::get();
        $this->code = $this->programs->pluck('poaActivities')->collapse()->count() + 1;
    }

    public function render()
    {
        return view('livewire.poa.activity.poa-create-activity');
    }

    public function updatedCode($value)
    {
        self::loadActivityTemplates();
    }

    public function updatedPoaActivityName($value)
    {
        self::loadActivityTemplates();
    }

    public function resetTemplate()
    {
        $this->activityTemplates = [];
    }

    private function loadActivityTemplates()
    {
        $this->activityTemplates = PoaActivityTemplate::where('code', 'iLike', '%' . $this->code . '%')
            ->where('name', 'iLike', '%' . $this->poaActivityName . '%')->limit(10)->orderBy('code')->get();
    }

    public function updatingPoaProgramId($value)
    {
        if ($this->poaProgramId != $value) {
            $this->poaActivityIndicatorId = null;
            $this->poaActivityIndicatorName = '';
        }
    }

    public function updatedUnitSelected()
    {
        self::updatedPoaProgramId($this->programIdSelected);
    }

    public function updatedPoaProgramId($value)
    {
        if ($value) {
            $this->programIdSelected = $value;
            $this->program = $this->programs->find($value);
            $this->poaProgramName = $this->program->planDetail->name;
            $programIndicators = PoaIndicatorConfig::selected()->where([
                ['poa_id', '=', $this->poaId],
                ['program_id', '=', $value],
            ])->get();

            $this->programIndicators = Measure::withOutGlobalScope(Company::class)->with(['unit'])
                ->whereIn('id', $programIndicators->pluck('measure_id')->toArray())
                ->when($this->unitSelected != null, function ($q) {
                    $q->where('unit_id', $this->unitSelected);
                })->get();
        }
    }

    public function updatedPoaActivityIndicatorId($value)
    {
        $this->measure = $this->programIndicators->find($value);
        $this->poaActivityIndicatorName = $this->measure->name;
    }

    public function updatedTypeLocation($value)
    {
        $this->selectedLocationId = null;
        $this->selectedLocationName = '';
        $this->searchLocation = '';
        self::locations();
    }

    public function updatedSearchLocation($value)
    {
        self::locations();
    }

    public function updatedSelectedLocationId($value)
    {
        $this->selectedLocationName = $this->locations->where('id', $value)->first()->getPath();
        $this->searchLocation = '';
        self::locations();
    }

    private function locations()
    {
        $this->locations = CatalogGeographicClassifier::when($this->typeLocation, function ($q) {
            $q->where('type', $this->typeLocation);
        })->when($this->searchLocation != '', function ($q) {
            $q->where(function ($q) {
                $q->where('full_code', 'iLike', '%' . $this->searchLocation . '%')
                    ->orWhere('description', 'iLike', '%' . $this->searchLocation . '%');
            });
        })->limit($this->limitLocation)->get();
    }

    /**
     * Load Program Indicators
     *
     */
    public function loadIndicators($poaProgramId)
    {
        $this->poaProgramId = $poaProgramId;
        self::updatedPoaProgramId($poaProgramId);
    }

    /**
     * Store POA program activity
     *
     */
    public function submitActivity()
    {
        $this->validate(
            [
                'poaActivityName' => 'required|max:255',
                'code' => 'required|numeric|' . Rule::unique('poa_activities')
                        ->where('poa_program_id', $this->poaProgramId)
                        ->where('deleted_at', null),
                'poaActivityCost' => 'nullable|numeric',
                'poaActivityImpact' => 'required',
                'poaActivityComplexity' => 'required',
                'poaActivityUserInChargeId' => 'required',
                'poaProgramId' => 'required',
                'poaActivityIndicatorId' => 'required',
                'typeOfAggregation' => 'required',
            ]
        );

        $data = [
            'poa_program_id' => $this->poaProgramId,
            'indicator_unit_id' => $this->measure->unit->id,
            'measure_id' => $this->poaActivityIndicatorId,
            'location_id' => $this->selectedLocationId,
            'plan_detail_id' => $this->program->plan_detail_id,
            'name' => $this->poaActivityName,
            'code' => $this->code,
            'user_id_in_charge' => $this->poaActivityUserInChargeId,
            'status' => PoaActivity::STATUS_SCHEDULED,
            'cost' => $this->poaActivityCost,
            'impact' => $this->poaActivityImpact,
            'complexity' => $this->poaActivityComplexity,
            'company_id' => session('company_id'),
            'description' => 'Texto descripción',
            'aggregation_type' => $this->typeOfAggregation,
            'measure' => $this->measure,
        ];

        $response = $this->ajaxDispatch(new CreatePoaActivity($data));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.activities', 1)]))->success()->livewire($this);
            $this->resetForm();
            $this->emit('activityCreated');
            $this->emit('toggleModalCreateActivity');
        } else {
            flash($response['message'])->error()->livewire($this);
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
        $this->reset(
            [
                'poaProgramId',
                'programIndicators',
                'poaActivityName',
                'poaActivityUserInChargeId',
                'poaActivityIndicatorId',
                'selectedLocationId',
                'poaActivityCost',
                'poaActivityImpact',
                'poaActivityComplexity',
                'selectedTemplate',
                'locations',
                'poaActivityIndicatorName',
                'selectedLocationName',
                'typeLocation',
                'typeOfAggregation',
            ]
        );
        $this->programs = PoaProgram::with(['poaActivities'])->where('poa_id', $this->poaId)->get();
        $this->code = $this->programs->pluck('poaActivities')->collapse()->count() + 1;

    }

    public function selectTemplateActivity(PoaActivityTemplate $template)
    {
        $this->code = $template->code;
        $this->poaActivityName = $template->name;
        $this->poaActivityCost = $template->cost;
        $this->poaActivityImpact = $template->impact;
        $this->poaActivityComplexity = $template->complexity;
        $this->activityTemplates = [];
    }

}