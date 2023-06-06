<?php

namespace App\Http\Controllers\Strategy;

use App\Abstracts\Http\Controller;
use App\Exports\DefaultHeaderReportExport;
use App\Models\Admin\Company;
use App\Models\Indicators\Units\IndicatorUnits;
use App\Models\Measure\Measure;
use App\Models\Measure\MeasureAdvances;
use App\Models\Poa\PoaActivity;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use App\Models\Strategy\PlanTemplate;
use Barryvdh\Snappy\Facades\SnappyPdf as PDFSnappy;
use Maatwebsite\Excel\Facades\Excel;


class StrategyReportController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('azure');
        $this->middleware('permission:strategy-manage-indicator-reports|strategy-manage|
        strategy-view-indicator-reports', ['only' => ['reportIndicators','show']]);
        $this->middleware('permission:strategy-manage|
        strategy-view', ['only' => ['reportArticulations','show','strategy-view-structure-poa','structurePoaExcel']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function reportIndicators()
    {
        return view('modules.strategy.home.report_indicators');
    }

    /**
     * Display a listing of the resource.
     */
    public function reportArticulations()
    {
        return view('modules.strategy.home.report_articulations');
    }

    public function structurePoaUpload(){
        $plan = Plan::with(['planDetails.measures'])->type(Plan::TYPE_STRATEGY)->active()->first();
        $planDetails=$plan->planDetails;
        $measures=$planDetails->pluck('measures')->collapse();
        return view('modules.strategy.home.report_structure',compact('measures'));
    }

    public function structurePoaExcel(){
        $plan = Plan::with(['planDetails.measures'])->type(Plan::TYPE_STRATEGY)->active()->first();
        $planDetails=$plan->planDetails;
        $measures=$planDetails->pluck('measures')->collapse();
        $view = view('modules.strategy.home.report_structure_excel')
            ->with('measures', $measures);
        $response = Excel::download(new DefaultHeaderReportExport($view, trans('general.report_general')), trans('general.report_general'). '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        if(ob_get_length() > 0) {
            ob_end_clean();
        }
        return $response;
    }
}
