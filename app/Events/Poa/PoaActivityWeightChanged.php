<?php

namespace App\Events\Poa;

use App\Models\Poa\PoaActivity;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PoaActivityWeightChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public PoaActivity $activity;

    /**
     * Create a new event instance.
     *
     * @param PoaActivity $activity
     */
    public function __construct(PoaActivity $activity)
    {
        //
        $this->activity = $activity;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PrivateChannel
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('channel-name');
    }
}
