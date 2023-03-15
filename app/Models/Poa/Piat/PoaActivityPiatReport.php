<?php

namespace App\Models\Poa\Piat;

use App\Models\Auth\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;
use Spatie\ModelStates\HasStates;

class PoaActivityPiatReport extends Model
{
    use HasFactory, HasStates, SoftDeletes, Mediable;

    protected $table = 'poa_activity_piat_report';

    /**
     * Fillable fields.
     *
     * @var string[]
     */
    protected $fillable = [
        'id_poa_activity_piat',
        'accomplished',
        'description',
        'positive_evaluation',
        'evaluation_for_improvement',
        'date',
        'initial_time',
        'end_time',
        'created_by',
        'approved_by',
    ];

    /**
     * Sortable columns.
     *
     * @var array
     */
    public $sortable = ['accomplished', 'positive_evaluation', 'evaluation_for_improvement', 'created_by', 'approved_by'];

    /**
     * piat poaActivities
     *
     * @return BelongsTo
     */
    public function piat(): BelongsTo
    {
        return $this->belongsTo(PoaActivityPiat::class, 'id_poa_activity_piat');
    }

    /**
     * PoaActivityPiat responsableToCreate
     *
     * @return BelongsTo
     */
    public function responsableToCreate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * PoaActivityPiat responsableToApprove
     *
     * @return BelongsTo
     */
    public function responsableToApprove(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * PoaActivityPiat Report
     *
     * @return HasMany
     */
    public function poaMatrixReportAgreementCommitment(): HasMany
    {
        return $this->hasMany(PoaMatrixReportAgreementCommitment::class, 'id_poa_activity_piat_report');
    }

    /**
     * Many to Many relationship with Beneficiaries
     *
     * @return BelongsToMany
     */
    public function poaMatrixReportBeneficiaries(): BelongsToMany
    {
        return $this->belongsToMany(PoaMatrixReportBeneficiaries::class, 'matrix_beneficiary_matrix_report', 'matrix_report_id', 'matrix_beneficiary_id')
            ->withPivot('observations', 'belong_to_board', 'participation_initial_time', 'participation_end_time')
            ->withTimestamps();
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->withoutGlobalScope(\App\Scopes\Company::class);
    }

    public function beneficiariesMen()
    {
        return $this->poaMatrixReportBeneficiaries->where('gender', 'H')->count();
    }

    public function beneficiariesWomen()
    {
        return $this->poaMatrixReportBeneficiaries->where('gender', 'M')->count();
    }


    public function benficiiariesDisability()
    {
        return $this->poaMatrixReportBeneficiaries->where('disability', 'SI')->count();
    }

    public function groupAge(){
        $beneficiaries=$this->poaMatrixReportBeneficiaries;
        $ageLt6=$beneficiaries->whereBetween('age',[0,5])->count();
        $age6_12=$beneficiaries->whereBetween('age',[6,12])->count();
        $age13_17=$beneficiaries->whereBetween('age',[13,17])->count();
        $age18_29=$beneficiaries->whereBetween('age',[18,29])->count();
        $age30_39=$beneficiaries->whereBetween('age',[30,39])->count();
        $age40_49=$beneficiaries->whereBetween('age',[40,49])->count();
        $age50_59=$beneficiaries->whereBetween('age',[50,59])->count();
        $age60_69=$beneficiaries->whereBetween('age',[60,69])->count();
        $age70_79=$beneficiaries->whereBetween('age',[70,70])->count();
        $age80=$beneficiaries->whereBetween('age',[80,120])->count();
        return
            [
                '6'=>$ageLt6,
                '6_12'=>$age6_12,
                '13_17'=>$age13_17,
                '18_29'=>$age18_29,
                '30_39'=>$age30_39,
                '40_49'=>$age40_49,
                '50_59'=>$age50_59,
                '60_69'=>$age60_69,
                '70_79'=>$age70_79,
                '80'=>$age80,
            ];


    }

}
