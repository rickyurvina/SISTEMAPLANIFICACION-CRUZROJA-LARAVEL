<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use Illuminate\Support\Facades\DB;


class DeletePoaActivityTemplate extends Job
{
    protected $poaActivityTemplate;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($poaActivityTemplate)
    {
        $this->poaActivityTemplate = $poaActivityTemplate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->poaActivityTemplate->delete();
        });

        return true;
    }
}
