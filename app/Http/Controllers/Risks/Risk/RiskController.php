<?php

namespace App\Http\Controllers\Risks\Risk;

use App\Abstracts\Http\Controller;
use App\Http\Requests\Risk\RiskRequest;
use App\Jobs\Risk\CreateRisk;
use App\Jobs\Risk\DeleteRisk;
use App\Models\Common\Catalog;
use App\Models\Projects\Catalogs\ProjectRiskClassification;
use App\Models\Risk\Risk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RiskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $risks = Risk::with(['state'])->enabled()->get();
        return view('modules.risk.home.index', compact('risks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $classifications = ProjectRiskClassification::get();
        return view('modules.risk.home.create', compact('classifications'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RiskRequest $request
     * @return RedirectResponse
     */
    public function store(RiskRequest $request): RedirectResponse
    {
        $response = $this->ajaxDispatch(new CreateRisk($request));
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans('general.module_risk')]))->success();
            return redirect()->route('risk.home');
        } else {
            flash($response['message'])->error();
            return redirect()->route('risks.create');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Risk $risk
     * @return View
     */
    public function edit(Risk $risk): View
    {
        $classifications = Catalog::catalogName('classifications')->first()->details;
        $scale_of_impacts = Catalog::catalogName('scale_of_impacts')->first()->details;
        $scale_of_probabilities = Catalog::catalogName('scale_of_probabilities')->first()->details;
        return view('modules.risk.home.edit', compact('risk', 'classifications', 'scale_of_impacts', 'scale_of_probabilities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Risk $risk
     * @return RedirectResponse
     */
    public function destroy(Risk $risk): RedirectResponse
    {
        $response = $this->ajaxDispatch(new DeleteRisk($risk));

        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.risks', 1)]))->success();
        } else {
            flash($response['message'])->error();
        }
        return back()->withInput();

    }
}
