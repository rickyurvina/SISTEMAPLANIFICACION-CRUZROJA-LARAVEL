<?php

namespace App\Http\Controllers\Poa;

use App\Abstracts\Http\Controller;
use App\Jobs\Budgets\Incomes\BudgetIncomeDelete;
use App\Models\Admin\Company;
use App\Models\Budget\Account;
use App\Models\Budget\Transaction;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaActivity;
use App\States\Poa\InProgress;
use App\Traits\Users;
use Illuminate\Http\RedirectResponse;

class ActivityController extends Controller
{

    public function index(Poa $poa)
    {
        return view('modules.poa.activity.index', compact('poa'));
    }

    public function edit(PoaActivity $activity)
    {
        if (!$activity->program->poa->status instanceof InProgress) {
            abort(404);
        }

        $activity->load([
            'poaActivityIndicator',
            'measure.unit',
            'planDetail',
            'program.poa',
            'location',
            'measureAdvances',
            'accounts.transactionsDetails'
        ]);

        $expenses = $activity->accounts->pluck('transactionsDetails')->collapse();

        $credits = $expenses->pluck('credit');
        $total = 0;
        foreach ($credits as $credit) {
            $total += $credit->getAmount();
        }
        $rule = 'required|max:255';

        $poaCurrentPhase = $activity->program->poa->phase;

        return view('modules.poa.activity.update', compact('activity', 'expenses', 'total', 'rule', 'poaCurrentPhase'));
    }

    public function show(PoaActivity $activity)
    {
        $activity->load([
            'measure.unit',
            'planDetail',
            'program.poa',
            'location',
            'measureAdvances',
            'accounts.transactionsDetails'
        ]);

        return view('modules.poa.activity.show', compact('activity'));
    }

    public function expensesPoaActivity(PoaActivity $activity)
    {

        $transaction = Transaction::where('year', $activity->program->poa->year)
            ->where('type', Transaction::TYPE_PROFORMA)->withoutGlobalScopes()->first();
        if ($activity->validateCrateBudget() === false) {
            abort(404);
        }
        $source = Transaction::SOURCE_POA;
        return view('modules.poa.activity.budget', compact('activity', 'transaction', 'source'));
    }

    public function deleteExpenseActivityPoa(int $accountId, int $activityId)
    {
        $activity = PoaActivity::find($activityId);
        $data = [
            'id' => $accountId
        ];
        $response = $this->ajaxDispatch(new BudgetIncomeDelete($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => __('budget.incomes')]))->success();
            return redirect()->route('poa.expenses_activity', $activity);
        } else {
            flash($response['message'])->error();
            return redirect()->route('poa.expenses_activity', $activity);
        }
    }
}
