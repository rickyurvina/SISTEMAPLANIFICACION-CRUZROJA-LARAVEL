<?php

namespace App\Models\Projects\Activities;

use App\Abstracts\Model;
use App\Models\Auth\User;
use App\Traits\LogToProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Plank\Mediable\Mediable;
use Spatie\Activitylog\Traits\LogsActivity;

class ActivityTask extends Model
{
    use Mediable;
    protected bool $tenantable = false;

    const STATE_OPEN='ABIERTO';
    const STATE_CLOSED='CERRADO';
    const STATUS_PROGRAMMED = 'PROGRAMADA';
    const STATUS_FINISHED = 'EJECUTADA';
    const STATUS_CANCELED = 'DESESTIMADA';

    const STATUSES_DD =
        [
            self::STATUS_PROGRAMMED => [
                'text' => self::STATUS_PROGRAMMED,
                'icon' => '',
                'style' => 'badge badge-info'
            ],
            self::STATUS_FINISHED => [
                'text' => self::STATUS_FINISHED,
                'icon' => '',
                'style' => 'badge badge-success'
            ],
            self::STATUS_CANCELED => [
                'text' => self::STATUS_CANCELED,
                'icon' => '',
                'style' => 'badge badge-danger'
            ],
        ];

    protected $fillable = [
        'code',
        'name',
        'prj_task_id',
        'status',
        'user_id',
        'state',
    ];

    protected $table = 'prj_task_activities';

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = mb_strtoupper($model->name);
            $model->code = mb_strtoupper($model->code);
            $model->state = mb_strtoupper($model->state);
            $model->status = mb_strtoupper($model->status);
        });
        static::updating(function ($model) {
            $model->name = mb_strtoupper($model->name);
            $model->code = mb_strtoupper($model->code);
            $model->state = mb_strtoupper($model->state);
            $model->status = mb_strtoupper($model->status);

        });
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'prj_task_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
