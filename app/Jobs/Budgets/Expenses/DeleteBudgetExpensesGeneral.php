<?php

namespace App\Jobs\Budgets\Expenses;

use App\Abstracts\Job;
use App\Models\Budget\Structure\BudgetGeneralExpensesStructure;
use Illuminate\Support\Facades\DB;
use Exception;

class DeleteBudgetExpensesGeneral extends Job
{
    protected $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $this->getRequestInstance($id);
    }

    /**
     * Execute the job.
     *
     * @return int
     * @throws Exception
     */
    public function handle()
    {

        try {
            DB::beginTransaction();
            $budget = BudgetGeneralExpensesStructure::destroy($this->id);
            DB::commit();
            return $budget;
        } catch (Exception $exception) {
            DB::rollback();
            throw new Exception($exception->getMessage());
        }
    }
}
