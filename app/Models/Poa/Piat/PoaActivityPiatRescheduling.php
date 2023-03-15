<?php

namespace App\Models\Poa\Piat;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStates\HasStates;
use function App\Models\Poa\mb_strtoupper;

class PoaActivityPiatRescheduling extends Model
{
    use HasFactory, HasStates, SoftDeletes;

    protected $table = 'poa_activity_piat_reschedulings';

    /**
     * Fillable fields.
     *
     * @var string[]
     */
    protected $fillable = [
        'poa_activity_piat_id',
        'description',
        'status',
        'user_id',
        'approved_by',
    ];

    const STATUS_APPROVED = 'Aprobado';
    const STATUS_DENIED = 'Rechazado';
    const STATUS_OPENED = 'Abierta';

    const STATUSES_BG = [
        self::STATUS_APPROVED => 'badge-success',
        self::STATUS_DENIED => 'badge-warning',
        self::STATUS_OPENED => 'badge-primary',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->description = \mb_strtoupper($model->description);
        });
        static::updating(function ($model) {
            $model->description = \mb_strtoupper($model->description);
        });
    }

    public function poaActivityPiat()
    {
        return $this->belongsTo(PoaActivityPiat::class, 'poa_activity_piat_id');
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
