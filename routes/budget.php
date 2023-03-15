<?php

use Illuminate\Support\Facades\Route;

/**
 * 'budget' middleware applied to all routes
 *
 * @see \App\Providers\RouteServiceProvider::
 */

Route::group(['prefix' => 'budget'], function () {

    Route::get('/', 'Budget\HomeController@index')->name('budget.home');
    Route::resource('budget_catalogs', 'Budget\Catalogs\BudgetClassifierController');
    Route::resource('source-information', 'Budget\Catalogs\FinancingSourceClassifierController');
    Route::resource('geographic-classifier', 'Common\CatalogGeographicClassifierController');
    Route::resource('structure', 'Budget\StructureController');
    Route::resource('budgets', 'Budget\BudgetController')->parameters([
        'budgets' => 'transaction'
    ]);

    //Incomes
    Route::get('budgets/{transaction}/incomes', 'Budget\BudgetController@incomes')->name('budgets.incomes');
    Route::delete('/destroy/income/{id}', 'Budget\BudgetController@deleteIncome')->name('income.delete');

    //expenses
    Route::get('budgets/{transaction}/expenses', 'Budget\BudgetController@expenses')->name('budgets.expenses');
    Route::get('budgets/{transaction}/expenses/poa', 'Budget\BudgetController@expensesPoa')->name('budgets.expenses_poas');
    Route::get('budgets/{transaction}/expenses/projects', 'Budget\BudgetController@expensesProjects')->name('budgets.expenses_projects');
    Route::get('budgets/{transaction}/expenses/general', 'Budget\BudgetController@generalExpenses')->name('budgets.general_expenses');
    Route::get('budgets/{transaction}/expenses/poa/{activity}', 'Budget\BudgetController@expensesPoaActivity')->name('budgets.expenses_poa_activity');
    Route::get('budgets/{transaction}/expenses/project/{activity}', 'Budget\BudgetController@expensesProjectActivity')->name('budgets.expenses_project_activity');
    Route::delete('/destroy/expense/project/{id}/{activityId}', 'Budget\BudgetController@deleteExpenseActivityProject')->name('budget-project.delete');
    Route::delete('/destroy/expense/general/{id}', 'Budget\BudgetController@deleteExpenseGeneral')->name('budget-general.delete');
    Route::delete('/destroy/expense/poa/{id}/{activityId}', 'Budget\BudgetController@deleteExpenseActivityPoa')->name('budget-poa.delete');
    Route::get('budgets/{budgetGeneralExpensesStructure}/expenses/general/create', 'Budget\BudgetController@createBudgetGeneralExpenses')->name('budgets.createBudgetGeneralExpenses');

    //reformas
    Route::get('budgets/{transaction}/reforms', 'Budget\BudgetController@reforms')->name('budgets.reforms');
    Route::get('budgets/{transaction}/createReform', 'Budget\BudgetController@viewCreatedReform')->name('budgets.viewCreatedReform');
    Route::get('budgets/{transaction}/editReform', 'Budget\BudgetController@editReform')->name('budgets.editReform');
    Route::post('/budget/create/reform/{transaction}', 'Budget\BudgetController@createReform')->name('budget.create-reform');
    //certificaciones
    Route::get('budgets/{transaction}/certifications', 'Budget\BudgetController@certifications')->name('budgets.certifications');
    Route::get('/budget/create/certification/{transaction}', 'Budget\BudgetController@viewCreateCertification')->name('budget.create-certification');
    Route::get('/budget/edit/certification/{transaction}', 'Budget\BudgetController@viewEditCertification')->name('budget.edit-certification');
    //compromisos
    Route::get('budgets/{certification}/commitments', 'Budget\BudgetController@commitments')->name('budgets.commitments');
    Route::get('/budget/create/commitment/{certification}', 'Budget\BudgetController@viewCreateCommitment')->name('budget.create-commitment');
    Route::get('/budget/edit/commitment/{commitment}/{certification}', 'Budget\BudgetController@viewEditCommitment')->name('budget.edit-commitment');
    //reports
    Route::get('documentReport', 'Budget\BudgetReportController@budgetDocumentReport')->name('budget.budgetDocumentReport');
    Route::get('budget-reports', 'Budget\BudgetReportController@list')->name('budget.reports');
    Route::get('/show/account/{account}', 'Budget\BudgetReportController@showAccount')->name('budget.showAccount');

});