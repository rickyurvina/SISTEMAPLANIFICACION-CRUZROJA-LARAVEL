<?php

namespace App\Events\Projects;

use App\Models\Projects\Objectives\ProjectObjectives;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectColorUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $objective;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ProjectObjectives $objective)
    {
        //
        $this->objective=$objective;
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
