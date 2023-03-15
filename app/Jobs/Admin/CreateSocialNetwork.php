<?php

namespace App\Jobs\Admin;

use App\Abstracts\Job;
use App\Models\Admin\SocialNetwork;
use Illuminate\Support\Facades\DB;

class CreateSocialNetwork extends Job
{
    protected $request;
    protected $socialNetwork;

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
     * @return SocialNetwork
     * @throws Throwable
     */
    public function handle(): SocialNetwork
    {
        DB::transaction(function () {
            $this->socialNetwork = SocialNetwork::create($this->request->all());
        });
        return $this->socialNetwork;
    }
}