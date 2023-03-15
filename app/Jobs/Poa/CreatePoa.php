<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use App\Models\Measure\Measure;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaIndicatorConfig as PoaIndicatorConfigs;
use App\Models\Poa\PoaProgram;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use App\Models\Strategy\PlanTemplate;
use App\Scopes\Company;
use Exception;
use Illuminate\Support\Facades\DB;

class CreatePoa extends Job
{
    protected $poa;

    protected $request;

    protected $poaIndicatorConfigs;

    protected $poaPrograms;

    protected $weight;

    protected $data = [];


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
     * @return mixed
     * @throws Exception
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $this->poa = Poa::create($this->request->all());
            $this->configPoa();
            $this->saveConfigAndPrograms();
            DB::commit();
            return $this->poa;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }

    private function configPoa()
    {
        try {
            $is_SC = false;
            $companyActive = \App\Models\Admin\Company::find(session('company_id'));
            $is_SC = $companyActive->parent_id ? false : true;
            $arrayObjective2Summary = [];
            $sorted = [];
            $plans = Plan::where('plan_type', PlanTemplate::PLAN_STRATEGY_CRE)->where('status', Plan::ACTIVE)->first();
            if ($plans) {
                $planDetails = $plans->planDetails;
                $programTemplateId = PlanRegisteredTemplateDetails::where('program', true)
                    ->where('plan_id', $plans->id)
                    ->first();
                $programTemplatePoaIndicator = PlanRegisteredTemplateDetails::where('poa_indicators', true)
                    ->where('plan_id', $plans->id)
                    ->first();
                foreach ($planDetails->where('plan_registered_template_detail_id', $programTemplateId->id) as $planDetail) {
                    if ($planDetail->plan_registered_template_detail_id === $programTemplatePoaIndicator->id) {
                        $measures = Measure::withoutGlobalScope(\App\Scopes\Company::class)
                            ->orderBy('id', 'asc')
                            ->when($is_SC === true, function ($query) {
                                $query->where('category', Measure::CATEGORY_TACTICAL);
                            }, function ($query) {
                                $query->where('category', Measure::CATEGORY_OPERATIVE);
                            })
                            ->where('indicatorable_id', $planDetail->id)
                            ->where('indicatorable_type', PlanDetail::class)->get();
                        foreach ($measures as $measure) {
                            $element = [];
                            $element['id'] = null;
                            $element['specificObjectiveId'] = $planDetail->parent->id;
                            $element['planDetailId'] = $planDetail->id;
                            $element['planDetailName'] = $planDetail->name;
                            $element['specificGoal'] = $planDetail->parent->name;
                            $element['indicatorName'] = $measure->name;
                            $element['measureId'] = $measure->id;
                            $element['programId'] = $planDetail->id;
                            $element['national'] = $measure->national;
                            if ($measure->national) {
                                $element['id'] = $element['measureId'];
                            }
                            array_push($arrayObjective2Summary, $element);
                        }
                    } else {
                        foreach ($planDetail->children as $childPlan) {
                            if ($childPlan->plan_registered_template_detail_id === $programTemplatePoaIndicator->id) {
                                $measures = Measure::withoutGlobalScope(\App\Scopes\Company::class)
                                    ->orderBy('id', 'asc')
                                    ->when($is_SC === true, function ($query) {
                                        $query->where('category', Measure::CATEGORY_TACTICAL);
                                    }, function ($query) {
                                        $query->where('category', Measure::CATEGORY_OPERATIVE);
                                    })
                                    ->where('indicatorable_id', $childPlan->id)
                                    ->where('indicatorable_type', PlanDetail::class)->get();
                                foreach ($measures as $measure) {
                                    $element = [];
                                    $element['id'] = null;
                                    $element['specificObjectiveId'] = $planDetail->parent->id;
                                    $element['planDetailId'] = $planDetail->id;
                                    $element['planDetailName'] = $planDetail->name;
                                    $element['specificGoal'] = $planDetail->parent->name;
                                    $element['indicatorName'] = $measure->name;
                                    $element['measureId'] = $measure->id;
                                    $element['programId'] = $planDetail->id;
                                    $element['national'] = $measure->national;

                                    if ($measure->national) {
                                        $element['id'] = $element['measureId'];
                                    }
                                    array_push($arrayObjective2Summary, $element);
                                }
                            }
                        }
                    }
                }
                $sorted = $this->array_order_by($arrayObjective2Summary, 'specificObjectiveId', SORT_ASC, 'planDetailId', SORT_ASC);
            }
            $this->data = $sorted;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function saveConfigAndPrograms()
    {
        try {
            $arrProgramsIds = array();
            foreach ($this->data as $item) {
                $programId = $item['programId'];
                if (!in_array($programId, $arrProgramsIds)) {
                    array_push($arrProgramsIds, $programId);
                }
            }
            $contProgramsSelected = count($arrProgramsIds);

            //Recuperar los programas seleccionados
            if ($contProgramsSelected > 0) {
                $this->weight = 100.00 / $contProgramsSelected;
            }
            for ($i = 0; $i < count($this->data); $i++) {
                $program = PoaProgram::where('plan_detail_id', $this->data[$i]['planDetailId'])
                    ->where('poa_id', $this->poa->id)
                    ->first();
                if ($program) {
                    $programId = $program->id;
                } else {
                    $poaProgram = $this->createPoaProgram($this->data[$i]['planDetailId']);
                    $programId = $poaProgram->id;
                }
                PoaIndicatorConfigs::updateOrCreate(['poa_id' => $this->poa->id,
                    'measure_id' => $this->data[$i]['measureId']],
                    [
                        'poa_id' => (int)$this->poa->id,
                        'measure_id' => $this->data[$i]['measureId'],
                        'program_id' => $programId,
                        'selected' => false,
                    ]);
            }
            $this->poaPrograms = PoaProgram::with(['poaIndicatorConfigs'])->where('poa_id', $this->poa->id)->get();
            $this->poaIndicatorConfigs = $this->poaPrograms->pluck('poaIndicatorConfigs');

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    private function createPoaProgram(int $id)
    {
        try {
            $data = [
                'poa_id' => $this->poa->id,
                'plan_detail_id' => $id,
                'weight' => $this->weight,
                'color' => config('constants.catalog.COLOR_PALETTE')[array_rand(config('constants.catalog.COLOR_PALETTE'), 1)],
                'company_id' => session('company_id'),
            ];
            $response = $this->ajaxDispatch(new CreatePoaProgram($data));
            return $response['data'];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    private function array_order_by()
    {
        try {
            $args = func_get_args();
            $data = array_shift($args);
            foreach ($args as $n => $field) {
                if (is_string($field)) {
                    $tmp = array();
                    foreach ($data as $key => $row) {
                        $tmp[$key] = $row[$field];
                    }
                    $args[$n] = $tmp;
                }
            }
            $args[] = &$data;
            call_user_func_array('array_multisort', $args);
            return array_pop($args);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }
}
