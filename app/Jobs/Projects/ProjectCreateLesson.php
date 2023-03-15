<?php

namespace App\Jobs\Projects;

use App\Abstracts\Job;
use App\Models\Projects\ProjectLearnedLessons;
use Illuminate\Support\Facades\DB;
use Exception;

class ProjectCreateLesson extends Job
{
    protected $lesson;
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
        try {
            DB::beginTransaction();
            $this->lesson = ProjectLearnedLessons::create($this->request->all());
            DB::commit();
            return $this->lesson;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
