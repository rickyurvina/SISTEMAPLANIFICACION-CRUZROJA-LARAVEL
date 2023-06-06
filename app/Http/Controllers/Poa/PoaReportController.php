<?php

namespace App\Http\Controllers\Poa;

use App\Abstracts\Http\Controller;
use App\Exports\DefaultHeaderReportExport;
use App\Models\Indicators\Units\IndicatorUnits;
use App\Models\Measure\MeasureAdvances;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaActivity;
use App\Models\Poa\PoaProgram;
use App\Models\Strategy\PlanDetail;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;

class PoaReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('azure');
        $this->middleware('permission:poa-manage|poa-view-reports',
            [
                'only' => ['
                index',
                    'getPoaSession',
                    'reportObjectives',
                    'showEvaluationReport',
                    'goals',
                    'activityStatus',
                    'exportActivityStatus',
                    'generateActivityStatusReport',
                    'showActivitiesReport',
                ]
            ]);
    }

    public function index()
    {
        $cardReports = Config::get('constants.catalog.CARD_REPORTS');
        return view('modules.poa.reports.index', compact('cardReports'));
    }

    public function getPoaSession()
    {
        return Poa::where('company_id', session('company_id'))->first();
    }

    public function reportObjectives()
    {
        return view('modules.poa.reports.objectives.index');
    }

    public function showEvaluationReport()
    {
        return view('modules.poa.reports.general-evaluation.evaluation');

    }

    public function goals()
    {
        return view('modules.poa.reports.goals.goals');
    }

    public function activityStatus()
    {
        $poa = $this->getPoaSession();
        $data = $this->generateActivityStatusReport($poa->id);
        return view('modules.poa.reports.activity-status.activity-status', compact('data'));
    }

    public function exportActivityStatus()
    {
        $poa = $this->getPoaSession();
        $data = $this->generateActivityStatusReport($poa->id);
        $view = view('modules.poa.reports.activity-status.excel', compact('data'));
        $response = Excel::download(new DefaultHeaderReportExport($view, trans('poa.activity-status')), trans('poa.activity-status') . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        return $response;
    }

    private function generateActivityStatusReport($poaId)
    {
        $arrayReport = [];

        $poaPrograms = PoaProgram::where('poa_id', $poaId)
            ->orderBy('plan_detail_id')
            ->get();
        foreach ($poaPrograms as $program) {
            $poaActivities = PoaActivity::where('poa_program_id', $program->id)
                ->orderBy('measure_id')
                ->get();
            foreach ($poaActivities as $activity) {
                $element['programId'] = $program->id;
                $element['programName'] = $program->planDetail->name;
                $element['indicator'] = $activity->measure->name;
                $element['activity'] = $activity->name;
                $element['responsible'] = $activity->responsible->name;
                $element['status'] = $activity->status;
                $arrayReport[$program->id][] = $element;
            }
        }
        return $arrayReport;
    }

    public function showActivitiesReport()
    {
        return view('modules.poa.reports.show-activity');
    }
}
