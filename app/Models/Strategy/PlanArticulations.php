<?php

namespace App\Models\Strategy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanArticulations extends Model
{
    use HasFactory;

    /**
     * Fillable fields.
     *
     * @var string[]
     */
    protected $fillable = [
        'plan_source_id',
        'plan_source_registered_template_id',
        'plan_source_detail_id',
        'plan_target_id',
        'plan_target_registered_template_id',
        'plan_target_detail_id',
    ];

    public function sourcePlanDetail(){
        return $this->belongsTo(PlanDetail::class, 'plan_source_detail_id');
    }

    public function sourcePlan(){
        return $this->belongsTo(Plan::class, 'plan_source_id');
    }
    public function targetPlan(){
        return $this->belongsTo(Plan::class, 'plan_target_id');
    }

    public function sourceRegisteredTemplate(){
        return $this->belongsTo(PlanRegisteredTemplateDetails::class, 'plan_source_registered_template_id');
    }
    public function targetRegisteredTemplate(){
        return $this->belongsTo(PlanRegisteredTemplateDetails::class, 'plan_target_registered_template_id');
    }

    public function targetPlanDetail(){
        return $this->belongsTo(PlanDetail::class, 'plan_target_detail_id');
    }
}
