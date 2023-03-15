<?php

namespace App\Events\MeasureAdvance;

use App\Models\Measure\MeasureAdvances;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MeasureAdvanceDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $measureAdvance;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MeasureAdvances $measureAdvance)
    {
        //
        $this->measureAdvance = $measureAdvance;
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
