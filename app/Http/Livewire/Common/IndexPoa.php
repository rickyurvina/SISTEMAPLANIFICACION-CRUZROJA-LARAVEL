<?php

namespace App\Http\Livewire\Common;

use App\Models\Admin\Company;
use App\Models\Indicators\Units\IndicatorUnits;
use App\Models\Measure\MeasureAdvances;
use App\Models\Poa\PoaActivity;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use App\Models\Strategy\PlanTemplate;
use Barryvdh\Snappy\Facades\SnappyPdf as PDFSnappy;
use Illuminate\Support\Collection;
use Livewire\Component;

class IndexPoa extends Component
{
    public $ejecuccionGeneral, $sumMujeresAlcanzadas, $sumHombresAlcanzadas, $totalMujeres, $totalHombres,
        $sumMujeresCapacitadas, $sumHombresCapacitadas, $totalMujeresCapacitados, $totalHombresCapacitados,
        $calificacionServicio, $plan, $test = true, $background_colors, $totalGoal, $totalGoalCapacitadas
    , $provinceSelected, $selectedPeriod = null, $selectedProvince = null, $selectedCanton = null, $selectedProgram = null,
        $programsGrouped, $idProgramsSelected, $nameProvince;

    public $selectedMonth = null;

    public array $ejectuadoJuntasArr = [];

    public array $listOfProvinces = [];

    public Collection $listOfCantones;

    public array $objectives = [];

    public array $groups = [];

    public array $groups2 = [];

    public array $groups3 = [];

    public array $groups4 = [];

    public array $idsPrograms = [];

    public array $filter = [];

    public array $filtersSelected = [];

    public array $array = [];

    public array $months = [];

    public IndicatorUnits $indicatorSourcePeopleReach, $indicatorSourcePeopleCapacitaion, $indicatorSourcePeopleEvaluation, $indicatorSourcePeopleDocuments;

    public Collection $provinces, $cantones;

    public PoaActivity $poaActivities;

    public Company $companies;

    public PoaActivityIndicator $poaActivitiesIndicator;

    public PlanDetail $planDetail;

    public PlanTemplate $planTemplate;

    public function mount()//VERIFICAR CREO QUE ESTA FUNCION YA NO SE USA SE DEBERIRA BORRAR
    {
        $indicatorUnits = new IndicatorUnits;
        $this->poaActivities = new PoaActivity;
        $this->companies = new Company;
        $this->poaActivitiesIndicator = new MeasureAdvances;
        $this->planDetail = new PlanDetail;
        $this->planTemplate = new PlanTemplate;
        $this->background_colors = array('#D52B1E', '#0046AD', '#2D2926', '#848484', '#000');
        $this->months = [1 => "ene", 2 => "feb", 3 => "mar", 4 => "abr$indicatorUnits", 5 => "may", 6 => "jun", 7 => "jul", 8 => "ago", 9 => "sep", 10 => "oct", 11 => "nov", 12 => "dic"];

        //**********************Obtiene las unidades de medidas necesarias****************************************/
        $this->indicatorSourcePeopleReach = $indicatorUnits->getUnits()[0];
        $this->indicatorSourcePeopleCapacitaion = $indicatorUnits->getUnits()[1];
        $this->indicatorSourcePeopleEvaluation = $indicatorUnits->getUnits()[2];
        $this->indicatorSourcePeopleDocuments = $indicatorUnits->getUnits()[3];
        /******************************************************************************************************************/

        //**********************Obtiene la ejecuccion general de CRE****************************************/
        $this->ejecuccionGeneral = $this->poaActivities->generalExecution();
        /******************************************************************************************************************/

        //**********************Obtiene la ejecuccion por cantones****************************************/
        $this->array = $this->companies->getExecutionCompanies($this->background_colors);
        $this->ejectuadoJuntasArr = $this->array['ejectuadoJuntasArr'];
        $this->listOfProvinces = $this->array['listOfProvinces'];
        /******************************************************************************************************************/

        //**********************Obtiene la misition vision y objetivos del plan****************************************/

        if (!is_null($this->planTemplate->withoutGlobalScope(\App\Scopes\Company::class)->where('plan_type', PlanTemplate::PLAN_STRATEGY_CRE)->first())) {
            $planTemplatesTypeStrategy = $this->planTemplate->withoutGlobalScope(\App\Scopes\Company::class)->where('plan_type', PlanTemplate::PLAN_STRATEGY_CRE)->first();
            $this->plan = Plan::where('plan_template_id', $planTemplatesTypeStrategy->id)->first();
        }

        /***********************************************************/

        //**********************Obtiene hombres y mujeres alcanzadas****************************************/
        $activities = $this->poaActivities->getActivitiesPeopleReached($this->indicatorSourcePeopleReach->id);
        $this->totalHombres = $this->poaActivitiesIndicator->getTotalHommbresAlcanzados($activities);
        $this->totalMujeres = $this->poaActivitiesIndicator->getTotalMujeresAlcanzadas($activities);
        $this->sumHombresAlcanzadas = $this->totalHombres;
        $this->sumMujeresAlcanzadas = $this->totalMujeres;
        $this->totalGoal = $this->poaActivitiesIndicator->getGoalMenWomen($activities);
        if ($this->totalGoal > 0) {
            $this->totalHombres = number_format($this->totalHombres / $this->totalGoal * 100, 1);
            $this->totalMujeres = number_format($this->totalMujeres / $this->totalGoal * 100, 1);
        }
        /******************************************************************************************************************/

        //**********************Obtiene hombres y mujeres capacitadas****************************************/
        $activities = $this->poaActivities->getActivitiesPeopleReached($this->indicatorSourcePeopleCapacitaion->id);
        $this->totalHombresCapacitados = $this->poaActivitiesIndicator->getTotalHommbresAlcanzados($activities);
        $this->totalMujeresCapacitados = $this->poaActivitiesIndicator->getTotalMujeresAlcanzadas($activities);
        $this->sumHombresCapacitadas = $this->totalHombresCapacitados;
        $this->sumMujeresCapacitadas = $this->totalMujeresCapacitados;
        $this->totalGoalCapacitadas = $this->poaActivitiesIndicator->getGoalMenWomen($activities);
        if ($this->totalGoalCapacitadas > 0) {
            $this->totalHombresCapacitados = number_format($this->totalHombresCapacitados / $this->totalGoalCapacitadas * 100, 1);
            $this->totalMujeresCapacitados = number_format($this->totalMujeresCapacitados / $this->totalGoalCapacitadas * 100, 1);
        }
        /******************************************************************************************************************/

        /***********************************************************/
        $this->idsPrograms = $this->planDetail->getPrograms()['idsPrograms'];
        $this->programsGrouped = $this->planDetail->getPrograms()['programsGrouped'];

        /************************Obtento el numero de personas alcanzas por programa******************/
        $this->groups = $this->poaActivities->getNumeroPersonasAlcanzadasPograma($this->idsPrograms, $this->indicatorSourcePeopleReach->id);
        /***************************************************************************************************************/

        /***********************************Personas humanitario capacitado*******************************************/
        $this->groups2 = $this->poaActivities->getNumeroPersonasAlcanzadasPograma($this->idsPrograms, $this->indicatorSourcePeopleCapacitaion->id);
        /******************************************************************************************************************/

        /***********************************Evaluacion de servicios*******************************************/
        $this->groups3 = $this->poaActivities->getNumeroPersonasAlcanzadasPograma($this->idsPrograms, $this->indicatorSourcePeopleEvaluation->id);
        $goal = 0;
        $progress = 0;
        $this->calificacionServicio = 0;
        foreach ($this->groups3 as $g) {
            $goal += $g['goal'];
            $progress += $g['advance'];
        }
        if ($goal > 0) {
            $this->calificacionServicio = number_format($progress / $goal * 100, 1);
        }
        /******************************************************************************************************************/

        /***********************************Productos por Area*******************************************/
        $this->groups4 = $this->poaActivities->getNumeroPersonasAlcanzadasPograma($this->idsPrograms, $this->indicatorSourcePeopleDocuments->id);

        /******************************************************************************************************************/
    }

    public function updatedselectedProvince()
    {
        $this->listOfCantones = $this->companies->getCantones($this->selectedProvince);
    }

    public function cleanFilter($type)
    {
        switch ($type) {
            case 'month':
                $this->selectedMonth = null;
                break;
            case 'period':
                $this->selectedPeriod = null;
                break;
            case 'canton':
                $this->selectedCanton = null;
                break;
            case 'province':
                $this->selectedProvince = null;
                $this->selectedCanton = null;
                break;
            case 'program':
                $this->selectedProgram = null;
                break;
        }
        $this->filter();
    }

    public function filter()
    {

        /*Calculo de la ejecuccion general de todas las juntas para la PANTALLA EN GENERAL **/
        $this->idProgramsSelected = $this->planDetail->getIdsPrograms($this->selectedProgram);

        $this->filter =
            [
                'time' => $this->selectedPeriod != null ? $this->selectedPeriod ?? null : $this->selectedMonth ?? null,
                'province' => $this->selectedProvince,
                'canton' => $this->selectedCanton,
                'program' => count($this->idProgramsSelected) > 0 ? $this->idProgramsSelected : null,
            ];
        $this->ejecuccionGeneral = $this->poaActivities->generalExecution($this->filter);
        //**********************Obtiene la ejecuccion por cantones****************************************/
        $array = $this->companies->getExecutionCompanies($this->background_colors, $this->filter);
        $this->ejectuadoJuntasArr = $array['ejectuadoJuntasArr'];
        $this->listOfProvinces = $array['listOfProvinces'];
        /******************************************************************************************************************/

        //**********************Obtiene hombres y mujeres alcanzadas****************************************/
        $activities = $this->poaActivities->getActivitiesPeopleReached($this->indicatorSourcePeopleReach->id, $this->filter);
        $this->totalHombres = $this->poaActivitiesIndicator->getTotalHommbresAlcanzados($activities, $this->filter['time']);
        $this->totalMujeres = $this->poaActivitiesIndicator->getTotalMujeresAlcanzadas($activities, $this->filter['time']);
        $this->sumHombresAlcanzadas = $this->totalHombres;
        $this->sumMujeresAlcanzadas = $this->totalMujeres;
        if ($this->totalGoal > 0) {
            $this->totalHombres = number_format($this->totalHombres / $this->totalGoal * 100, 1);
            $this->totalMujeres = number_format($this->totalMujeres / $this->totalGoal * 100, 1);
        }
        /******************************************************************************************************************/

        //**********************Obtiene hombres y mujeres capacitadas****************************************/
        $activities = $this->poaActivities->getActivitiesPeopleReached($this->indicatorSourcePeopleCapacitaion->id, $this->filter);
        $this->totalHombresCapacitados = $this->poaActivitiesIndicator->getTotalHommbresAlcanzados($activities, $this->filter['time']);
        $this->totalMujeresCapacitados = $this->poaActivitiesIndicator->getTotalMujeresAlcanzadas($activities, $this->filter['time']);
        $this->sumHombresCapacitadas = $this->totalHombresCapacitados;
        $this->sumMujeresCapacitadas = $this->totalMujeresCapacitados;
        if ($this->totalGoalCapacitadas > 0) {
            $this->totalHombresCapacitados = number_format($this->totalHombresCapacitados / $this->totalGoalCapacitadas * 100, 1);
            $this->totalMujeresCapacitados = number_format($this->totalMujeresCapacitados / $this->totalGoalCapacitadas * 100, 1);
        }
        /******************************************************************************************************************/

        /************************Obtento el numero de personas alcanzas por programa******************/
        $this->groups = $this->poaActivities->getNumeroPersonasAlcanzadasPograma($this->idsPrograms, $this->indicatorSourcePeopleReach->id, $this->filter);
        /***************************************************************************************************************/

        /***********************************Personas humanitario capacitado*******************************************/
        $this->groups2 = $this->poaActivities->getNumeroPersonasAlcanzadasPograma($this->idsPrograms, $this->indicatorSourcePeopleCapacitaion->id, $this->filter);
        /******************************************************************************************************************/

        /***********************************Evaluacion de servicios*******************************************/
        $this->groups3 = $this->poaActivities->getNumeroPersonasAlcanzadasPograma($this->idsPrograms, $this->indicatorSourcePeopleEvaluation->id, $this->filter);
        $goal = 0;
        $progress = 0;
        $this->calificacionServicio = 0;
        foreach ($this->groups3 as $g) {
            $goal += $g['goal'];
            $progress += $g['advance'];
        }
        if ($goal > 0) {
            $this->calificacionServicio = number_format($progress / $goal * 100, 1);
        }
        /******************************************************************************************************************/

        /***********************************Productos por Area*******************************************/
        $this->groups4 = $this->poaActivities->getNumeroPersonasAlcanzadasPograma($this->idsPrograms, $this->indicatorSourcePeopleDocuments->id, $this->filter);

        /******************************************************************************************************************/
        $this->test = false;
        $this->filtersSelected = [];
        $filterPeriod = '';
        if (!is_null($this->selectedMonth)) {
            $filterTime = $this->months[$this->selectedMonth];
            $this->filtersSelected[] =
                [
                    'name' => $filterTime,
                    'type' => 'month'
                ];
        }
        if ($this->selectedPeriod == 'last-month') {
            $filterPeriod = "Último mes";
            $this->filtersSelected[] =
                [
                    'name' => $filterPeriod ?? null,
                    'type' => 'period'
                ];
        } else {
            if ($this->selectedPeriod == 'quarterly') {
                $filterPeriod = "Último trimestre";
                $this->filtersSelected[] =
                    [
                        'name' => $filterPeriod ?? null,
                        'type' => 'period'
                    ];

            } else {
                if ($this->selectedPeriod == 'semester') {
                    $filterPeriod = "Último semestre";
                    $this->filtersSelected[] =
                        [
                            'name' => $filterPeriod ?? null,
                            'type' => 'period'
                        ];
                }
            }
        }

        if ($this->selectedCanton) {
            $canton = $this->companies->where('id', $this->selectedCanton)->first()->name;
            $this->filtersSelected[] =
                [
                    'name' => $canton,
                    'type' => 'canton'
                ];
        }
        if ($this->selectedProvince) {
            $province = $this->companies->where('id', $this->selectedProvince)->first()->name;
            $this->filtersSelected[] =
                [
                    'name' => $province,
                    'type' => 'province',
                ];
        }
        if ($this->selectedProgram) {
            $this->filtersSelected[] =
                [
                    'name' => $this->selectedProgram,
                    'type' => 'program',
                ];
        }
        if (is_null($this->selectedProvince) && is_null($this->selectedPeriod) && is_null($this->selectedMonth) && is_null($this->selectedCanton) && is_null($this->selectedProgram)) {
            $this->filtersSelected = [];
        }
        $this->emit('toggleDropDownFilter');

    }

    public function exportPdf()
    {
        setlocale(LC_TIME, 'es_ES.utf8');
        $date = ucfirst(strftime('%B %Y'));
        $data = [
            'ejecucionGeneral' => $this->ejecuccionGeneral <= 100 ? $this->ejecuccionGeneral : 100,
            'ejecutadoJuntasArr' => $this->ejectuadoJuntasArr,
            'listOfProvinces' => $this->listOfProvinces,
            'totalHombres' => $this->totalHombres,
            'sumHombresAlcanzadas' => $this->sumHombresAlcanzadas,
            'sumMujeresAlcanzadas' => $this->sumMujeresAlcanzadas,
            'sumHombresCapacitadas' => $this->sumHombresCapacitadas,
            'sumMujeresCapacitadas' => $this->sumMujeresCapacitadas,
            'totalGoalCapacitadas' => $this->totalGoalCapacitadas,
            'totalMujeres' => $this->totalMujeres,
            'goalPersonasCapacitadas' => $this->totalGoal,
            'totalHombresCapacitados' => $this->totalHombresCapacitados ?? 0,
            'totalMujeresCapacitados' => $this->totalMujeresCapacitados ?? 0,
            'plan' => $this->plan,
            'groups4' => $this->groups4,
            'groups' => $this->groups,
            'groups2' => $this->groups2,
            'groups3' => $this->groups3,
            'calificacionServicio' => $this->calificacionServicio,
            'date' => $date
        ];
        $pdf = PDFSnappy::loadView('modules.strategy.reports.dashboard-poa', ['data' => $data]);
        $pdf->setOption('margin-left', 0);
        $pdf->setOption('margin-top', 0);
        $pdf->setOption('margin-right', 0);
        $pdf->setOption('dpi', 300);


        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Estrategia.pdf');
    }

    public function render()
    {
        $this->dispatchBrowserEvent('updateChartData-',
            [
                'ejecucionGeneral' => $this->ejecuccionGeneral <= 100 ? $this->ejecuccionGeneral : 100,
                'ejecutadoJuntasArr' => $this->ejectuadoJuntasArr,
                'listOfProvinces' => $this->listOfProvinces,
                'totalHombres' => $this->totalHombres,
                'totalMujeres' => $this->totalMujeres,
                'totalHombresCapacitados' => $this->totalHombresCapacitados ?? 0,
                'totalMujeresCapacitados' => $this->totalMujeresCapacitados ?? 0,
                'plan' => $this->plan,
                'objectives' => $this->objectives,
                'groups4' => $this->groups4,
                'groups' => $this->groups,
                'groups2' => $this->groups2,
                'groups3' => $this->groups3,
                'test' => $this->test,
                'selectedProvince' => $this->selectedProvince,
            ]
        );
        $this->test = true;
        $this->array = $this->companies->getExecutionCompanies($this->background_colors);
        $this->ejectuadoJuntasArr = $this->array['ejectuadoJuntasArr'];
        $this->listOfProvinces = $this->array['listOfProvinces'];
        return view('livewire.common.index-poa');
    }
}
