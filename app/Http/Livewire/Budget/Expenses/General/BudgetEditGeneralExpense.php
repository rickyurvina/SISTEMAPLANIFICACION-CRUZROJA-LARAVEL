<?php

namespace App\Http\Livewire\Budget\Expenses\General;

use App\Jobs\Budgets\Expenses\BudgetExpenseEdit;
use App\Models\Budget\Account;
use App\Models\Budget\Structure\BudgetStructure;
use App\Models\Budget\Transaction;
use App\Models\Projects\Activities\Task;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;

class BudgetEditGeneralExpense extends Component
{
    use Jobs;

    public $transaction;
    public $transactionDetail;
    public $budgetGeneralExpensesStructure;
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
    protected $listeners = ['loadExpense'];

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

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function render()
    {
        return view('livewire.budget.expenses.general.budget-edit-general-expense', ['budgetItem' => $this->getItem()]);
    }

    public function loadExpense(int $id)
    {
        $this->reset(['fieldsOptionals']);
        $this->account = Account::find($id);
        $budgetGeneralExpensesStructure = $this->account->accountable;
        $this->transactionDetail = $this->account->transactionsDetails->first();
        $this->itemName = $this->account->name;
        $this->transactionId = $budgetGeneralExpensesStructure->bdg_transaction_id;
        $this->transaction = $budgetGeneralExpensesStructure->transaction;
        $this->budgetGeneralExpensesStructure = $budgetGeneralExpensesStructure;
        $this->itemDescription = $this->account->description;
        $this->itemAmount = $this->transactionDetail->credit->getAmount() / 100;
        $this->budgetItemOld = $this->account->code;
        $this->fields = $this->account->settings;
        $maxLevel = max(array_column($this->fields, 'level'));
        $keyResultsProject = array_search('Resultados Proyecto', array_column($this->fields, 'label'));
        $keyActivity = array_search('Actividad', array_column($this->fields, 'label'));
        $keyLocation = array_search('Localidad', array_column($this->fields, 'label'));
        $keyMaxLevel = array_search($maxLevel, array_column($this->fields, 'level'));
        $keyMaxLevel_1 = array_search($maxLevel - 1, array_column($this->fields, 'level'));
        if ($keyResultsProject) {
            $item = '';
            $item .= $budgetGeneralExpensesStructure->parent->parent->code;
            $this->fields[$keyResultsProject]['format'] = $item;
            $this->fields[$keyResultsProject]['value'] = $item;
            $this->fields[$keyResultsProject]['id'] = $budgetGeneralExpensesStructure->parent->parent->id;
        }
        if ($keyActivity) {
            $item = '';
            $item .= $budgetGeneralExpensesStructure->parent->code;
            $this->fields[$keyActivity]['format'] = $item;
            $this->fields[$keyActivity]['value'] = $item;
            $this->fields[$keyActivity]['id'] = $budgetGeneralExpensesStructure->parent->id;
        }
        if ($keyLocation) {
            $item = '';
            $item .= $budgetGeneralExpensesStructure->code;
            $this->fields[$keyLocation]['format'] = $item;
            $this->fields[$keyLocation]['value'] = $item;
            $this->fields[$keyLocation]['id'] = $budgetGeneralExpensesStructure->id;
        }
        if ($this->fields[$keyMaxLevel_1]) {
            array_push($this->fieldsOptionals, $this->fields[$keyMaxLevel_1]);
        }
        if ($this->fields[$keyMaxLevel]) {
            array_push($this->fieldsOptionals, $this->fields[$keyMaxLevel]);
        }

        foreach ($this->fieldsOptionals as $key => $field2) {
            if (isset($field2['meta']['source']) && $field2['meta']['source']['type'] == BudgetStructure::SOURCE_TYPE_MODEL) {

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
        if ($this->fields){
            $item = '';
            $maxLevel = max(array_column($this->fields, 'level'));
            $keyMaxLevel = array_search($maxLevel, array_column($this->fields, 'level'));
            $keyMaxLevel_1 = array_search($maxLevel - 1, array_column($this->fields, 'level'));
            if ($this->fieldsOptionals) {
                $this->fields[$keyMaxLevel_1]['format'] = $this->fieldsOptionals[0]['value'];
                $this->fields[$keyMaxLevel_1]['value'] = $this->fieldsOptionals[0]['value'];
                $this->fields[$keyMaxLevel_1]['id'] = $this->fieldsOptionals[0]['id'];
                $this->fields[$keyMaxLevel]['format'] = $this->fieldsOptionals[1]['value'];
                $this->fields[$keyMaxLevel]['value'] = $this->fieldsOptionals[1]['value'];
                $this->fields[$keyMaxLevel]['id'] = $this->fieldsOptionals[1]['id'];
            }


            foreach ($this->fields as $key => $field) {
                if ($field['format']) {
                    $item .= $field['format'] . '.';
                } else {
                    if ($field['level'] != $keyMaxLevel_1 || $field['level'] != $keyMaxLevel)
                        $item .= '999' . '.';
                }
            }
            $this->dispatchBrowserEvent('loadBudgets');

            return substr($item, 0, -1);
        }


    }

    public function resetForm()
    {
        $this->reset(['itemName', 'itemDescription', 'itemAmount', 'fields', 'fieldsOptionals']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function hydrate()
    {
        $this->emit('initSelect');
    }


    public function submit()
    {
        $this->validate();
        $this->code = $this->getItem();
        $transaction = $this->transaction;

        $this->validate(
            [
                'code' => ['required', Rule::unique('bdg_accounts')->where(function ($query) use ($transaction) {
                    return $query->where('year', $transaction->year);
                })->ignore($this->account->id)],
            ]
        );

        $transaction = Transaction::query()->find($this->transactionId);

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
            flash(trans_choice('messages.success.updated', 0, ['type' => __('budget.expense')]))->success();
            return redirect()->route('budgets.createBudgetGeneralExpenses', $this->budgetGeneralExpensesStructure);

        } else {
            flash($response['message'])->error();
            return redirect()->route('budgets.createBudgetGeneralExpenses', $this->budgetGeneralExpensesStructure);

        }
    }
}
