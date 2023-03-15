<?php

namespace App\Models\Projects\Stakeholders;

use App\Abstracts\Model;
use App\Models\Auth\User;
use App\Models\Projects\Project;
use App\Traits\LogToProject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Plank\Mediable\Mediable;
use Spatie\Activitylog\Traits\LogsActivity;

class ProjectStakeholder extends Model
{
    use Mediable, LogsActivity, LogToProject;

    protected bool $tenantable = false;

    const UPDATED = 'La articulación fue actualizada';
    const CREATED = 'La articulación fue creada';
    const DELETED = 'La articulación fue eliminada';

    const LOW = "bajo";
    const HIGH = "alto";

    const KEEP_SATISFIED = "Mantener satisfecho";
    const MANAGE_CAREFULLY = "Gestionar Atentamente";
    const MONITOR = "Monitorear";
    const KEEP_INFORMED = "Mantener Informado";

    const PENDING = "pendiente";
    const IN_PROGRESS = "en_cruso";
    const COMPLETED = "completado";

    const URGENT = "urgente";
    const IMPORTANT = "importante";
    const HALF = "media";

    const DAILY = "diario";
    const WEEKLY = "semanal";
    const MONTHLY = "mensual";

    const OPEN = 'abierto';
    const CLOSED = 'cerrado';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prj_project_stakeholders';

    protected $fillable = [
        'user_id',
        'prj_project_id',
        'priority',
        'description',
        'frequency',
        'interest_level',
        'influence_level',
        'positive_impact',
        'negative_impact',
        'strategy',
    ];

    public static function boot()
    {
        parent::boot();
        static::deleted(function ($model) {
            $model->actions->each->delete();
        });
        static::creating(function ($model) {
            $model->description = mb_strtoupper($model->description);
            $model->positive_impact = mb_strtoupper($model->positive_impact);
            $model->negative_impact = mb_strtoupper($model->negative_impact);
        });
        static::updating(function ($model) {
            $model->description = mb_strtoupper($model->description);
            $model->positive_impact = mb_strtoupper($model->positive_impact);
            $model->negative_impact = mb_strtoupper($model->negative_impact);
        });
    }

    /**
     * Obtener las acciones del stakeholder
     *
     * @return HasMany
     */
    public function actions(): HasMany
    {
        return $this->hasMany(ProjectStakeholderActions::class, 'prj_project_stakeholder_id');
    }

    /**
     * Obtiene el proyecto al que pertenece
     *
     * @return BelongsTo
     */
    public function interested(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtener las acciones del stakeholder
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'prj_project_id');
    }

    public function communications()
    {
        return $this->hasMany(ProjectCommunicationMatrix::class, 'prj_project_stakeholder_id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        switch ($eventName) {
            case 'updated':
                return ProjectStakeholder::UPDATED;
                break;
            case 'created':
                return ProjectStakeholder::CREATED;
                break;
            case 'deleted':
                return ProjectStakeholder::DELETED;
                break;
        }
    }

    public function isMemberOfTask()
    {
        $actions = $this->actions;
        $isMemeber = false;
        foreach ($actions as $action) {
            if ($action->user_id == user()->id)
                $isMemeber = true;
        }
        return $isMemeber;
    }
}
