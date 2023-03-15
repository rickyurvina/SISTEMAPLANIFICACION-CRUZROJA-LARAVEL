<?php

namespace App\Http\Controllers\Project;

use App\Abstracts\Http\Controller;
use App\Jobs\Budgets\Incomes\BudgetIncomeDelete;
use App\Jobs\Projects\ProjectDeleteCommunication;
use App\Jobs\Projects\ProjectDeleteStakeholder;
use App\Models\Admin\Company;
use App\Models\Auth\User;
use App\Models\Budget\Transaction;
use App\Models\Common\Catalog;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectEvaluation;
use App\Models\Projects\ProjectLearnedLessons;
use App\Models\Projects\ProjectRescheduling;
use App\Models\Projects\Stakeholders\ProjectCommunicationMatrix;
use App\Models\Projects\Stakeholders\ProjectStakeholder;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Barryvdh\Snappy\Facades\SnappyPdf as PDFSnappy;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Traits\Jobs;

class ProjectController extends Controller
{
    use Jobs;

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function index()
    {
        if (user()->can('project-crud') || user()->can('project-read') || user()->can('project-super-admin')) {
            return view('modules.project.index');
        } else {
            abort(403);
        }
    }


    /**
     * Show the form for viewing the specified resource.
     */
    public function show(Project $project)
    {
        $project->load(
            [
                'members.user.media',
                'subsidiaries',
                'areas.department',
                'risks',
                'stakeholders.actions',
                'feasibilityProject',
                'feasibilityCapabilityProject',
                'feasibilityProjectFeasibilityMatrix',
                'acquisitions',
                'beneficiaries',
                'indicators',
                'articulations',
                'objectives.results.indicators',
                'objectives.indicators',
                'location',
                'articulations.sourceProject',
                'articulations.targetPlan', 'articulations.targetRegisteredTemplate',
                'articulations.targetPlanDetail'
            ]);
        return view('modules.project.project-overview', ['project' => $project, 'page' => 'overview']);
    }

    public function showIndex(Project $project)
    {
        if (user()->can('project-manage-indexCard') || user()->can('project-view-indexCard') || user()->can('project-super-admin')) {
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
            return view('modules.project.formulation.index.index', ['project' => $project, 'page' => 'act', 'messages' => $messages]);
        } else {
            abort(403);
        }
    }


    /**
     * Show the form for viewing the specified resource.
     */
    public function showActivities(Project $project, $company = null)
    {
        if (user()->can('project-manage-timetable') || user()->can('project-view-timetable') || user()->can('project-super-admin')) {
            $project->load(['tasks']);
            return view('modules.project.project-activities', ['project' => $project, 'page' => 'activities', 'users' => User::get(), 'companies' => Company::get(), 'company' => $company]);
        } else {
            abort(403);
        }
    }

    /**
     * Show the form for viewing the specified resource.
     */
    public function showTeam(Project $project)
    {
        if (user()->can('project-manage-team') || user()->can('project-view-team') || user()->can('project-super-admin')) {
            $project->load(['subsidiaries', 'company', 'areas', 'members.user.media', 'members.role', 'members.place']);
            return view('modules.project.project-team', ['project' => $project, 'page' => 'team']);
        } else {
            abort(403);
        }
    }

    /**
     * Show the form for viewing the specified resource.
     */
    public function showLogicFrame(Project $project)
    {
        if (user()->can('project-manage-logicFrame') || user()->can('project-view-logicFrame') || user()->can('project-super-admin')) {
            $project->load(['objectives.results.indicators', 'objectives.indicators']);
            $messages = Catalog::CatalogName('help_messages')->first()->details;
            return view('modules.project.project-logic-frame', ['project' => $project, 'page' => 'logic_frame', 'messages' => $messages]);
        } else {
            abort(403);
        }
    }

    /**
     * Show the form for viewing the specified resource.
     */
    public function showRisk(Project $project)
    {
        if (user()->can('project-manage-risks') || user()->can('project-view-risks') || user()->can('project-super-admin')) {
            return view('modules.project.project-risks', ['project' => $project, 'page' => 'risks']);
        } else {
            abort(403);
        }
    }


    /**
     * Show the form for viewing the specified resource.
     */
    public function showFiles(Project $project)
    {
        if (user()->can('project-manage-files') || user()->can('project-view-files') || user()->can('project-super-admin')) {
            return view('modules.project.project-files', ['project' => $project, 'page' => 'files']);
        } else {
            abort(403);
        }
    }

    /**
     * Show the form for viewing the specified resource.
     */
    public function showDocument(Project $project)
    {
        if (user()->can('project-manage-formulatedDocument') || user()->can('project-super-admin')) {
            $messages = Catalog::CatalogName('help_messages')->first()->details;
            return view('modules.project.formulation.document-formulated', ['project' => $project, 'page' => 'formulated_document', 'messages' => $messages]);
        } else {
            abort(403);
        }
    }

    /**
     * Show the form for viewing the specified resource.
     */
    public function showAcquisitions(Project $project)
    {
        if (user()->can('project-manage-acquisitions') || user()->can('project-view-acquisitions') || user()->can('project-super-admin')) {
            $project->load([
                'acquisitions.product',
                'acquisitions.unit',
                'acquisitions.mode'
            ]);
            return view('modules.project.project-acquisitions', ['project' => $project, 'page' => 'acquisitions']);
        } else {
            abort(403);
        }
    }

    /**
     * Show the form for viewing the specified resource.
     */
    public function showReferentialBudget(Project $project)
    {
        if (user()->can('project-manage-referentialBudget') || user()->can('project-super-admin')) {
            $messages = Catalog::CatalogName('help_messages')->first()->details;
            return view('modules.project.formulation.project-profile-referential-budget', ['project' => $project, 'page' => 'budget', 'messages' => $messages]);
        } else {
            abort(403);
        }
    }

    /**
     * Show the form for viewing the specified resource.
     */
    public function showEvents(Project $project)
    {
        if (user()->can('project-view-events') || user()->can('project-super-admin')) {
            return view('modules.project.project-events', ['project' => $project, 'page' => 'events']);

        } else {
            abort(403);
        }
    }

    /**
     * Show the form for viewing the specified resource.
     */
    public function showSummary(Project $project)
    {
        if (user()->can('project-view-summary') || user()->can('project-super-admin')) {
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
                foreach ($project->objectives as $objective) {
                    foreach ($objective->results as $result) {
                        if ($result->planning) {
                            $plans[$result->id] = $result->planning;
                        }
                    }
                }
            }
            $messages = Catalog::CatalogName('help_messages')->first()->details;
            return view('modules.project.formulation.project-profile-summary', ['project' => $project, 'page' => 'summary', 'time' => $time ?? 0, 'plans' => $plans, 'messages' => $messages]);
        } else {
            abort(403);
        }
    }

    /**
     * @param $id
     * @return RedirectResponse|void
     */
    public function deleteStakeholder($id)
    {
        $response = $this->ajaxDispatch(new ProjectDeleteStakeholder($id));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 1, ['type' => trans_choice('general.stakeholder', 0)]))->success();
            return redirect()->back();
        } else {
            flash($response['message'])->error()->livewire($this);
        }
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
            $time = explode(',', $project->estimated_time)[3] ?? 0;
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
//        return view('modules.project.reports.profile', ['project'=>$project, 'time' => $time ?? 0, 'plans' => $plans]);
        $pdf = PDFSnappy::loadView('modules.project.reports.profile', ['project' => $project, 'time' => $time ?? 0, 'plans' => $plans]);
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
            $time = explode(',', $project->estimated_time)[3] ?? 0;
            $years = $time / 12;
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
//        return view('modules.project.reports.constitutional_act', ['project' => $project, 'time' => $time ?? 0, 'plans' => $plans, 'years' => $years]);
        $pdf = PDFSnappy::loadView('modules.project.reports.constitutional_act', ['project' => $project, 'time' => $time ?? 0, 'plans' => $plans, 'years' => $years]);
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
        if (user()->can('project-manage-stakeholders') || user()->can('project-view-stakeholders') || user()->can('project-super-admin')) {
            $data = array();
            $stakeholders = ProjectStakeholder::where('prj_project_id', $project->id)
                ->collect();
            if ($stakeholders) {
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
            }
            $messages = Catalog::CatalogName('help_messages')->first()->details;
            return view('modules.project.project-stakeholders', ['project' => $project, 'page' => 'stakeholders', 'stakeholders' => $stakeholders, 'data' => $data, 'messages' => $messages]);
        } else {
            abort(403);
        }
    }

    public function communicationMatrix(Project $project)
    {
        if (user()->can('project-manage-communication') || user()->can('project-super-admin')) {
            $project->load([
                'stakeholders.interested',
                'stakeholders.communications'
            ]);
            $stakeholders = $project->stakeholders->pluck('id');
            $communications = ProjectCommunicationMatrix::whereIn('prj_project_stakeholder_id', $stakeholders)
                ->when(!(user()->hasRole('super-admin')), function ($q) {
                    $s = user()->id;
                    $q->where('user_id', user()->id)
                        ->orWhere('prj_project_stakeholder_id', user()->id);
                })
                ->collect();
            return view('modules.project.project-communications', ['communications' => $communications, 'page' => 'communications', 'project' => $project]);
        } else {
            abort(403);
        }
    }

    /**
     * @param $id
     * @return RedirectResponse|void
     */
    public function deleteCommunication($id)
    {
        $response = $this->ajaxDispatch(new ProjectDeleteCommunication($id));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 1, ['type' => trans_choice('general.communication', 0)]))->success();
            return redirect()->back();
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

    public function showActivitiesLogicFrame(Project $project, $resultId = null)
    {
        if (user()->can('project-manage-activities') || user()->can('project-super-admin')) {
            $project->load([
                'tasks',
                'objectives.results',
            ])->when(!(user()->hasRole('super-admin')), function ($q) {
                $q->where('owner_id', user()->id);
            });
            return view('modules.project.project-activities_results', ['page' => 'activities_results', 'project' => $project]);
        } else {
            abort(403);
        }
    }

    public function lessonsLearned(Project $project)
    {
        if (user()->can('project-manage-learnedLessons' && 'project-view-learnedLessons') || user()->can('project-super-admin')) {
            $project->load([
                'lessonsLearned'
            ]);
            return view('modules.project.project-lessons-learned', ['page' => 'lessons_learned', 'project' => $project]);
        } else {
            abort(403);
        }
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
        if (user()->can('project-manage-validations' || 'project-view-validations') || user()->can('project-super-admin')) {
            $project->load([
                'responsible', 'stateValidations.user', 'members', 'tasks',
                'subsidiaries', 'areas', 'risks', 'stakeholders',
                'acquisitions', 'beneficiaries', 'indicators', 'articulations',
                'objectives', 'comments', 'locations',
                'funders', 'cooperators', 'referentialBudgets',
                'location', 'lessonsLearned', 'reschedulings', 'evaluations'
            ]);
            return view('modules.project.project-validations', ['page' => 'validations', 'project' => $project]);
        } else {
            abort(403);
        }
    }

    public function showReschedulings(Project $project)
    {
        if (user()->can('project-manage-reschedulings' || 'project-view-reschedulings') || user()->can('project-approve-rescheduling') || user()->can('project-super-admin')) {
            $project->load(['reschedulings']);
            return view('modules.project.project-reschedulings', ['page' => 'reschedulings', 'project' => $project]);
        } else {
            abort(403);
        }
    }

    public function deleteRescheduling(int $id)
    {
        $rescheduling = ProjectRescheduling::find($id);
        $projectId = $rescheduling->project->id;
        $rescheduling->delete();
        flash('Eliminado exitosamente')->success();
        return redirect()->route('projects.reschedulings', $projectId);
    }

    public function indexLessons()
    {
        return view('modules.project.indexLessons', ['page' => 'lessons']);
    }

    public function showEvaluations(Project $project)
    {
        if (user()->can('project-manage-evaluations' || 'project-view-evaluations') || user()->can('project-super-admin')) {
            $project->load(['evaluations']);
            return view('modules.project.project-evaluations', ['page' => 'evaluations', 'project' => $project]);
        } else {
            abort(403);
        }
    }

    public function deleteEvaluation(int $id)
    {
        $evaluation = ProjectEvaluation::find($id);
        $projectId = $evaluation->project->id;
        $evaluation->delete();
        flash('Eliminado exitosamente')->success();
        return redirect()->route('projects.evaluations', $projectId);
    }

    public function showCalendar(Project $project)
    {
        $canAddActivity = true;
        if (user()->can('project-manage-calendar') || user()->can('project-view-calendar') || user()->can('project-super-admin')) {
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
            if ($project->phase == Project::PHASE_IMPLEMENTATION) {
                $canAddActivity = false;
            }
            return view('modules.project.project-calendar', compact('activities', 'data', 'canAddActivity'), ['page' => 'calendar', 'project' => $project]);
        } else {
            abort(403);
        }
    }

    public function showProjectBudgetDocument(Project $project)
    {
        return view('modules.project.budgetProject.projectBudgetDocument', compact('project'), ['page' => 'budget']);
    }

    public function showPiats(Task $task)
    {
        $task->load(['project']);
        $project = $task->project;
        return \view('modules.project.piat.index', ['task' => $task, 'project' => $project, 'page' => 'activities_results']);
    }

    public function expensesProjectActivity(Task $activity)
    {
        $project = $activity->project;
        $transaction = Transaction::where('year', $activity->project->year)
            ->where('type', Transaction::TYPE_PROFORMA)->withoutGlobalScopes()->first();
        if ($activity->validateCrateBudget() === false) {
            abort(404);
        }
        $source = Transaction::SOURCE_PROJECT;
        return view('modules.project.budget.index', ['activity' => $activity, 'project' => $project, 'page' => 'activities_results', 'transaction' => $transaction, 'source' => $source]);
    }

    public function deleteExpenseActivityProject(int $accountId, int $activityId)
    {
        $activity = Task::find($activityId);
        $data = [
            'id' => $accountId
        ];
        $response = $this->ajaxDispatch(new BudgetIncomeDelete($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => __('budget.incomes')]))->success();
            return redirect()->route('projects.expenses_activity', [$activity]);
        } else {
            flash($response['message'])->error();
            return redirect()->route('projects.expenses_activity', $activity);
        }
    }

}

