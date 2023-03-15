<?php

namespace App\Models\Projects;


use App\Abstracts\Model;
use App\Models\Auth\User;
use App\Models\Comment;
use App\Traits\LogToProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Plank\Mediable\Mediable;
use Spatie\Activitylog\Traits\LogsActivity;

class ProjectEvaluation extends Model
{
    use HasFactory, Mediable, LogsActivity, LogToProject;

    protected $table = 'prj_project_evaluations';

    const INITIAL_CONST = 'Inicial';
    const INTERMEDIATE_CONST = 'Intermedia';
    const FINAL_CONST = 'Final';

    const UNINITIATED = 'No Iniciada';
    const IN_PROCESS = 'En curso';
    const CANCELED = 'Cancelada';
    const SUSPENDED = 'Suspendida';
    const FINISHED = 'Finalizada';

    const EFFICIENCY = 'Eficiencia';
    const EFFICACY = 'Eficacia';
    const EFFECTIVENESS = 'Efectividad';
    const SUSTAINABILITY = 'Sostenibilidad';
    const RELEVANCE = 'Pertinencia';
    const QUALITY = 'Calidad';

    const VARIABLES =
        [
            self::EFFICIENCY,
            self::EFFICACY,
            self::EFFECTIVENESS,
            self::SUSTAINABILITY,
            self::RELEVANCE,
            self::QUALITY,
        ];

    const PHASES = [
        self::INITIAL_CONST,
        self::INTERMEDIATE_CONST,
        self::FINAL_CONST
    ];
    const STATES = [
        self::UNINITIATED,
        self::IN_PROCESS,
        self::CANCELED,
        self::SUSPENDED,
        self::FINISHED,
    ];
    const STATES_BG = [
        self::UNINITIATED => 'badge-warning',
        self::IN_PROCESS => 'badge-secondary',
        self::CANCELED => 'badge-primary',
        self::SUSPENDED => 'badge-info',
        self::FINISHED => 'badge-dark',
    ];
    const PHASES_BG = [
        self::INITIAL_CONST => 'badge-warning',
        self::INTERMEDIATE_CONST => 'badge-secondary',
        self::FINAL_CONST => 'badge-primary'
    ];

    protected $fillable =
        [
            'name',
            'variables',
            'methodology',
            'phase',
            'state',
            'resources',
            'systematization',
            'user_id',
            'company_id',
            'prj_project_id',
        ];

    protected $casts = [
        'variables' => 'array',
        'resources' => 'array',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = mb_strtoupper($model->name);
            $model->methodology = mb_strtoupper($model->methodology);
            $model->systematization = mb_strtoupper($model->systematization);
        });
        static::updating(function ($model) {
            $model->name = mb_strtoupper($model->name);
            $model->methodology = mb_strtoupper($model->methodology);
            $model->systematization = mb_strtoupper($model->systematization);
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'prj_project_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->withoutGlobalScope(\App\Scopes\Company::class);
    }
}
