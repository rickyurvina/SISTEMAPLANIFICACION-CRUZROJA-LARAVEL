<?php

namespace App\Http\Livewire\Budget\Commitments;

use App\Models\Budget\Account;
use App\Models\Budget\Transaction;
use App\Models\Poa\PoaActivity;
use App\Models\Projects\Activities\Task;
use App\States\Transaction\Approved;
use App\States\Transaction\Rejected;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowCommitment extends Component
{

    public $transaction;
    public $viewProjectActivity = false;
    public $viewPoaActivity = false;
    public $poaActivity;
    public $projectActivity;
    public $expensesPoa;
    public $expensesProject;
    public string $description = '';
    public array $commitmentsValues = [];
    public $certification;
    public $canApprove = true;

    protected $listeners = ['loadTransaction'];

    public function mount(Transaction $certification)
    {
        $this->certification = $certification;
    }

    public function loadTransaction(int $id)
    {
        $this->transaction = Transaction::find($id);
        $account = $this->transaction->transactions->first()->account;
        if (isset($account->accountable->program)) {
            $this->poaActivity = PoaActivity::find($account->accountable_id);
            $this->description = $this->transaction->description;
            $this->viewPoaActivity = true;
            self::loadPoaActivity($this->poaActivity->id);
        } else {
            $this->projectActivity = Task::find($account->accountable_id);
            $this->description = $this->transaction->description;
            $this->viewProjectActivity = true;
            self::loadProjectActivity($this->projectActivity->id);
        }
    }

    public function render()
    {
        return view('livewire.budget.commitments.show-commitment');
    }

    public function resetForm()
    {
        $this->reset(
            [
                'transaction',
                'viewProjectActivity',
                'viewPoaActivity',
                'poaActivity',
                'projectActivity',
                'expensesPoa',
                'expensesProject',
                'description',
                'commitmentsValues',
                'canApprove',
            ]);
        $this->emit('refreshCertifications');

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
            foreach ($this->expensesPoa as $account) {
                if ($account->getCertifiedValues($this->certification->id)->getAmount() < $this->transaction->expenseCommitments($account->id)->getAmount()) {
                    $this->canApprove = false;
                    break;
                }
            }
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
            foreach ($this->expensesProject as $account) {
                if ($account->getCertifiedValues($this->certification->id)->getAmount()  < $this->transaction->expenseCommitments($account->id)->getAmount()) {
                    $this->canApprove = false;
                    break;
                }
            }
            $this->viewProjectActivity = true;
        } else {
            flash('No tiene partidas asignadas')->warning()->livewire($this);
        }
    }

    public function approveCommitment()
    {
//        try {
//            DB::beginTransaction();
            $this->transaction->status = Approved::label();
            $this->transaction->approved_by = user()->id;
            $this->transaction->approved_date = now();
            $this->transaction->save();
            $this->resetForm();
            $this->emit('toggleShowCommitment');
//        } catch (\Exception $exception) {
//            flash('Error: ' . $exception->getMessage())->error()->livewire($this);
//            DB::rollBack();
//        }
    }

    public function declineCommitment()
    {
        try {
            DB::beginTransaction();
            $this->transaction->status = Rejected::label();
            $this->transaction->approved_by = user()->id;
            $this->transaction->approved_date = now();
            $this->transaction->save();
            $this->resetForm();
            $this->emit('toggleShowCommitment');
        } catch (\Exception $exception) {
            flash('Error: ' . $exception->getMessage())->error()->livewire($this);
            DB::rollBack();
        }
    }
}
