<?php

namespace App\Models\AdministrativeTasks;

use App\Abstracts\Model;
use App\Models\Auth\User;
use App\Models\Comment;
use App\Models\Projects\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Plank\Mediable\Mediable;

class AdministrativeTask extends Model
{
    use HasFactory,Mediable;

    const STATUS_PENDING = 'Pendiente';
    const STATUS_PROGRESS = 'En curso';
    const STATUS_FINISHED = 'Completada';
    const PRIORITY_IMPORTANT = 'Importante';
    const PRIORITY_LOW = 'Baja';
    const PRIORITY_MEDIUM = 'Media';
    const PRIORITY_URGENT = 'Urgente';

    const PRIORITIES = [
        self::PRIORITY_LOW,
        self::PRIORITY_MEDIUM,
        self::PRIORITY_IMPORTANT,
        self::PRIORITY_URGENT,
    ];
    const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_PROGRESS,
        self::STATUS_FINISHED,
    ];
    const PRIORITIES_BG = [
        self::PRIORITY_LOW => 'badge-primary',
        self::PRIORITY_MEDIUM => 'badge-secondary',
        self::PRIORITY_URGENT => 'badge-danger',
        self::PRIORITY_IMPORTANT => 'badge-warning',
    ];

    const STATUSES_BG = [
        self::STATUS_PENDING => 'badge-secondary',
        self::STATUS_PROGRESS => 'badge-warning',
        self::STATUS_FINISHED => 'badge-success',
    ];

    protected $fillable = [
        'name',
        'user_id',
        'project_id',
        'status',
        'type',
        'start_date',
        'end_date',
        'priority',
        'frequency',
        'description',
        'company_id',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = strtoupper($model->name);
            $model->description = strtoupper($model->description);
        });
        static::updating(function ($model){
            $model->name = strtoupper($model->name);
            $model->description = strtoupper($model->description);
        });
        static::deleted(function ($model) {
            $model->subTasks->each->delete();
        });
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function subTasks()
    {
        return $this->hasMany(AdministrativeSubTask::class, 'administrative_task_id')->orderBy('id', 'asc');
    }
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->withoutGlobalScope(\App\Scopes\Company::class);
    }
}
