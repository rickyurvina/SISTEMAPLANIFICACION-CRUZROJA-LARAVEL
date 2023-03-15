<?php

namespace App\Events\Indicators;

use App\Models\Indicators\GoalIndicator\GoalIndicators;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActualValueIndicatorUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public GoalIndicators $goal;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(GoalIndicators $goal)
    {
        //
        $this->goal=$goal;
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
