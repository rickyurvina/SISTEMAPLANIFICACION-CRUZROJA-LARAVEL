<?php

namespace App\Http\Livewire\Budget\Incomes;

use App\Jobs\Budgets\Incomes\BudgetIncomeCreate;
use App\Jobs\Budgets\Incomes\BudgetIncomeEdit;
use App\Models\Budget\Account;
use App\Models\Budget\Structure\BudgetStructure;
use App\Models\Budget\Transaction;
use App\States\Transaction\Approved;
use App\States\Transaction\Draft;
use App\Traits\Jobs;
use Livewire\Component;

class IncomesCreate extends Component
{
    use Jobs;

    public array $fields = [];

    public string $itemName = '';

    public string $itemDescription = '';

    public $itemAmount = 0;
    public int $transactionId;
    public $transaction;
    public $isDraft = false;

    protected $listeners = ['resetForm'];

    public $ids = array();

    protected function rules(): array
    {
        return [
            'itemName' => 'required',
            'itemDescription' => 'required',
            'itemAmount' => 'required_if:isDraft,true|numeric|gte:0',
            'fields.*.value' => 'required'
        ];
    }

    public function mount(int $id)
    {
        $this->transactionId = $id;
        $this->transaction = Transaction::query()->find($this->transactionId);
        if ($this->transaction->status instanceof Approved) {
            $this->isDraft = false;
        } else {
            $this->isDraft = true;
        }

        $this->loadBudgetStructure();

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

    private function loadBudgetStructure()
    {
        $this->transaction = Transaction::query()->with('structures')->find($this->transactionId);
        $this->fields = $this->transaction->structures->where('name', \App\Models\Budget\Structure\BudgetStructure::INCOMES)->first()->settings['fields'];
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

    public function submit()
    {
        $this->validate();

        foreach ($this->fields as $index => $item) {
            unset($this->fields[$index]['meta']['source']['options']);
            $this->fields[$index]['id'] = $this->ids[$index]['id'];
        }
        $accountData = [
            'year' => $this->transaction->year,
            'type' => Account::TYPE_INCOME,
            'code' => $this->getItem(),
            'name' => $this->itemName,
            'description' => $this->itemDescription,
            'bdg_transaction_id' => $this->transactionId,
            'amount' => $this->itemAmount,
            'settings' => $this->fields
        ];

        $response = $this->ajaxDispatch(new BudgetIncomeCreate($accountData));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => __('budget.incomes')]))->success();
        } else {
            flash($response['message'])->error();
        }
        return redirect()->route('budgets.incomes', $this->transactionId);
    }

    public function hydrate()
    {
        $this->emit('initSelect2');
    }

    public function render()
    {
        return view('livewire.budget.incomes.incomes-create', ['budgetItem' => $this->getItem()]);
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

}
