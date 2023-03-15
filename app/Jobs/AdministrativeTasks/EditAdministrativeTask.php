<?php

namespace App\Jobs\AdministrativeTasks;

use App\Abstracts\Job;
use App\Models\AdministrativeTasks\AdministrativeTask;
use App\Traits\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class EditAdministrativeTask extends Job
{
    protected $task;
    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        //
        $this->request=$this->getRequestInstance($request);
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
            $this->task=AdministrativeTask::find($this->request->id);
            $this->task=$this->task->update($this->request->all());
            DB::commit();
            return $this->task;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
