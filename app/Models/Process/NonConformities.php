<?php

namespace App\Models\Process;

use App\Abstracts\Model;
use App\Models\Auth\User;
use Plank\Mediable\Mediable;

class NonConformities extends Model
{
    use Mediable;

    protected $table = 'processes_non_conformities';

    protected bool $tenantable = false;

    protected $fillable = [
        'number',
        'code',
        'type',
        'closing_verification',
        'efficiency_verification',
        'process_id',
        'description',
        'date',
        'evidence',
        'causes',
        'state',
        'criteria',
        'verification_close_date',
        'verification_effectiveness_date',
        'raised_by',
        'user_id',
    ];

    protected $casts =
        [
            'causes' => 'array',
            'date' => 'date:Y-m-d',
            'verification_close_date' => 'date:Y-m-d',
            'verification_effectiveness_date' => 'date:Y-m-d',
        ];

    const TYPE_CORRECTIVE_ACTION = 'Acción Correctiva';
    const TYPE_IMPROVEMENT_OPPORTUNITY = 'Oportunidad de Mejora';

    const TYPE_OPEN = 'ABIERTO';
    const TYPE_CLOSED = 'CERRADO';
    const TYPE_CLOSED_PROCESS = 'PROCESO DE CIERRE';

    const TYPE_BG = [
        self::TYPE_OPEN => 'badge-info',
        self::TYPE_CLOSED => 'badge-secondary',
        self::TYPE_CLOSED_PROCESS => 'badge-warning',
    ];

    const TYPES = [
        self::TYPE_CORRECTIVE_ACTION => self::TYPE_CORRECTIVE_ACTION,
        self::TYPE_IMPROVEMENT_OPPORTUNITY => self::TYPE_IMPROVEMENT_OPPORTUNITY,
        self::TYPE_CLOSED_PROCESS => self::TYPE_CLOSED_PROCESS,
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->number = mb_strtoupper($model->number);
            $model->code = mb_strtoupper($model->code);
            $model->description = mb_strtoupper($model->description);
            $model->evidence = mb_strtoupper($model->evidence);
            $model->state = mb_strtoupper($model->state);
            $model->criteria = mb_strtoupper($model->criteria);
        });
        static::updating(function ($model) {
            $model->number = mb_strtoupper($model->number);
            $model->code = mb_strtoupper($model->code);
            $model->description = mb_strtoupper($model->description);
            $model->evidence = mb_strtoupper($model->evidence);
            $model->state = mb_strtoupper($model->state);
            $model->criteria = mb_strtoupper($model->criteria);
        });
    }

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id');
    }

    public function actions()
    {
        return $this->hasMany(NonConformitiesActions::class, 'processes_non_conformities_id')->orderBy('id', 'asc');
    }

    public function raisedBy()
    {
        return $this->belongsTo(User::class, 'raised_by');
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function canBeClosed()
    {
        $actions = $this->actions;
        if ($actions->count() > 0) {
            $result = true;
            foreach ($actions as $item) {
                if ($item->status== NonConformitiesActions::STATUS_CLOSED) {
                    $result = false;
                    break;
                }
            }
            return $result;
        } else {
            return true;
        }
    }
}
