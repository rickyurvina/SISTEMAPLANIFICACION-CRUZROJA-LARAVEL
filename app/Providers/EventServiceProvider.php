<?php

namespace App\Providers;

use App\Events\Indicators\ActualValueIndicatorUpdated;
use App\Events\Indicators\IndicatorProccessed;
use App\Events\Indicators\IndicatorUpdated;
use App\Events\Measure\MeasureAdvanceUpdated;
use App\Events\Measure\MeasureCreated;
use App\Events\Measure\MeasureGroupedCreated;
use App\Events\Measure\MeasureUpdated;
use App\Events\Measure\ScoreMonthlyUpdated;
use App\Events\Measure\ScoreUpdated;
use App\Events\MeasureAdvance\MeasureAdvanceDeleted;
use App\Events\Menu\AdminCreated;
use App\Events\Menu\AuditCreated;
use App\Events\Menu\BudgetCreated;
use App\Events\Menu\CommonCreated;
use App\Events\Menu\IndicatorCreated;
use App\Events\Menu\PoaCreated;
use App\Events\Menu\ProcessCreated;
use App\Events\Menu\ProjectCreated;
use App\Events\Menu\RiskCreated;
use App\Events\Menu\StrategyCreated;
use App\Events\Poa\PoaActivityDeleted;
use App\Events\Poa\PoaActivityIndicatorUpdated;
use App\Events\Poa\PoaActivityWeightChanged;
use App\Events\Projects\Activities\ActivityProcessed;
use App\Events\Projects\Activities\ResultCreated;
use App\Events\Projects\Activities\ServicesSelected;
use App\Events\Projects\Activities\TaskColorUpdated;
use App\Events\Projects\Activities\TaskCreated;
use App\Events\Projects\Activities\TaskDetailUpdated;
use App\Events\Projects\Activities\TaskUpdated;
use App\Events\Projects\Activities\TaskUpdatedCreateGoals;
use App\Events\Projects\Activities\TaskUpdatedThresholds;
use App\Events\Projects\ProjectActivityWeightChanged;
use App\Events\Projects\ProjectColorUpdated;
use App\Events\Projects\ProjectSubsidiaryUpdated;
use App\Events\Projects\ProjectUpdatedThresholds;
use App\Events\Projects\Stakeholder\ActionStakeholderCreated;
use App\Events\Risks\RiskCreatedEvent;
use App\Events\Strategy\PlanDetailCreated;
use App\Listeners\Auth\Login;
use App\Listeners\Auth\Logout;
use App\Listeners\Indicators\UpdateAdvanceIndicator;
use App\Listeners\Indicators\UpdateIndicatorParents;
use App\Listeners\Measure\CreateMeasureScore;
use App\Listeners\Measure\DeleteMeasureScore;
use App\Listeners\Measure\UpdateElementsScore;
use App\Listeners\Measure\UpdateMeasureGrouped;
use App\Listeners\Measure\UpdateMeasureScore;
use App\Listeners\Measure\UpdateMeasureWeight;
use App\Listeners\Measure\UpdateScore;
use App\Listeners\MeasureAdvances\DeleteMeasureAdvances;
use App\Listeners\Menu\AddAdminItems;
use App\Listeners\Menu\AddAuditItems;
use App\Listeners\Menu\AddBudgetItems;
use App\Listeners\Menu\AddCommonItems;
use App\Listeners\Menu\AddIndicatorItems;
use App\Listeners\Menu\AddPoaItems;
use App\Listeners\Menu\AddProcessItems;
use App\Listeners\Menu\AddProjectItems;
use App\Listeners\Menu\AddRiskItems;
use App\Listeners\Menu\AddStrategyItems;
use App\Listeners\Poa\UpdateActivity;
use App\Listeners\Poa\UpdateActivityWeight;
use App\Listeners\Projects\Activities\ActionsTaskUpdated;
use App\Listeners\Projects\Activities\CreateActivitiesOfServices;
use App\Listeners\Projects\Activities\CreateActivityOfResult;
use App\Listeners\Projects\Activities\CreateTaskGoals;
use App\Listeners\Projects\Activities\CreateThresholdsTask;
use App\Listeners\Projects\Activities\DuplicateActivity;
use App\Listeners\Projects\Activities\UpdateActivityProcessed;
use App\Listeners\Projects\Activities\UpdateCascadeProgressTasks;
use App\Listeners\Projects\Activities\UpdateChildsColor;
use App\Listeners\Projects\Activities\UpdateDurationTask;
use App\Listeners\Projects\Activities\UpdateFieldsThresholdTask;
use App\Listeners\Projects\CreateDeleteTasksOfProject;
use App\Listeners\Projects\CreateProjectActivity;
use App\Listeners\Projects\CreateProjectMemberSubsidiary;
use App\Listeners\Projects\CreateProjectReferentialBudget;
use App\Listeners\Projects\CreateProjectStateValidations;
use App\Listeners\Projects\CreateProjectThreshold;
use App\Listeners\Projects\Stakeholder\CreateTask;
use App\Listeners\Projects\UpdatedColorResults;
use App\Listeners\Projects\UpdateDurationProject;
use App\Listeners\Projects\UpdateFieldsThresholdProject;
use App\Listeners\Projects\UpdateProjectActivityWeight;
use App\Listeners\Risks\CreateTaskOfRisk;
use App\Listeners\Scores\SubstractAdvanceFromScore;
use App\Listeners\Scores\UpdateParentScores;
use App\Listeners\Strategy\CreatePlanDetailScore;
use Illuminate\Auth\Events\Login as LoginEvent;
use Illuminate\Auth\Events\Logout as LogoutEvent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        AdminCreated::class => [
            AddAdminItems::class,
        ],
        StrategyCreated::class => [
            AddStrategyItems::class,
        ],
        ProjectCreated::class => [
            AddProjectItems::class,
        ],
        BudgetCreated::class => [
            AddBudgetItems::class,
        ],
        AuditCreated::class => [
            AddAuditItems::class,
        ],
        ProcessCreated::class => [
            AddProcessItems::class,
        ],
        IndicatorCreated::class => [
            AddIndicatorItems::class,
        ],
        PoaCreated::class => [
            AddPoaItems::class,
        ],
        LoginEvent::class => [
            Login::class,
        ],
        LogoutEvent::class => [
            Logout::class,
        ],
        CommonCreated::class => [
            AddCommonItems::class,
        ],
        RiskCreated::class => [
            AddRiskItems::class,
        ],
        ActivityProcessed::class => [
            UpdateActivityProcessed::class,
        ],

        \App\Events\Projects\ProjectCreated::class => [
            CreateProjectActivity::class,
            CreateProjectStateValidations::class,
            CreateProjectMemberSubsidiary::class,
            CreateProjectReferentialBudget::class,
            CreateProjectThreshold::class,
        ],

        ProjectColorUpdated::class => [
            UpdatedColorResults::class,
        ],
        ActionStakeholderCreated::class => [
            CreateTask::class,
        ],
        ResultCreated::class => [
            CreateActivityOfResult::class,
        ],
        RiskCreatedEvent::class => [
            CreateTaskOfRisk::class,
        ],
        ServicesSelected::class => [
            CreateActivitiesOfServices::class
        ],
        TaskUpdatedCreateGoals::class => [
            CreateTaskGoals::class,
            UpdateDurationTask::class,
        ],
        ProjectSubsidiaryUpdated::class => [
            CreateDeleteTasksOfProject::class
        ],
        PoaActivityWeightChanged::class => [
            UpdateActivityWeight::class
        ],
        ProjectActivityWeightChanged::class => [
            UpdateProjectActivityWeight::class
        ],
        TaskDetailUpdated::class => [
            UpdateCascadeProgressTasks::class
        ],
        TaskUpdated::class => [
            ActionsTaskUpdated::class,
        ],
        ProjectUpdatedThresholds::class => [
            UpdateFieldsThresholdProject::class,
            UpdateDurationProject::class

        ],
        TaskUpdatedThresholds::class => [
            UpdateFieldsThresholdTask::class
        ],
        TaskColorUpdated::class => [
            UpdateChildsColor::class
        ],
        TaskCreated::class => [
            CreateThresholdsTask::class,
            DuplicateActivity::class
        ],
        MeasureCreated::class => [
            UpdateMeasureWeight::class,
            CreateMeasureScore::class
        ],
        PlanDetailCreated::class => [
            CreatePlanDetailScore::class
        ],
        ScoreUpdated::class => [
            UpdateMeasureScore::class
        ],
        ScoreMonthlyUpdated::class => [
            UpdateElementsScore::class
        ],
        MeasureGroupedCreated::class => [
            UpdateMeasureGrouped::class,
        ],
        ActualValueIndicatorUpdated::class => [
            UpdateAdvanceIndicator::class
        ],
        PoaActivityIndicatorUpdated::class => [
            UpdateActivity::class,
        ],
        MeasureAdvanceUpdated::class => [
            UpdateScore::class,
        ],
        MeasureUpdated::class => [
            DeleteMeasureScore::class,
        ],
        PoaActivityDeleted::class => [
            DeleteMeasureAdvances::class
        ],
        MeasureAdvanceDeleted::class => [
            SubstractAdvanceFromScore::class
        ],
        UpdateScore::class => [//TODO PARECE QUE EL ORDEN ESTA AL REEVES
            UpdateParentScores::class
        ],
//        UpdateParentScores::class => [
//            UpdateScore::class
//        ],
        IndicatorUpdated::class => [
            UpdateIndicatorParents::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }
}
