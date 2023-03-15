<?php

namespace App\Listeners\Auth;

use App\Helpers\Date;
use App\Models\Auth\User;
use App\Models\Vendor\Spatie\Activity;
use Illuminate\Auth\Events\Login as ILogin;
use Illuminate\Support\MessageBag;

class Login
{

    /**
     * Handle the event.
     *
     * @param ILogin $event
     * @return void
     */
    public function handle(ILogin $event)
    {
        // Get first company
        $company = $event->user->companies()->enabled()->first();

        // Logout if no company assigned
        if (!$company) {
            app('App\Http\Controllers\Auth\LoginController')->logout();
            return;
        }

        // Set company id
        session(['company_id' => $company->id]);

        // Save user login time
        $event->user->last_logged_in_at = Date::now();

        $event->user->save();

        Activity::create(
            [
                'log_name'=>'login',
                'description'=>'Usuario Loggeado',
                'subject_type'=>'App\\Models\\Auth\\User',
                'subject_id'=>$event->user->id,
                'causer_type'=>'App\\Models\\Auth\\User',
                'causer_id'=>$event->user->id,
            ]
        );
    }
}
