<?php

namespace App\Jobs\Budgets\Incomes;

use App\Abstracts\Job;
use App\Models\Budget\Account;
use Exception;
use Illuminate\Support\Facades\DB;

class BudgetIncomeEdit extends Job
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
            $income = Account::find($this->request->id);
            $income->update($this->request->all());
            $transaction = $this->request->transaction;
            $transaction->debitUpdate($this->request->amount, $this->request->description, $this->request->transactionDetail->id);
            DB::commit();
            return $income;
        } catch (Exception $exception) {
            DB::rollback();
            throw new Exception($exception->getMessage());
        }
    }
}
