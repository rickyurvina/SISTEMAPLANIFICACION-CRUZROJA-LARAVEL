<?php

namespace App\Jobs\Budgets\Expenses;

use App\Abstracts\Job;
use App\Models\Budget\Account;
use App\Models\Budget\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class BudgetExpenseCreate extends Job
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
     * @return Account|Builder|Model
     * @throws \Throwable
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $transaction = $this->request->transaction;
            $expense = Account::query()->create($this->request->all());
            $transaction->credit($this->request->amount, $this->request->description, $expense->id);
            DB::commit();
            return $transaction;
        } catch (Exception $exception) {
            DB::rollback();
            throw new Exception($exception->getMessage());
        }
    }
}
