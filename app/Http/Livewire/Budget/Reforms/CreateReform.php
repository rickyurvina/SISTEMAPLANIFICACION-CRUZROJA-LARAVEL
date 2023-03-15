<?php

namespace App\Http\Livewire\Budget\Reforms;

use App\Models\Budget\Account;
use App\Models\Budget\Transaction;
use App\Models\Budget\TransactionDetail;
use App\States\Transaction\Balanced;
use App\States\Transaction\Digited;
use Livewire\Component;
use Livewire\WithPagination;

class CreateReform extends Component
{
    use WithPagination;

    public $transaction;
    public $account;
    public $typeReformSelected = Transaction::REFORM_TYPE_INCREMENT;
    public $countRegisterSelect;
    public $typeBudgetIncome = true;
    public $typeBudgetExpense;
    public $accountSelected;
    public $increment;
    public $decrease;
    public array $arrayReformsExpenses = [];
    public array $arrayReformsIncomes = [];
    public $search = '';
    public $isEditing = false;
    public $totalIncrements = 0;
    public $totalDecreases = 0;
    public $newValue = 0;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function render()
    {
        $accounts = Account::where('year', $this->transaction->year)
            ->when($this->typeBudgetIncome, function ($query) {
                $query->where('type', Account::TYPE_INCOME);
            })
            ->when($this->typeBudgetExpense, function ($query) {
                $query->where('type', Account::TYPE_EXPENSE);
            })->search('code', $this->search)
            ->paginate(setting('default.list_limit', '25'));

        $this->totalDecreases = array_sum(array_column($this->arrayReformsExpenses, 'credit')) + array_sum(array_column($this->arrayReformsIncomes, 'credit'));
        $this->totalIncrements = array_sum(array_column($this->arrayReformsExpenses, 'debit')) + array_sum(array_column($this->arrayReformsIncomes, 'debit'));
        return view('livewire.budget.reforms.create-reform', compact('accounts'));
    }

    public function updatedTypeBudgetIncome()
    {
        $this->typeBudgetExpense = false;
    }

    public function updatedTypeBudgetExpense()
    {
        $this->typeBudgetIncome = false;
    }

    public function updatedAccountSelected()
    {
        $this->account = Account::find($this->accountSelected);
    }

    public function updatedTypeReformSelected()
    {
        $this->reset(
            [
                'typeBudgetIncome',
                'typeBudgetExpense',
                'arrayReformsIncomes',
                'arrayReformsExpenses',
            ]);
    }

    public function messages(): array
    {
        return [
            'increment.gt' => 'El valor ingresado no es válido',
            'decrease.gt' => 'El valor ingresado no es válido',
        ];
    }

    public function addReform()
    {
        $this->validate(
            [
                'increment' => 'nullable|regex:/^\d*(\.\d{2})?$/|numeric|gt:0',
                'decrease' => 'nullable|regex:/^\d*(\.\d{2})?$/|numeric|gt:0',
            ]
        );
        if ($this->decrease > $this->account->balance->getAmount() / 100) {
            flash('El valor de la cuenta es menor a la disminución')->warning()->livewire($this);
        } else {
            switch ($this->typeReformSelected) {
                case Transaction::REFORM_TYPE_TRANSFER:
                    $this->isTransfer();
                    break;
                case Transaction::REFORM_TYPE_DECREASE || Transaction::REFORM_TYPE_INCREMENT;
                    $this->isDecreaseOrIncrement();
                    break;
            }
            $this->reset(['increment', 'decrease']);
        }
    }

    public function deleteItemExpense($index)
    {
        try {
            unset($this->arrayReformsExpenses[$index]);
            flash(trans_choice('messages.success.deleted', 0, ['type' => 'Gasto']))->success()->livewire($this);;
        } catch (\Exception $exception) {
            flash($exception->getMessage())->error()->livewire($this);;
        }
    }

    public function deleteItemIncome($index)
    {
        try {
            unset($this->arrayReformsIncomes[$index]);
            flash(trans_choice('messages.success.deleted', 0, ['type' => 'Ingreso']))->success()->livewire($this);;
        } catch (\Exception $exception) {
            flash($exception->getMessage())->error()->livewire($this);;
        }
    }

    public function saveReform()
    {
        if ($this->typeReformSelected) {
            $this->transaction->reform_type = $this->typeReformSelected;
            if ($this->totalIncrements == $this->totalDecreases) {
                $this->transaction->status = Balanced::label();
            } else {
                $this->transaction->status = Digited::label();
            }
            $this->transaction->save();
            foreach ($this->arrayReformsExpenses as $itemExpense) {
                if ($itemExpense['credit'] > 0) {
                    $this->transaction->credit($itemExpense['credit'], null, $itemExpense['id']);
                } else {
                    $this->transaction->debit($itemExpense['debit'], null, $itemExpense['id']);
                }
            }
            foreach ($this->arrayReformsIncomes as $itemIncome) {
                if ($itemIncome['credit'] > 0) {
                    $this->transaction->credit($itemIncome['credit'], null, $itemIncome['id']);
                } else {
                    $this->transaction->debit($itemIncome['debit'], null, $itemIncome['id']);
                }
            }
            $transactionGeneral = Transaction::where('year', $this->transaction->year)
                ->where('type', Transaction::TYPE_PROFORMA)->first();
            flash('Reforma Creada Exitosamente')->success();
            return redirect()->route('budgets.reforms', $transactionGeneral);
        }
    }

    public function resetCreate()
    {
        $this->reset(
            [
                'account',
                'typeReformSelected',
                'countRegisterSelect',
                'typeBudgetIncome',
                'typeBudgetExpense',
                'accountSelected',
                'increment',
                'decrease',
                'arrayReformsExpenses',
                'arrayReformsIncomes',
                'search',
                'totalIncrements',
                'totalDecreases',
            ]
        );
    }

    public function isTransfer()
    {
        if ($this->account->type == Account::TYPE_EXPENSE) {
            $this->arrayReformsExpenses[] =
                [
                    'id' => $this->account->id,
                    'code' => $this->account->code,
                    'name' => $this->account->name,
                    'debit' => $this->decrease ? $this->decrease : '0',
                    'credit' => $this->increment ? $this->increment : '0',
                    'transaction_id' => $this->transaction->id,
                    'company_id' => session('company_id'),
                ];
        } else {
            $this->arrayReformsIncomes[] = [
                'id' => $this->account->id,
                'code' => $this->account->code,
                'name' => $this->account->name,
                'debit' => $this->increment ? $this->increment : '0',
                'credit' => $this->decrease ? $this->decrease : '0',
                'transaction_id' => $this->transaction->id,
                'company_id' => session('company_id'),
            ];
        }
    }

    public function isDecreaseOrIncrement()
    {
        if ($this->account->type == Account::TYPE_EXPENSE) {
            $this->arrayReformsExpenses[] =
                [
                    'id' => $this->account->id,
                    'code' => $this->account->code,
                    'name' => $this->account->name,
                    'debit' => $this->decrease ? $this->decrease : '0.00',
                    'credit' => $this->increment ? $this->increment : '0.00',
                    'transaction_id' => $this->transaction->id,
                    'company_id' => session('company_id'),
                ];
        } else {
            $this->arrayReformsIncomes[] = [
                'id' => $this->account->id,
                'code' => $this->account->code,
                'name' => $this->account->name,
                'debit' => $this->increment ? $this->increment : '0',
                'credit' => $this->decrease ? $this->decrease : '0',
                'transaction_id' => $this->transaction->id,
                'company_id' => session('company_id'),
            ];
        }
    }

    public function editArrayReformExpense($index, $value, $type)
    {
        $this->validate(
            [
                'newValue' => 'required|regex:/^\d*(\.\d{2})?$/|numeric|gt:0',
            ]
        );
        $this->arrayReformsExpenses[$index][$type] = $value;
        $this->reset(['newValue']);
    }

    public function editArrayReformIncomes($index, $value, $type)
    {
        $this->validate(
            [
                'newValue' => 'required|regex:/^\d*(\.\d{2})?$/|numeric|gt:0',
            ]
        );
        $this->arrayReformsIncomes[$index][$type] = $value;
        $this->reset(['newValue']);
    }

}
