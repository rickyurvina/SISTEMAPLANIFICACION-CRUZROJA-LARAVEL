<?php

namespace App\Jobs\Admin;

use App\Abstracts\Job;
use App\Models\Admin\Perspective;
use App\Traits\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdatePerspective extends Job
{
    use Jobs;

    protected $request;
    protected $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request,$id)
    {
        //
        $this->request = $this->getRequestInstance($request);
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
            DB::transaction(function () {
                $this->perspective = Perspective::find($this->id);
                $this->perspective->update($this->request->all());
            });
            return $this->perspective;
        } catch (Throwable $e) {
            return $e;
        }
    }
}
