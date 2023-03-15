<?php

namespace App\Events\Measure;

use App\Models\Measure\MeasureAdvances;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MeasureAdvanceUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $measureAdvamce;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MeasureAdvances $measureAdvance)
    {
        //
        $this->measureAdvamce = $measureAdvance;
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
