<?php

namespace App\Http\Controllers\Poa;

use App\Abstracts\Http\Controller;
use App\Jobs\Poa\CreatePoa;
use App\Jobs\Poa\DeletePoa;
use App\Jobs\Poa\DeletePoaActivityTemplate;
use App\Jobs\Poa\ReplicatePoa;
use App\Models\Admin\Company;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaActivity;
use App\Models\Poa\PoaActivityTemplate;
use App\Models\Poa\PoaIndicatorGoalChangeRequest;
use App\Models\Poa\PoaRescheduling;
use App\States\Poa\InProgress;
use App\States\Poa\Planning;
use App\Traits\Jobs;
use Illuminate\Support\Facades\DB;

class PoaController extends Controller
{
    use Jobs;

    public function index()
    {
        if (user()->can('poa-crud-poa') || user()->can('poa-read-poa')) {
            $currentYear = (int)date('Y');
            $nextYear = $currentYear + 1;
            $poaExists = Poa::with(['company', 'responsible'])->whereIn('year', [$currentYear, $nextYear])
                ->where('company_id', session('company_id'))
                ->count();
            $companiesArray = [];
            $companiesChildrenArray = [];
            $companyFind = Company::find(session('company_id'));
            $companies = Company::where('level', 2)
                ->when($companyFind->level != 1, function ($q) use ($companyFind) {
                    $q->where('id', $companyFind->id);
                })
                ->get();

            foreach ($companies as $company) {
                $element = [];
                $element['id'] = $company->id;
                $element['name'] = $company->name;
                $element['level'] = $company->level;
                $element['poa'] = $company->poas ?? null;
                array_push($companiesArray, $element);
            }
            foreach ($companiesArray as $index => $comp) {
                $children = $companies->find($comp['id'])->children;
                foreach ($children as $child) {
                    $countPoas = Poa::with(['company', 'responsible'])->whereIn('year', [$currentYear, $nextYear])
                        ->where('company_id', $company->id)
                        ->count();
                    $element = [];
                    $element['id'] = $child->id;
                    $element['poaExists'] = $countPoas;
                    $element['parent'] = $child->parent_id;
                    $element['level'] = $child->level;
                    $element['poa'] = $child->poas ?? null;
                    array_push($companiesChildrenArray, $element);
                }
            }
            $poas = null;
            if ($companyFind->level != 2) {
                $poas = Poa::with(['company', 'responsible'])
                    ->where('company_id', session('company_id'))
                    ->collect();
            }
            return view('modules.poa.poas.list', compact('poaExists', 'poas', 'companiesChildrenArray', 'companiesArray', 'companyFind'));
        } else {
            abort(403);
        }
    }

    public function changeControl($poaId = null)
    {
        if (user()->can('poa-manage-changeControl')) {
            return view('modules.poa.poas.changeControl')->with('poaId', $poaId);
        } else {
            abort(403);
        }
    }

    public function config($poaId = null)
    {
        $poa = Poa::find($poaId);
        return view('modules.poa.poas.config', compact('poa'))
            ->with('poaId', $poaId);
    }


    public function store($year = null)
    {
        try {
            if ($year == null) {
                $currentYear = date('Y');
            } else {
                $currentYear = $year;
            }
            $name = __('general.title.new', ['type' => __('general.poa')]);
            $userInCharge = user()->id;

            $data = [
                'year' => $currentYear,
                'name' => $name . ' ' . $currentYear,
                'user_id_in_charge' => $userInCharge,
                'status' => InProgress::label(),
                'phase' => Planning::label(),
                'company_id' => session('company_id'),
            ];

            DB::beginTransaction();
            $response = $this->ajaxDispatch(new CreatePoa($data));
            if ($response['success']) {
                flash(trans_choice('messages.success.added', 0, ['type' => __('general.poa')]))->success();
                DB::commit();
                return redirect()->route('poa.poas');
            } else {
                flash($response['message'])->error();
                return redirect()->route('poa.poas');
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
            return redirect()->route('poa.poas');
        }

    }

    public function replicate($poaId)
    {
        $response = $this->ajaxDispatch(new ReplicatePoa($poaId));
        if ($response['success']) {
            flash(trans('general.poa_replicate_title'))->success();
            return redirect()->route('poa.poas');
        } else {
            flash($response['message'])->error();
            return redirect()->route('poa.poas');
        }
    }

    public function goalChangeRequest()
    {
        if (user()->can('poa-manage-changeGoal')) {
            $requests = [];
            $activities = PoaActivity::with(['program.poa.company'])
                ->get()
                ->groupBy('plan_detail_id');
            foreach ($activities as $activity) {
                foreach ($activity as $item) {
                    $listRequests = PoaIndicatorGoalChangeRequest::where('poa_activity_id', $item->id)
                        ->get()->groupBy('request_number');
                    foreach ($listRequests as $goalRequest) {
                        if ($goalRequest->first()->status === PoaIndicatorGoalChangeRequest::STATUS_OPEN) {
                            $element = [];
                            $element['id'] = $goalRequest->first()->id;
                            $element['date'] = $goalRequest->first()->created_at->format('F j, Y');
                            $element['activity'] = $item->name;
                            $element['indicator'] = $item->measure->name;
                            $element['number_requests'] = $goalRequest->count();
                            $element['user'] = $goalRequest->first()->requestUser->getFullName();
                            $element['status'] = $goalRequest->first()->status;
                            $element['poa'] = $item->program->poa->name;
                            $element['company'] = $item->program->poa->company->name;
                            array_push($requests, $element);
                        }
                    }
                }
            }
            return view('modules.poa.poas.goal-requests', compact('requests'));
        } else {
            abort(403);
        }
    }

    public function manageCatalogActivities()
    {
        $poaActTempl = PoaActivityTemplate::collect();
        return view('modules.poa.activity.catalog', compact('poaActTempl'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Poa $poa
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Poa $poa): \Illuminate\Http\RedirectResponse
    {
        if ($poa->configs->count() > 0) {
            flash('No se puede eliminar Poa')->error();
            return redirect()->route('poa.poas');
        } else {
            $response = $this->ajaxDispatch(new DeletePoa($poa));
            if ($response['success']) {
                flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.poa', 1)]))->success();
            } else {
                flash($response['message'])->error();
            }
            return redirect()->route('poa.poas');
        }
    }

    public function deleteCatalogActivities($id)
    {
        $activityCatalog = PoaActivityTemplate::find($id);

        if ($activityCatalog) {
            $response = $this->ajaxDispatch(new DeletePoaActivityTemplate($activityCatalog));
            if ($response['success']) {
                flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.poa_activity_catalog_create', 1)]))->success();
            } else {
                flash($response['message'])->error();
                return;
            }
        }

        return redirect()->route('poa.manage_catalog_activities');
    }

    public function rescheduling($poaId)
    {
        if (user()->can('poa-approve-rescheduling') || user()->can('poa-manage-reschedulings')) {
            $poa = Poa::find($poaId);
            return view('modules.poa.rescheduling.index', compact('poa'));
        } else {
            abort(403);
        }
    }

    public function deleteRescheduling(int $id)
    {
        $rescheduling = PoaRescheduling::find($id);
        $poaId = $rescheduling->poa->id;
        $rescheduling->delete();
        flash('Eliminado exitosamente')->success();
        return redirect()->route('poa.rescheduling', $poaId);
    }

    public function configurationThreshold()
    {
        $poas = Poa::with(['company', 'responsible'])->withOutGlobalScopes()->collect();
        return view('modules.poa.configuration.threshold', compact('poas'));
    }

    public function poaBudget(Poa $poa)
    {
        return view('modules.poa.budget.index', compact('poa'));
    }
}
