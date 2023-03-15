<?php

namespace App\Http\Controllers\Project;


use App\Models\Admin\Department;
use App\Models\Auth\User;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Catalogs\ProjectLineAction;
use App\Models\Projects\Project;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Abstracts\Http\Controller;
use Illuminate\Support\Facades\Config;

class ProjectReportController extends Controller
{

    public function reports()
    {
        $cardReports = Config::get('constants.catalog.PROJECT_REPORTS');
        $projects = Project::get();

        return view('modules.project.reports.index', compact('cardReports'));
    }

    public function portfolioReport()
    {
        $now = now();
        return view('modules.project.project-portfolio-report', compact('now'))->with('page', 'reports');
    }

    public function index(Project $project)
    {
        $cardReports = Config::get('constants.catalog.PROJECT_CARD_REPORTS');
        return view('modules.project.project-reports', compact('project', 'cardReports'))
            ->with('page', 'reports');
    }

    public function executiveReport(Project $project)
    {
        $project->load(['location']);
        date_default_timezone_set('America/Guayaquil');
        $activities = Task::all()->where('project_id', $project->id)
            ->where('type', 'task');
        $now = now();
        $indicators = $activities->pluck('indicator');
        $lineActions = [];
        $element = [];
        foreach ($indicators as $indicator) {
            if ($indicator) {
                $lineAction=ProjectLineAction::findOrFail($indicator->indicatorable->parent->parent_id);
                $element['name'] = $lineAction->name;
                array_push($lineActions, $element);
            }
        }
        $taskServices=[];
        foreach ($activities as $activity){
            foreach($activity->services as $service){
                array_push($taskServices,$service);
            }
        }
        $lineActions = array_unique($lineActions, SORT_REGULAR);
        $taskServices = array_unique($taskServices, SORT_REGULAR);
        $projectProgress = $project->tasks->where('parent', 'root')->first()->progress;

        return view('modules.project.project-executive-report', compact('project', 'activities', 'projectProgress', 'now', 'lineActions'))
            ->with('page', 'reports');
    }

    public function indicatorsReport(Project $project)
    {
        $now = now();
        return view('modules.project.project-indicators-report', compact('project', 'now'))->with('page', 'reports');
    }

    public function activitiesExecutionBudgetReport(Project $project)
    {

        $activities = Task::all()->where('project_id', $project->id)
            ->where('type', 'task');
        return view('modules.project.project-execution-budget-activities-report', compact('project', 'activities'))->with('page', 'reports');
    }

    public function activitiesReport(Project $project)
    {
        $activities = Task::with(['goals'])->where('project_id', $project->id)
            ->where('type', 'task')->get();
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

        return view('modules.project.project-activities-report', compact('project', 'activities', 'periods'))->with('page', 'reports');
    }

    public function fundsOriginReport(Project $project)
    {
        return view('modules.project.project-fundsOrigin-report', compact('project'))->with('page', 'reports');
    }


    public function budgetNeedReport(Project $project)
    {
        return view('modules.project.project-budgetNeed-report', compact('project'))->with('page', 'reports');
    }

    public function budgetReport(Project $project)
    {
        return view('modules.project.project-budget-report', compact('project'))->with('page', 'reports');
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
        return view('modules.project.project-report-report', compact('project', 'programs'))->with('page', 'reports');
    }
}
