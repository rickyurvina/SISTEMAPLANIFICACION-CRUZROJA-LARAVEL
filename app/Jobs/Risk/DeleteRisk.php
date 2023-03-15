<?php

namespace App\Jobs\Risk;

use App\Abstracts\Job;
use App\Models\Risk\Risk;

class DeleteRisk extends Job
{

    protected Risk $risk;

    /**
     * Create a new job instance.
     *
     * @param $risk
     */
    public function __construct($risk)
    {
        $this->risk = $risk;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle(): bool
    {
        Risk::destroy($this->risk->id);
        return true;
    }
}
