<?php

namespace App\Jobs\Process;

use App\Abstracts\Job;
use App\Models\Process\Process;
use Illuminate\Support\Facades\DB;

class DeleteProcess extends Job
{
    protected Process $process;

    /**
     * Create a new job instance.
     *
     * @param Process $process
     */
    public function __construct(Process $process)
    {
        $this->process = $process;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle(): bool
    {
        try {
            DB::beginTransaction();
            $result = Process::destroy($this->process->id);
            DB::commit();
            return $result;
        } catch (\Exception $exception) {
            DB::rollback();
            throw new \Exception($exception->getMessage());
        }

    }
}
