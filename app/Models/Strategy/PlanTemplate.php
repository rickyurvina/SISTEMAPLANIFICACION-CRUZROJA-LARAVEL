<?php

namespace App\Models\Strategy;

use App\Abstracts\Model;
use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanTemplate extends Model
{
    use HasFactory;

    const PLAN_STRATEGY_CRE = 'ESTRATEGIA CRE';
    const DRAFT = 'draft';
    const ACTIVE = 'active';
    const ARCHIVED = 'archived';

    protected $fillable = [
        'plan_type',
        'description',
        'vision',
        'mission',
        'temporality',
        'status',
        'company_id',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->plan_type = mb_strtoupper($model->plan_type);
            $model->description = mb_strtoupper($model->description);
            $model->vision = mb_strtoupper($model->vision);
            $model->mission = mb_strtoupper($model->mission);
        });
        static::updating(function ($model){
            $model->plan_type = mb_strtoupper($model->plan_type);
            $model->description = mb_strtoupper($model->description);
            $model->vision = mb_strtoupper($model->vision);
            $model->mission = mb_strtoupper($model->mission);
        });
    }

    protected bool $tenantable = false;


    /**
     * Obtener los detalles del plan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planTemplateDetails(): HasMany
    {
        return $this->hasMany(PlanTemplateDetails::class, 'plan_template_id');
    }

    /**
     * Active plan template scope
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '1');
    }

    public function getObjectives()
    {
        $objectives = array();
        if (!is_null(PlanTemplate::withoutGlobalScope(\App\Scopes\Company::class)->where('plan_type', PlanTemplate::PLAN_STRATEGY_CRE)->first())) {
            $plan = new Plan;
            $planTemplatesTypeStrategy = PlanTemplate::withoutGlobalScope(\App\Scopes\Company::class)->where('plan_type', PlanTemplate::PLAN_STRATEGY_CRE)->first();
            $plan = $plan->getPlanStrategic($planTemplatesTypeStrategy->id);
            $planDetails = $plan->planDetails();
            $planObjectives = $planDetails->where('level', 1)->get();
            foreach ($planObjectives as $index => $pd) {
                $objectives[$index] = $pd->name;
            }
        }
        return $objectives;
    }

}
