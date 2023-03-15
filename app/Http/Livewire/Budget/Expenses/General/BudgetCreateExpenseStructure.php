<?php

namespace App\Http\Livewire\Budget\Expenses\General;

use App\Jobs\Budgets\Expenses\CreateBudgetExpensesGeneral;
use App\Jobs\Budgets\Expenses\DeleteBudgetExpensesGeneral;
use App\Models\Admin\Department;
use App\Models\Budget\Transaction;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;

class BudgetCreateExpenseStructure extends Component
{
    use jobs;

    public string $code = '';
    public string $name = '';
    public $deparments;
    public $transaction;
    public $data;
    public $responsibleUnit = null;
    public $executingUnit = null;
    public $parentId = null;
    public string $nameAdd = '';
    public string $nameProgram = '';
    public string $nameSubProgram = '';
    public $modelSearch;

    protected $listeners = ['loadResponsibleUnit', 'chargeInformation'];

    public function mount(Transaction $transaction)
    {
        $this->deparments = Department::get();
        $this->transaction = $transaction;

    }

    public function render()
    {
        return view('livewire.budget.expenses.general.budget-create-expense-structure');
    }

    public function chargeInformation(array $dataCreate)
    {
        $this->reset([
            'data',
            'parentId',
            'nameAdd',
            'nameProgram',
            'nameSubProgram',
            'parentId',
            'modelSearch',
            'name',
            'code',
            'executingUnit',
            'responsibleUnit',
        ]);
        $this->data = $dataCreate;
        $this->parentId = $dataCreate['parentId'] ?? null;
        $this->nameAdd = $dataCreate['nameAdd'] ?? '';
        $this->nameProgram = $dataCreate['nameProgram'] ?? '';
        $this->nameSubProgram = $dataCreate['nameSubProgram'] ?? '';

        if (isset($dataCreate['modelSearch'])) {
            $this->modelSearch = $dataCreate['modelSearch'] ?? null;
            $this->name = $this->modelSearch['name'];
            $this->code = $this->modelSearch['code'];
            $this->executingUnit = $this->modelSearch['executing_unit'];
            $this->responsibleUnit = $this->modelSearch['responsible_unit'];
        }
        $this->dispatchBrowserEvent('loadAreas');

    }

    public function save()
    {
        if ($this->modelSearch) {
            $data = $this->validate(
                [
                    'name' => 'required|max:100',
                    'code' => 'required|alpha_num|alpha_dash|max:5|' . Rule::unique('bdg_general_expenses_structures')->ignore($this->modelSearch['id'])
                ]
            );
            $data +=
                [
                    'id' => $this->modelSearch ? $this->modelSearch['id'] : '',
                    'responsible_unit' => $this->responsibleUnit,
                    'executing_unit' => $this->executingUnit,
                ];

        } else {
            $data = $this->validate(
                [
                    'name' => 'required|max:100',
                    'code' => 'required|max:5|alpha_num|alpha_dash|unique:bdg_general_expenses_structures',
                ]
            );
            $data +=
                [
                    'bdg_transaction_id' => $this->transaction->id,
                    'parent_id' => $this->parentId,
                    'responsible_unit' => $this->responsibleUnit,
                    'executing_unit' => $this->executingUnit,
                ];

        }

        $response = $this->ajaxDispatch(new CreateBudgetExpensesGeneral($data));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => __('budget.expense')]))->success()->livewire($this);
            $this->reset(
                [
                    'name',
                    'code',
                    'parentId',
                    'responsibleUnit',
                    'executingUnit',
                ]
            );
            $this->emit('itemCreated');
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

    public function loadResponsibleUnit($payload)
    {
        if (isset($payload['responsibleUnit'])) {
            $this->responsibleUnit = $payload['responsibleUnit'] ?? '';
        }
        if (isset($payload['executingUnit'])) {
            $this->executingUnit = $payload['executingUnit'] ?? '';
        }
    }
}
