<?php

namespace App\Jobs\Budgets\Expenses;

use App\Abstracts\Job;
use App\Models\Budget\Structure\BudgetGeneralExpensesStructure;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class CreateBudgetExpensesGeneral extends Job
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
     * @throws Exception
     */
    public function handle()
    {
        //
        try {
            DB::beginTransaction();
            $transaction = $this->request->transaction;
            if ($this->request->id) {
                $budget = BudgetGeneralExpensesStructure::find($this->request->id);
                $budget->update($this->request->all());
            } else {
                BudgetGeneralExpensesStructure::query()->create($this->request->all());
            }
            DB::commit();
            return $transaction;
        } catch (Exception $exception) {
            DB::rollback();
            throw new Exception($exception->getMessage());
        }
    }
}
