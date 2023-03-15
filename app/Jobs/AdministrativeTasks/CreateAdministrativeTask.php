<?php

namespace App\Jobs\AdministrativeTasks;

use App\Abstracts\Job;
use App\Models\AdministrativeTasks\AdministrativeSubTask;
use App\Models\AdministrativeTasks\AdministrativeTask;
use Illuminate\Support\Facades\DB;

class CreateAdministrativeTask extends Job
{
    protected $task;
    protected $request;
    public $subTasks;
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
            $this->task = AdministrativeTask::create($this->request->all());
            DB::commit();
            for($i=0; $i<=count($this->request->subTasks)-1;$i++){
                $data=[
                    'administrative_task_id'=>  $this->task->id,
                    'name'=>$this->request->subTasks[$i],
                    'status'=>\App\Models\AdministrativeTasks\AdministrativeSubTask::STATUS_PENDING,
                ];
                $responseSubTask=$this->ajaxDispatch(new \App\Jobs\AdministrativeTasks\CreateAdministrativeSubTask($data));
            }
            return $this->task;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
