<?php

namespace App\Http\Livewire\Poa\Reports;

use App\Models\Admin\Company;
use App\Models\Indicators\Units\IndicatorUnits;
use App\Models\Measure\MeasureAdvances;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaProgram;
use App\Models\Strategy\Plan;
use Livewire\Component;
use function view;

class PoaReportEvaluation extends Component
{
    public $poas;
    public $plan;
    public $progressTotal;
    public $poaPrograms;
    public $poaActivities;
    public $planDetails;
    public $indicatorUnits;
    public $measureAdvances = null;
    public $data = [];
    public $dataReportObjectives = [];
    public $groupObjectives = [];
    public $dataObjective1 = [];
    public $dataObjective2 = [];
    public $unitSelected;
    public $selectYears;
    public $selectUnits = 1;
    public $unitUpdated = false;
    public $years = [];

    public function mount()
    {
        $this->selectYears = now()->year;
        $this->indicatorUnits = IndicatorUnits::get();
        $this->plan = Plan::with(['planDetails'])->type(Plan::TYPE_STRATEGY)->active()->first();
        $this->planDetails = $this->plan->planDetails;
        for ($i = 1; $i <= 5; $i++) {
            $year = 2020 + $i;
            array_push($this->years, $year);
        }
    }

    public function render()
    {
        self::getPoaSession();
        self::getData();
        self::reportByObjectives();
        self::reportByPrograms();
        $dataParticipation = $this->reportParticipation($this->selectUnits);
        $this->dispatchBrowserEvent('showChartParticipation', ['data' => $dataParticipation]);
        $this->dispatchBrowserEvent('showChartEvaluation', ['data' => $this->dataReportObjectives]);
        $this->dispatchBrowserEvent('showChartObjectives1', ['data' => $this->dataObjective1]);
        $this->dispatchBrowserEvent('showChartObjectives2', ['data' => $this->dataObjective2]);
        self::exectionTotal();
        return view('livewire.poa.reports.poa-report-evaluation', compact('dataParticipation'));
    }

    public function getPoaSession()
    {
        $this->poas = Poa::withoutGlobalScope(\App\Scopes\Company::class)
            ->when($this->selectYears != null, function ($q) {
                return $q->where('year', $this->selectYears);
            })->get();
    }

    public function exectionTotal()
    {
        $progress = 0;
        $goal = $this->measureAdvances->sum('goal');
        $actual = $this->measureAdvances->sum('actual');
        if ($goal > 0) {
            $progress = $actual / $goal;
        }
        $this->progressTotal = number_format($progress, 2) * 100;
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
        $programs = $this->poaPrograms;
        $parentPrograms = [];
        $groupByObjective = [];
        foreach ($programs as $program) {
            $planDetail = $program->planDetail;
            while ($planDetail->parent) {
                $planDetail = $planDetail->parent;
            }
            $element = [];
            $element['id'] = $planDetail->id;
            $element['level'] = $planDetail->level;
            $element['program_id'] = $program->id;
            array_push($parentPrograms, $element);
        }
        foreach ($parentPrograms as $item) {
            $key = $item['id'];
            $programId = $item['program_id'];
            $groupByObjective[$key][$programId] = array(
                'program_id' => $programId,
            );
        }

        $objectives = [];
        $count = 0;
        foreach ($groupByObjective as $index => $objective) {
            $programs = $this->poaPrograms->whereIn('id', array_keys($groupByObjective[$index]));
            $poaActivitiesGroupedByIndicator = $this->poaActivities->whereIn('poa_program_id', $programs->pluck('id'))
                ->groupBy('indicator_unit_id');
            $objectives[$count]['objective'] = $this->planDetails->find($index)->name;
            foreach ($poaActivitiesGroupedByIndicator as $unit => $poaActivities) {
                $progress = 0;
                $goal = $this->measureAdvances->whereIn('measurable_id', $poaActivities->pluck('id'))->sum('goal');
                $actual = $this->measureAdvances->whereIn('measurable_id', $poaActivities->pluck('id'))->sum('actual');
                if ($goal > 0) {
                    $progress = $actual / $goal;
                }
                $objectives[$count][$this->indicatorUnits->find($unit)->abbreviation] = floatval(number_format($progress * 100, 2));
            }
            $count++;
        }
        $this->dataReportObjectives = $objectives;
        $this->groupObjectives = $groupByObjective;
    }

    public function reportByPrograms()
    {
        $dataObjectives1 = [];
        $dataObjectives2 = [];
        $programsObjective1 = $this->poaPrograms->whereIn('id', array_keys($this->groupObjectives[1]))->groupBy('plan_detail_id');
        $programsObjective2 = $this->poaPrograms->whereIn('id', array_keys($this->groupObjectives[2]))->groupBy('plan_detail_id');
        foreach ($programsObjective1 as $index => $program) {
            $poaActivitiesByUnit = $program->pluck('poaActivities')->collapse()->groupBy('indicator_unit_id');
            $element = [];
            $element['program'] = $this->planDetails->find($index)->name;
            foreach ($poaActivitiesByUnit as $unit => $poaActivities) {
                $progress = 0;

                $goal = $poaActivities->pluck('measureAdvances')->collapse()->sum('goal');
                $actual = $poaActivities->pluck('measureAdvances')->collapse()->sum('actual');
                if ($goal > 0) {
                    $progress = $actual / $goal * 100;
                    if ($progress > 100) {
                        $progress = 100;
                    }
                }
//                $element[$this->indicatorUnits->find($unit)->abbreviation] = number_format($progress, 0);
                $element[$this->indicatorUnits->find($unit)->abbreviation] = number_format($progress, 0, '.', '');;
            }
            array_push($dataObjectives1, $element);
        }
        foreach ($programsObjective2 as $index => $program) {
            $poaActivitiesByUnit = $program->pluck('poaActivities')->collapse()->groupBy('indicator_unit_id');
            $element = [];
            $element['program'] = $this->planDetails->find($index)->name;
            foreach ($poaActivitiesByUnit as $unit => $poaActivities) {
                $progress = 0;
                $goal = $poaActivities->pluck('measureAdvances')->collapse()->sum('goal');
                $actual = $poaActivities->pluck('measureAdvances')->collapse()->sum('actual');
                if ($goal > 0) {
                    $progress = $actual / $goal * 100;
                    if ($progress > 100) {
                        $progress = 100;
                    }
                }
//                $element[$this->indicatorUnits->find($unit)->abbreviation] = number_format($progress, 0);
                $element[$this->indicatorUnits->find($unit)->abbreviation] =number_format($progress, 0, '.', '');
            }
            array_push($dataObjectives2, $element);
        }
        $this->dataObjective1 = $dataObjectives1;
        $this->dataObjective2 = $dataObjectives2;
    }

    public function reportParticipation($unit = 1)
    {
        $data = [];
        $companies = Company::where('level', 3)->get();
        foreach ($companies as $index => $company) {
            $poa = $this->poas->where('company_id', $company->id)
                ->first();
            if ($poa) {
                $infoProgressByUnit = $poa->progressByUnit($unit);
                $data[$index] =
                    [
                        'name' => $company->name,
                        'participation' => -1 * $poa->progressByUnitParticipation($companies->pluck('id'), $infoProgressByUnit['actual'], $this->selectYears, $unit),
                        'progress' => $infoProgressByUnit['progress'],
                    ];
            }
        }
        return $data;
    }

    public function cleanFilters()
    {
        $this->reset(
            [
                'selectUnits',
            ]);
        $this->selectYears = now()->year;
    }

    public function updatedSelectUnits()
    {
        $this->unitUpdated = true;
    }

    public function getData()
    {
        $this->poaPrograms = PoaProgram::with(
            [
                'poaActivities.measureAdvances',
                'planDetail.parent',
                'planDetail.children'
            ])->whereIn('poa_id', $this->poas->pluck('id'))
            ->get();
        $this->poaActivities = $this->poaPrograms->pluck('poaActivities')->collapse();

        $this->measureAdvances = MeasureAdvances::whereIn('measurable_id', $this->poaActivities->pluck('id'))
            ->where('measurable_type', \App\Models\Poa\PoaActivity::class)
            ->get();
    }
}
