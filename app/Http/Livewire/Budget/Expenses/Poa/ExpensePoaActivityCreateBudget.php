<?php

namespace App\Http\Livewire\Budget\Expenses\Poa;

use App\Jobs\Budgets\Expenses\BudgetExpenseCreate;
use App\Models\Budget\Account;
use App\Models\Budget\Structure\BudgetStructure;
use App\Models\Budget\Transaction;
use App\Models\Poa\PoaActivity;
use App\States\Transaction\Approved;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ExpensePoaActivityCreateBudget extends Component
{
    use Jobs;

    public $activity;
    public $transaction;
    public array $fields = [];
    public array $fieldsOptionals = [];
    public string $itemName = '';
    public string $itemDescription = '';
    public $itemAmount = 0;
    public int $transactionId;
    public $code;
    public $tree;
    public $ids = array();
    public $isDraft = false;

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

    public function mount(int $activityId, Transaction $transaction)
    {
        $this->activity = PoaActivity::with(['location', 'measure.indicatorable.parent.parent.parent'])->find($activityId);
        $this->transaction = $transaction;
        $this->transactionId = $transaction->id;
        if ($this->transaction->status instanceof Approved) {
            $this->isDraft = false;
        } else {
            $this->isDraft = true;
        }

    }

    public function render()
    {
        if (!$this->fieldsOptionals) {
            self::chargeFieldOptionals();
        }
        return view('livewire.budget.expenses.poa.expense-poa-activity-create-budget', ['budgetItem' => $this->getItem()]);
    }

    public function resetForm()
    {
        $this->reset(['itemName', 'itemDescription', 'itemAmount', 'fields', 'fieldsOptionals']);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->loadBudgetStructure();
    }

    public function submit()
    {
        $this->validate();
        $this->code = $this->getItem();
        $transaction = Transaction::query()->find($this->transactionId);
        $this->validate(
            [
                'code' => Rule::unique('bdg_accounts')->where(function ($query) use ($transaction) {
                    return $query->where('year', $transaction->year);
                })
            ]
        );

        $accountData = [
            'year' => $transaction->year,
            'type' => Account::TYPE_EXPENSE,
            'code' => $this->getItem(),
            'name' => $this->itemName,
            'description' => $this->itemDescription,
            'amount' => $this->itemAmount,
            'settings' => $this->fields,
            'accountable_type' => PoaActivity::class,
            'accountable_id' => $this->activity->id,
            'transaction' => $this->transaction
        ];
        $response = $this->ajaxDispatch(new BudgetExpenseCreate($accountData));
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => __('budget.expense')]))->success()->livewire($this);
            $this->emit('updateIndexExpensesPoaActivity');
            $this->emit('toggleCreateExpensePoaActivity');
            $this->resetForm();
        } else {
            flash($response['message'])->error()->livewire($this);
        }
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
        $maxLevel = max(array_column($this->fields, 'level'));
        $keyMaxLevel = array_search($maxLevel, array_column($this->fields, 'level'));
        $keyMaxLevel_1 = array_search($maxLevel - 1, array_column($this->fields, 'level'));

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

    public function chargeFieldOptionals()
    {
        $this->loadBudgetStructure();
        if ($this->activity->measure) {
            $maxLevel = max(array_column($this->fields, 'level'));
            $keyMaxLevel = array_search($maxLevel, array_column($this->fields, 'level'));
            $keyMaxLevel_1 = array_search($maxLevel - 1, array_column($this->fields, 'level'));
            $keyIndicators = array_search('Indicadores', array_column($this->fields, 'label'));
            $keyCatalogGeographic = array_search('Juntas Provinciales', array_column($this->fields, 'label'));
            $keyResults = array_search('Resultados Proyecto', array_column($this->fields, 'label'));
            $keyActivity = array_search('Actividad', array_column($this->fields, 'label'));
            $keyLocation = array_search('Localidad', array_column($this->fields, 'label'));
            $indicator = $this->activity->measure;
            $planElementOfIndicator = $indicator->indicatorable;
            $this->tree = $planElementOfIndicator->ancestorsAndSelf;
            foreach ($this->tree as $planElement) {
                $key = array_search($planElement->planRegistered->name, array_column($this->fields, 'label'));
                $this->fields[$key]['format'] = $planElement->code;
                $this->fields[$key]['value'] = $planElement->code;
                $this->fields[$key]['id'] = $planElement->id;
            }

            if ($keyIndicators) {
                $item = '';
                $item .= $indicator->code;
                $this->fields[$keyIndicators]['format'] = $item;
                $this->fields[$keyIndicators]['value'] = $item;
                $this->fields[$keyIndicators]['id'] = $indicator->id;
            }
            if ($keyCatalogGeographic) {
                $item = '';
                $item .= $this->activity->location->full_code;
                $this->fields[$keyCatalogGeographic]['format'] = $item;
                $this->fields[$keyCatalogGeographic]['value'] = $item;
                $this->fields[$keyCatalogGeographic]['id'] = $this->activity->location->id;
            }
            if ($keyActivity) {
                $item = '';
                $item .= $this->activity->code;
                $this->fields[$keyResults]['format'] = $item;
                $this->fields[$keyResults]['value'] = $item;
                $this->fields[$keyResults]['id'] = $this->activity->id;
            }
            if ($keyLocation) {
                $item = '';
                $item .= $this->activity->location->full_code;
                $this->fields[$keyResults]['format'] = $item;
                $this->fields[$keyResults]['value'] = $item;
                $this->fields[$keyResults]['id'] = $this->activity->location->id;
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
    }
}
