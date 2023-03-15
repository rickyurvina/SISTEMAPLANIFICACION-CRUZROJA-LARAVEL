<?php

namespace App\Jobs\Admin;

use App\Abstracts\Job;
use App\Models\Admin\Department;
use Throwable;

class CreateDepartment extends Job
{

    protected $request;
    protected $department;
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
     * @return Department
     * @throws Throwable
     *
     */
    public function handle() : Department
    {
        $this->department = Department::create($this->request->all());
        $this->department->programs()->sync($this->request['select2-dropdown-programs']);
        return $this->department;
    }
}
