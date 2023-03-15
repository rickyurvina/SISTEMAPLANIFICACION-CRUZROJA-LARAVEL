<?php

namespace App\Jobs\Admin;

use App\Abstracts\Job;
use App\Models\Admin\Department;

class UpdateDepartment extends Job
{
    public $request;
    public Department $department;

    /**
     * Create a new job instance.
     *
     * @param $request
     * @param $department
     */
    public function __construct($request, $department)
    {
        $this->department = $department;
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return Department
     */
    public function handle(): Department
    {
        $this->department->update($this->request->except(['select2-dropdown-programs']));
        $this->department->programs()->sync($this->request['select2-dropdown-programs']);
        return $this->department;
    }
}