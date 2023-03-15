<?php

namespace App\Events\Projects\Stakeholder;


use App\Models\Projects\Stakeholders\ProjectStakeholderActions;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActionStakeholderCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $action;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ProjectStakeholderActions $action)
    {
        //
        $this->action = $action;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
