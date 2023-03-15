<?php

namespace App\Events\Measure;

use App\Models\Measure\Measure;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MeasureUpdated
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
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
