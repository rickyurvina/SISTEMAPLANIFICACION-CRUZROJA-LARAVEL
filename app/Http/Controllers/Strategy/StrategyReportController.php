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
     */
    public function reportIndicators()
    {
        if (user()->cannot('strategy-crud-strategy') && user()->cannot('strategy-read-strategy')) {
            abort(403);
        }
        return view('modules.strategy.home.report_indicators');
    }

    /**
     * Display a listing of the resource.
     */
    public function reportArticulations()
    {
        if (user()->cannot('strategy-crud-strategy') && user()->cannot('strategy-read-strategy')) {
            abort(403);
        }
        return view('modules.strategy.home.report_articulations');
    }

    public function exportPdf()//TODO VERIFICAR, ENTIENDO QUE ESTA FUNCION HAY QUE CAMBIAR O BORRAR PORQUE NO SE LA USA
    {
        $indicatorUnits = new IndicatorUnits;
        $poaActivities = new PoaActivity;
        $companies = new Company;
        $poaActivitiesIndicator = new MeasureAdvances;
        $planDetail = new PlanDetail;
        $planTemplate = new PlanTemplate;
        $background_colors = array('#D52B1E', '#0046AD', '#2D2926', '#848484', '#000');
        $months = [1 => "ene", 2 => "feb", 3 => "mar", 4 => "abr", 5 => "may", 6 => "jun", 7 => "jul", 8 => "ago", 9 => "sep", 10 => "oct", 11 => "nov", 12 => "dic"];

        //**********************Obtiene las unidades de medidas necesarias****************************************/
        $indicatorSourcePeopleReach = $indicatorUnits->getUnits()[0];
        $indicatorSourcePeopleCapacitaion = $indicatorUnits->getUnits()[1];
        $indicatorSourcePeopleEvaluation = $indicatorUnits->getUnits()[2];
        $indicatorSourcePeopleDocuments = $indicatorUnits->getUnits()[3];
        /******************************************************************************************************************/

        //**********************Obtiene la ejecuccion general de CRE****************************************/
        $ejecuccionGeneral = $poaActivities->generalExecution();
        /******************************************************************************************************************/

        //**********************Obtiene la ejecuccion por cantones****************************************/
        $array = $companies->getExecutionCompanies($background_colors);
        $ejectuadoJuntasArr = $array['ejectuadoJuntasArr'];
        $listOfProvinces = $array['listOfProvinces'];
        /******************************************************************************************************************/

        //**********************Obtiene la misition vision y objetivos del plan****************************************/

        if (!is_null($planTemplate->withoutGlobalScope(\App\Scopes\Company::class)->where('plan_type', PlanTemplate::PLAN_STRATEGY_CRE)->first())) {
            $planTemplatesTypeStrategy = $planTemplate->withoutGlobalScope(\App\Scopes\Company::class)->where('plan_type', PlanTemplate::PLAN_STRATEGY_CRE)->first();
            $plan = Plan::where('plan_template_id', $planTemplatesTypeStrategy->id)->first();
        }

        /***********************************************************/

        //**********************Obtiene hombres y mujeres alcanzadas****************************************/
        $activities = $poaActivities->getActivitiesPeopleReached($indicatorSourcePeopleReach->id);
        $totalHombres = $poaActivitiesIndicator->getTotalHommbresAlcanzados($activities);
        $totalMujeres = $poaActivitiesIndicator->getTotalMujeresAlcanzadas($activities);
        $sumHombresAlcanzadas = $totalHombres;
        $sumMujeresAlcanzadas = $totalMujeres;
        $totalGoal = $poaActivitiesIndicator->getGoalMenWomen($activities);
        if ($totalGoal > 0) {
            $totalHombres = number_format($totalHombres / $totalGoal * 100, 1);
            $totalMujeres = number_format($totalMujeres / $totalGoal * 100, 1);
        }
        /******************************************************************************************************************/

        //**********************Obtiene hombres y mujeres capacitadas****************************************/
        $activities = $poaActivities->getActivitiesPeopleReached($indicatorSourcePeopleCapacitaion->id);
        $totalHombresCapacitados = $poaActivitiesIndicator->getTotalHommbresAlcanzados($activities);
        $totalMujeresCapacitados = $poaActivitiesIndicator->getTotalMujeresAlcanzadas($activities);
        $sumHombresCapacitadas = $totalHombresCapacitados;
        $sumMujeresCapacitadas = $totalMujeresCapacitados;
        $totalGoalCapacitadas = $poaActivitiesIndicator->getGoalMenWomen($activities);
        if ($totalGoalCapacitadas > 0) {
            $totalHombresCapacitados = number_format($totalHombresCapacitados / $totalGoalCapacitadas * 100, 1);
            $totalMujeresCapacitados = number_format($totalMujeresCapacitados / $totalGoalCapacitadas * 100, 1);
        }
        /******************************************************************************************************************/

        /***********************************************************/
        $idsPrograms = $planDetail->getPrograms()['idsPrograms'];
        $programsGrouped = $planDetail->getPrograms()['programsGrouped'];

        /************************Obtento el numero de personas alcanzas por programa******************/
        $groups = $poaActivities->getNumeroPersonasAlcanzadasPograma($idsPrograms, $indicatorSourcePeopleReach->id);
        /***************************************************************************************************************/

        /***********************************Personas humanitario capacitado*******************************************/
        $groups2 = $poaActivities->getNumeroPersonasAlcanzadasPograma($idsPrograms, $indicatorSourcePeopleCapacitaion->id);
        /******************************************************************************************************************/

        /***********************************Evaluacion de servicios*******************************************/
        $groups3 = $poaActivities->getNumeroPersonasAlcanzadasPograma($idsPrograms, $indicatorSourcePeopleEvaluation->id);
        $goal = 0;
        $progress = 0;
        $calificacionServicio = 0;
        foreach ($groups3 as $g) {
            $goal += $g['goal'];
            $progress += $g['advance'];
        }
        if ($goal > 0) {
            $calificacionServicio = number_format($progress / $goal * 100, 1);
        }
        /******************************************************************************************************************/

        /***********************************Productos por Area*******************************************/
        $groups4 = $poaActivities->getNumeroPersonasAlcanzadasPograma($idsPrograms, $indicatorSourcePeopleDocuments->id);

        /******************************************************************************************************************/

        setlocale(LC_TIME, 'es_ES.utf8');
        $date = ucfirst(strftime('%B %Y'));

        $data = [
            'ejecucionGeneral' => $ejecuccionGeneral <= 100 ? $ejecuccionGeneral : 100,
            'ejecutadoJuntasArr' => $ejectuadoJuntasArr,
            'listOfProvinces' => $listOfProvinces,
            'totalHombres' => $totalHombres,
            'sumHombresAlcanzadas' => $sumHombresAlcanzadas,
            'sumMujeresAlcanzadas' => $sumMujeresAlcanzadas,
            'sumHombresCapacitadas' => $sumHombresCapacitadas,
            'sumMujeresCapacitadas' => $sumMujeresCapacitadas,
            'totalGoalCapacitadas' => $totalGoalCapacitadas,
            'totalMujeres' => $totalMujeres,
            'goalPersonasCapacitadas' => $totalGoal,
            'totalHombresCapacitados' => $totalHombresCapacitados ?? 0,
            'totalMujeresCapacitados' => $totalMujeresCapacitados ?? 0,
            'plan' => $plan,
            'groups4' => $groups4,
            'groups' => $groups,
            'groups2' => $groups2,
            'groups3' => $groups3,
            'calificacionServicio' => $calificacionServicio,
            'date' => $date
        ];
        return view('modules.strategy.reports.dashboard-poa',compact('data'));

        $pdf = PDFSnappy::loadView('modules.strategy.reports.dashboard-poa', ['data' => $data]);
        $pdf->setOption('margin-left', 0);
        $pdf->setOption('margin-top', 0);
        $pdf->setOption('margin-right', 0);
        $pdf->setOption('dpi', 300);
        return $pdf->download('chart.pdf');
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
