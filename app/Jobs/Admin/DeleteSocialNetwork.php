<?php

namespace App\Jobs\Admin;

use App\Abstracts\Job;
use App\Models\Admin\SocialNetwork;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeleteSocialNetwork extends Job
{

    public $request;

    /**
     * Create a new job instance.
     *
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Throwable
     *
     */
    public function handle()
    {
        DB::transaction(function () {
            SocialNetwork::destroy($this->request->id);
        });
    }
}
