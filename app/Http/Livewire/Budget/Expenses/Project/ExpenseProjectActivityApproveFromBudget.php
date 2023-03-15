<?php

namespace App\Http\Livewire\Budget\Expenses\Project;

use App;
use App\Models\Budget\Account;
use App\Models\Budget\Transaction;
use App\Models\Budget\TransactionDetail;
use App\Models\Projects\Activities\Task;
use App\States\TransactionDetails\Approved;
use App\States\TransactionDetails\Decline;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ExpenseProjectActivityApproveFromBudget extends Component
{
    public $transaction;
    public $account;
    public $activity;
    public $transactionDetail;
    public $class;
    public $terms = false;

    protected $listeners = ['loadApprove'];

    public function mount(int $transactionId, string $class)
    {
        $this->transaction = Transaction::find($transactionId);
        $this->class = $class;
    }

    public function loadApprove(int $accountId, int $activityId)
    {
        $this->account = Account::find($accountId);
        $this->activity = App::make($this->class)::find($activityId);

        $this->transactionDetail = TransactionDetail::where('account_id', $this->account->id)
            ->where('transaction_id', $this->transaction->id)->first();

    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('livewire.budget.expenses.project.expense-project-activity-approve-from-budget');
    }

    public function resetForm()
    {
        $this->reset(
            [
                'transactionDetail',
                'account',
                'activity',
                'terms',
                'terms',
            ]);

    }

    public function save(bool $approve)
    {
        $this->transactionDetail->loadMedia(['file']);
        $media = $this->transactionDetail->media;
        if (count($media) > 0) {
            if ($this->terms === true) {
                try {
                    DB::beginTransaction();
                    if ($approve) {
                        $this->transactionDetail->status = Approved::label();
                    } else {
                        $this->transactionDetail->status = Decline::label();
                    }
                    $this->transactionDetail->approved_by = user()->id;
                    $this->transactionDetail->save();
                    DB::commit();
                    flash(trans_choice('messages.success.approved', 0, ['type' => trans_choice('general.module_poa', 0)]))->success();
                    $this->emit('updateIndexBudget');
                    $this->emit('toggleExpenseApprove');
                    $this->resetForm();
                } catch (\Exception $exception) {
                    DB::rollback();
                    flash(trans_choice('messages.error.approve_permission_denied', 0, ['type' => trans_choice('general.module_poa', 0)]))->success();
                }
            }
        } else {
            flash('Para Pre Aprobar el presupuesto se debe subir al menos un archivo')->error()->livewire($this);

        }
    }
}
