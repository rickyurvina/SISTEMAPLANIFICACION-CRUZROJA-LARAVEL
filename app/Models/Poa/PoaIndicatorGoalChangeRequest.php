<?php

namespace App\Models\Poa;

use App\Models\Auth\User;
use App\Models\Measure\MeasureAdvances;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Plank\Mediable\Mediable;

class PoaIndicatorGoalChangeRequest extends Model
{
    use Mediable;

    const STATUS_OPEN = 'ABIERTO';
    const STATUS_APPROVED = 'APROBADO';
    const STATUS_DENIED = 'NEGADO';

    const STATUS_BG = [
        self::STATUS_OPEN => 'badge-info',
        self::STATUS_APPROVED => 'badge-success',
        self::STATUS_DENIED => 'badge-danger',
    ];

    protected $table = 'poa_indicator_goal_change_requests';

    /**
     * Fillable fields.
     *
     * @var string[]
     */
    protected $fillable = [
        'old_value',
        'new_value',
        'request_justification',
        'answer_justification',
        'request_user',
        'answer_user',
        'status',
        'request_number',
        'measure_advance_id',
        'period',
        'poa_activity_id',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->request_justification = strtoupper($model->request_justification);
            $model->answer_justification = strtoupper($model->answer_justification);
        });
        static::updating(function ($model){
            $model->request_justification = strtoupper($model->request_justification);
            $model->answer_justification = strtoupper($model->answer_justification);
        });
    }

    public function requestUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'request_user');
    }

    public function measureAdvance():HasMany
    {
        return $this->hasMany(MeasureAdvances::class,'measure_advance_id');
    }

    public function answerUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'answer_user');
    }

    public function poaActivity(): BelongsTo
    {
        return $this->belongsTo(PoaActivity::class,'poa_activity_id');
    }
}
