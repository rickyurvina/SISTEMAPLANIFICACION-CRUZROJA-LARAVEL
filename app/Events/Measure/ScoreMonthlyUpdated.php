<?php

namespace App\Events\Measure;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScoreMonthlyUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $item;

    public $periodId;

    /**
     * Create a new event instance.
     *
     * @param $item
     */
    public function __construct($item, $periodId)
    {
        $this->item = $item;
        $this->periodId = $periodId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
