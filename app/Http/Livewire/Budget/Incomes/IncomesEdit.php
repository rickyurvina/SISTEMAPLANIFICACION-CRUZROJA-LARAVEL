<?php

namespace App\Http\Livewire\Budget\Incomes;

use App\Jobs\Budgets\Incomes\BudgetIncomeEdit;
use App\Models\Budget\Account;
use App\Models\Budget\Structure\BudgetStructure;
use App\Models\Budget\Transaction;
use App\Traits\Jobs;
use Livewire\Component;
use Cknow\Money\Money;

class IncomesEdit extends Component
{
    use Jobs;

    public $income;

    public $transaction;

    public $transactionDetail;

    public array $fields = [];

    public string $itemName = '';

    public string $itemDescription = '';

    public $itemAmount;

    public int $transactionId;

    public $ids = array();

    protected $listeners = ['loadIncome', 'resetForm'];

    protected function rules(): array
    {
        return [
            'itemName' => 'required',
            'itemDescription' => 'required',
            'itemAmount' => 'required|gte:0|numeric',
            'fields.*.value' => 'required'
        ];
    }

    public function loadIncome(int $id)
    {
        $this->income = Account::find($id);
        $this->transactionDetail = $this->income->transactionsDetails->first();
        $this->transaction = $this->transactionDetail->transaction;
        $this->itemName = $this->income->name;
        $this->transactionId = $this->transactionDetail->transaction->id;
        $this->itemDescription = $this->income->description;
        $this->itemAmount = $this->transactionDetail->debit->getAmount() / 100;
        $this->fields = $this->income->settings;
        foreach ($this->fields as $key => $field) {
            if (isset($field['meta']['source']) && $field['meta']['source']['type'] == BudgetStructure::SOURCE_TYPE_MODEL) {
                $model = app($field['meta']['source']['class']);
                $query = $model->query();
                foreach ($field['meta']['source']['conditions'] as $condition) {
                    $query->where($condition['field'], $condition['op'], $condition['value']);
                }
                $result = $query->pluck($field['meta']['source']['field_display'], $field['meta']['source']['field']);
                $options = [];
                foreach ($result as $index => $value) {
                    $options[] = [
                        $field['meta']['source']['field'] => $index,
                        $field['meta']['source']['field_display'] => $value,
                    ];
                }
                $this->fields[$key]['meta']['source']['options'] = $options;
            }
        }
    }

    public function render()
    {
        return view('livewire.budget.incomes.incomes-edit', ['budgetItem' => $this->getItem()]);
    }

    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->reset(['itemName', 'itemDescription', 'itemAmount']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    private function getItem()
    {
        $item = '';
        $this->ids = [];
        foreach ($this->fields as $field) {
            if ($field['value']) {
                $item .= $field['value'] . '.';
                $model = app($field['meta']['source']['class']);

                $query = $model->query();

                foreach ($field['meta']['source']['conditions'] as $condition) {
                    $query->where($condition['field'], $condition['op'], $condition['value']);
                }
                $result = $query->get();
                $result = $result->where($field['meta']['source']['field'], $field['value'])->first();
                $this->ids[] = [
                    'id' => $result->id,
                ];
            } else {
                $item .= $field['format'] . '.';
            }
        }

        return substr($item, 0, -1);
    }

    public function hydrate()
    {
        $this->emit('initSelect');
    }

    public function submit()
    {
        $this->validate();

        foreach ($this->fields as $index => $item) {
            $this->fields[$index]['id'] = $this->ids[$index]['id'];
        }

        $accountData = [
            'id' => $this->income->id,
            'code' => $this->getItem(),
            'name' => $this->itemName,
            'description' => $this->itemDescription,
            'amount' => $this->itemAmount,
            'settings' => $this->fields,
            'transactionDetail' => $this->transactionDetail,
            'transaction' => $this->transaction,
        ];

        $response = $this->ajaxDispatch(new BudgetIncomeEdit($accountData));

        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 0, ['type' => __('budget.incomes')]))->success();
            return redirect()->route('budgets.incomes', $this->transactionId);
        } else {
            flash($response['message'])->error();
            return redirect()->route('budgets.incomes', $this->transactionId);
        }
    }
}
