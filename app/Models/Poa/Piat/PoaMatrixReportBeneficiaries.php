<?php

namespace App\Models\Poa\Piat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PoaMatrixReportBeneficiaries extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'poa_matrix_report_beneficiaries';
    
    /**
     * Fillable fields.
     *
     * @var string[]
     */
    protected $fillable = [
        'names',
        'surnames',
        'sex',
        'gender',
        'identification',
        'identificaiton_card',
        'disability',
        'age',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->names = strtoupper($model->names);
            $model->surnames = strtoupper($model->surnames);
            $model->disability = strtoupper($model->disability);
        });
        static::updating(function ($model){
            $model->names = strtoupper($model->names);
            $model->surnames = strtoupper($model->surnames);
            $model->disability = strtoupper($model->disability);
        });
    }


    /**
     * Sortable columns.
     *
     * @var array
     */
    public $sortable = ['names', 'surnames', 'identificaiton_card', 'age'];

    /**
     * Many to Many relationship with PoaActivityPiatReport
     *
     * @return BelongsToMany
     */
    public function poaActivityPiatReport(): BelongsToMany
    {
        return $this->belongsToMany(PoaActivityPiatReport::class, 'matrix_beneficiary_matrix_report', 'matrix_report_id', 'matrix_beneficiary_id')
        ->withPivot('observations', 'belong_to_board', 'participation_initial_time', 'participation_end_time')
        ->withTimestamps();
    }
}
