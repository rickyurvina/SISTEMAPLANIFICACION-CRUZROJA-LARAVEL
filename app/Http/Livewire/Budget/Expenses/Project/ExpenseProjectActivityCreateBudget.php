<?php

namespace App\Http\Livewire\Budget\Expenses\Project;

use App\Jobs\Budgets\Expenses\BudgetExpenseCreate;
use App\Models\Budget\Account;
use App\Models\Budget\Structure\BudgetStructure;
use App\Models\Budget\Transaction;
use App\Models\Measure\Measure;
use App\Models\Projects\Activities\Task;
use App\States\Transaction\Approved;
use App\Traits\Jobs;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;

class ExpenseProjectActivityCreateBudget extends Component
{
    use Jobs;

    public array $fields = [];
    public array $fieldsOptionals = [];
    public string $itemName = '';
    public string $itemDescription = '';
    public $itemAmount = 0;
    public int $transactionId;
    public $activity;
    public $transaction;
    public $code;
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
        $this->activity = Task::with(['project.location', 'parentOfTask', 'location'])->find($activityId);
        $this->transaction = $transaction;
        $indicator = Measure::with(['indicatorable'])->findOrFail($this->activity->measure_id);
        $this->transactionId = $transaction->id;
        if ($this->transaction->status instanceof Approved) {
            $this->isDraft = false;
        } else {
            $this->isDraft = true;
        }
        $this->loadBudgetStructure();
        if ($indicator) {
            foreach ($this->fields as $key => $field) {
                $item = '';
                if ($field['level'] == '10') {
                    $item .= $this->activity->project->location->code;
                    $this->fields[$key]['format'] = $item;
                    $this->fields[$key]['value'] = $item;
                    $this->fields[$key]['id'] = $this->activity->project->location->id;
                }
                if ($field['level'] == '9') {
                    $item .= $this->activity->code;
                    $this->fields[$key]['format'] = $item;
                    $this->fields[$key]['value'] = $item;
                    $this->fields[$key]['id'] = $this->activity->id;
                }
                if ($field['level'] == '8') {
                    $item .= $this->activity->parentOfTask->code;
                    $this->fields[$key]['format'] = $item;
                    $this->fields[$key]['value'] = $item;
                    $this->fields[$key]['id'] = $this->activity->parentOfTask->id;
                }
                if ($field['level'] == '7') {
                    $item .= $this->activity->location->full_code;
                    $this->fields[$key]['format'] = $item;
                    $this->fields[$key]['value'] = $item;
                    $this->fields[$key]['id'] = $this->activity->location->id;
                }
                if ($field['level'] == '6') {
                    $item .= $this->activity->project->code;
                    $this->fields[$key]['format'] = $item;
                    $this->fields[$key]['value'] = $item;
                    $this->fields[$key]['id'] = $this->activity->project->id;
                }
                if ($field['level'] == '5') {
                    $item .= $indicator->code;
                    $this->fields[$key]['format'] = $item;
                    $this->fields[$key]['value'] = $item;
                    $this->fields[$key]['id'] = $indicator->id;
                }
                if ($field['level'] == '4') {
                    $item .= $indicator->indicatorable->code;
                    $this->fields[$key]['format'] = $item;
                    $this->fields[$key]['value'] = $item;
                    $this->fields[$key]['id'] = $indicator->indicatorable->id;
                }
                if ($field['level'] == '3') {
                    $item .= $indicator->indicatorable->parent->code;
                    $this->fields[$key]['format'] = $item;
                    $this->fields[$key]['value'] = $item;
                    $this->fields[$key]['id'] = $indicator->indicatorable->parent->id;
                }
                if ($field['level'] == '2') {
                    $item .= $indicator->indicatorable->parent->parent->code;
                    $this->fields[$key]['format'] = $item;
                    $this->fields[$key]['value'] = $item;
                    $this->fields[$key]['id'] = $indicator->indicatorable->parent->parent->id;
                }
                if ($field['level'] == '1') {
                    $item .= $indicator->indicatorable->parent->parent->parent->code;
                    $this->fields[$key]['format'] = $item;
                    $this->fields[$key]['value'] = $item;
                    $this->fields[$key]['id'] = $indicator->indicatorable->parent->parent->parent->id;
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

        $this->transaction = $transaction;
    }

    public function render()
    {
        return view('livewire.budget.expenses.project.expense-project-activity-create-budget', ['budgetItem' => $this->getItem()]);
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

    public function hydrate()
    {
        $this->emit('initSelect');
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
            'accountable_type' => Task::class,
            'accountable_id' => $this->activity->id,
            'transaction' => $this->transaction
        ];

        $response = $this->ajaxDispatch(new BudgetExpenseCreate($accountData));

        if ($response['success']) {
            Artisan::call('cache:clear');
            flash(trans_choice('messages.success.added', 0, ['type' => __('budget . expense')]))->success()->livewire($this);
            $this->emit('updateIndexExpensesProjectActivity');
            $this->emit('toggleCreateExpenseProjectActivity');
            $this->resetForm();

        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

}
