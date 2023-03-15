<?php

namespace App\Models\Poa\Piat;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PoaMatrixReportAgreementCommitment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'poa_matrix_report_agreement_commitment';
   
    /**
     * Fillable fields.
     *
     * @var string[]
     */
    protected $fillable = [
        'id_poa_activity_piat_report',
        'description',
        'responsable',
    ];

    /**
     * Sortable columns.
     *
     * @var array
     */
    public $sortable = ['description', 'responsable'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->description = strtoupper($model->description);
        });
        static::updating(function ($model){
            $model->description = strtoupper($model->description);
        });
    }


    /**
     * PoaActivityPiatPlan poaActivities
     *
     * @return BelongsTo
     */
    public function poaActivityPiatReport()
    {
        return $this->belongsTo(PoaActivityPiatReport::class, 'id_poa_activity_piat_report');
    }

    /**
     * PoaActivityPiatPlan responsable
     *
     * @return BelongsTo
     */
    public function userResponsable()
    {
        return $this->belongsTo(User::class, 'responsable');
    }
}
