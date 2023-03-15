<?php

namespace App\Models\Poa\Piat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use function App\Models\Poa\mb_strtoupper;

class PoaActivityPiatRequirements extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'poa_activity_piat_requirements';

    /**
     * Fillable fields.
     *
     * @var string[]
     */
    protected $fillable = [
        'id_poa_activity_piat',
        'description',
        'quantity',
        'approximate_cost',
        'responsable',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->description = \mb_strtoupper($model->description);
        });
        static::updating(function ($model){
            $model->description = \mb_strtoupper($model->description);
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
