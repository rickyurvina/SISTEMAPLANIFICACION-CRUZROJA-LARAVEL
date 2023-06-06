<?php

use Illuminate\Support\Facades\Route;

/**
 * 'project' middleware applied to all routes
 *
 * @see \App\Providers\RouteServiceProvider::mapProjectRoutes()
 */
//DB::listen(function ($auery){
//    var_dump($auery->sql);
//});

Route::group(['prefix' => 'projects'], function () {
    Route::group(['prefix' => 'catalogs'], function () {
        Route::view('/', 'modules.project.catalogs.index')->name('projects.catalogs');
        Route::view('line-actions', 'modules.project.catalogs.project-line-actions')->name('line-actions.index');
        Route::view('line-action/services', 'modules.project.catalogs.project-line-action-services')
            ->name('line-action.services.index');
        Route::view('line-action/service/activities', 'modules.project.catalogs.project-line-action-service-activities')
            ->name('line-action.service.activities.index');
        Route::view('/assistants', 'modules.project.catalogs.project-assistants')->name('assistants.index');
        Route::view('/funders', 'modules.project.catalogs.project-founders')->name('founders.index');
        Route::view('/risks_classification', 'modules.project.catalogs.project-risks-classification')->name('risks_classification.index');
    });

    Route::group(['prefix' => 'thresholds'], function () {
        Route::get('/', 'Project\Configuration\ProjectThresholds@index')->name('projects.thresholds');
    });
    Route::get('/catalog-purchases', 'Project\PublicPurchasesController@index')->name('projects.purchases');
    Route::get('/', 'Project\ProjectController@index')->name('projects.index');
    Route::get('/lessons-learned', 'Project\ProjectController@indexLessons')->name('projects.indexLessons');
    //Reportes generales de proyectos
    Route::get('/reports/index', 'Project\ProjectReportController@reports')->name('projects.reports');
    Route::get('/reports/portfolioReport', 'Project\ProjectReportController@portfolioReport')->name('projects.portfolioReport');

});


Route::prefix('projects')->middleware('checkProjectPhase')->group(function () {

    Route::put('/{project}', 'Project\ProjectController@update')->name('projects.update');
    Route::get('/{project}', 'Project\ProjectController@show')->name('projects.show');
    Route::get('/{project}/activities/{company?}', 'Project\ProjectController@showActivities')->name('projects.activities');
    Route::get('/{project}/team', 'Project\ProjectController@showTeam')->name('projects.team');
    Route::get('/{project}/logic-frame', 'Project\ProjectController@showLogicFrame')->name('projects.logic-frame');
    Route::get('/{project}/stakeholder', 'Project\ProjectController@showStakeholder')->name('projects.stakeholder');
    Route::get('/{project}/files', 'Project\ProjectController@showFiles')->name('projects.files');
    Route::get('/{project}/events', 'Project\ProjectController@showEvents')->name('projects.events');
    Route::get('/{project}/reports', 'Project\ProjectReportController@index')->name('projects.reportsIndex');
    Route::get('/{project}/reports/executivereport', 'Project\ProjectReportController@executiveReport')->name('projects.executiveReport');
    Route::get('/{project}/reports/indicatorsreport', 'Project\ProjectReportController@indicatorsReport')->name('projects.indicatorsReport');
    Route::get('/{project}/reports/activities-exc-bud-Report', 'Project\ProjectReportController@activitiesExecutionBudgetReport')->name('projects.activities-exc-bud-Report');
    Route::get('/{project}/reports/activitiesreport', 'Project\ProjectReportController@activitiesReport')->name('projects.activitiesReport');
    Route::get('/{project}/reports/fundsoriginreport', 'Project\ProjectReportController@fundsOriginReport')->name('projects.fundsOriginReport');
    Route::get('/{project}/reports/budgetneedreport', 'Project\ProjectReportController@budgetNeedReport')->name('projects.budgetNeedReport');
    Route::get('/{project}/reports/budgetreport', 'Project\ProjectReportController@budgetReport')->name('projects.budgetReport');
    Route::get('/{project}/reports/reportreport', 'Project\ProjectReportController@reportReport')->name('projects.reportReport');

    Route::get('/{project}/administrativeTasks', 'AdministrativeTasks\AdministrativeTaskController@index')->name('projects.administrativeTasks');
    Route::delete('/destroy/administrativeTasks/{id}', 'AdministrativeTasks\AdministrativeTaskController@destroy')->name('admintask.delete');

    Route::get('/{project}/feasibility', 'Project\ProjectController@showFeasibility')->name('projects.feasibility');
    Route::get('/{project}/risks', 'Project\ProjectController@showRisk')->name('projects.risks');
    Route::get('/{project}/acquisitions', 'Project\ProjectController@showAcquisitions')->name('projects.acquisitions');
    Route::get('/{project}/communication-matrix', 'Project\ProjectController@communicationMatrix')->name('projects.communication');
    Route::get('/{project}/activities_results/logic-frame/{resultId?}', 'Project\ProjectController@showActivitiesLogicFrame')->name('projects.activities_results');
    Route::get('/{project}/lessons_learned', 'Project\ProjectController@lessonsLearned')->name('projects.lessons_learned');
    Route::get('/{project}/validations', 'Project\ProjectController@showValidations')->name('projects.validations');
    Route::get('/{project}/reschedulings', 'Project\ProjectController@showReschedulings')->name('projects.reschedulings');
    Route::get('/{project}/evaluations', 'Project\ProjectController@showEvaluations')->name('projects.evaluations');
    Route::delete('/destroy/lesson/{id}', 'Project\ProjectController@deleteLesson')->name('projects.delete_lesson');
    Route::delete('/destroy/rescheduling/{id}', 'Project\ProjectController@deleteRescheduling')->name('projects.delete_rescheduling');
    Route::delete('/destroy/evaluation/{id}', 'Project\ProjectController@deleteEvaluation')->name('projects.delete_evaluation');
    Route::get('/{project}/budget', 'Project\ProjectController@showProjectBudgetDocument')->name('projects.budgetDocumentReport');


    //formulation
    Route::get('/{project}/referential-budget', 'Project\ProjectController@showReferentialBudget')->name('projects.showReferentialBudget');
    Route::get('/{project}/summary', 'Project\ProjectController@showSummary')->name('projects.showSummary');
    Route::get('/{project}/formulation/showIndex', 'Project\ProjectController@showIndex')->name('projects.showIndex');
    Route::get('/{project}/formulation/document', 'Project\ProjectController@showDocument')->name('projects.doc');

    //stakeholders
    Route::delete('/destroy/stakeholder/{id}', 'Project\ProjectController@deleteStakeholder')->name('project.deleteStakeholder');
    Route::delete('/destroy/communication/{id}', 'Project\ProjectController@deleteCommunication')->name('project.deleteCommunication');

    // Project Gantt
    // Task
    Route::get('/{project}/gantt/data/{company?}', 'Project\GanttController@get')->name('projects.gantt');
    Route::post('/{project}/gantt/task', 'Project\TaskController@store')->name('gantt.tasks.store');
    Route::put('/{project}/gantt/task/{task}', 'Project\TaskController@update')->name('gantt.tasks.update');
    Route::delete('/{project}/gantt/task/{task}', 'Project\TaskController@delete')->name('gantt.tasks.delete');
    // Links
    Route::post('/{project}/gantt/link', 'Project\LinkController@store')->name('gantt.links.store');
    Route::put('/{project}/gantt/link/{link}', 'Project\LinkController@update')->name('gantt.links.update');
    Route::delete('/{project}/gantt/link/{link}', 'Project\LinkController@delete')->name('gantt.links.delete');

    Route::get('/report/profile/{project}', 'Project\ProjectController@reportProfile')->name('projects.reportProfile');
    Route::get('/report/constitutional-act/{project}', 'Project\ProjectController@reportConstitutionalAct')->name('projects.reportConstitutionalAct');

    //PROYECTOS DE FORTALECIMIENTO INTERNO
    Route::get('/{project}/formulation/showIndexInternal', 'Project\ProjectInternalController@showIndexInternal')->name('projects.showIndexInternal');
    Route::get('/{project}/teamInternal', 'Project\ProjectInternalController@showTeam')->name('projects.teamInternal');
    Route::get('/{project}/stakeholderInternal', 'Project\ProjectInternalController@showStakeholder')->name('projects.stakeholderInternal');
    Route::get('/{project}/risksInternal', 'Project\ProjectInternalController@showRisk')->name('projects.risksInternal');
    Route::get('/{project}/formulation/documentInternal', 'Project\ProjectInternalController@showDocument')->name('projects.docInternal');
    Route::get('/{project}/referential-budgetInternal', 'Project\ProjectInternalController@showReferentialBudget')->name('projects.showReferentialBudgetInternal');
    Route::get('/{project}/activities_results/logic-frameInternal/{resultId?}', 'Project\ProjectInternalController@showActivitiesLogicFrame')->name('projects.activities_resultsInternal');
    Route::get('/{project}/summaryInternal', 'Project\ProjectInternalController@showSummary')->name('projects.showSummaryInternal');
    Route::get('/{project}/filesInternal', 'Project\ProjectInternalController@showFiles')->name('projects.filesInternal');
    Route::get('/{project}/lessons_learnedInternal', 'Project\ProjectInternalController@lessonsLearned')->name('projects.lessons_learnedInternal');
    Route::get('/{project}/validationsInternal', 'Project\ProjectInternalController@showValidations')->name('projects.validationsInternal');
    Route::get('/report/profileInternal/{project}', 'Project\ProjectInternalController@reportProfile')->name('projects.reportProfileInternal');
    Route::get('/report/constitutional-actInternal/{project}', 'Project\ProjectInternalController@reportConstitutionalAct')->name('projects.reportConstitutionalActInternal');
    Route::get('/{project}/eventsInternal', 'Project\ProjectInternalController@showEvents')->name('projects.eventsInternal');
    Route::get('/{project}/reschedulingsInternal', 'Project\ProjectInternalController@showReschedulings')->name('projects.reschedulingsInternal');
    Route::get('/{project}/evaluationsInternal', 'Project\ProjectInternalController@showEvaluations')->name('projects.evaluationsInternal');
    Route::get('/{project}/reportsInternal', 'Project\ProjectInternalController@indexReports')->name('projects.reportsIndexInternal');
    Route::get('/{project}/administrativeTasksInternal', 'AdministrativeTasks\AdministrativeTaskController@indexInternal')->name('projects.administrativeTasksInternal');


    //reportes proyectos de fortalecimiento
    Route::get('/{project}/reports/executivereportInternal', 'Project\ProjectInternalController@executiveReport')->name('projects.executiveReportInternal');
    Route::get('/{project}/reports/indicatorsreportInternal', 'Project\ProjectInternalController@indicatorsReport')->name('projects.indicatorsReportInternal');
    Route::get('/{project}/reports/activities-exc-bud-ReportInternal', 'Project\ProjectInternalController@activitiesExecutionBudgetReport')->name('projects.activities-exc-bud-ReportInternal');
    Route::get('/{project}/reports/portfolioreportInternal', 'Project\ProjectInternalController@portfolioReport')->name('projects.portfolioReportInternal');
    Route::get('/{project}/reports/activitiesreportInternal', 'Project\ProjectInternalController@activitiesReport')->name('projects.activitiesReportInternal');
    Route::get('/{project}/reports/fundsoriginreportInternal', 'Project\ProjectInternalController@fundsOriginReport')->name('projects.fundsOriginReportInternal');
    Route::get('/{project}/reports/budgetneedreportInternal', 'Project\ProjectInternalController@budgetNeedReport')->name('projects.budgetNeedReportInternal');
    Route::get('/{project}/reports/budgetreportInternal', 'Project\ProjectInternalController@budgetReport')->name('projects.budgetReportInternal');
    Route::get('/{project}/calendarInternal', 'Project\ProjectInternalController@showCalendar')->name('projects.calendarInternal');
    Route::get('/{project}/reports/reportreportInternal', 'Project\ProjectInternalController@reportReport')->name('projects.reportReportInternal');

    //calendario actividades
    Route::get('/{project}/calendar', 'Project\ProjectController@showCalendar')->name('projects.calendar');

    //piats
    Route::get('/project/piat/{task?}', 'Project\ProjectController@showPiats')->name('project.piat_index');
    Route::get('/project/internal/piat/{task?}', 'Project\ProjectInternalController@showPiats')->name('internal.piat_index');

    //budget
    Route::group(['prefix' => 'budget'], function () {
        Route::get('/expenses/activity/{activity}', 'Project\ProjectController@expensesProjectActivity')->name('projects.expenses_activity');
        Route::delete('/destroy/expense/project/{accountId}/{activityId}', 'Project\ProjectController@deleteExpenseActivityProject')->name('projects.expenses_delete');

    });
    //budget Internal
    Route::group(['prefix' => 'budgetInternal'], function () {
        Route::get('/expenses/activity/{activity}', 'Project\ProjectInternalController@expensesProjectActivity')->name('projectsInternal.expenses_activity');
        Route::delete('/destroy/expense/project/{accountId}/{activityId}', 'Project\ProjectInternalController@deleteExpenseActivityProject')->name('projectsInternal.expenses_delete');
        Route::get('/{project}/budget/internal', 'Project\ProjectInternalController@showProjectBudgetDocument')->name('projectsInternal.budgetDocumentReport');
    });
});
