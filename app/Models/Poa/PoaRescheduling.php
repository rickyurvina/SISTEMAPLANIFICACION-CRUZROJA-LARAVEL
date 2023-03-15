<?php

namespace App\Models\Poa;

use App\Abstracts\Model;
use App\Models\Auth\User;

class PoaRescheduling extends Model
{
    protected bool $tenantable = false;

    protected $table = 'poa_reschedulings';

    const STATUS_APPROVED = 'Aprobado';
    const STATUS_DENIED = 'Rechazado';
    const STATUS_OPENED = 'Abierta';

    const STATUSES_BG = [
        self::STATUS_APPROVED => 'badge-success',
        self::STATUS_DENIED => 'badge-warning',
        self::STATUS_OPENED => 'badge-primary',
    ];

    protected $fillable =
        [
            'description',
            'status',
            'state',
            'phase',
            'poa_id',
            'user_id',
            'approved_id',
        ];
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->description = mb_strtoupper($model->description);
        });
        static::updating(function ($model) {
            $model->description = mb_strtoupper($model->description);
        });
    }

    public function poa(){
        return $this->belongsTo(Poa::class, 'poa_id');
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_id');
    }
}
