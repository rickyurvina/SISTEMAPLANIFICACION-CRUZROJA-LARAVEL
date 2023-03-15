<?php

namespace App\Jobs\Projects;

use App\Abstracts\Job;
use App\Models\Common\CatalogPurchase;
use Exception;
use Illuminate\Support\Facades\DB;

class ProjectCreateShoppingJob extends Job
{

    protected $purchase;
    protected $request;

    /**
     * Create a new job instance.
     *
     * @param $request ;
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
        try {
            DB::beginTransaction();
            $this->purchase = CatalogPurchase::create($this->request->all());
            DB::commit();
            return $this->purchase;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
