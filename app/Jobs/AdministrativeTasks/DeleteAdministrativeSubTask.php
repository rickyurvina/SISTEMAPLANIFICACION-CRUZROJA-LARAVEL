<?php

namespace App\Jobs\AdministrativeTasks;

use App\Abstracts\Job;
use App\Models\AdministrativeTasks\AdministrativeSubTask;
use App\Traits\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class DeleteAdministrativeSubTask extends Job
{
    use Jobs;

    protected $request;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        //
        $this->request = $this->getRequestInstance($request);
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
            $task =AdministrativeSubTask::find($this->request->id);
            $task->delete();
            DB::commit();
            return $task;
        } catch (Exception $exception) {
            DB::rollback();
            throw new Exception($exception->getMessage());
        }
    }
}
