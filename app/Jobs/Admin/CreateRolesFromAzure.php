<?php

namespace App\Jobs\Admin;

use App\Abstracts\Job;
use App\Models\Auth\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateRolesFromAzure extends Job
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
        //
        $roles = $this->request->all();
        foreach ($roles as $index => $role) {
            $this->createRole($role);
        }
    }

    /**
     * @param $name
     * @return Role|\Spatie\Permission\Models\Role
     */
    public function createRole($name)
    {
        return Role::firstOrCreate([
            'name' => $name,
        ]);
    }
}
