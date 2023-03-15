<?php

namespace App\Jobs\Admin;

use App\Abstracts\Job;
use App\Models\Admin\Company;

class DeleteCompany extends Job
{
    protected Company $company;

    /**
     * Create a new job instance.
     *
     * @param $company
     */
    public function __construct($company)
    {
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle(): bool
    {
        Company::destroy($this->company->id);
        return true;
    }
}