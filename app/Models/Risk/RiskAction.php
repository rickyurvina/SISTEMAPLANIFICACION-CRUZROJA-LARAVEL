<?php

namespace App\Models\Risk;

use App\Abstracts\Model;
use App\Events\Risks\RiskCreatedEvent;
use App\Models\Auth\User;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Project;

class RiskAction extends Model
{
    protected bool $tenantable = false;

    const OPEN = 'abierto';
    const CLOSED = 'cerrado';
    const TYPE_AVOID = 'EVITAR';
    const TYPE_PREVENT = 'PREVENIR';
    const TYPE_TRANSFER = 'TRANSFERIR';
    const TYPE_CONTINGENCY = 'CONTINGENCIA';

    const TYPES_BG = [
        self::TYPE_AVOID => 'badge-primary',
        self::TYPE_PREVENT => 'badge-secondary',
        self::TYPE_TRANSFER => 'badge-success',
        self::TYPE_CONTINGENCY => 'badge-warning'
    ];

    const TYPES = [
        self::TYPE_AVOID => self::TYPE_AVOID,
        self::TYPE_PREVENT => self::TYPE_PREVENT,
        self::TYPE_TRANSFER => self::TYPE_TRANSFER,
        self::TYPE_CONTINGENCY => self::TYPE_CONTINGENCY
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    protected $fillable =
        [
            'name',
            'start_date',
            'end_date',
            'state',
            'type',
            'color',
            'user_id',
            'risk_id',
            'task_id',
        ];

    public static function boot()
    {
        parent::boot();

        static::updated(function ($model) {
            if ($model->task) {
                $model->task->parent = $model->task_id;
                $model->task->text = $model->name;
                $model->task->start_date = $model->start_date;
                $model->task->end_date = $model->end_date;
                $model->task->color = $model->color;
                $model->task->save();
            }
        });

        static::created(function ($model) {
            if ($model->risk->riskable_type == Project::class) {
                RiskCreatedEvent::dispatch($model);
            }
        });
        static::creating(function ($model) {
            $model->name = mb_strtoupper($model->name);
        });
        static::updating(function ($model) {
            $model->name = mb_strtoupper($model->name);
        });
    }

    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }

    public function result()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function task()
    {
        return $this->morphOne(Task::class, 'taskable');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
