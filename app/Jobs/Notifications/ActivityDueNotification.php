<?php

namespace App\Jobs\Notifications;

use App\Abstracts\Job;
use Carbon\Carbon;

class ActivityDueNotification extends Job
{
    public $request;
    public Carbon $date;
    public $days;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($request,$date,$days)
    {
        $this->request = $this->getRequestInstance($request);
        $this->date=$date;
        $this->days=$days;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notificationArray = $this->request->notificationArray;
        $user = $this->request->user;
        $user->notifyAt(new \App\Notifications\ActivityDueNotification($notificationArray), $this->date->subDays($this->days));
    }
}
