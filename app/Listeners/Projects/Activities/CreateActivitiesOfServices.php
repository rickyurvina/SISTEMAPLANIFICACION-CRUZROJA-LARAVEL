<?php

namespace App\Listeners\Projects\Activities;

use App\Events\Projects\Activities\ServicesSelected;
use App\Listeners\ServiceSelected;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Catalogs\ProjectLineActionServiceActivity;
use Exception;
use Illuminate\Support\Facades\DB;
use function now;
use function session;

class CreateActivitiesOfServices
{
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
     * @param ServiceSelected $event
     * @return void
     */
    public function handle(ServicesSelected $event)
    {
        try {
            DB::beginTransaction();
            $result = $event->result;
            $resultsToDelete = Task::where('parent', $result->id)->get();
            if ($resultsToDelete->count() > 0) {
                $resultsToDelete->delete();
            }
            $servicesSelect = $event->servicesSelect;
            $activities = ProjectLineActionServiceActivity::whereIn('service_id', $servicesSelect)->get();
            foreach ($activities as $item) {
                $activity = new Task;
                $activity->text = $item->name;
                $activity->code =$result->code.$item->code;
                $activity->color = $item->color;
                $activity->start_date = now()->format('Y-m-d');
                $activity->end_date = now()->format('Y-m-d');
                $activity->duration = 4;
                $activity->type = 'task';
                $activity->progress = 0;
                $activity->parent = $result->id;
                $activity->sortorder = 1;
                $activity->weight = 0;
                $activity->project_id = $result->project->id;
                $activity->taskable_id = $item->id;
                $activity->taskable_type = ProjectLineActionServiceActivity::class;
                $activity->company_id = session('company_id');
                $activity->save();
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }

    }
}
