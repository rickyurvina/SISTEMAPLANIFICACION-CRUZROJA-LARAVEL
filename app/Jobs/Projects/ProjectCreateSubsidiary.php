<?php

namespace App\Jobs\Projects;

use App\Abstracts\Job;
use App\Models\Common\Catalog;
use Exception;
use Illuminate\Support\Facades\DB;

class ProjectCreateSubsidiary extends Job
{
    protected $project;

    protected $subsidiaries;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subsidiaries, $project)
    {
        $this->subsidiaries = $subsidiaries;
        $this->project = $project;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $this->project->subsidiaries()->saveMany($this->subsidiaries);
            $this->project->refresh();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
