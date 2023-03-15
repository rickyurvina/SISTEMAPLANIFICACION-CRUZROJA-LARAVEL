<?php

namespace App\Http\Livewire\Budget\Expenses\General;

use App\Jobs\Budgets\Expenses\DeleteBudgetExpensesGeneral;
use App\Models\Budget\Structure\BudgetGeneralExpensesStructure;
use App\Models\Budget\Transaction;
use Livewire\Component;
use App\Traits\Jobs;

class BudgetExpensesIndex extends Component
{
    use jobs;

    public $transaction;
    public $programs;
    public $viewAdd = false;
    public $parentId = null;
    public string $nameAdd = '';
    public string $nameProgram = '';
    public string $nameSubProgram = '';
    public array $dataCreate = [];
    public $modelSearch;

    protected $listeners = ['itemCreated', 'refreshComponent' => '$refresh'];

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction->load(['budgetGeneralExpensesStructures']);
    }

    public function render()
    {
        $this->dispatchBrowserEvent('loadAreas');
        $this->programs = BudgetGeneralExpensesStructure::where('bdg_transaction_id', $this->transaction->id)->get();
        return view('livewire.budget.expenses.general.budget-expenses-index');
    }

    public function addProgram()
    {
        $this->reset(['modelSearch','nameAdd','nameProgram','parentId','nameSubProgram','modelSearch']);
        $this->viewAdd = true;
        $this->nameAdd = trans('general.program');
        self::chargeCreate();
    }

    public function addSubProgram(int $id, string $name)
    {
        $this->reset(['modelSearch','nameAdd','nameProgram','parentId','nameSubProgram','modelSearch']);
        $this->viewAdd = true;
        $this->nameAdd = trans('general.subprogram');
        $this->parentId = $id;
        $this->nameProgram = $name;
        $this->reset(['nameSubProgram']);
        self::chargeCreate();
    }

    public function addActivity(int $id, string $name)
    {
        $this->reset(['modelSearch','nameAdd','nameProgram','parentId','nameSubProgram','modelSearch']);
        $this->viewAdd = true;
        $this->nameAdd = trans('general.activity');
        $this->parentId = $id;
        $this->nameProgram = BudgetGeneralExpensesStructure::find($id)->parent->name;
        $this->nameSubProgram = $name;
        self::chargeCreate();
    }

    public function updateProgram(int $id)
    {
        $this->reset(['modelSearch','nameAdd','nameProgram','parentId','nameSubProgram']);
        $this->viewAdd = true;
        $this->nameAdd = trans('general.program');
        $this->modelSearch = BudgetGeneralExpensesStructure::find($id);
        self::chargeCreate();

    }

    public function updateSubProgram(int $id)
    {
        $this->reset(['modelSearch','nameAdd','nameProgram','parentId','nameSubProgram']);
        $this->viewAdd = true;
        $this->nameAdd = trans('general.subprogram');
        $this->modelSearch = BudgetGeneralExpensesStructure::find($id);
        self::chargeCreate();
    }

    public function updateActivity(int $id)
    {
        $this->reset(['modelSearch','nameAdd','nameProgram','parentId','nameSubProgram']);
        $this->viewAdd = true;
        $this->nameAdd = trans('general.activity');
        $this->modelSearch = BudgetGeneralExpensesStructure::find($id);
        $this->nameSubProgram = BudgetGeneralExpensesStructure::find($id)->parent->name;
        self::chargeCreate();
    }

    public function deleteProgram(int $id)
    {
        $response = $this->ajaxDispatch(new DeleteBudgetExpensesGeneral($id));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => __('budget.expense')]))->success()->livewire($this);
            $this->reset(
                [
                    'parentId',
                    'viewAdd'
                ]
            );
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

    public function chargeCreate()
    {
        $this->dataCreate =
            [
                'parentId' => $this->parentId,
                'nameProgram' => $this->nameProgram,
                'nameSubProgram' => $this->nameSubProgram,
                'nameAdd' => $this->nameAdd,
                'modelSearch' => $this->modelSearch,
            ];
        $this->emit('chargeInformation',$this->dataCreate);
        $this->dispatchBrowserEvent('loadAreas');
    }

    public function itemCreated()
    {
        $this->reset(
            [
                'parentId',
                'viewAdd',
            ]
        );
        $this->emitSelf('refreshComponent');
    }
}
