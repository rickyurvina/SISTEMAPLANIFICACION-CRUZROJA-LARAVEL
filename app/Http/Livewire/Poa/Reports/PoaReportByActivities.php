<?php

namespace App\Http\Livewire\Poa\Reports;

use App\Exports\DefaultHeaderReportExport;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaActivity;
use App\Models\Poa\PoaProgram;
use App\Scopes\Company;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class PoaReportByActivities extends Component
{
    public $selectYears;
    public $poaSelected;
    public $data;
    public $cantons;
    public $provinces;
    public $selectProvinces;
    public $selectCantons;
    public $actualMonth;
    public $actualDay;
    public $years = [];
    public $statuses = [];
    public $selectStatus;

    public function mount()
    {
        $this->cantons = \App\Models\Admin\Company::where('level', 3)->get();
        $this->provinces = \App\Models\Admin\Company::where('level', 2)->get();
        $this->actualMonth = now()->month - 1;
        $this->actualDay = now()->day;
        $this->selectYears = now()->year;
        $this->statuses = PoaActivity::STATUSES;
        for ($i = 1; $i <= 5; $i++) {
            $year = 2020 + $i;
            array_push($this->years, $year);
        }
    }

    public function render()
    {
        $this->data = $this->generateActivityStatusReport();
        return view('livewire.poa.reports.poa-report-by-activities');
    }

    public function updatedSelectProvinces()
    {
        $this->reset(['selectCantons']);
        $this->cantons = \App\Models\Admin\Company::where('level', 3)
            ->when($this->selectProvinces != null, function ($q) {
                return $q->where('parent_id', $this->selectProvinces);
            })->get();
    }

    public function getPoaSession()
    {
        $this->poaSelected = Poa::withoutGlobalScope(Company::class)
            ->when($this->selectYears != null, function ($q) {
                return $q->where('year', $this->selectYears);
            })->when($this->selectCantons != null, function ($q) {
                return $q->where('company_id', $this->selectCantons);
            }, function ($q) {
                $q->where('company_id', session('company_id'));
            })->first();
    }

    public function cleanFilters()
    {
        $this->reset(
            [
                'selectYears',
                'selectCantons',
                'selectProvinces',
                'selectStatus',
                'years',
            ]);
        self::mount();
    }

    public function exportExcel()
    {
        $view = view('modules.poa.reports.activity-status.excel')
            ->with('data', $this->data);
        $response = Excel::download(new DefaultHeaderReportExport($view, trans('poa.activity-status')), trans('poa.activity-status') . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        return $response;
    }

    private function generateActivityStatusReport()
    {
        self::getPoaSession();

        $arrayReport = [];
        if ($this->poaSelected) {
            $poaPrograms = PoaProgram::where('poa_id', $this->poaSelected->id)
                ->orderBy('plan_detail_id')
                ->get();
            foreach ($poaPrograms as $program) {
                $poaActivities = PoaActivity::with(['measureAdvances'])->where('poa_program_id', $program->id)
                    ->orderBy('measure_id')
                    ->get();
                foreach ($poaActivities as $activity) {
                    $measureAdvances = $activity->measureAdvances;
                    $element['id'] = $activity->id;
                    $element['programId'] = $program->id;
                    $element['programName'] = $program->planDetail->name;
                    $element['indicator'] = $activity->measure->name;
                    $element['indicatorIcon'] = $activity->measure->unit->getIcon();
                    $element['activity'] = $activity->name;
                    $element['responsible'] = $activity->responsible->name;
                    if ($activity->status) {
                        $status = $activity->status;
                    } else {
                        $status = PoaActivity::STATUS_SCHEDULED;
                    }
                    $contMonth = 1;

                    if ($status != PoaActivity::STATUS_FINISHED) {
                        foreach ($measureAdvances as $advance) {
                            if ($contMonth == $this->actualMonth) {
                                if ($this->actualDay > 15) {
                                    $actual = $advance->actual;
                                    if ($actual > 0) {
                                        $status = PoaActivity::STATUS_IN_PROGRESS;
                                    } else {
                                        $status = PoaActivity::STATUS_ON_DELAY;
                                    }
                                } else {
                                    $status = PoaActivity::STATUS_SCHEDULED;
                                }
                            }
                            $contMonth++;
                        }
                    }

                    $element['status'] = $status;

                    if ($this->selectStatus != null) {
                        if ($status === $this->selectStatus) {
                            $arrayReport[$program->id][] = $element;
                        }
                    } else {
                        $arrayReport[$program->id][] = $element;
                    }
                }
            }
        }

        return $arrayReport;
    }
}
