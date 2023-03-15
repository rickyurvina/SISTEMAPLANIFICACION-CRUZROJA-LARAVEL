<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use Illuminate\Support\Facades\DB;


class DeletePoaActivityPiat extends Job
{
    protected $poaActivityPiat;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($poaActivityPiat)
    {
        $this->poaActivityPiat = $poaActivityPiat;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->poaActivityPiat->poaActivityPiatPlan()->delete();
            $this->poaActivityPiat->poaActivityPiatRequirements()->delete();
            $this->poaActivityPiat->delete();
        });

        return true;
    }
}
