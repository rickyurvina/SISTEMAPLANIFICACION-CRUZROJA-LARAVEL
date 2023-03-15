<?php

namespace App\Traits;

use App\Models\Projects\Project;
use App\Models\Vendor\Spatie\Activity;

trait LogToProject
{

    public function tapActivity(Activity $activity, $event)
    {
        $activity->category_type = Project::class;
        $activity->log_name=$event;
        if ($this->project) {
            $activity->category_id = $this->project->id;

        } else {
            $activity->category_id = $this->id;
        }
    }

}
