<?php

namespace App\Http\Livewire\Budget\Reforms;

use App\Models\Budget\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class BudgetReformsIndex extends Component
{
    use WithPagination;

    public $transaction;
    public $stateSelect;
    public $reformSelect;
    public $countRegisterSelect = 25;
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function render()
    {
        $transactions = Transaction::orderBy('number', 'asc')->where('year', $this->transaction->year)
            ->when($this->stateSelect, function ($query) {
                $query->where('status', $this->stateSelect);
            })
            ->when($this->reformSelect, function ($query) {
                $query->where('reform_type', $this->reformSelect);
            })
            ->where('type', Transaction::TYPE_REFORM)
            ->search('description', $this->search)
            ->paginate(setting('default.list_limit', $this->countRegisterSelect));
        return view('livewire.budget.reforms.budget-reforms-index', compact('transactions'));
    }

    public function clearFilters()
    {
        $this->reset(['stateSelect', 'countRegisterSelect','search','reformSelect']);
    }
}
