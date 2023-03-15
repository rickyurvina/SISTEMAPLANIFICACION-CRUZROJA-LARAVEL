<?php

namespace App\Jobs\Notifications;

use App\Abstracts\Job;

class ActivityStarted extends Job
{
    protected $request;
    protected $start_date;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request,$start_date)
    {
        $this->request = $this->getRequestInstance($request);
        $this->start_date=$start_date;
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
        $user->notifyAt(new \App\Notifications\ActivityStarted($notificationArray), $this->start_date);

    }
}
