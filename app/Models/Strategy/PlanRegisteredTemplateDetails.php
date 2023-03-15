<?php

namespace App\Models\Strategy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\isNull;

class PlanRegisteredTemplateDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'plan_template_detail_id',
        'parent_id',
        'level',
        'order',
        'name',
        'indicators',
        'poa_indicators',
        'program',
        'articulations',
        'cre_objective',
        'company_id',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = mb_strtoupper($model->name);
        });
        static::updating(function ($model){
            $model->name = mb_strtoupper($model->name);
        });
    }

    protected $path = [];

    public function parent()
    {
        return $this->belongsTo($this, 'parent_id', 'plan_template_detail_id');
    }

    public function childs()
    {
        return $this->hasMany($this, 'parent_id', 'plan_template_detail_id');
    }

    public function planDetails()
    {
        return $this->hasMany(PlanDetail::class, 'plan_registered_template_detail_id');
    }

    public function hasPlanDetailChildIndicators()
    {
        foreach ($this->planDetails as $item) {
            if ($item->indicators->count() > 0) {
                return true;
            }
        }
        return false;
    }

    public function hasArticulations()
    {
        return $this->hasMany(PlanArticulations::class, 'plan_source_registered_template_id');
    }


    public function getPath($itemId, $planId, $planDetailId, $elementId = null)
    {
        $element = array();
        $totalElements = count($this->path);
        if (!$itemId) {
            $plan = Plan::with(['planRegisteredTemplateDetails'])->find($planId);
            $element['name'] = $plan->name;
            $element['link'] = route('plans.index');
            $element['first'] = 1;
            array_unshift($this->path, $element);
            if (!$planDetailId) {
                $planRegisteredTemplateDetail = $plan->planRegisteredTemplateDetails->where('parent_id', null)->first();
                $element['name'] = $planRegisteredTemplateDetail->name;
                $element['link'] = "";
                $element['first'] = 0;
//                array_push($this->path, $element);
            } else {
                $planRegisteredTemplateDetail = PlanRegisteredTemplateDetails::find($planDetailId);
            }

        } else {
            $planRegisteredTemplateDetail = PlanRegisteredTemplateDetails::find($itemId);
            if ($planRegisteredTemplateDetail->level != 1) {
                $planDetail = PlanDetail::find($elementId);
                $parent_id = $planDetail ? $planDetail->parent_id : NULL;

            } else {
                $parent_id = null;
            }
            $element['name'] = $planRegisteredTemplateDetail->name;
            if (!$totalElements) {
                $element['link'] = '';
                $parent_id = $elementId;
            } else {
                if ($planRegisteredTemplateDetail->level == 1) {
                    $element['link'] = route('plans.detail',
                        [
                            'plan' => $planId,
                            'level' => $planRegisteredTemplateDetail->level,
                            'planDetailId' => $parent_id,
                        ]);
                } else {
                    $element['link'] = route('plans.detail',
                        [
                            'plan' => $planRegisteredTemplateDetail->id,
                            'planDetailId' => $parent_id,
                            'detail' => $planRegisteredTemplateDetail->id
                        ]);
                }

            }
            $element['first'] = 0;
            array_unshift($this->path, $element);
            $auxPlanRegisteredTemplateDetail = PlanRegisteredTemplateDetails::where('plan_id', $planId)
                ->where('plan_template_detail_id', $planRegisteredTemplateDetail->parent_id)
                ->first();
            if ($auxPlanRegisteredTemplateDetail) {
                $this->getPath($auxPlanRegisteredTemplateDetail->id, $planId, $planDetail->id, $parent_id);
            } else {
                $this->getPath(null, $planId, isset($planDetail) ? $planDetail->id : null, $parent_id);
            }
        }
        return $this->path;
    }
}
