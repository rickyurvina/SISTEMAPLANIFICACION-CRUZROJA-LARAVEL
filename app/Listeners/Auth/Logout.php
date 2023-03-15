<?php

namespace App\Listeners\Auth;

use App\Models\Vendor\Spatie\Activity;
use Illuminate\Auth\Events\Logout as ILogout;

class Logout
{

    /**
     * Handle the event.
     *
     * @param ILogout $event
     * @return void
     */
    public function handle(ILogout $event)
    {
        Activity::create(
            [
                'log_name'=>'logout',
                'description'=>'Usuario Cerro Sesion',
                'subject_type'=>'App\\Models\\Auth\\User',
                'subject_id'=>$event->user->id,
                'causer_type'=>'App\\Models\\Auth\\User',
                'causer_id'=>$event->user->id,
            ]
        );
        session()->forget('company_id');
    }
}