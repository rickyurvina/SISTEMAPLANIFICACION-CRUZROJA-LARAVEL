<?php

namespace App\Http\Controllers\Budget;


use App\Abstracts\Http\Controller;
use App\Models\Budget\Account;
use Illuminate\Support\Facades\Config;


class BudgetReportController extends Controller
{
    //
    public function list()
    {
        $cardReports = Config::get('constants.catalog.BUDGET_CARD_REPORTS');
        return view('modules.budget.reports.index', compact('cardReports'))
            ->with('page', 'reports');
    }

    public function budgetDocumentReport()
    {
        return view('modules.budget.reports.budgetDocumentReport');
    }

    public function showAccount(Account $account)
    {
        $account->load(['transactions.transaction']);
        return view('modules.budget.reports.showAccount', compact('account'));
    }
}
