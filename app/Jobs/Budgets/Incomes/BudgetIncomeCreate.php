<?php

namespace App\Jobs\Budgets\Incomes;

use App\Abstracts\Job;
use App\Models\Budget\Account;
use App\Models\Budget\Transaction;
use Illuminate\Support\Facades\DB;
use Exception;

class BudgetIncomeCreate extends Job
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
     * @return Account|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws Exception
     */
    public function handle()
    {

        try {
            DB::beginTransaction();
            $transaction = Transaction::query()->find($this->request->bdg_transaction_id);
            $income = Account::query()->create($this->request->all());
            $transaction->debit($this->request->amount, $this->request->description, $income->id);
            DB::commit();
            return $transaction;
        } catch (Exception $exception) {
            DB::rollback();
            throw new Exception($exception->getMessage());
        }
    }
}
