<?php

namespace App\Http\Controllers\Strategy;

use App\Abstracts\Http\Controller;
use App\Http\Middleware\Azure\Azure;
use App\Jobs\Strategy\CreatePlanDetail;
use App\Jobs\Strategy\DeletePlan;
use App\Jobs\Strategy\DeletePlanDetail;
use App\Jobs\Strategy\UpdatePlanDetail;
use App\Models\Admin\Perspective;
use App\Models\Poa\PoaProgram;
use App\Models\Projects\ProjectArticulations;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use App\Traits\Jobs;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    use Jobs;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(Azure $azure)
    {
        $this->middleware('azure');
        $this->middleware('permission:strategy-manage|strategy-manage-plans|strategy-view-plans', ['only' => ['index','detail']]);
        $this->middleware('permission:strategy-manage|strategy-view-plans|strategy-view', ['only' => ['articulations','showPlanDetailsIndicators']]);
        $this->middleware('permission:strategy-manage|strategy-manage-plans', ['only' => ['detailStore','detailEdit','detailUpdate','destroy']]);
    }

    /**
     * Calls Plan default view.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $plans = Plan::with(['planDetails', 'planRegisteredTemplateDetails'])->where('company_id', session('company_id'))->collect();
        return view('modules.strategy.plan.index', compact('plans'));
    }

    /**
     * Calls Plan default view.
     *
     * @return Application|Factory|View
     */
    public function articulations($id)
    {
        $plan = Plan::find($id);
        return view('modules.strategy.plan.articulations', [
            'planId' => $id,
            'plan' => $plan
        ]);
    }

    public function listDetails(Plan $plan)
    {
        $children = $plan->planRegisteredTemplateDetails->where('parent_id', null);
        return view('modules.strategy.plan.index-level-1')->with(compact('plan', 'children'));
    }


    /**
     * PLan detail view.
     */
    public function detail(Request $request)
    {

        $level = $request->level;
        $id = $request->plan;
        $planDetailId = $request->planDetailId;
        $itemId = $request->itemId;
        $planTemplateDetailId = $request->planTemplateDetailId;

        if ($request->detail) {
            $planRegisteredTemplateDetail = PlanRegisteredTemplateDetails::find($request->detail);
        } else {
            $planRegisteredTemplateDetail = Plan::find($id)->planRegisteredTemplateDetails->where('parent_id', null)->first();
        }
        if ($level) {
            $plan = Plan::with(['planRegisteredTemplateDetails.childs', 'planDetails.parent'])->find($id);
            $planDetails = PlanDetail::where('level', $level)
                ->where('plan_registered_template_detail_id', $planRegisteredTemplateDetail->id)
                ->get();
            $itemId = $planRegisteredTemplateDetail->id;
            $planDetailId = $planRegisteredTemplateDetail->id;
            $title = $plan->name;
        } else {
            $planDetails = PlanDetail::with(['planArticulationSource', 'indicators', 'children', 'parent'])
                ->where('plan_registered_template_detail_id', $id)
                ->where('parent_id', $planDetailId)
                ->get();
            $plan = Plan::find($planRegisteredTemplateDetail->plan_id);
            $level = $planRegisteredTemplateDetail->level;
            $planDetail = PlanDetail::find($planDetailId);
            $title = $planDetail->name;
            $itemId = $planRegisteredTemplateDetail->id;

        }
        $planRegisteredTemplateDetailsBreadcrumbs = $planRegisteredTemplateDetail
            ->getPath($itemId ?? null, $plan->id, $planRegisteredTemplateDetail->id ?? null, $planDetailId);

        $articulations = [];
        foreach ($planDetails as $index => $pd) {
            foreach ($pd->planArticulationSource as $articulation) {
                $key = $articulation->plan_target_id;
                if (array_key_exists($key, $articulations)) {
                    $articulations[$key][] = $articulation->plan_source_detail_id;
                } else {
                    $articulations[$key][] = $articulation->plan_source_detail_id;
                }
            }
        }
        $plans = Plan::get();
        return view('modules.strategy.plan.detail', compact('planRegisteredTemplateDetail', 'planDetails'))
            ->with('planId', $id)
            ->with('plan', $plan)
            ->with('level', $level)
            ->with('title', $title)
            ->with('planDetailId', $planDetailId)
            ->with('articulations', $articulations)
            ->with('plans', $plans)
            ->with('planRegisteredTemplateDetailsBreadcrumbs', $planRegisteredTemplateDetailsBreadcrumbs);

    }

    /**
     * Plan detail store.
     *
     * @param Request $request
     */
    public function detailStore(Request $request)
    {
        $plan = $request->plan;
        $level = $request->level;
        $planDetailId = null;
        if ($request->planDetailId != '') {
            $planDetailId = $request->planDetailId;
        }

        $planTemplateDetailId = PlanRegisteredTemplateDetails::find($request->planRegisteredTemplateDetail)->parent_id;
        if ($planTemplateDetailId) {
            $planRegisteredTemplateDetailId = PlanRegisteredTemplateDetails::where('plan_id', $plan)
                ->where('plan_template_detail_id', $planTemplateDetailId)
                ->first()->id;
        } else {
            $planRegisteredTemplateDetailId = null;
        }
        $data = [
            'plan_id' => $plan,
            'plan_registered_template_detail_id' => $request->planRegisteredTemplateDetail,
            'parent_id' => $planDetailId,
            'code' => $request->code,
            'name' => $request->name,
            'level' => $level,
        ];

        dispatch_now(new CreatePlanDetail($data));
        return redirect(route('plans.detail', ['plan' => $plan,
            'level' => $level,
            'planDetailId' => $planDetailId,
            'itemId' => $planRegisteredTemplateDetailId,
            'planTemplateDetailId' => $planTemplateDetailId]));
    }


    public function detailEdit($id)
    {
        $perspectives = Perspective::get();
        $planDetail = PlanDetail::find($id);
        return view('modules.strategy.plan.detail-edit', compact('planDetail'))
            ->with('perspectives', $perspectives);
    }

    public function detailUpdate(Request $request)
    {
        $data = [
            'code' => $request->code,
            'name' => $request->name,
        ];

        if (isset($request->objectiveType)) {
            if ($request->objectiveType) {
                $data['mission_objective'] = false;
                $data['organizational_development'] = true;
                $data['perspective'] = $request->perspective;
            } else {
                $data['mission_objective'] = true;
                $data['organizational_development'] = false;
                $data['perspective'] = null;
            }
        }

        $response = $this->ajaxDispatch(new UpdatePlanDetail($request->id, $data));

        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.elements', 1)]))->success();
        } else {
            flash($response['message'])->error();
        }
        return redirect()->route('plans.detail.edit', ['id' => $request->id]);
    }


    public function destroy($id)
    {
        $plan = PlanDetail::with(['children', 'planArticulationTarget', 'indicators', 'articulations', 'programs'])->find($id);
        if ($plan->children->count() == 0) {
            if ($plan->planArticulationTarget->count() == 0) {
                if ($plan->indicators->count() == 0) {
                    if ($plan->articulations->count() == 0) {
                        if ($plan->programs->count() == 0) {
                            $response = $this->ajaxDispatch(new DeletePlanDetail($plan));
                            if ($response['success']) {
                                flash(trans('general.deleted_element'))->success();
                            } else {
                                flash($response['message'])->error();
                            }
                        } else {
                            flash(trans('general.delete_program_message'))->info();
                        }
                    } else {
                        flash(trans('general.delete_strategy_message'))->info();
                    }
                } else {
                    flash(trans('general.delete_strategy_message'))->info();
                }
            } else {
                flash(trans('general.delete_strategy_message'))->info();
            }
        } else {
            flash(trans('general.delete_strategy_message'))->info();
        }
        return redirect(url()->previous());
    }

    public function delete($id)
    {
        $plan = Plan::with(['planDetails'])->find($id);
        if ($plan->planDetails->count() < 1) {
            $response = $this->ajaxDispatch(new DeletePlan($id));
            if ($response['success']) {
                flash(trans('general.plan_detail_message'))->success();
            } else {
                flash($response['message'])->info();
            }
        } else {
            flash(trans('general.delete_strategy_message'))->info();
        }

        return redirect(url()->previous());
    }

    public function showPlanDetailsIndicators(Request $request, $planDetailId = null)
    {
        return view('modules.strategy.plan.plan_details_indicators',
            [
                'planDetailId' => $planDetailId,
                'type' => $request->type,
                'navigation' => $request->navigation
            ]
        );
    }
}
