<?php

namespace App\Models\Process;

use App\Abstracts\Model;
use App\Models\Auth\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Plank\Mediable\Mediable;

class NonConformitiesActions extends Model
{
    use Mediable;

    protected $table = 'processes_non_conformities_actions';

    protected bool $tenantable = false;

    const STATUS_OPEN='ABIERTO';
    const STATUS_CLOSED='CERRADO';

    const STATUES=
        [
            self::STATUS_OPEN=>self::STATUS_OPEN,
            self::STATUS_CLOSED=>self::STATUS_CLOSED,
        ];

    protected $fillable = [
        'name',
        'implantation_date',
        'status',
        'start_date',
        'end_date',
        'processes_non_conformities_id',
        'user_id',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->status = mb_strtoupper($model->status);
            $model->name = mb_strtoupper($model->name);
        });
        static::updating(function ($model) {
            $model->status = mb_strtoupper($model->status);
            $model->name = mb_strtoupper($model->name);
        });
    }

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'implantation_date' => 'date:Y-m-d',
    ];

    public function nonConformity()
    {
        return $this->belongsTo(NonConformities::class, 'processes_non_conformities_id');
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->withoutGlobalScope(\App\Scopes\Company::class);
    }
}
