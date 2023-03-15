<?php

namespace App\Jobs\Admin;

use App\Abstracts\Job;
use App\Models\Admin\Department;

class DeleteDepartment extends Job
{
    protected Department $department;

    /**
     * Create a new job instance.
     *
     * @param $department
     */
    public function __construct($department)
    {
        $this->department = $department;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle(): bool
    {
        $this->department->programs()->detach();
        Department::destroy($this->department->id);
        return true;
    }
}
