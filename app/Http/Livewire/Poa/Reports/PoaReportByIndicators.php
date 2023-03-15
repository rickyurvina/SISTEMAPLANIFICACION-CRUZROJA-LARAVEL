<?php

namespace App\Http\Livewire\Poa\Reports;

use App\Exports\DefaultHeaderReportExport;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Measure\MeasureAdvances;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaActivity;
use App\Models\Poa\PoaProgram;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use App\Models\Strategy\PlanTemplate;
use App\Scopes\Company;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use function view;

class PoaReportByIndicators extends Component
{
    public $indicatorUnit = '';
    public $selectYears;
    public $poaSelected;
    public $data;
    public $total;
    public $cantons;
    public $provinces;
    public $selectProvinces;
    public $selectCantons = [];
    public $selectedPrograms = [];
    public $years = [];
    public $programs;
    public $visibilityByMonth = true;

    public function mount()
    {
        $this->cantons = \App\Models\Admin\Company::where('level', 3)->get();
        $this->provinces = \App\Models\Admin\Company::where('level', 2)->get();
        $this->selectYears = now()->year;
        for ($i = 1; $i <= 5; $i++) {
            $year = 2020 + $i;
            array_push($this->years, $year);
        }
        self::loadPrograms();
    }

    public function render()
    {
        $this->getPoaSession();
        if ($this->poaSelected) {
            $this->data = $this->generateGoalPoaReport($this->poaSelected);
            $this->total = $this->generateGoalPoaReportTotalByIndicator($this->poaSelected);
        }
        return view('livewire.poa.reports.poa-report-by-indicators');
    }

    public function updatedSelectProvinces()
    {
        $this->reset(['selectCantons']);
        $this->cantons = \App\Models\Admin\Company::where('level', 3)->when($this->selectProvinces != null, function ($q) {
            return $q->where('parent_id', $this->selectProvinces);
        })->get();
        $this->selectCantons = $this->cantons->pluck('id');
    }

    public function getPoaSession()
    {
        $this->poaSelected = Poa::withoutGlobalScope(Company::class)
            ->when($this->selectYears != null, function ($q) {
                return $q->where('year', $this->selectYears);
            })->when(count($this->selectCantons) > 0, function ($q) {
                return $q->whereIn('company_id', $this->selectCantons);
            }, function ($q) {
                $q->where('company_id', session('company_id'));
            })->get();
    }

    public function cleanFilters()
    {
        $this->reset(
            [
                'selectYears',
                'selectCantons',
                'selectProvinces',
                'selectedPrograms',
                'years',
            ]);
        self::mount();
    }

    public function exportExcel()
    {
        $view = view('modules.poa.reports.goals.excel')
            ->with('data', $this->data)
            ->with('selectProvinces', $this->selectProvinces)
            ->with('visibilityByMonth', $this->visibilityByMonth)
            ->with('total', $this->total);
        $response = Excel::download(new DefaultHeaderReportExport($view, trans('poa.reached_people')), trans('poa.reached_people') . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        return $response;
    }

    private function generateGoalPoaReport($poas)
    {
        $arrayPoas = [];

        foreach ($poas as $poa) {
            $arrayObjective2Summary = [];
            $poaPrograms = PoaProgram::where('poa_id', $poa->id)
                ->when(count($this->selectedPrograms) > 0, function ($q) {
                    return $q->whereIn('plan_detail_id', $this->selectedPrograms);
                })
                ->get();
            $sumMen = 0;
            $sumWomen = 0;
            foreach ($poaPrograms as $program) {
                $poaActivities = PoaActivity::with(
                    [
                        'planDetail.measures',
                        'planDetail.parent',
                        'measure.unit'
                    ])->where('poa_program_id', $program->id)
                    ->get();

                $firstActivity = $poaActivities->first();
                if ($firstActivity) {
                    $objective2Id = $firstActivity->planDetail->parent->id;
                    $arrayObjective2Summary[$program->id]['idObjective'] = $objective2Id;
                    $arrayObjective2Summary[$program->id]['programId'] = $program->id;
                    $arrayObjective2Summary[$program->id]['programName'] = $firstActivity->planDetail->name;
                    $arrayObjective2Summary[$program->id]['specificGoal'] = $firstActivity->planDetail->parent->name;
                    foreach (Indicator::FREQUENCIES[12] as $index => $month) {
                        $arrayObjective2Summary[$program->id]['totals'][$month]['men'] = 0;
                        $arrayObjective2Summary[$program->id]['totals'][$month]['women'] = 0;
                    }
                }

                foreach ($poaActivities as $activity) {
                    $indicatorUnit = $activity->measure->unit;
                    $arrayObjective2Summary[$program->id][$activity->id]['id'] = $activity->id;
                    $arrayObjective2Summary[$program->id][$activity->id]['activityName'] = $activity->name;
                    $arrayObjective2Summary[$program->id][$activity->id]['indicatorUnit'] = trim($indicatorUnit->abbreviation);
                    $arrayObjective2Summary[$program->id][$activity->id]['activityIndicatorIcon'] = $activity->measure->unit->getIcon();
                    $arrayObjective2Summary[$program->id][$activity->id]['activityIndicatorName'] = $activity->measure->name;
                    $poaActivityIndicators = MeasureAdvances::orderBy('period_id', 'asc')
                        ->where('measurable_type', PoaActivity::class)
                        ->where('measurable_id', $activity->id)
                        ->get();
                    $month = 1;
                    $sumPlanned = 0;
                    $sumProgress = 0;
                    foreach ($poaActivityIndicators as $poaActivityIndicator) {
                        $arrayObjective2Summary[$program->id][$activity->id][Indicator::FREQUENCIES[12][$month]]['planned'] = $poaActivityIndicator->goal ?? 0;
                        $arrayObjective2Summary[$program->id][$activity->id][Indicator::FREQUENCIES[12][$month]]['men'] = $poaActivityIndicator->men ?? 0;
                        $arrayObjective2Summary[$program->id][$activity->id][Indicator::FREQUENCIES[12][$month]]['women'] = $poaActivityIndicator->women ?? 0;
                        $arrayObjective2Summary[$program->id][$activity->id][Indicator::FREQUENCIES[12][$month]]['progress'] = $poaActivityIndicator->actual ?? 0;
                        $arrayObjective2Summary[$program->id]['totals'][Indicator::FREQUENCIES[12][$month]]['men'] += $poaActivityIndicator->men ?? 0;
                        $arrayObjective2Summary[$program->id]['totals'][Indicator::FREQUENCIES[12][$month]]['women'] += $poaActivityIndicator->women ?? 0;
                        $sumPlanned += $poaActivityIndicator->goal ?? 0;
                        $sumMen += $poaActivityIndicator->men ?? 0;
                        $sumWomen += $poaActivityIndicator->women ?? 0;
                        $sumProgress += $poaActivityIndicator->actual ?? 0;
                        $month++;
                    }
                    $arrayObjective2Summary[$program->id][$activity->id]['sum_planned'] = $sumPlanned;
                    $arrayObjective2Summary[$program->id][$activity->id]['sum_progress'] = $sumProgress;
                    $progress = 0;
                    if ($sumPlanned > 0) {
                        if ($sumProgress > $sumPlanned) {
                            $progress = 100;
                        } else {
                            $progress = $sumProgress / $sumPlanned * 100;
                        }
                    }
                    $progressTotal = $this->calcProgresThreshold($poa, $progress);
                    $arrayObjective2Summary[$program->id][$activity->id]['progress'] = $progressTotal;
                }
            }

            $arrayPoas[$poa->id] = [];
            $arrayPoas[$poa->id]['sum_men'] = $sumMen;
            $arrayPoas[$poa->id]['sum_women'] = $sumWomen;
            $arrayPoas[$poa->id]['company'] = $poa->company->name . ' - ' . $poa->year;
            $arrayPoas[$poa->id]['data'] = $arrayObjective2Summary;
        }

        return $arrayPoas;
    }

    public function assignMonths($index)
    {
        $arrayObjective2Summary = [];

        foreach (Indicator::FREQUENCIES[12] as $ind => $month) {
            $arrayObjective2Summary[$index][$month]['planned'] = 0;
            $arrayObjective2Summary[$index][$month]['men'] = 0;
            $arrayObjective2Summary[$index][$month]['women'] = 0;
            $arrayObjective2Summary[$index][$month]['progress'] = 0;
        }
        $arrayObjective2Summary[$index]['sum_planned'] = 0;
        $arrayObjective2Summary[$index]['sum_men'] = 0;
        $arrayObjective2Summary[$index]['sum_women'] = 0;
        $arrayObjective2Summary[$index]['sum_progress'] = 0;
        $arrayObjective2Summary[$index]['progress'] = 0;

        return $arrayObjective2Summary;
    }

    private function generateGoalPoaReportTotalByIndicator($poas)
    {
        $arrayTotalProvince = [];
        $arrayObjective2Summary = [];
        $sumMen = 0;
        $sumWomen = 0;
        foreach ($poas as $poa) {
            $poaPrograms = PoaProgram::where('poa_id', $poa->id)
                ->when(count($this->selectedPrograms) > 0, function ($q) {
                    return $q->whereIn('plan_detail_id', $this->selectedPrograms);
                })->get();
            foreach ($poaPrograms as $program) {
                $poaActivitiesByMeasure = PoaActivity::where('poa_program_id', $program->id)
                    ->get()->groupBy('measure_id');
                $firstGroup = $poaActivitiesByMeasure->first();
                if ($firstGroup) {
                    foreach (Indicator::FREQUENCIES[12] as $index => $month) {
                        $arrayObjective2Summary[$program->plan_detail_id]['totals'][$month]['men'] = 0;
                        $arrayObjective2Summary[$program->plan_detail_id]['totals'][$month]['women'] = 0;
                    }
                }
                foreach ($poaActivitiesByMeasure as $index => $units) {
                    foreach ($units as $activity) {
                        $arrayObjective2Summary[$program->plan_detail_id]['programName'] = $activity->planDetail->name;
                        $arrayObjective2Summary[$program->plan_detail_id]['specificGoal'] = $activity->planDetail->parent->name;
                        $poaActivityIndicators = MeasureAdvances::orderBy('period_id', 'asc')
                            ->where('measurable_type', PoaActivity::class)
                            ->where('measurable_id', $activity->id)
                            ->get();
                        $month = 1;
                        $sumPlanned = 0;
                        $sumProgress = 0;
                        $arrayObjective2Summary[$program->plan_detail_id] += self::assignMonths($index);
                        foreach ($poaActivityIndicators as $poaActivityIndicator) {
                            $arrayObjective2Summary[$program->plan_detail_id][$index][Indicator::FREQUENCIES[12][$month]]['planned'] += $poaActivityIndicator->goal ?? 0;
                            $arrayObjective2Summary[$program->plan_detail_id][$index][Indicator::FREQUENCIES[12][$month]]['men'] += $poaActivityIndicator->men ?? 0;
                            $arrayObjective2Summary[$program->plan_detail_id][$index][Indicator::FREQUENCIES[12][$month]]['women'] += $poaActivityIndicator->women ?? 0;
                            $arrayObjective2Summary[$program->plan_detail_id][$index][Indicator::FREQUENCIES[12][$month]]['progress'] += $poaActivityIndicator->actual ?? 0;
                            $arrayObjective2Summary[$program->plan_detail_id]['totals'][Indicator::FREQUENCIES[12][$month]]['men'] += $poaActivityIndicator->men ?? 0;
                            $arrayObjective2Summary[$program->plan_detail_id]['totals'][Indicator::FREQUENCIES[12][$month]]['women'] += $poaActivityIndicator->women ?? 0;
                            $sumPlanned += $poaActivityIndicator->goal ?? 0;
                            $sumProgress += $poaActivityIndicator->actual ?? 0;
                            $sumMen += $poaActivityIndicator->men ?? 0;
                            $sumWomen += $poaActivityIndicator->women ?? 0;
                            $month++;
                        }
                        $arrayObjective2Summary[$program->plan_detail_id][$index]['sum_planned'] += $sumPlanned;
                        $arrayObjective2Summary[$program->plan_detail_id][$index]['sum_progress'] += $sumProgress;
                        $arrayObjective2Summary[$program->plan_detail_id][$index]['activityIndicatorIcon'] = $activity->measure->unit->getIcon();
                        $arrayObjective2Summary[$program->plan_detail_id][$index]['activityIndicatorName'] = $activity->measure->name;
                        $progress = 0;
                        if ($sumPlanned > 0) {
                            if ($sumProgress > $sumPlanned) {
                                $progress = 100;
                            } else {
                                $progress = $sumProgress / $sumPlanned * 100;
                            }
                        }
                        $progressTotal = $this->calcProgresThreshold($poa, $progress);
                        $arrayObjective2Summary[$program->plan_detail_id][$index]['progress'] = $progressTotal;
                    }
                }
            }
            $arrayTotalProvince[$poa->year] = [];
            $arrayTotalProvince[$poa->year]['company'] = 'Reporte Total por Indicador- ' . $poa->year;
            $arrayTotalProvince[$poa->year]['sum_men'] = $sumMen;
            $arrayTotalProvince[$poa->year]['sum_women'] = $sumWomen;
            $arrayTotalProvince[$poa->year]['data'] = $arrayObjective2Summary;
        }
        return $arrayTotalProvince;
    }

    public function loadPrograms()
    {
        $plans = Plan::with(['planDetails'])
            ->where('plan_type', PlanTemplate::PLAN_STRATEGY_CRE)
            ->where('status', Plan::ACTIVE)->first();
        $planDetails = $plans->planDetails;
        $programTemplateId = PlanRegisteredTemplateDetails::where('program', true)
            ->where('plan_id', $plans->id)
            ->first();
        $this->programs = $planDetails->where('plan_registered_template_detail_id', $programTemplateId->id);
    }

    public function calcProgresThreshold($poa, $progress = 0)
    {
        $progress = number_format($progress, 2);
        if ($progress <= $poa->min) {
            return '<span class="badge badge-danger badge-pill">' . $progress . '% </span>';
        } else if ($progress >= $poa->max) {
            return '<span class="badge badge-success badge-pill">' . $progress . '% </span>';
        } else {
            return '<span class="badge badge-warning badge-pill">' . $progress . '% </span>';
        }
    }
}
