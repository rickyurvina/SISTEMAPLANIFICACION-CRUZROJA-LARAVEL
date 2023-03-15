<?php

namespace App\Http\Livewire\Budget\Reports;

use App\Models\Budget\Account;
use App\Models\Budget\Transaction;
use Livewire\Component;
use Livewire\WithPagination;
use function view;

class BudgetDocumentReport extends Component
{
    use WithPagination;

    public $transaction;
    public $account;
    public $typeReformSelected = Transaction::REFORM_TYPE_INCREMENT;
    public $search = '';
    public $readOnly = false;
    public $typeBudgetIncome = true;
    public $typeBudgetExpense;
    public $yearSelected;
    public $levelIncomeSelected;
    public array $levelsIncomes = [];

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->levelsIncomes +=
            [
                0 => 'Fuente de Financiamiento'
            ];
        $this->levelsIncomes +=
            [
                1=> 'Item Presupuestario'
            ];
    }

    public function render()
    {
        $search = $this->search;
        $budgetAccounts = Account::when($this->typeBudgetIncome, function ($query) {
            $query->where('type', Account::TYPE_INCOME);
        })->when($this->yearSelected, function ($q) {
            $q->where('year', $this->yearSelected);
        })->when($this->typeBudgetExpense, function ($query) {
            $query->where('type', Account::TYPE_EXPENSE);
        })->when($this->search, function ($query) use ($search) {
            $query->where('code', 'iLIKE', '%' . $search . '%')
                ->orWhere('name', 'iLIKE', '%' . $search . '%');
        })->paginate(setting('default.list_limit', '25'));
        return view('livewire.budget.reports.budget-document-report', compact('budgetAccounts'));
    }

    public function updatedTypeBudgetIncome()
    {
        $this->typeBudgetExpense = false;
    }

    public function updatedTypeBudgetExpense()
    {
        $this->typeBudgetIncome = false;
    }
}
