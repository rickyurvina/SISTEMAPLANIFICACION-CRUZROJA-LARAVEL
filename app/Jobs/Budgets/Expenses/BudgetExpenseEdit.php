<?php

namespace App\Jobs\Budgets\Expenses;

use App\Abstracts\Job;
use App\Models\Budget\Account;
use Illuminate\Support\Facades\DB;
use Exception;

class BudgetExpenseEdit extends Job
{

    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try {
            DB::beginTransaction();
            $expense = Account::find($this->request->id);
            $expense->update($this->request->all());
            $transaction = $this->request->transaction;
            $transactionDetail = $this->request->transactionDetail;
            $transaction->creditUpdate($this->request->amount, $this->request->description, $transactionDetail->id);
            DB::commit();
            return $expense;
        } catch (Exception $exception) {
            DB::rollback();
            throw new Exception($exception->getMessage());
        }
    }
}
