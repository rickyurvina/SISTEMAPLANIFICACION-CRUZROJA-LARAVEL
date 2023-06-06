<?php

namespace App\Jobs\Strategy;

use App\Events\Measure\MeasureAdvanceUpdated;
use App\Models\Measure\MeasureAdvances;
use App\Models\Measure\Period;
use App\Models\Strategy\Plan;
use App\Scopes\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateScoresStrategy implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
            MeasureAdvanceUpdated::dispatch();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
