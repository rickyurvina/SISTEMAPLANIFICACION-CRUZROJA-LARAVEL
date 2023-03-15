<?php

namespace App\Http\Livewire\Budget\Expenses\Poa;

use App\Jobs\Budgets\Expenses\BudgetExpenseEdit;
use App\Models\Budget\Account;
use App\Models\Budget\Structure\BudgetStructure;
use App\Models\Budget\Transaction;
use App\Models\Poa\PoaActivity;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ExpensePoaActivityEditBudget extends Component
{
    use Jobs;

    public $activity;

    public $transaction;

    public $transactionDetail;

    public $account;

    public array $fields = [];

    public array $fieldsOptionals = [];

    public string $itemName = '';

    public string $itemDescription = '';

    public $itemAmount;

    public int $transactionId;

    public $code;

    public $budgetItemOld;

    public $ids = array();

    protected $listeners = ['loadExpensePoa'];

    protected function rules(): array
    {
        return [
            'itemName' => 'required',
            'itemDescription' => 'required',
            'itemAmount' => 'required|numeric|gte:0',
            'fieldsOptionals.*.value' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'code.unique' => 'El código de la partida ya existe.',
        ];
    }


    public function loadExpensePoa(int $id)
    {
        $this->account = Account::find($id);
        $this->transactionDetail = $this->account->transactionsDetails->first();
        $this->itemName = $this->account->name;
        $this->transactionId = $this->transaction->id;
        $this->itemDescription = $this->account->description;
        $this->itemAmount = $this->transactionDetail->credit->getAmount() / 100;
        $this->budgetItemOld = $this->account->code;
        $this->fields = $this->account->settings;
        foreach ($this->fields as $key => $field) {
            $item = '';
            if ($field['level'] == '10') {
                $item .= $this->activity->location->full_code;
                $this->fields[$key]['format'] = $item;
                $this->fields[$key]['value'] = $item;
                $this->fields[$key]['id'] = $this->activity->location->id;
            }
            if ($field['level'] == '9') {
                $item .= $this->activity->code;
                $this->fields[$key]['format'] = $item;
                $this->fields[$key]['value'] = $item;
                $this->fields[$key]['id'] = $this->activity->id;
            }
            if ($field['level'] == '8') {
                $item .= '';
                $this->fields[$key]['format'] = $item;
                $this->fields[$key]['value'] = $item;
                $this->fields[$key]['id'] = '';
            }
            if ($field['level'] == '7') {
                $item .= $this->activity->location->full_code;
                $this->fields[$key]['format'] = $item;
                $this->fields[$key]['value'] = $item;
                $this->fields[$key]['id'] = $this->activity->location->id;
            }
            if ($field['level'] == '6') {
                $this->fields[$key]['format'] = '';
                $this->fields[$key]['value'] = '';
                $this->fields[$key]['id'] = '';
            }
            if ($field['level'] == '5') {
                $item .= $this->activity->measure->code;
                $this->fields[$key]['format'] = $item;
                $this->fields[$key]['value'] = $item;
                $this->fields[$key]['id'] = $this->activity->measure->id;
            }
            if ($field['level'] == '4') {
                $item .= $this->activity->measure->indicatorable->code;
                $this->fields[$key]['format'] = $item;
                $this->fields[$key]['value'] = $item;
                $this->fields[$key]['id'] = $this->activity->measure->indicatorable->id;
            }
            if ($field['level'] == '3') {
                $item .= $this->activity->measure->indicatorable->parent->code;
                $this->fields[$key]['format'] = $item;
                $this->fields[$key]['value'] = $item;
                $this->fields[$key]['id'] = $this->activity->measure->indicatorable->parent->id;
            }
            if ($field['level'] == '2') {
                $item .= $this->activity->measure->indicatorable->parent->parent->code;
                $this->fields[$key]['format'] = $item;
                $this->fields[$key]['value'] = $item;
                $this->fields[$key]['id'] = $this->activity->measure->indicatorable->parent->parent->id;
            }
            if ($field['level'] == '1') {
                $item .= $this->activity->measure->indicatorable->parent->parent->parent->code;
                $this->fields[$key]['format'] = $item;
                $this->fields[$key]['value'] = $item;
                $this->fields[$key]['id'] = $this->activity->measure->indicatorable->parent->parent->parent->id;
            }
            if ($field['level'] == '11') {
                array_push($this->fieldsOptionals, $field);
            }
            if ($field['level'] == '12') {
                array_push($this->fieldsOptionals, $field);
            }
        }
        foreach ($this->fieldsOptionals as $key => $field2) {
            if (isset($field2['meta']['source']) && $field['meta']['source']['type'] == BudgetStructure::SOURCE_TYPE_MODEL) {

                $model = app($field2['meta']['source']['class']);

                $query = $model->query();

                foreach ($field2['meta']['source']['conditions'] as $condition) {
                    $query->where($condition['field'], $condition['op'], $condition['value']);
                }

                $result = $query->pluck($field2['meta']['source']['field_display'], $field2['meta']['source']['field']);

                $options = [];
                foreach ($result as $index => $value) {
                    $options[] = [
                        $field2['meta']['source']['field'] => $index,
                        $field2['meta']['source']['field_display'] => $value,
                    ];
                }
                $this->fieldsOptionals[$key]['meta']['source']['options'] = $options;
            }
        }
    }

    public function mount(int $activityId, Transaction $transaction)
    {
        $this->activity = PoaActivity::find($activityId);
        $this->transaction = $transaction;
    }

    public function render()
    {
        return view('livewire.budget.expenses.poa.expense-poa-activity-edit-budget', ['budgetItem' => $this->getItem()]);
    }

    private function getItem()
    {
        $item2 = '';
        $this->ids = [];
        foreach ($this->fieldsOptionals as $field2) {
            if ($field2['value']) {
                $item2 .= $field2['value'] . '.';
                $model = app($field2['meta']['source']['class']);
                $query = $model->query();
                foreach ($field2['meta']['source']['conditions'] as $condition) {
                    $query->where($condition['field'], $condition['op'], $condition['value']);
                }
                $result = $query->get();
                $result = $result->where($field2['meta']['source']['field'], $field2['value'])->first();
                $this->ids[] = [
                    'id' => $result->id,
                ];
            } else {
                $item2 .= $field2['format'] . '.';
            }
        }
        if ($this->ids) {
            foreach ($this->fieldsOptionals as $index => $item) {
                if (isset($this->ids[$index])) {
                    $this->fieldsOptionals[$index]['id'] = $this->ids[$index]['id'];
                }
            }
        }
        $item = '';

        if ($this->fieldsOptionals) {
            $this->fields[10]['format'] = $this->fieldsOptionals[0]['value'];
            $this->fields[10]['value'] = $this->fieldsOptionals[0]['value'];
            $this->fields[10]['id'] = $this->fieldsOptionals[0]['id'];
            $this->fields[11]['format'] = $this->fieldsOptionals[1]['value'];
            $this->fields[11]['value'] = $this->fieldsOptionals[1]['value'];
            $this->fields[11]['id'] = $this->fieldsOptionals[1]['id'];
        }


        foreach ($this->fields as $key => $field) {
            if ($field['format']) {
                $item .= $field['format'] . '.';
            } else {
                if ($field['level'] != '11' || $field['level'] != '12') {
                    $item .= '999' . '.';
                }
            }
        }
        $this->dispatchBrowserEvent('loadBudgets');

        return substr($item, 0, -1);
    }

    public function resetForm()
    {
        $this->reset(['itemName', 'itemDescription', 'itemAmount']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function submit()
    {
        $this->validate();
        $this->code = $this->getItem();
        $transaction = $this->transaction;

        $this->validate(
            [
                'code' => [
                    'required',
                    Rule::unique('bdg_accounts')->where(function ($query) use ($transaction) {
                        return $query->where('year', $transaction->year);
                    })->ignore($this->account->id)
                ],
            ]
        );

        $accountData = [
            'id' => $this->account->id,
            'code' => $this->getItem(),
            'name' => $this->itemName,
            'description' => $this->itemDescription,
            'amount' => $this->itemAmount,
            'settings' => $this->fields,
            'transaction' => $this->transaction,
            'transactionDetail' => $this->transactionDetail,
        ];

        $response = $this->ajaxDispatch(new BudgetExpenseEdit($accountData));

        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 0, ['type' => __('budget . expense')]))->success()->livewire($this);
            $this->emit('updateIndexExpensesPoaActivity');
            $this->emit('toggleEditExpensePoaActivity');
            $this->resetForm();
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }
}
