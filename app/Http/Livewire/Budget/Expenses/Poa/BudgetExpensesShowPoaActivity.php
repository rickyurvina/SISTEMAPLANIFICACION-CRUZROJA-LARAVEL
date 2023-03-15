<?php

namespace App\Http\Livewire\Budget\Expenses\Poa;

use App\Models\Budget\Account;
use App\Models\Budget\Transaction;
use App\Models\Budget\TransactionDetail;
use App\Models\Poa\PoaActivity;
use App\Models\Projects\Activities\Task;
use Livewire\Component;

class BudgetExpensesShowPoaActivity extends Component
{
    public $activity;

    public $transaction;

    public $expenses;

    public $total = 0;

    protected $listeners = ['loadActivity'];

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function loadActivity(int $id)
    {
        $this->activity = PoaActivity::find($id);
//
//        $query = TransactionDetail::whereHas('account', function ($query) use ($id) {
//            $query->where([
//                ['type', Account::TYPE_EXPENSE],
//                ['accountable_id', $id],
//                ['accountable_type', PoaActivity::class],
//            ]);
//        })->where('transaction_id', $this->transaction->id)->with(['account', 'transaction']);

        $this->expenses = Account::where([
                ['type', Account::TYPE_EXPENSE],
                ['accountable_id', $id],
                ['accountable_type', PoaActivity::class],
            ]
        )->get();

    }

    public function render()
    {
        return view('livewire.budget.expenses.poa.budget-expenses-show-poa-activity');
    }

    public function resetForm()
    {
        $this->reset(['activity']);
    }
}
