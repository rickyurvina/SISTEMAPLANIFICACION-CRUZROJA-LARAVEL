<?php

namespace App\Http\Livewire\Poa\Config;

use App\Jobs\Poa\CreatePoaProgram;
use App\Models\Admin\Company;
use App\Models\Measure\Measure;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaActivity;
use App\Models\Poa\PoaIndicatorConfig as PoaIndicatorConfigs;
use App\Models\Poa\PoaProgram;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use App\Models\Strategy\PlanTemplate;
use App\Traits\Jobs;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use function config;
use function flash;
use function redirect;
use function session;
use function trans;
use function view;

class PoaIndicatorConfig extends Component
{
    use Jobs;

    public $poaId = null;

    public $data = [];

    public $weight = 0;

    public $poa;

    public $poaActivities;
    public bool $is_SC = false;

    public $showButtonDeleteIndicators = false;

    public function mount()
    {
        $companyActive = Company::find(session('company_id'));
        $this->is_SC = $companyActive->parent_id ? false : true;
        $this->data = $this->configPoa();
        $this->checkPoaActivities();
    }

    public function render()
    {
        return view('livewire.poa.config.poa-indicator-config');
    }

    public function checkActivities($measureId, $programId, $pos)
    {
        $poaActivities = PoaActivity::where('poa_program_id', $programId)
            ->where('measure_id', $measureId)
            ->first();
        if ($poaActivities) {
            $this->data[$pos]['id'] = $this->data[$pos]['measureId'];
            flash(trans('general.error_message_uncheck_indicator'))->error()->livewire($this);
        }
    }

    public function saveConfig()
    {
        $contProgramsSelected = 0;
        $this->validate([
            'data' => 'required|array',
            'data.*.reason' => 'required_without:data.*.id',
        ]);
        $this->validate([
            'data' => 'required|array',
            'data.*.reason' => 'required_if:data.*.id,==,false',
        ]);

        //Recuperar los programas seleccionados
        $lastPlanDetailId = "";
        for ($i = 0; $i < count($this->data); $i++) {
            if (!($this->data[$i]['id'] == null)) {
                if ($lastPlanDetailId != $this->data[$i]['planDetailId']) {
                    $contProgramsSelected++;
                    $lastPlanDetailId = $this->data[$i]['planDetailId'];
                }
            }
        }

        if ($contProgramsSelected > 0) {
            $this->weight = 100.00 / $contProgramsSelected;
        }
        for ($i = 0; $i < count($this->data); $i++) {
            $poaIndicatorConfigs = new PoaIndicatorConfigs();
            $poaIndicatorConfigs->poa_id = $this->poaId;
            $poaIndicatorConfigs->measure_id = $this->data[$i]['measureId'];
            if ($this->data[$i]['id'] == null) {
                $poaIndicatorConfigs->selected = false;
                $poaIndicatorConfigs->reason = $this->data[$i]['reason'];
            } else {
                $poaIndicatorConfigs->selected = true;
                $program = PoaProgram::where('plan_detail_id', $this->data[$i]['planDetailId'])
                    ->where('poa_id', $this->poaId)
                    ->first();
                if ($program) {
                    $programId = $program->id;
                } else {
                    $programId = $this->selectProgram($this->data[$i]['planDetailId']);
                }
                $poaIndicatorConfigs->program_id = $programId;
            }
            PoaIndicatorConfigs::updateOrCreate(['poa_id' => $this->poaId,
                'measure_id' => $this->data[$i]['measureId']],
                [
                    'poa_id' => (int)$this->poaId,
                    'measure_id' => $this->data[$i]['measureId'],
                    'program_id' => $this->data[$i]['id'] == null ? null : $poaIndicatorConfigs->program_id,
                    'selected' => $this->data[$i]['id'] == null ? false : true,
                    'reason' => $this->data[$i]['id'] == null ? $this->data[$i]['reason'] : null
                ]);
        }
        flash(trans('general.ok_config_indicator'))->success();
        return redirect()->route('poa.poas');
    }

    private function selectProgram(int $id)
    {
        $data = [
            'poa_id' => $this->poaId,
            'plan_detail_id' => $id,
            'weight' => $this->weight,
            'color' => config('constants.catalog.COLOR_PALETTE')[array_rand(config('constants.catalog.COLOR_PALETTE'), 1)],
            'company_id' => session('company_id'),
        ];

        $response = $this->ajaxDispatch(new CreatePoaProgram($data));
        return $response['data']->id;
    }

    private function configPoa()
    {
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
                        ->when($this->is_SC === true, function ($query) {
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
                        $poaIndicatorConfig = PoaIndicatorConfigs::where('poa_id', $this->poaId)
                            ->where('measure_id', $measure->id)
                            ->first();
                        if ($poaIndicatorConfig) {
                            $element['reason'] = $poaIndicatorConfig->reason;
                            $element['selected'] = $poaIndicatorConfig->selected;
                            if ($poaIndicatorConfig->program_id) {
                                $element['programId'] = $poaIndicatorConfig->program_id;
                            }
                            if ($poaIndicatorConfig->selected) {
                                $element['id'] = $element['measureId'];
                            }
                        } else {
                            $element['reason'] = "";
                            $element['selected'] = "";
                        }
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
                                ->when($this->is_SC === true, function ($query) {
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
                                $poaIndicatorConfig = PoaIndicatorConfigs::where('poa_id', $this->poaId)
                                    ->where('measure_id', $measure->id)
                                    ->first();

                                if ($poaIndicatorConfig) {
                                    $element['reason'] = $poaIndicatorConfig->reason;
                                    $element['selected'] = $poaIndicatorConfig->selected;
                                    if ($poaIndicatorConfig->program_id) {
                                        $element['programId'] = $poaIndicatorConfig->program_id;
                                    }
                                    if ($poaIndicatorConfig->selected) {
                                        $element['id'] = $element['measureId'];
                                    }
                                } else {
                                    $element['reason'] = "";
                                    $element['selected'] = "";
                                }
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
        return $sorted;
    }

    private function array_order_by()
    {
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
    }

    public function checkPoaActivities()
    {
        $this->poa = Poa::find($this->poaId);
        if ($this->poa->hasActivities() == true) {
            $this->showButtonDeleteIndicators = true;
        } else {
            $this->showButtonDeleteIndicators = false;
        }
    }

    public function deletePrograms()
    {
        if ($this->poa->hasActivities() == true) {
            flash('No se puede eliminar los programas, existen actividades asociadas');
        } else {
            try {
                DB::beginTransaction();
                $this->poa->configs->each->forceDelete();
                $this->poa->programs->each->forceDelete();
                DB::commit();
                return redirect()->route('poa.poas');
            } catch (\Exception $e) {
                flash($e->getMessage())->error()->livewire($this);
                DB::rollBack();
            }
        }
    }
}
