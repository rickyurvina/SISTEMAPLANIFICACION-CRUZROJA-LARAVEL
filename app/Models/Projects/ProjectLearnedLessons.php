<?php

namespace App\Models\Projects;

use App\Abstracts\Model;
use App\Models\Auth\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Plank\Mediable\Mediable;

class ProjectLearnedLessons extends Model
{

    use Mediable;

    protected $table = 'prj_project_learned_lessons';

    const KNOWLEDGE_RESOURCE = 'Recursos';
    const KNOWLEDGE_INTERESTED = 'Interesados';
    const KNOWLEDGE_SCOPE = 'Alcance';
    const KNOWLEDGE_QUALITY = 'Calidad';
    const KNOWLEDGE_BUDGET = 'Presupuesto';
    const KNOWLEDGE_INTEGRATION = 'Integración';
    const KNOWLEDGE_TIME = 'Tiempo';
    const KNOWLEDGE_COMMUNICATION = 'Comunicación';
    const KNOWLEDGE_RISKS = 'Riesgos';
    const KNOWLEDGE_ACQUISITIONS = 'Adquisiciones';

    const KNOWLEDGE_AREAS = [
        self::KNOWLEDGE_RESOURCE,
        self::KNOWLEDGE_INTERESTED,
        self::KNOWLEDGE_SCOPE,
        self::KNOWLEDGE_QUALITY,
        self::KNOWLEDGE_BUDGET,
        self::KNOWLEDGE_INTEGRATION,
        self::KNOWLEDGE_TIME,
        self::KNOWLEDGE_COMMUNICATION,
        self::KNOWLEDGE_RISKS,
        self::KNOWLEDGE_ACQUISITIONS,
    ];

    const KNOWLEDGE_BG = [
        self::KNOWLEDGE_RESOURCE => 'badge-warning',
        self::KNOWLEDGE_INTERESTED => 'badge-info',
        self::KNOWLEDGE_SCOPE => 'badge-success',
        self::KNOWLEDGE_QUALITY => 'badge-dark',
        self::KNOWLEDGE_BUDGET => 'badge-secondary',
        self::KNOWLEDGE_INTEGRATION => 'badge-primary',
        self::KNOWLEDGE_TIME => 'badge-secondary',
        self::KNOWLEDGE_COMMUNICATION => 'badge-danger',
        self::KNOWLEDGE_RISKS => 'badge-light',
        self::KNOWLEDGE_ACQUISITIONS => 'badge-warning'
    ];

    protected $fillable =
        [
            'background',
            'causes',
            'learned_lesson',
            'corrective_lesson',
            'evidences',
            'recommendations',
            'user_id',
            'phase',
            'state',
            'type',
            'knowledge',
            'prj_project_id',
            'company_id',
        ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->background = mb_strtoupper($model->background);
            $model->causes = mb_strtoupper($model->causes);
            $model->learned_lesson = mb_strtoupper($model->learned_lesson);
            $model->corrective_lesson = mb_strtoupper($model->corrective_lesson);
            $model->evidences = mb_strtoupper($model->evidences);
            $model->recommendations = mb_strtoupper($model->recommendations);
        });
        static::updating(function ($model) {
            $model->background = mb_strtoupper($model->background);
            $model->causes = mb_strtoupper($model->causes);
            $model->learned_lesson = mb_strtoupper($model->learned_lesson);
            $model->corrective_lesson = mb_strtoupper($model->corrective_lesson);
            $model->evidences = mb_strtoupper($model->evidences);
            $model->recommendations = mb_strtoupper($model->recommendations);
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
