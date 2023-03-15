<?php

namespace App\Http\Livewire\Budget\Reforms;

use App\Models\Budget\Account;
use App\Models\Budget\Transaction;
use App\Models\Budget\TransactionDetail;
use App\States\Transaction\Approved;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowReform extends Component
{
    public $transaction;
    public $accountsIncomes;
    public $accountsExpenses;
    public $canApproveReform;
    public $totalIncrements = 0;
    public $totalDecreases = 0;
    public array $arrayReformsExpenses = [];
    public array $arrayReformsIncomes = [];


    protected $listeners = ['loadTransaction'];

    public function loadTransaction(int $id)
    {
        $this->transaction = Transaction::find($id);
        $transactionDetails = TransactionDetail::where('transaction_id', $this->transaction->id)->get()->groupBy('account_id');
        foreach ($transactionDetails as $items) {
            foreach ($items as $item) {
                if ($item->account->type == Account::TYPE_INCOME) {
                    $this->arrayReformsIncomes [] =
                        [
                            'id' => $item->id,
                            'id_account' => $item->account->id,
                            'code' => $item->account->code,
                            'name' => $item->account->name,
                            'debit' => $item->debit->getAmount(),
                            'credit' => $item->credit->getAmount(),
                            'transaction_id' => $this->transaction->id,
                            'company_id' => session('company_id'),
                        ];
                } else {
                    $this->arrayReformsExpenses [] =
                        [
                            'id' => $item->id,
                            'id_account' => $item->account->id,
                            'code' => $item->account->code,
                            'name' => $item->account->name,
                            'debit' => $item->debit->getAmount(),
                            'credit' => $item->credit->getAmount(),
                            'transaction_id' => $this->transaction->id,
                            'company_id' => session('company_id'),
                        ];
                }
            }
        }
        $this->totalDecreases = array_sum(array_column($this->arrayReformsExpenses, 'credit')) + array_sum(array_column($this->arrayReformsIncomes, 'credit'));
        $this->totalIncrements = array_sum(array_column($this->arrayReformsExpenses, 'debit')) + array_sum(array_column($this->arrayReformsIncomes, 'debit'));

        $this->accountsIncomes = Account::whereIn('code', array_column($this->arrayReformsIncomes, 'code'))
            ->where('type', Account::TYPE_INCOME)
            ->get();

        $this->accountsExpenses = Account::whereIn('code', array_column($this->arrayReformsExpenses, 'code'))
            ->where('type', Account::TYPE_EXPENSE)
            ->get();

        $this->canApproveReform=self::canApprove();

    }

    /**
     * @return bool
     */
    public function canApprove(): bool
    {
        foreach ($this->accountsIncomes as $income) {
            $arr = array_filter($this->arrayReformsIncomes, function ($v, $k) use ($income) {
                return $v['code'] == $income->code;
            }, ARRAY_FILTER_USE_BOTH);

            if (array_sum(array_column($arr, 'credit')) > $income->balance->getAmount()) {
                flash('No se puede aprobar no existen suficientes fondos en la cuenta: ' . $income->code)->error();
                return false;
            }
        }

        foreach ($this->accountsExpenses as $expense) {
            $arr = array_filter($this->arrayReformsExpenses, function ($v, $k) use ($expense) {
                return $v['code'] == $expense->code;
            }, ARRAY_FILTER_USE_BOTH);

            if (array_sum(array_column($arr, 'debit')) > $expense->balance->getAmount()) {
                flash('No se puede aprobar no existen suficientes fondos en la cuenta: ' . $expense->code)->error();
                return false;
            }
        }
        return true;
    }

    public function render()
    {
        return view('livewire.budget.reforms.show-reform');
    }

    public function resetForm()
    {
        $this->reset(
            [
                'transaction',
                'arrayReformsIncomes',
                'arrayReformsExpenses',
                'accountsIncomes',
                'accountsExpenses',
            ]);
    }

    public function saveReform()
    {
        try {
            if (self::canApprove()) {
                DB::beginTransaction();
                $this->transaction->status = Approved::label();
                $this->transaction->approved_by = user()->id;
                $this->transaction->save();
                flash('Reforma Aprobada Exitosamente')->success();
                DB::commit();
            }
            return redirect()->route('budgets.reforms', $this->transaction);
        } catch (\Exception $exception) {
            DB::rollBack();
            flash($exception->getMessage())->error()->livewire($this);
        }

    }
}
