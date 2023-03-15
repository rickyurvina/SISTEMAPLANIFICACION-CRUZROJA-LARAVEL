<?php

namespace App\Jobs\Budgets\Structure;

use App\Abstracts\Job;
use App\Models\Budget\BudgetItemIncome;
use App\Models\Budget\TransactionDetail;
use Exception;

class CreateBudgetIncome extends Job
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
           return TransactionDetail::create($this->request->all());
        }catch (Exception $exception){
            throw new Exception($exception->getMessage());
        }
    }
}
