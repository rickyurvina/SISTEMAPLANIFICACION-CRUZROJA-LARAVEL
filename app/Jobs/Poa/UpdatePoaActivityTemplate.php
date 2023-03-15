<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use App\Models\Poa\PoaActivityTemplate;
use DB;
// use Exception;
// use Throwable;

class UpdatePoaActivityTemplate extends Job
{

    protected $catalog;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @param  $catalog
     * @param  $request
     */
    public function __construct($catalog, $request)
    {
        $this->catalog = $catalog;
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return PoaActivityTemplate
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->catalog->update($this->request->input());
        });

        return $this->catalog;
    }
}