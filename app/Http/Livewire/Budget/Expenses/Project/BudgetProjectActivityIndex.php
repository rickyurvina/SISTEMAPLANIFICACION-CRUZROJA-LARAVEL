<?php

namespace App\Http\Livewire\Budget\Expenses\Project;

use App\Models\Budget\Account;
use App\Models\Budget\Transaction;
use App\Models\Projects\Activities\Task;
use App\States\Transaction\Approved;
use Livewire\Component;

class BudgetProjectActivityIndex extends Component
{
    public $activity;
    public $transaction;
    public $idActivity;
    public $source = 'sourceBudget';


    protected $listeners = ['updateIndexExpensesProjectActivity' => 'render'];

    public function mount(int $idTransaction, int $idActivity, string $source = Transaction::SOURCE_BUDGET)
    {
        $this->idActivity = $idActivity;
        $this->activity = Task::find($idActivity);
        $this->transaction = Transaction::find($idTransaction);
        $this->source = $source;
    }

    public function render()
    {
        $expenses = Account::where([
                ['type', Account::TYPE_EXPENSE],
                ['accountable_id', $this->idActivity],
                ['accountable_type', Task::class],
                ['year', $this->transaction->year],
            ]
        );

        $total = 0;

        foreach ($expenses->get() as $account) {
            if ($this->transaction->status instanceof Approved) {
                $total += $account->balance->getAmount();
            } else {
                $total += $account->balanceDraft->getAmount();
            }
        }

        $total = money($total);
        $expenses = $expenses->orderBy('id', 'desc')->collect();
        return view('livewire.budget.expenses.project.budget-project-activity-index', compact('expenses', 'total'));
    }
}
