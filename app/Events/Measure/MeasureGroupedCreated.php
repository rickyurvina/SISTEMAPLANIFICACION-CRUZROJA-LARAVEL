<?php

namespace App\Events\Measure;

use App\Models\Measure\Measure;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MeasureGroupedCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $measure;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Measure $measure)
    {
        $this->measure = $measure;
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
