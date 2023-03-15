<?php

namespace App\Events\Indicators;

use App\Models\Indicators\Indicator\Indicator;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IndicatorUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $indicator;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Indicator $indicator)
    {
        //
        $this->indicator = $indicator;
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
