<?php

namespace App\Http\Livewire\Budget\Expenses\Project;

use App\Models\Budget\Account;
use App\Models\Budget\Transaction;
use App\Models\Budget\TransactionDetail;
use App\Models\Projects\Activities\Task;
use Livewire\Component;

class BudgetExpensesShowProjectActivity extends Component
{
    public $activity;
    public $transaction;
    public $expenses;
    public $credits;
    public $total = 0;

    protected $listeners = ['loadActivity'];

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function loadActivity(int $id)
    {
        $this->activity = Task::find($id);
        $this->expenses = Account::where([
                ['type', Account::TYPE_EXPENSE],
                ['accountable_id', $id],
                ['accountable_type', Task::class],
            ]
        )->get();
    }

    public function render()
    {
        return view('livewire.budget.expenses.project.budget-expenses-show-project-activity');
    }

    public function resetForm()
    {
        $this->reset(['activity','expenses']);
    }
}
