<?php

namespace App\Jobs\Admin;

use App\Abstracts\Job;
use App\Models\Admin\Perspective;
use App\Traits\Jobs;
use Illuminate\Support\Facades\DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeletePerspective extends Job
{
    use Jobs;

    protected $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $this->getRequestInstance($id);
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
            $perspective =Perspective::find($this->id);
            $perspective->delete();
            DB::commit();
            return $perspective;
        } catch (Exception $exception) {
            DB::rollback();
            throw new Exception($exception->getMessage());
        }
    }
}
