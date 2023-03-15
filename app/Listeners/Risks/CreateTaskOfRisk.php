<?php

namespace App\Listeners\Risks;

use App\Events\Menu\RiskCreated;
use App\Events\Risks\RiskCreatedEvent;
use App\Models\Projects\Activities\Task;
use App\Models\Risk\RiskAction;
use function session;

class CreateTaskOfRisk
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
     * @param RiskCreated $event
     * @return void
     */
    public function handle(RiskCreatedEvent $event)
    {
        $action = $event->action;
        $task = Task::find($event->action->task_id);
        $task2 = new Task();
        $code = self::generateCode($event);
        $task2->code = $code;
        $task2->text = $action->name;
        $task2->start_date = $action->start_date;
        $task2->end_date = $action->end_date;
        $task2->duration = 1;
        $task2->progress = 0;
        $task2->weight = 0;
        $task2->type = 'task';
        $task2->parent = $task->id;
        $task2->sortorder = Task::max("sortorder") + 1;
        $task2->project_id = $action->risk->riskable_id;
        $task2->company_id = session('company_id');
        $task2->taskable_id = $action->id;
        $task2->taskable_type = RiskAction::class;
        $task2->save();
    }


    public function generateCode($event)
    {
        $idAction = $event->action->id;
        $idRisk = $event->action->risk->id;
        return 'CRA' . $idAction . $idRisk;
    }
}
