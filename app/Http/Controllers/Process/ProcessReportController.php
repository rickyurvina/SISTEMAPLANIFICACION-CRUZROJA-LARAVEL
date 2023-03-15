<?php

namespace App\Http\Controllers\Process;

use App\Abstracts\Http\Controller;
use App\Models\Process\Process;
use Illuminate\Support\Facades\Config;


class ProcessReportController extends Controller
{
    public function index(Process $process, $page)
    {
        $cardReports = Config::get('constants.catalog.PROJECT_CARD_REPORTS');
        $subMenu = 'reports';
        return view('modules.process.reports.process-reports', compact('process', 'cardReports', 'subMenu'))
            ->with('page', $page);
    }

    public function nonConformitiesReport()
    {
        $processes = Process::with(['nonConformities'])->orderBy('id')->get();
        return view('modules.process.reports.non-conformities-report',
            ['processes' => $processes]);
    }
}
