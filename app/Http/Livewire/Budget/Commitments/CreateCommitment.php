<?php

namespace App\Http\Livewire\Budget\Commitments;

use App\Models\Budget\Account;
use App\Models\Budget\Transaction;
use App\Models\Poa\PoaActivity;
use App\Models\Projects\Activities\Task;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateCommitment extends Component
{
    public $transaction;
    public $certification;
    public $search = '';
    public $viewProjectActivity = false;
    public $viewPoaActivity = false;
    public $poaActivity;
    public $projectActivity;
    public $expensesPoa;
    public $expensesProject;
    public string $description = '';
    public array $commitmentsValues = [];
    public array $selectedProjects = [];

    protected $rules = [
        'description' => 'required',
        'commitmentsValues.*' => 'numeric|min:0'
    ];

    public function mount(Transaction $transaction)
    {
        $this->certification = $transaction;
        $activityId = $transaction->transactions->first()->account->accountable_id;
        if ($transaction->transactions->first()->account->accountable_type === Task::class) {
            self::loadProjectActivity($activityId);
        } else {
            self::loadPoaActivity($activityId);
        }
    }

    public function render()
    {
        return view('livewire.budget.commitments.create-commitment');
    }

    public function loadPoaActivity(int $activityId)
    {
        $this->poaActivity = PoaActivity::find($activityId);

        $expenses = Account::where([
                ['type', Account::TYPE_EXPENSE],
                ['accountable_id', $activityId],
                ['accountable_type', PoaActivity::class],
                ['year', $this->transaction->year],
            ]
        );
        if ($expenses->count() > 0) {
            $this->expensesPoa = $expenses->get();
            $this->viewPoaActivity = true;
        } else {
            flash('No tiene partidas asignadas')->warning()->livewire($this);
        }
    }

    public function loadProjectActivity(int $activityId)
    {
        $this->viewPoa = false;
        $this->viewPoaActivity = false;
        $this->projectActivity = Task::find($activityId);

        $expenses = Account::where([
                ['type', Account::TYPE_EXPENSE],
                ['accountable_id', $activityId],
                ['accountable_type', Task::class],
                ['year', $this->transaction->year],
            ]
        );

        if ($expenses->count() > 0) {
            $this->expensesProject = $expenses->get();
            $this->viewProjectActivity = true;
        } else {
            flash('No tiene partidas asignadas')->warning()->livewire($this);
        }
    }

    public function closeActivity()
    {
        $this->viewPoaActivity = false;
        $this->reset(['poaActivity']);
        $this->viewPoa = true;
    }

    public function saveCommitment()
    {
        $this->validate();
        if (count($this->commitmentsValues) === 0) {
            flash('No se han asignado valores al compromiso')->warning()->livewire($this);
        } else {
            try {
                DB::beginTransaction();
                self::updatedCommitmentsValues();
                $number = Transaction::query()->where([
                        ['year', '=', $this->transaction->year],
                        ['type', '=', Transaction::TYPE_COMMITMENT],
                    ])->max('number') + 1;
                $newTransaction = Transaction::create([
                    'year' => $this->transaction->year,
                    'description' => $this->description,
                    'type' => Transaction::TYPE_COMMITMENT,
                    'number' => $number,
                    'parent_id' => $this->certification->id,
                    'created_by' => user()->id,
                    'company_id' => session('company_id'),
                ]);
                foreach ($this->commitmentsValues as $index => $item) {
                    if ($this->expensesPoa) {
                        $expense = $this->expensesPoa->find($index);
                    } else {
                        $expense = $this->expensesProject->find($index);
                    }
                    $newTransaction->debit($item, $this->description, $expense->id);
                }
                flash('Guardado Exitosamente')->success();
                DB::commit();
                return redirect()->route('budgets.commitments', $this->certification);
            } catch (\Exception $exception) {
                flash($exception->getMessage())->error()->livewire($this);
                DB::rollBack();
            }
        }
    }

    public function updatedCommitmentsValues()
    {
        foreach ($this->commitmentsValues as $index => $item) {
            if ($this->expensesPoa) {
                $expense = $this->expensesPoa->find($index);
            } else {
                $expense = $this->expensesProject->find($index);
            }
            if ($expense->getCertifiedValues($this->certification->id)->getAmount() / 100 < $item) {
                flash('El valor no puede ser mayor al valor comprometido')->warning()->livewire($this);
                unset($this->commitmentsValues[$index]);
            }
        }
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedProjects = [];
    }

}
