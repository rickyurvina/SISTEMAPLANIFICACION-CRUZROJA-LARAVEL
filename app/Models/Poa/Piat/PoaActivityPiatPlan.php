<?php

namespace App\Models\Poa\Piat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PoaActivityPiatPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'poa_activity_piat_plan';

    /**
     * Fillable fields.
     *
     * @var string[]
     */
    protected $fillable = [
        'id_poa_activity_piat',
        'task',
        'responsable',
        'date',
        'end_date',
        'initial_time',
        'end_time',
    ];
    protected $casts=[
        'date'=>'date:Y-m-d',
        'end_date'=>'date:Y-m-d',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->task = strtoupper($model->task);
        });
        static::updating(function ($model){
            $model->task = strtoupper($model->task);
        });
    }

    /**
     * PoaActivityPiatPlan poaActivities
     *
     * @return BelongsTo
     */
    public function poaActivityPiat(): BelongsTo
    {
        return $this->belongsTo(PoaActivityPiat::class, 'id_poa_activity_piat');
    }

    /**
     * PoaActivityPiatPlan responsable
     *
     * @return BelongsTo
     */
    public function responsible(): BelongsTo
    {
        return $this->belongsTo(PoaPiatActivityResponsibles::class, 'responsable');
    }

}
