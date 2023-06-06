<?php

namespace App\Listeners;

use App\Events\RoleCreated;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Microsoft\Graph\Graph;

class CreateRoleInAzure
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\RoleCreated $event
     * @return void
     */
    public function handle(RoleCreated $event)
    {
        //
        try {
            $graph = new Graph();

            $graph->setApiVersion("v1.0")->setAccessToken(user()->remember_token);
            $resource = env('AZURE_RESOURCE', '');
            $newRole = new Role();
            $newRole->displayName = $event->role->name;
            $newRole->description = $event->role->description;
            $uri = $resource . '/v1.0/applications' . '/';

            $userRoles = $graph->createRequest("GET", $uri)
                ->addHeaders(array("Content-Type" => "application/json"))
                ->execute();


        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
