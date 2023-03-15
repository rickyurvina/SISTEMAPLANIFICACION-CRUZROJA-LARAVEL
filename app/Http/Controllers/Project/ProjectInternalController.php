<?php

namespace App\Http\Controllers\Project;

use App\Abstracts\Http\Controller;
use App\Models\Common\Catalog;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectLearnedLessons;
use App\Models\Projects\Stakeholders\ProjectStakeholder;
use Illuminate\Support\Facades\Config;
use Barryvdh\Snappy\Facades\SnappyPdf as PDFSnappy;
use Symfony\Component\HttpFoundation\StreamedResponse;
use DateInterval;
use DatePeriod;
use DateTime;

class ProjectInternalController extends Controller
{


    public function showIndexInternal(Project $project)
    {
        $project->load(
            [
                'objectives.results',
                'location',
                'objectives.results.indicators',
                'objectives.indicators',
                'articulations.sourceProject',
                'articulations.targetPlan', 'articulations.targetRegisteredTemplate',
                'articulations.targetPlanDetail'
            ]
        );
        $messages = Catalog::CatalogName('help_messages')->first()->details;
        return view('modules.projectInternal.formulation.index.index', ['project' => $project, 'page' => 'act', 'messages' => $messages]);
    }

    /**
     * Show the form for viewing the specified resource.
     */
    public function showTeam(Project $project)
    {
        $project->load(['subsidiaries', 'company', 'areas', 'members.role', 'members.place']);
        return view('modules.projectInternal.project-team', ['project' => $project, 'page' => 'team']);
    }

    /**
     * Show the form for viewing the specified resource.
     */
    public function showRisk(Project $project)
    {
        return view('modules.projectInternal.project-risks', ['project' => $project, 'page' => 'risks']);
    }


    /**
     * Show the form for viewing the specified resource.
     */
    public function showFiles(Project $project)
    {
        return view('modules.projectInternal.project-files', ['project' => $project, 'page' => 'files']);
    }

    /**
     * Show the form for viewing the specified resource.
     */
    public function showDocument(Project $project)
    {
        $messages = Catalog::CatalogName('help_messages')->first()->details;
        return view('modules.projectInternal.formulation.document-formulated', ['project' => $project, 'page' => 'formulated_document', 'messages' => $messages]);
    }

    /**
     * Show the form for viewing the specified resource.
     */
    public function showAcquisitions(Project $project)
    {
        $project->load([
            'acquisitions.product',
            'acquisitions.unit',
            'acquisitions.mode'
        ]);
        return view('modules.projectInternal.project-acquisitions', ['project' => $project, 'page' => 'acquisitions']);
    }

    /**
     * Show the form for viewing the specified resource.
     */
    public function showReferentialBudget(Project $project)
    {
        $messages = Catalog::CatalogName('help_messages')->first()->details;
        return view('modules.projectInternal.formulation.project-profile-referential-budget', ['project' => $project, 'page' => 'budget', 'messages' => $messages]);
    }

    /**
     * Show the form for viewing the specified resource.
     */
    public function showEvents(Project $project)
    {
        return view('modules.projectInternal.project-events', ['project' => $project, 'page' => 'events']);

    }

    /**
     * Show the form for viewing the specified resource.
     */
    public function showSummary(Project $project)
    {
        $project->load(
            [
                'members.user.media',
                'risks',
                'stakeholders',
                'beneficiaries',
                'articulations',
                'articulations.sourceProject',
                'articulations.targetPlan',
                'articulations.targetRegisteredTemplate',
                'articulations.targetPlanDetail',
                'objectives.results.indicators',
                'objectives.results',
                'funders',
                'cooperators',
                'location',
                'objectives.results',
            ]);
        $plans = [];

        if ($project->estimated_time) {
            $time = explode(',', $project->estimated_time)[3];
        }
        if ($project->estimated_time) {
            $time = explode(',', $project->estimated_time)[3];
            foreach ($project->objectives as $objective) {
                foreach ($objective->results as $result) {
                    if ($result->planning) {
                        $plans[$result->id] = $result->planning;
                    }
                }
            }
        }
        $messages = Catalog::CatalogName('help_messages')->first()->details;
        return view('modules.projectInternal.formulation.project-profile-summary', ['project' => $project, 'page' => 'summary', 'time' => $time ?? 0, 'plans' => $plans, 'messages' => $messages]);
    }

    /**
     * @param Project $project
     * @return StreamedResponse
     */
    public function reportProfile(Project $project)
    {
        $project->load(
            [
                'members.user.media',
                'risks',
                'stakeholders',
                'beneficiaries',
                'articulations',
                'articulations.sourceProject',
                'articulations.targetPlan',
                'articulations.targetRegisteredTemplate',
                'articulations.targetPlanDetail',
                'objectives.results.indicators',
                'objectives.results',
                'funders',
                'cooperators',
                'location',
                'objectives.results',
            ]);
        $plans = [];

        if ($project->estimated_time) {
            $time = explode(',', $project->estimated_time)[3];
        }
        if ($project->estimated_time) {
            $time = explode(',', $project->estimated_time)[3];
            foreach ($project->objectives as $objective) {
                foreach ($objective->results as $result) {
                    if ($result->planning) {
                        $plans[$result->id] = $result->planning;
                    }
                }
            }
        }
        setlocale(LC_TIME, 'es_ES.utf8');
        $date = ucfirst(strftime('%B %Y'));
//        return view('modules.projectInternal.reports.profile', ['project'=>$project, 'time' => $time ?? 0, 'plans' => $plans]);
        $pdf = PDFSnappy::loadView('modules.projectInternal.reports.profile', ['project' => $project, 'time' => $time ?? 0, 'plans' => $plans]);
        $pdf->setOption('margin-left', 10);
        $pdf->setOption('margin-top', 10);
        $pdf->setOption('margin-right', 10);
        $pdf->setOption('dpi', 300);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'PerfilProyecto.pdf');
    }

    public function reportConstitutionalAct(Project $project)
    {
        $project->load(
            [
                'members.user.media',
                'risks',
                'stakeholders',
                'beneficiaries',
                'articulations',
                'articulations.sourceProject',
                'articulations.targetPlan',
                'articulations.targetRegisteredTemplate',
                'articulations.targetPlanDetail',
                'objectives.results.indicators',
                'objectives.results',
                'funders',
                'cooperators',
                'location',
                'objectives.results',
            ]);
        $plans = [];

        if ($project->estimated_time) {
            $time = explode(',', $project->estimated_time)[3];
        }
        if ($project->estimated_time) {
            $time = explode(',', $project->estimated_time)[3];
            foreach ($project->objectives as $objective) {
                foreach ($objective->results as $result) {
                    if ($result->planning) {
                        $plans[$result->id] = $result->planning;
                    }
                }
            }
        }
        setlocale(LC_TIME, 'es_ES.utf8');
        $date = ucfirst(strftime('%B %Y'));
//        return view('modules.projectInternal.reports.constitutional_act', ['project'=>$project, 'time' => $time ?? 0, 'plans' => $plans]);
        $pdf = PDFSnappy::loadView('modules.projectInternal.reports.constitutional_act', ['project' => $project, 'time' => $time ?? 0, 'plans' => $plans]);
        $pdf->setOption('margin-left', 10);
        $pdf->setOption('margin-top', 10);
        $pdf->setOption('margin-right', 10);
        $pdf->setOption('dpi', 300);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'ActaConstitución.pdf');
    }


    /**
     * Show the form for viewing the specified resource.
     */
    public function showStakeholder(Project $project)
    {
        $data = array();
        $stakeholders = ProjectStakeholder::where('prj_project_id', $project->id)->collect();
        foreach ($stakeholders->groupBy('strategy') as $index => $stakeholder) {
            switch ($index) {
                case ProjectStakeholder::MONITOR:
                    $bajo = ProjectStakeholder::LOW;
                    $alto = ProjectStakeholder::LOW;
                    $color = '#0b7d03';
                    $color2 = '#ffffff';
                    break;

                case ProjectStakeholder::KEEP_SATISFIED:
                    $bajo = ProjectStakeholder::LOW;
                    $alto = ProjectStakeholder::HIGH;
                    $color = '#5dbe24';
                    $color2 = '#ffffff';
                    break;
                case ProjectStakeholder::KEEP_INFORMED:
                    $bajo = ProjectStakeholder::HIGH;
                    $alto = ProjectStakeholder::LOW;
                    $color = '#e17a2d';
                    $color2 = '#ffffff';
                    break;
                case ProjectStakeholder::MANAGE_CAREFULLY:
                    $bajo = ProjectStakeholder::HIGH;
                    $alto = ProjectStakeholder::HIGH;
                    $color = '#ca0101';
                    $color2 = '#ffffff';
                    break;
                default:
                    $alto = '';
                    $bajo = '';
                    $color = '#0b7d03';
                    $color2 = '#ffffff';
                    break;
            }
            $data[] = [
                "x" => $bajo,
                "y" => $alto,
                "result" => $index,
                "color" => $color,
                "color2" => $color2,
                "value" => $stakeholder->count(),
            ];
        }
        $messages = Catalog::CatalogName('help_messages')->first()->details;


        return view('modules.projectInternal.project-stakeholders', ['project' => $project, 'page' => 'stakeholders', 'stakeholders' => $stakeholders, 'data' => $data, 'messages' => $messages]);
    }

    public function showActivitiesLogicFrame(Project $project, $resultId = null)
    {
        $project->load([
            'tasks',
            'objectives.results',
        ]);

        return view('modules.projectInternal.project-activities_results', ['page' => 'activities_results', 'project' => $project]);
    }

    public function lessonsLearned(Project $project)
    {
        $project->load([
            'lessonsLearned'
        ]);
        return view('modules.projectInternal.project-lessons-learned', ['page' => 'lessons_learned', 'project' => $project]);
    }

    public function deleteLesson(int $id)
    {
        $lesson = ProjectLearnedLessons::find($id);
        $projectId = $lesson->project->id;
        $lesson->delete();
        flash('Eliminado exitosamente')->success();
        return redirect()->route('projects.lessons_learned', $projectId);
    }

    public function showValidations(Project $project)
    {
        $project->load(['stateValidations']);
        return view('modules.projectInternal.project-validations', ['page' => 'validations', 'project' => $project]);
    }

    public function showReschedulings(Project $project)
    {
        $project->load(['reschedulings']);
        return view('modules.projectInternal.project-reschedulings', ['page' => 'reschedulings', 'project' => $project]);
    }

    public function showEvaluations(Project $project)
    {
        $project->load(['evaluations']);
        return view('modules.projectInternal.project-evaluations', ['page' => 'evaluations', 'project' => $project]);
    }

    public function indexReports(Project $project)
    {
        $cardReports = Config::get('constants.catalog.PROJECT_INTERNAL_CARD_REPORTS');
        return view('modules.projectInternal.project-reports', compact('project', 'cardReports'))
            ->with('page', 'reports');
    }

    public function executiveReport(Project $project)
    {
        $activities = Task::all()->where('project_id', $project->id)
            ->where('type', 'task');
        $now = now();
        $indicators = $activities->pluck('indicator');
        $programs = [];
        $element = [];
        foreach ($indicators as $indicator) {
            if ($indicator) {
                $element['name'] = $indicator->indicatorable->parent->name;
                array_push($programs, $element);
            }
        }
        $programs = array_unique($programs, SORT_REGULAR);
        $projectProgress = $project->tasks->where('parent', 'root')->first()->progress;
        return view('modules.projectInternal.reports.project-executive-report', compact('project', 'activities', 'projectProgress', 'now', 'programs'))
            ->with('page', 'reports');
    }

    public function indicatorsReport(Project $project)
    {
        $now = now();
        return view('modules.projectInternal.reports.project-indicators-report', compact('project', 'now'))->with('page', 'reports');
    }

    public function activitiesExecutionBudgetReport(Project $project)
    {

        $activities = Task::all()->where('project_id', $project->id)
            ->where('type', 'project');
        return view('modules.projectInternal.reports.project-execution-budget-activities-report', compact('project', 'activities'))->with('page', 'reports');
    }

    public function activitiesReport(Project $project)
    {
        $activities = Task::all()->where('project_id', $project->id)
            ->where('type', 'task');
        $periods = [];
        $begin = new DateTime($project->start_date);
        $end = new DateTime($project->end_date);
        $end = $end->modify("+0 month");
        $interval = new DateInterval("P1M");
        $daterange = new DatePeriod($begin, $interval, $end);
        $i = 0;
        foreach ($daterange as $date) {
            $periods[$i] = $date->format("Y-m-d");
            $i++;
        }
        return view('modules.projectInternal.reports.project-activities-report', compact('project', 'activities', 'periods'))->with('page', 'reports');
    }

    public function fundsOriginReport(Project $project)
    {
        return view('modules.projectInternal.reports.project-fundsOrigin-report', compact('project'))->with('page', 'reports');
    }

    public function portfolioReport(Project $project)
    {
        $now = now();
        return view('modules.projectInternal.reports.project-portfolio-report', compact('project', 'now'))->with('page', 'reports');
    }

    public function budgetNeedReport(Project $project)
    {
        return view('modules.projectInternal.reports.project-budgetNeed-report', compact('project'))->with('page', 'reports');
    }

    public function budgetReport(Project $project)
    {
        return view('modules.projectInternal.reports.project-budget-report', compact('project'))->with('page', 'reports');
    }

    public function showCalendar(Project $project)
    {
        $project->load(['tasks']);
        $activities = Task::where('project_id', $project->id)->where('parent', '!=', 'root')
            ->where('type', '=', 'task')
            ->get();
        $data = [];
        foreach ($activities as $activity) {
            $data[] =
                [
                    'title' => $activity->text,
                    'description' => $activity->description,
                    'start' => $activity->start_date->format('Y-m-d'),
                    'end' => $activity->end_date->format('Y-m-d'),
                    'color' => $activity->color ?? '#3A87AD',
                    'textColor' => '#ffffff',
                    'id' => $activity->id
                ];
        }
        return view('modules.projectInternal.project-calendar', compact('activities', 'data'), ['page' => 'calendar', 'project' => $project]);
    }

    public function reportReport(Project $project)
    {
        $activities = Task::all()->where('project_id', $project->id)
            ->where('type', 'task');
        $indicators = $activities->pluck('indicator');
        $programs = array();
        $element = [];
        foreach ($indicators as $indicator) {
            if ($indicator) {
                $element['sector'] = $indicator->indicatorable->parent->name;
                $element['budget'] = '501.9';
                $element['value'] = '309.65';
                array_push($programs, $element);
            }
        }
        $programs = array_unique($programs, SORT_REGULAR);
        return view('modules.projectInternal.reports.project-report-report', compact('project', 'programs'))->with('page', 'reports');
    }

    public function showPiats(Task $task)
    {
        $task->load(['project']);
        $project = $task->project;

        return \view('modules.projectInternal.piat.index', ['task' => $task, 'project' => $project,'page'=>'activities_results']);
    }
}
