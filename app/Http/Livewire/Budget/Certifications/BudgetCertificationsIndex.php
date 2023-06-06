<?php

namespace App\Http\Livewire\Budget\Certifications;

use App\Models\Budget\Transaction;
use App\States\Transaction\Override;
use Livewire\Component;
use Livewire\WithPagination;

class BudgetCertificationsIndex extends Component
{

    use WithPagination;

    public $transaction;
    public $stateSelect;
    public $start_date;
    public $end_date;
    public $countRegisterSelect = 25;
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    protected $listeners = ['refreshCertifications' => '$refresh'];

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function render()
    {
        $transactions = Transaction::with(['transactions.account'])->orderBy('number', 'desc')->where('year', $this->transaction->year)
            ->when($this->stateSelect, function ($query) {
                $query->where('status', $this->stateSelect);
            })
            ->where('type', Transaction::TYPE_CERTIFICATION)
            ->search('description', $this->search)
            ->paginate(setting('default.list_limit', $this->countRegisterSelect));
        $this->dispatchBrowserEvent('loadSelects2');

        return view('livewire.budget.certifications.budget-certifications-index', compact('transactions'));
    }

    public function clearFilters()
    {
        $this->reset(['stateSelect', 'countRegisterSelect','search']);
    }

    public function overrideTransaction(int $id)
    {
        $transaction = Transaction::find($id);
        $transaction->status = Override::label();
        $transaction->save();
    }

}
