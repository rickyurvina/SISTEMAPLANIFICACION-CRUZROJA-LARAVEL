<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use Illuminate\Support\Facades\DB;


class DeletePoa extends Job
{
    protected $poa;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($poa)
    {
        $this->poa = $poa;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        DB::transaction(function () {
            $this->poa->delete();
        });

        return true;
    }
}
