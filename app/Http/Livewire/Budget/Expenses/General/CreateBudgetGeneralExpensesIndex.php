<?php

namespace App\Http\Livewire\Budget\Expenses\General;

use App\Models\Budget\Account;
use App\Models\Budget\Structure\BudgetGeneralExpensesStructure;
use App\Models\Budget\Transaction;
use Livewire\Component;

class CreateBudgetGeneralExpensesIndex extends Component
{
    protected $expensesCollection;
    public $transaction;
    protected $totalSum;
    public $budgetGeneralExpensesStructure;

    public function mount($expenses, Transaction $transaction, BudgetGeneralExpensesStructure $budgetGeneralExpensesStructure)
    {
        $this->transaction = $transaction;
        $this->budgetGeneralExpensesStructure = $budgetGeneralExpensesStructure;
        $total = 0;

        foreach ($expenses->get() as $expens) {
            $total += $expens->balanceDraft($transaction->status)->getAmount();
        }
        $this->expensesCollection = $expenses;
        $this->totalSum = $total;
    }

    public function render()
    {
        $expenses = $this->expensesCollection->collect();
        $total = money($this->totalSum);

        return view('livewire.budget.expenses.general.create-budget-general-expenses-index', compact('expenses','total'));
    }
}
