<?php

namespace App\Http\Livewire\Poa\Reports;

use App\Exports\DefaultHeaderReportExport;
use App\Models\Indicators\Units\IndicatorUnits;
use App\Models\Measure\MeasureAdvances;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaActivity;
use App\Models\Poa\PoaProgram;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use App\Scopes\Company;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use function view;

class PoaReportByObjectives extends Component
{
    public $indicatorUnit = '';
    public $indicatorUnits;
    public $selectUnits = 1;
    public $selectYears;
    public $poaSelected;
    public $data;
    public $cantons;
    public $provinces;
    public $selectProvinces;
    public $selectCantons = [];
    public $years = [];

    public $poas;
    public $plan;
    public $year;
    public $poaPrograms;
    public $poaActivities;
    public $planDetails;
    public $dataReportObjectives = [];
    public $dataReportObjectivesTotal = [];
    public $dataReportObjectivesSpecific = [];
    public $dataReportObjectivesTotalSpecific = [];
    public $measureAdvances;
    public $poaFinded = false;


    public function mount()
    {
        $this->indicatorUnits = IndicatorUnits::get();
        $this->cantons = \App\Models\Admin\Company::where('level', 3)
            ->get();
        $this->provinces = \App\Models\Admin\Company::where('level', 2)->get();
        $this->plan = Plan::with(['planDetails'])->type(Plan::TYPE_STRATEGY)->active()->first();
        $this->selectYears = now()->year;
        $this->planDetails = $this->plan->planDetails;
        for ($i = 1; $i <= 5; $i++) {
            $year = 2020 + $i;
            array_push($this->years, $year);
        }
    }

    public function render()
    {
        $this->getPoaSession();
        $this->data = self::getData();
        $this->poaPrograms = $this->data['poaPrograms'];
        $this->poaActivities = $this->data['poaActivities'];
        $this->measureAdvances = $this->data['measureAdvances'];
        $dataReportByObjectives = self::reportByObjectives();
        $this->dataReportObjectives = $dataReportByObjectives['dataForReportByObjectives'];
        $this->dataReportObjectivesSpecific = $dataReportByObjectives['dataForReportByObjectivesSpecifics'];
        $this->dataReportObjectivesTotalSpecific = $dataReportByObjectives['totalProvinceSpecific'];
        $this->dataReportObjectivesTotal = $dataReportByObjectives['totalProvince'];
        if ($this->poaFinded == false && $this->selectProvinces != null) {
            flash('No se encontraron resultados. Se muestra información de la sede actual')->warning()->livewire($this);
        }
        return view('livewire.poa.reports.poa-report-by-objectives');
    }


    /**
     * @return array
     * Para calcular el avance por objetivos se sigue el sig algoritmo
     * 1. se obtiene todos los programas de todos los poas
     * 2. se obtiene todos los elementos de la estrategia al cual pertenece cada programa
     * 3. Se obtiene el elemento (planDetail) de primer nivel de todos los programas para sbaer cualees y cuantos sob los objetivos de priemr nivel
     * 4. se seapara los programas en grupos por cada objetivo de primer nivel encontrado
     * 5. se encuentra las actividades por cada grupo previamente encontrado
     * 6. se encuentra el progreso de todas estas actividades accediendo a sus avances y metas de todas las actividades de este grupo
     * 7. se guarda en el array con el formato necesario para el chart.
     */
    public function reportByObjectives()
    {
        $poas = $this->poaSelected;
        $objectives = [];
        $objectivesSpecifics = [];
        $groupByObjective = [];
        /*
       * Funcion foreach sirve sumar los avances por objetivo nivel 1 que se encuentra dinamicamente
       * */
        foreach ($poas as $poa) {
            $groupByObjective = [];
            $groupByObjectiveSpecific = [];
            $parentPrograms = [];
            $parentProgramsSpecificObjectives = [];
            $programs = $this->poaPrograms->where('poa_id', $poa->id);
            $goalTotal = 0;
            $actualTotal = 0;
            $goalTotalSpecific = 0;
            $actualTotalSpecific = 0;
            foreach ($programs as $program) {
                $planDetail = $program->planDetail;
                $planDetailSpecific = $program->planDetail->parent;
                while ($planDetail->parent) {
                    $planDetail = $planDetail->parent;
                }
                $element = [];
                $element['objective_id'] = $planDetail->id;
                $element['level'] = $planDetail->level;
                $element['program_id'] = $program->id;
                $element2 = [];
                $element2['objective_id'] = $planDetailSpecific->id;
                $element2['level'] = $planDetailSpecific->level;
                $element2['program_id'] = $program->id;
                array_push($parentProgramsSpecificObjectives, $element2);

                array_push($parentPrograms, $element);
            }
            foreach ($parentPrograms as $item) {
                $key = $item['objective_id'];
                $programId = $item['program_id'];
                $groupByObjective[$key][$programId] = array(
                    'program_id' => $programId,
                );
            }

            foreach ($parentProgramsSpecificObjectives as $item) {
                $key = $item['objective_id'];
                $programId = $item['program_id'];
                $groupByObjectiveSpecific[$key][$programId] = array(
                    'program_id' => $programId,
                );
            }

            foreach ($groupByObjective as $index => $objective) {
                $goal = 0;
                $actual = 0;
                $programs = $this->poaPrograms->whereIn('id', array_keys($groupByObjective[$index]));
                $poaActivities = $this->poaActivities->where('indicator_unit_id', $this->selectUnits)
                    ->whereIn('poa_program_id', $programs->pluck('id'));
                $progress = 0;
                $goal = $this->measureAdvances->whereIn('measurable_id', $poaActivities->pluck('id'))->sum('goal') ?? 0;
                $actual = $this->measureAdvances->whereIn('measurable_id', $poaActivities->pluck('id'))->sum('actual') ?? 0;
                $goalTotal += $goal;
                $actualTotal += $actual;
                if ($goal > 0) {
                    if ($actual > $goal) {
                        $progress = 100;
                    } else {
                        $progress = $actual / $goal * 100;
                    }
                }
                $progress = $this->calcProgresThreshold($poa, $progress);
                $nameObjective = $this->planDetails->find($index)->name;
                $objectives[$poa->year][$poa->id][$nameObjective] = [];
                $objectives[$poa->year][$poa->id][$nameObjective]['goal'] = $goal;
                $objectives[$poa->year][$poa->id][$nameObjective]['actual'] = $actual;
                $objectives[$poa->year][$poa->id][$nameObjective]['progress'] = $progress;
            }

            foreach ($groupByObjectiveSpecific as $index2 => $objective) {
                $goal = 0;
                $actual = 0;
                $programs = $this->poaPrograms->whereIn('id', array_keys($groupByObjectiveSpecific[$index2]));
                $poaActivities = $this->poaActivities->where('indicator_unit_id', $this->selectUnits)
                    ->whereIn('poa_program_id', $programs->pluck('id'));
                $progress = 0;
                $goal = $this->measureAdvances->whereIn('measurable_id', $poaActivities->pluck('id'))->sum('goal') ?? 0;
                $actual = $this->measureAdvances->whereIn('measurable_id', $poaActivities->pluck('id'))->sum('actual') ?? 0;
                $goalTotalSpecific += $goal;
                $actualTotalSpecific += $actual;
                if ($goal > 0) {
                    if ($actual > $goal) {
                        $progress = 100;
                    } else {
                        $progress = $actual / $goal * 100;
                    }
                }
                $progress = $this->calcProgresThreshold($poa, $progress);
                $nameObjective = $this->planDetails->find($index2)->name;
                $objectivesSpecifics[$poa->year][$poa->id][$nameObjective] = [];
                $objectivesSpecifics[$poa->year][$poa->id][$nameObjective]['goal'] = $goal;
                $objectivesSpecifics[$poa->year][$poa->id][$nameObjective]['actual'] = $actual;
                $objectivesSpecifics[$poa->year][$poa->id][$nameObjective]['progress'] = $progress;
            }

            $totalProgress = 0;
            $totalProgressSpecific = 0;
            if ($goalTotal > 0) {
                $totalProgress = $actualTotal / $goalTotal * 100;
            }
            $totalProgress = $this->calcProgresThreshold($poa, $totalProgress);

            if ($goalTotalSpecific > 0) {
                $totalProgressSpecific = $actualTotalSpecific / $goalTotalSpecific * 100;
            }
            $totalProgressSpecific = $this->calcProgresThreshold($poa, $totalProgressSpecific);

            $objectives[$poa->year][$poa->id]['Total']['goal'] = $goalTotal;
            $objectives[$poa->year][$poa->id]['Total']['actual'] = $actualTotal;
            $objectives[$poa->year][$poa->id]['Total']['progress'] = $totalProgress;

            $objectivesSpecifics[$poa->year][$poa->id]['Total']['goal'] = $goalTotalSpecific;
            $objectivesSpecifics[$poa->year][$poa->id]['Total']['actual'] = $actualTotalSpecific;
            $objectivesSpecifics[$poa->year][$poa->id]['Total']['progress'] = $totalProgressSpecific;
        }

        /*
         * Funcion foreach sirve para sumar los avances por programa de cada ano de los poas seleccionados
         * */
        $totalProvince = [];
        $totalProvinceSpecific = [];
        if ($this->selectProvinces != null && $this->poaFinded == true) {
            foreach ($objectives as $indexYear => $year) {
                foreach ($year as $objs) {
                    foreach ($objs as $nameObjective => $obj) {
                        if (isset($totalProvince[$indexYear][$nameObjective])) {
                            $totalProvince[$indexYear][$nameObjective]['goal'] += $obj['goal'];
                            $totalProvince[$indexYear][$nameObjective]['actual'] += $obj['actual'];
                            $progressTotal = $totalProvince[$indexYear][$nameObjective]['goal'] > 0 ? ($totalProvince[$indexYear][$nameObjective]['actual'] / $totalProvince[$indexYear][$nameObjective]['goal']) * 100 : 0;
                            $progressTotal = $this->calcProgresThreshold($poa, $progressTotal);
                            $totalProvince[$indexYear][$nameObjective]['progress'] = $progressTotal;
                        } else {
                            $totalProvince[$indexYear][$nameObjective] = [];
                            $totalProvince[$indexYear][$nameObjective]['goal'] = $obj['goal'];
                            $totalProvince[$indexYear][$nameObjective]['actual'] = $obj['actual'];
                            if ($totalProvince[$indexYear][$nameObjective]['goal'] > 0) {
                                if ($totalProvince[$indexYear][$nameObjective]['actual'] > $totalProvince[$indexYear][$nameObjective]['goal']) {
                                    $progressTotal = 100;
                                } else {
                                    $progressTotal = $totalProvince[$indexYear][$nameObjective]['actual'] / $totalProvince[$indexYear][$nameObjective]['goal'] * 100;
                                }
                            } else {
                                $progressTotal = 0;
                            }
                            $progressTotal = $this->calcProgresThreshold($poa, $progressTotal);
                            $totalProvince[$indexYear][$nameObjective]['progress'] = $progressTotal;
                        }
                    }
                }
            }
            foreach ($objectivesSpecifics as $indexYear => $year) {
                foreach ($year as $objs) {
                    foreach ($objs as $nameObjective => $obj) {
                        if (isset($totalProvinceSpecific[$indexYear][$nameObjective])) {
                            $totalProvinceSpecific[$indexYear][$nameObjective]['goal'] += $obj['goal'];
                            $totalProvinceSpecific[$indexYear][$nameObjective]['actual'] += $obj['actual'];
                            $progressTotalSpecific = $totalProvinceSpecific[$indexYear][$nameObjective]['goal'] > 0 ?
                                $totalProvinceSpecific[$indexYear][$nameObjective]['actual'] / $totalProvinceSpecific[$indexYear][$nameObjective]['goal'] * 100 : 0;
                            $progressTotalSpecific = $this->calcProgresThreshold($poa, $progressTotalSpecific);
                            $totalProvinceSpecific[$indexYear][$nameObjective]['progress'] = $progressTotalSpecific;
                        } else {
                            $totalProvinceSpecific[$indexYear][$nameObjective] = [];
                            $totalProvinceSpecific[$indexYear][$nameObjective]['goal'] = $obj['goal'];
                            $totalProvinceSpecific[$indexYear][$nameObjective]['actual'] = $obj['actual'];
                            if ($totalProvinceSpecific[$indexYear][$nameObjective]['goal'] > 0) {
                                if ($totalProvinceSpecific[$indexYear][$nameObjective]['actual'] > $totalProvinceSpecific[$indexYear][$nameObjective]['goal']) {
                                    $progressTotalSpecific = 100;
                                } else {
                                    $progressTotalSpecific = $totalProvinceSpecific[$indexYear][$nameObjective]['actual'] / $totalProvinceSpecific[$indexYear][$nameObjective]['goal'];
                                }
                            } else {
                                $progressTotalSpecific = 0;
                            }
                            $progressTotalSpecific = $this->calcProgresThreshold($poa, $progressTotalSpecific);
                            $totalProvinceSpecific[$indexYear][$nameObjective]['progress'] = $progressTotalSpecific;
                        }
                    }
                }
            }
        }

        return [
            'totalProvince' => $totalProvince,
            'totalProvinceSpecific' => $totalProvinceSpecific,
            'dataForReportByObjectives' => $objectives,
            'dataForReportByObjectivesSpecifics' => $objectivesSpecifics,
            'groupByObjectives' => $groupByObjective,
        ];
    }

    public function getPoaSession()
    {
        $this->poaSelected = Poa::withoutGlobalScope(Company::class)
            ->when($this->selectYears != null, function ($q) {
                return $q->where('year', $this->selectYears);
            })->when(count($this->selectCantons) > 0, function ($q) {
                $this->poaFinded = true;
                return $q->whereIn('company_id', $this->selectCantons);
            }, function ($q) {
                $this->poaFinded = false;
                return $q->where('company_id', session('company_id'));
            })->get();
    }

    /**
     * @return array
     * Permite cargar toda la data necesaria para las oepraciones de filtros por POA
     * Carga los programas de los poa seleccionados
     * carga las actividades de cada programa
     * carga los measureAdvances de cada poaActivities
     */
    public function getData()
    {
        $poas = $this->poaSelected;
        $poaPrograms = PoaProgram::with(
            [
                'poaActivities.measureAdvances',
                'planDetail.parent',
                'planDetail.children'
            ])->whereIn('poa_id', $this->poaSelected->pluck('id'))
            ->get();
        $poaActivities = $poaPrograms->pluck('poaActivities')->collapse();
        $measureAdvances=MeasureAdvances::where('measurable_type', PoaActivity::class)
            ->whereIn('measurable_id',$poaActivities->pluck('id')->toArray())->get();
//        $measureAdvances = $poaActivities->pluck('measureAdvances')->collapse();

        return [
            'poas' => $poas,
            'poaPrograms' => $poaPrograms,
            'poaActivities' => $poaActivities,
            'measureAdvances' => $measureAdvances
        ];
    }

    public function cleanFilters()
    {
        $this->reset(
            [
                'selectUnits',
                'selectYears',
                'selectCantons',
                'selectProvinces',
                'years',
            ]);
        self::mount();
    }

    public function updatedSelectProvinces()
    {
        $this->reset(['selectCantons', 'dataReportObjectivesTotal', 'poaSelected']);
        $this->cantons = \App\Models\Admin\Company::where('level', 3)
            ->when($this->selectProvinces != null, function ($q) {
                return $q->where('parent_id', $this->selectProvinces);
            })->get();
        $this->selectCantons = $this->cantons->pluck('id');
    }


    public function exportExcel()
    {
        $view = view('modules.poa.reports.objectives.excel')
            ->with('dataReportObjectives', $this->dataReportObjectives)
            ->with('dataReportObjectivesSpecific', $this->dataReportObjectivesSpecific)
            ->with('dataReportObjectivesTotalSpecific', $this->dataReportObjectivesTotalSpecific)
            ->with('dataReportObjectivesTotal', $this->dataReportObjectivesTotal)
            ->with('poaFinded', $this->poaFinded)
            ->with('selectProvinces', $this->selectProvinces)
            ->with('poaSelected', $this->poaSelected)
            ->with('selectYears', $this->selectYears);
        $response = Excel::download(new DefaultHeaderReportExport($view, trans('poa.reached_people')), trans('poa.reached_people') . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        return $response;
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
