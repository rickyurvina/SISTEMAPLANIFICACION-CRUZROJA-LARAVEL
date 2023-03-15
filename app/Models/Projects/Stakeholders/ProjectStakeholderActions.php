<?php

namespace App\Models\Projects\Stakeholders;

use App\Abstracts\Model;
use App\Events\Projects\Stakeholder\ActionStakeholderCreated;
use App\Models\Auth\User;
use App\Models\Projects\Activities\Task;
use App\Traits\LogToProject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class ProjectStakeholderActions extends Model
{
    use LogToProject, LogsActivity;

    protected bool $tenantable = false;

    const UPDATED = 'La acción de stakeholder fue actualizada';
    const CREATED = 'La acción de stakeholder fue creada';
    const DELETED = 'La acción de stakeholder fue eliminada';

    const OPEN = 'abierto';
    const CLOSED = 'cerrado';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prj_project_stakeholder_actions';


    protected $fillable = [
        'name',
        'prj_project_stakeholder_id',
        'start_date',
        'end_date',
        'frequency',
        'state',
        'user_id',
        'color',
        'task_id'
    ];

    public static function boot()
    {
        parent::boot();

        static::updated(function ($model) {
            if ($model->task) {
                $task = $model->task;
                $model->task->parent = $model->task_id;
                $model->task->text = $model->name;
                $model->task->save();
            }

        });

        static::deleted(function ($model) {
            if ($model->task) {
                $model->task->delete();
            }
        });

        static::created(function ($model) {
            ActionStakeholderCreated::dispatch($model);
        });
        static::creating(function ($model) {
            $model->name = mb_strtoupper($model->name);
        });
        static::updating(function ($model) {
            $model->name = mb_strtoupper($model->name);
        });
    }


    /**
     * Obtener el stackholder al que pertenece
     *
     * @return BelongsTo
     */
    public function stakeholder(): BelongsTo
    {
        return $this->belongsTo(ProjectStakeholder::class, 'prj_project_stakeholder_id');
    }

    /**
     * Obtener el stackholder al que pertenece
     *
     * @return BelongsTo
     */
    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        switch ($eventName) {
            case 'updated':
                return ProjectStakeholderActions::UPDATED;
                break;
            case 'created':
                return ProjectStakeholderActions::CREATED;
                break;
            case 'deleted':
                return ProjectStakeholderActions::DELETED;
                break;
        }
    }

    public function task()
    {
        return $this->morphOne(Task::class, 'taskable');
    }

    public function result()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
