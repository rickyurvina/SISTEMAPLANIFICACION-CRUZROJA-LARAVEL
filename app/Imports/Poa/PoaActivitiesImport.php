<?php

namespace App\Imports\Poa;

use App\Jobs\Poa\CreatePoaActivity;
use App\Jobs\Poa\UpdatePoaActivityGoal;
use App\Models\Auth\User;
use App\Models\Common\CatalogGeographicClassifier;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Measure\Measure;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaActivity;
use App\Models\Poa\PoaIndicatorConfig as PoaIndicatorConfigs;
use App\Models\Poa\PoaProgram;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use App\Models\Strategy\PlanTemplate;
use App\Scopes\Company;
use App\Traits\Jobs;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Exception;
use Illuminate\Support\Facades\Validator;

class PoaActivitiesImport implements ToCollection, WithHeadingRow, WithValidation, WithBatchInserts
{
    use Importable, SkipsErrors, SkipsFailures, Jobs;

    public $poa;
    public $programs = null;
    public $results = null;

    public function __construct(int $poaId)
    {
        $this->poa = Poa::findOrFail($poaId);
        $plan = Plan::with(['planDetails.children', 'planDetails.measures'])
            ->where('plan_type', PlanTemplate::PLAN_STRATEGY_CRE)
            ->where('status', Plan::ACTIVE)->first();
        $planDetails = $plan->planDetails;
        $programsTemplate = PlanRegisteredTemplateDetails::where('program', true)
            ->where('plan_id', $plan->id)
            ->first();
        $resultsTemplate = PlanRegisteredTemplateDetails::where('poa_indicators', true)
            ->where('plan_id', $plan->id)
            ->first();
        $this->programs = $planDetails->where('plan_registered_template_detail_id', $programsTemplate->id);
        $this->results = $planDetails->where('plan_registered_template_detail_id', $resultsTemplate->id);
    }

    /**
     * @param Collection $rows
     * @throws Exception
     */
    public function collection(Collection $rows)
    {
        self::deletePoaActivities();
        foreach ($rows as $row) {
            self::createActivitiesFromFile($row);
        }
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            foreach ($validator->getData() as $key => $data) {
                $program = $this->programs->where('code', $data['code_program'])->first();
                if (!$program) {
                    $validator->errors()->add($key, 'No existe el programa con el código' . $data['code_program']);
                } else {
                    $results = $program->children;
                    $result = $results->where('code', $data['code_result'])->first();
                    if (!$result) {
                        $validator->errors()->add($key, 'No existe el resultado ascociado al programa ' . $program->code . ' con el código ' . $data['code_result']);
                    } else {
                        $measures = $result->measures;
                        $measure = $measures->where('code', $data['code_indicator'])->first();
                        if (!$measure) {
                            $validator->errors()->add($key, 'No existe el indicador ascociado al resulado ' . $result->code . ' con el código ' . $data['code_indicator']);
                        }
                        $poaIndicatorConfig = PoaIndicatorConfigs::where('poa_id', $this->poa->id)->pluck('measure_id')->toArray();
                        if (!in_array($measure->id, $poaIndicatorConfig)) {
                            $validator->errors()->add($key, 'El indicador no existe en la configuración del POA con el código ' . $data['code_indicator']);
                        }
                    }
                }
            }
        });
    }

    public function rules(): array
    {
        return [
            '*.code_program' => ['required', 'exists:plan_details,code'],
            '*.code_result' => ['required', 'exists:plan_details,code'],
            '*.code_indicator' => ['required', 'exists:msr_measures,code'],
            '*.impact' => ['required', 'between:1,3'],
            '*.complexity' => ['required', 'between:1,3'],
            '*.cost' => ['nullable', 'numeric'],
            '*.code_location' => ['required', 'exists:catalog_geographic_classifiers,full_code'],
            '*.email_responsable' => ['required', 'exists:users,email'],
            '*.name_activity' => ['required', 'max:255'],
            '*.description' => ['nullable', 'max:500'],
            '*.code' => ['required', 'numeric'],
            '*.aggregation_type' => ['required', Rule::in(['sum', 'ave'])],
            '*.ene_planned' => ['nullable', 'numeric'],
            '*.feb_planned' => ['nullable', 'numeric'],
            '*.mar_planned' => ['nullable', 'numeric'],
            '*.abr_planned' => ['nullable', 'numeric'],
            '*.may_planned' => ['nullable', 'numeric'],
            '*.jun_planned' => ['nullable', 'numeric'],
            '*.jul_planned' => ['nullable', 'numeric'],
            '*.ago_planned' => ['nullable', 'numeric'],
            '*.sep_planned' => ['nullable', 'numeric'],
            '*.oct_planned' => ['nullable', 'numeric'],
            '*.nov_planned' => ['nullable', 'numeric'],
            '*.dic_planned' => ['nullable', 'numeric'],

            '*.men_ene' => ['nullable', 'numeric'],
            '*.men_feb' => ['nullable', 'numeric'],
            '*.men_mar' => ['nullable', 'numeric'],
            '*.men_abr' => ['nullable', 'numeric'],
            '*.men_may' => ['nullable', 'numeric'],
            '*.men_jun' => ['nullable', 'numeric'],
            '*.men_jul' => ['nullable', 'numeric'],
            '*.men_ago' => ['nullable', 'numeric'],
            '*.men_sep' => ['nullable', 'numeric'],
            '*.men_oct' => ['nullable', 'numeric'],
            '*.men_nov' => ['nullable', 'numeric'],
            '*.men_dic' => ['nullable', 'numeric'],

            '*.women_ene' => ['nullable', 'numeric'],
            '*.women_feb' => ['nullable', 'numeric'],
            '*.women_mar' => ['nullable', 'numeric'],
            '*.women_abr' => ['nullable', 'numeric'],
            '*.women_may' => ['nullable', 'numeric'],
            '*.women_jun' => ['nullable', 'numeric'],
            '*.women_jul' => ['nullable', 'numeric'],
            '*.women_ago' => ['nullable', 'numeric'],
            '*.women_sep' => ['nullable', 'numeric'],
            '*.women_oct' => ['nullable', 'numeric'],
            '*.women_nov' => ['nullable', 'numeric'],
            '*.women_dic' => ['nullable', 'numeric'],

            '*.actual_ene' => ['nullable', 'numeric'],
            '*.actual_feb' => ['nullable', 'numeric'],
            '*.actual_mar' => ['nullable', 'numeric'],
            '*.actual_abr' => ['nullable', 'numeric'],
            '*.actual_may' => ['nullable', 'numeric'],
            '*.actual_jun' => ['nullable', 'numeric'],
            '*.actual_jul' => ['nullable', 'numeric'],
            '*.actual_ago' => ['nullable', 'numeric'],
            '*.actual_sep' => ['nullable', 'numeric'],
            '*.actual_oct' => ['nullable', 'numeric'],
            '*.actual_nov' => ['nullable', 'numeric'],
            '*.actual_dic' => ['nullable', 'numeric'],
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function deletePoaActivities()
    {
        $poaActivities = $this->poa->poaActivities();
        if ($poaActivities->count() > 0) {
            $poaActivities->each->forceDelete();
        }
    }

    public function createActivitiesFromFile($row)
    {
        try {
            DB::beginTransaction();
            $code_program = $row['code_program'];
            $code_indicator = $row['code_indicator'];
            $code_result = $row['code_result'];
            $poaProgram = PoaProgram::whereHas('planDetail', function (Builder $query) use ($code_program) {
                $query->where('code', $code_program);
            })->where('poa_id', $this->poa->id)
                ->first();
            $results = PlanDetail::where('parent_id', $poaProgram->plan_detail_id)
                ->where('code', $code_result)
                ->get();
            $measure = Measure::withOutGlobalScope(Company::class)
                ->where('code', $code_indicator)
                ->where('indicatorable_type', PlanDetail::class)
                ->whereIn('indicatorable_id', $results->pluck('id'))
                ->first();
            $user = User::where('email', $row['email_responsable'])->first();
            $location = CatalogGeographicClassifier::where('full_code', $row['code_location'])->first();
            $name = $row['name_activity'];
            //datos para la actividad
            $code = $row['code'];
            $poaProgramId = $poaProgram->id;
            $indicatorUnitId = $measure->unit_id;
            $planDetailId = $poaProgram->plan_detail_id;
            $userIdInCharge = $user->id;
            $cost = $row['cost'];
            $impact = $row['impact'];
            $complexity = $row['complexity'];
            $locationId = $location->id;
            $description = $row['description'];
            $measureId = $measure->id;
            $aggregationType = $row['aggregation_type'];

            $data = [
                'code' => $code,
                'poa_program_id' => $poaProgramId,
                'indicator_unit_id' => $indicatorUnitId,
                'plan_detail_id' => $planDetailId,
                'name' => $name,
                'user_id_in_charge' => $userIdInCharge,
                'status' => PoaActivity::STATUS_FINISHED,
                'cost' => $cost ?? 1,
                'impact' => $impact ?? 1,
                'complexity' => $complexity ?? 1,
                'company_id' => session('company_id'),
                'location_id' => $locationId,
                'description' => $description,
                'measure_id' => $measureId,
                'aggregation_type' => $aggregationType,
                'measure' => $measure,
            ];
            $response = $this->ajaxDispatch(new CreatePoaActivity($data));
            if ($response['success']) {
                $poaActivity = $response['data'];
                $poaIndicatorConfig = PoaIndicatorConfigs::where('poa_id', $this->poa->id)
                    ->where('measure_id', $poaActivity->measure_id)->first();
                $poaIndicatorConfig->selected = true;
                $poaIndicatorConfig->save();
                self::createGoalsAdvances($poaActivity, $row);
            }
            DB::commit();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function createGoalsAdvances($poaActivity, $row)
    {
        try {
            //OBTENER METAS
            $goalsCharged =
                [
                    1 => $row['ene_planned'] ?? null,
                    2 => $row['feb_planned'] ?? null,
                    3 => $row['mar_planned'] ?? null,
                    4 => $row['abr_planned'] ?? null,
                    5 => $row['may_planned'] ?? null,
                    6 => $row['jun_planned'] ?? null,
                    7 => $row['jul_planned'] ?? null,
                    8 => $row['ago_planned'] ?? null,
                    9 => $row['sep_planned'] ?? null,
                    10 => $row['oct_planned'] ?? null,
                    11 => $row['nov_planned'] ?? null,
                    12 => $row['dic_planned'] ?? null
                ];

            $menByMonths =
                [
                    1 => $row['men_ene'] ?? null,
                    2 => $row['men_feb'] ?? null,
                    3 => $row['men_mar'] ?? null,
                    4 => $row['men_abr'] ?? null,
                    5 => $row['men_may'] ?? null,
                    6 => $row['men_jun'] ?? null,
                    7 => $row['men_jul'] ?? null,
                    8 => $row['men_ago'] ?? null,
                    9 => $row['men_sep'] ?? null,
                    10 => $row['men_oct'] ?? null,
                    11 => $row['men_nov'] ?? null,
                    12 => $row['men_dic'] ?? null
                ];

            $womenByMonths =
                [
                    1 => $row['women_ene'] ?? null,
                    2 => $row['women_feb'] ?? null,
                    3 => $row['women_mar'] ?? null,
                    4 => $row['women_abr'] ?? null,
                    5 => $row['women_may'] ?? null,
                    6 => $row['women_jun'] ?? null,
                    7 => $row['women_jul'] ?? null,
                    8 => $row['women_ago'] ?? null,
                    9 => $row['women_sep'] ?? null,
                    10 => $row['women_oct'] ?? null,
                    11 => $row['women_nov'] ?? null,
                    12 => $row['women_dic'] ?? null
                ];

            $actualMonths =
                [
                    1 => $row['actual_ene'] ?? null,
                    2 => $row['actual_feb'] ?? null,
                    3 => $row['actual_mar'] ?? null,
                    4 => $row['actual_abr'] ?? null,
                    5 => $row['actual_may'] ?? null,
                    6 => $row['actual_jun'] ?? null,
                    7 => $row['actual_jul'] ?? null,
                    8 => $row['actual_ago'] ?? null,
                    9 => $row['actual_sep'] ?? null,
                    10 => $row['actual_oct'] ?? null,
                    11 => $row['actual_nov'] ?? null,
                    12 => $row['actual_dic'] ?? null
                ];

            $goals = [];
            $poaActivityDetails = $poaActivity->measureAdvances;
            $count = 1;
            foreach ($poaActivityDetails as $poaActivityDetail) {
                $element = [];
                $element['id'] = $poaActivityDetail->id;
                $element['year'] = now()->format('Y');
                $element['monthName'] = Indicator::FREQUENCIES[12][$count];
                $element['goal'] = $goalsCharged[$count];
                $element['men'] = $menByMonths[$count];
                $element['women'] = $womenByMonths[$count];
                $element['actual'] = $actualMonths[$count];
                array_push($goals, $element);
                $count++;
            }
            $this->ajaxDispatch(new UpdatePoaActivityGoal($poaActivity->id, $goals));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }
}
