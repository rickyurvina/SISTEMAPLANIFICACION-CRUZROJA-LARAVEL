<?php

namespace App\Jobs\Process;

use App\Abstracts\Job;
use App\Models\Process\Process;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CreateProcessInputs extends Job
{

    public array $request;
    public $response;
    public $id;
    public $process;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request,$id)
    {
        $this->request=$request;
        $this->id=$id;
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
            $this->process = Process::find($this->id);
            $this->response = $this->process->update(['inputs'=>$this->request]);
            DB::commit();
            return $this->response;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
