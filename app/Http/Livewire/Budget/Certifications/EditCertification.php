<?php

namespace App\Http\Livewire\Budget\Certifications;

use App\Models\Budget\Account;
use App\Models\Budget\Transaction;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaActivity;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Project;
use App\States\Poa\Approved;
use Livewire\Component;

class EditCertification extends Component
{
    public $transaction;
    public $transactionPr;
    public $viewProjectActivity = false;
    public $viewPoaActivity = false;
    public $poaActivity;
    public $projectActivity;
    public $expensesPoa;
    public $expensesProject;
    public $transactionDetails;
    public string $description = '';
    public array $certificationsValues = [];

    protected $rules = [
        'description' => 'required',
    ];

    public function mount(Transaction $transaction)
    {
        $transaction->load(['transactions.account']);
        $this->transactionPr=Transaction::where('year',$transaction->year)->whereStatus(Approved::label())->first();
        $this->transaction = $transaction;
        $this->transactionDetails = $transaction->transactions;
        $account = $this->transaction->transactions->first()->account;
        if (isset($account->accountable->program)) {
            $this->poaActivity = PoaActivity::find($account->accountable_id);
            $this->description = $transaction->description;
            $this->viewPoaActivity = true;
            self::loadPoaActivity($this->poaActivity->id);
        } else {
            $this->projectActivity = Task::find($account->accountable_id);
            $this->description = $transaction->description;
            $this->viewProjectActivity = true;
            self::loadProjectActivity($this->projectActivity->id);
        }
        foreach ($this->transactionDetails as $item) {
            $this->certificationsValues[$item->account_id] = $item->debit->getAmount() / 100;
        }
    }

    public function render()
    {
        return view('livewire.budget.certifications.edit-certification');
    }

    public function loadPoaActivity(int $activityId)
    {
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

    public function updatedCertificationsValues()
    {
        foreach ($this->certificationsValues as $index => $item) {
            if ($this->expensesPoa) {
                $expense = $this->expensesPoa->find($index);
            } else {
                $expense = $this->expensesProject->find($index);
            }
            if ($expense->balanceDraft($this->transaction->status)->getAmount() / 100 < $item) {
                flash('El valor no puede ser mayor al valor por comprometer')->warning()->livewire($this);
                unset($this->certificationsValues[$index]);
            }
        }
    }

    public function saveCertification()
    {
        $this->validate();
        if (count($this->certificationsValues) === 0) {
            flash('No se han asignado valores a la certificación')->warning()->livewire($this);
        } else {
            foreach ($this->certificationsValues as $index => $item) {
                $transactionDetail = $this->transactionDetails->where('account_id', $index)->first();
                $this->transaction->debitUpdate($item, $this->description, $transactionDetail->id);
            }
            $this->transaction->description = $this->description;
            $this->transaction->save();
            flash('Guardado Exitosamente')->success();
            return redirect()->route('budgets.certifications', $this->transaction);
        }
    }
}
