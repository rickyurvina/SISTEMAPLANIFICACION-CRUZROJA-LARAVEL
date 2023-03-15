<?php

namespace App\Events\Risks;

use App\Models\Risk\RiskAction;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RiskCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $action;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(RiskAction $action)
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
