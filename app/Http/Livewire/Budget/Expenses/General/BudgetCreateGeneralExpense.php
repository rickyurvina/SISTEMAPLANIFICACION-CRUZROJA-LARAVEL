<?php

namespace App\Http\Livewire\Budget\Expenses\General;

use App\Jobs\Budgets\Expenses\BudgetExpenseCreate;
use App\Models\Budget\Account;
use App\Models\Budget\Structure\BudgetGeneralExpensesStructure;
use App\Models\Budget\Structure\BudgetStructure;
use App\Models\Budget\Transaction;
use App\Models\Projects\Activities\Task;
use App\States\Transaction\Approved;
use App\Traits\Jobs;
use Livewire\Component;

class BudgetCreateGeneralExpense extends Component
{
    use Jobs;

    public array $fields = [];
    public array $fieldsOptionals = [];
    public string $itemName = '';
    public string $itemDescription = '';
    public $itemAmount = 0;
    public int $transactionId;
    public $transaction;
    public $code;
    public $ids = array();
    public $isDraft = false;
    public $budgetGeneralExpensesStructure;

    protected function rules(): array
    {
        return [
            'itemName' => 'required',
            'itemDescription' => 'required',
            'itemAmount' => 'required_if:isDraft,true|numeric|gte:0',
            'fieldsOptionals.*.value' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'code.unique' => 'El código de la partida ya existe.',
        ];
    }

    public function mount(BudgetGeneralExpensesStructure $budgetGeneralExpensesStructure)
    {
        $this->budgetGeneralExpensesStructure = $budgetGeneralExpensesStructure;
        $this->transaction = $budgetGeneralExpensesStructure->transaction;
        $this->transactionId = $this->transaction->id;
        $this->loadBudgetStructure();
        foreach ($this->fields as $key => $field) {
            $item = '';
            if ($field['level'] == '8') {
                $item .= $budgetGeneralExpensesStructure->parent->parent->code;
                $this->fields[$key]['format'] = $item;
                $this->fields[$key]['value'] = $item;
                $this->fields[$key]['id'] = $budgetGeneralExpensesStructure->parent->parent->id;
            }
            if ($field['level'] == '9') {
                $item .= $budgetGeneralExpensesStructure->parent->code;
                $this->fields[$key]['format'] = $item;
                $this->fields[$key]['value'] = $item;
                $this->fields[$key]['id'] = $budgetGeneralExpensesStructure->parent->id;
            }
            if ($field['level'] == '10') {
                $item .= $budgetGeneralExpensesStructure->code;
                $this->fields[$key]['format'] = $item;
                $this->fields[$key]['value'] = $item;
                $this->fields[$key]['id'] = $budgetGeneralExpensesStructure->id;
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

    public function render()
    {
        return view('livewire.budget.expenses.general.budget-create-general-expense', ['budgetItem' => $this->getItem()]);
    }

    public function resetForm()
    {
        $this->reset(['itemName', 'itemDescription', 'itemAmount']);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->loadBudgetStructure();
    }

    private function loadBudgetStructure()
    {
        $transaction = Transaction::query()->with('structures')->find($this->transactionId);
        $this->fields = $transaction->structures->where('name', \App\Models\Budget\Structure\BudgetStructure::EXPENSES)->first()->settings['fields'];
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
                if ($field['level'] != '11' || $field['level'] != '12')
                    $item .= '999' . '.';
            }
        }
        $this->dispatchBrowserEvent('loadBudgets');

        return substr($item, 0, -1);
    }

    public function submit()
    {
        $this->validate();
        $this->code = $this->getItem();
        $this->validate(
            [
                'code' => 'unique:bdg_accounts'
            ]
        );

        $transaction = Transaction::query()->find($this->transactionId);

        $accountData = [
            'year' => $transaction->year,
            'type' => Account::TYPE_EXPENSE,
            'code' => $this->getItem(),
            'name' => $this->itemName,
            'description' => $this->itemDescription,
            'amount' => $this->itemAmount,
            'settings' => $this->fields,
            'transaction' => $this->transaction,
            'accountable_type' => BudgetGeneralExpensesStructure::class,
            'accountable_id' => $this->budgetGeneralExpensesStructure->id,
        ];

        $response = $this->ajaxDispatch(new BudgetExpenseCreate($accountData));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => __('budget.expense')]))->success();
            return redirect()->route('budgets.createBudgetGeneralExpenses', $this->budgetGeneralExpensesStructure);
        } else {
            flash($response['message'])->error();
            return redirect()->route('budgets.createBudgetGeneralExpenses', $this->budgetGeneralExpensesStructure);
        }
    }

}
