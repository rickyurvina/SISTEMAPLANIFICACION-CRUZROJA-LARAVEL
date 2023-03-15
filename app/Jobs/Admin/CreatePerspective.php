<?php

namespace App\Jobs\Admin;

use App\Models\Admin\Perspective;
use App\Traits\Jobs;
use App\Abstracts\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CreatePerspective extends Job
{
    use Jobs;

    protected $request;
    protected $perspective;

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
        //
        try {
            DB::transaction(function () {
                $this->perspective = Perspective::create($this->request->all());
            });
            return $this->perspective;
        } catch (Throwable $e) {
            return $e;
        }
    }
}
