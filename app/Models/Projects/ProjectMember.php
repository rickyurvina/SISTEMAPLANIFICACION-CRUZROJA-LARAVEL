<?php

namespace App\Models\Projects;

use App\Abstracts\Model;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Common\CatalogDetail;
use App\Models\Projects\Activities\Task;
use App\Traits\LogToProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Notifiable;
use SnoozeNotifiable;

class ProjectMember extends Model
{
    use HasFactory, LogsActivity, LogToProject;

    protected bool $tenantable = false;

    const UPDATED = 'El miembro fue actualizado';
    const CREATED = 'El miembro fue creado';
    const DELETED = 'El miembro fue eliminado';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prj_project_members';

    protected $fillable = [
        'role_id',
        'place_id',
        'responsibilities',
        'contribution',
        'project_id',
        'user_id'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->contribution = mb_strtoupper($model->contribution);
        });
        static::updating(function ($model) {
            $model->contribution = mb_strtoupper($model->contribution);
        });
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function place(): BelongsTo
    {
        return $this->belongsTo(CatalogDetail::class, 'place_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function canBeDeleted()
    {
        $task = Task::where('project_id', $this->project_id)->pluck('owner_id')->toArray();
        if (in_array($this->user->id, $task)) {
            return false;
        } else {
            return true;
        }
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        switch ($eventName) {
            case 'updated':
                return ProjectMember::UPDATED;
            case 'created':
                return ProjectMember::CREATED;
            case 'deleted':
                return ProjectMember::DELETED;
        }
        return ProjectMember::DELETED;
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

}
