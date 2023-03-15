<?php

namespace App\Models\AdministrativeTasks;

use App\Abstracts\Model;
use App\Models\Auth\User;



class AdministrativeSubTask extends Model
{
    const STATUS_PENDING = 'Pendiente';
    const STATUS_FINISHED = 'Completada';

    const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_FINISHED,
    ];
    protected $fillable = [
        'administrative_task_id',
        'name',
        'status',
        ];

    protected bool $tenantable=false;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = strtoupper($model->name);
        });
        static::updating(function ($model){
            $model->name = strtoupper($model->name);
        });
    }

    public function subtask(){
        return $this->belongsTo(AdministrativeTask::class,'administrative_task_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
