<?php

namespace App\Jobs\Admin;

use App\Abstracts\Job;
use App\Models\Auth\User;
use Illuminate\Support\Facades\DB;

class CreateContact extends Job
{
    protected $request;
    protected User $user;

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
     * @return Contact
     * @throws Throwable
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->user = User::create($this->request->all());
        });
        return $this->user;
    }
}