<?php

namespace App\Jobs\Admin;

use App\Abstracts\Job;
use App\Models\Admin\Address;
use Illuminate\Support\Facades\DB;

class CreateAddress extends Job
{

    protected $request;
    protected $address;

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
     * @return Address
     * @throws Throwable
     */
    public function handle(): Address
    {
        DB::transaction(function () {
            $this->address = Address::create($this->request->all());
        });
        return $this->address;
    }
}