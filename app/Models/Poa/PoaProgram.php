<?php

namespace App\Models\Poa;

use App\Abstracts\Model;
use App\Models\Strategy\PlanDetail;
use App\Scopes\Company;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PoaProgram extends Model
{

    /**
     * Fillable fields.
     *
     * @var string[]
     */
    protected $fillable = [
        'poa_id',
        'plan_detail_id',
        'weight',
        'color',
        'company_id',
    ];
    protected bool $tenantable=false;

    public static function boot()
    {
        parent::boot();
    }

    /**
     * POA Program plan detail
     *
     * @return BelongsTo
     */
    public function planDetail(): BelongsTo
    {
        return $this->belongsTo(PlanDetail::class,'plan_detail_id');
    }

    /**
     * POA Program POA
     *
     * @return BelongsTo
     */
    public function poa(): BelongsTo
    {
        return $this->belongsTo(Poa::class)->withoutGlobalScope(Company::class);
    }

    /**
     * POA Program activities
     *
     * @return HasMany
     */
    public function poaActivities()
    {
        return $this->hasMany(PoaActivity::class)->orderBy('measure_id')->orderBy('id')->withoutGlobalScope(Company::class);
    }

    public function calcProgress()
    {
        $activities = $this->activities;
        $progress = 0;
        foreach ($activities as $activity) {
            if ($activity->status != PoaActivity::STATUS_SCHEDULED) {
                $progress += $activity->poa_weight;
            }
        }
        if ($this->progress != $progress) {
            $this->progress = $progress;
            $this->save();
        }
        return $progress;
    }

    public function poaIndicatorConfigs(){
        return $this->hasMany(PoaIndicatorConfig::class,'program_id');
    }
}
