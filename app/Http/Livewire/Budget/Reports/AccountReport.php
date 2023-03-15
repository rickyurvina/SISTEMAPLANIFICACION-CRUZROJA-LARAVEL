<?php

namespace App\Http\Livewire\Budget\Reports;

use App\Models\Budget\Account;
use App\Models\Budget\Transaction;
use Livewire\Component;

class AccountReport extends Component
{
    public $account;

    protected $listeners = ['loadAccount'];

    public function mount(Account $account)
    {
        $this->account = $account;
    }

    public function render()
    {
        $transactions = $this->account->transactions;
        return view('livewire.budget.reports.account-report', compact('transactions'));
    }
}
