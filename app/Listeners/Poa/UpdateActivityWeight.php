<?php

namespace App\Listeners\Poa;

use App\Events\Poa\PoaActivityWeightChanged;
use App\Jobs\Poa\UpdatePoaActivityWeight;
use App\Traits\Jobs;

class UpdateActivityWeight
{
    use Jobs;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PoaActivityWeightChanged  $event
     * @return void
     */
    public function handle(PoaActivityWeightChanged $event)
    {
        $activity = $event->activity->load(['program.poa']);
        $data = [
            'cost' => $activity->cost,
            'impact' => $activity->impact,
            'complexity' => $activity->complexity
        ];
        $this->ajaxDispatch(new UpdatePoaActivityWeight($activity->id, $activity->program->poa->id, $data));
    }
}
