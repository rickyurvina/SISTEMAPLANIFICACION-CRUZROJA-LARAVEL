<?php

namespace App\Models\Projects;

use App\Abstracts\Model;
use App\Models\Auth\User;

class ProjectRescheduling extends Model
{
    protected bool $tenantable = false;

    protected $table = 'prj_project_reschedulings';

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
            'prj_project_id',
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

    public function project()
    {
        return $this->belongsTo(Project::class, 'prj_project_id');
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
