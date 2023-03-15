<?php

namespace App\Models\Projects;


use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use App\Traits\LogToProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class ProjectArticulations extends Model
{
    use LogToProject, LogsActivity;
    /**
     * Fillable fields.
     *
     * @var string[]
     */
    const UPDATED = 'La articulación fue actualizada';
    const CREATED =  'La articulación fue creada';
    const DELETED = 'La articulación fue eliominada';
    protected $table = 'prj_project_articulations';
    protected $fillable = [
        'prj_project_id',
        'plan_target_id',
        'plan_target_registered_template_id',
        'plan_target_detail_id',
    ];

    public function sourceProject(){
        return $this->belongsTo(Project::class, 'prj_project_id');
    }

    public function targetPlan(){
        return $this->belongsTo(Plan::class, 'plan_target_id');
    }

    public function targetRegisteredTemplate(){
        return $this->belongsTo(PlanRegisteredTemplateDetails::class, 'plan_target_registered_template_id');
    }

    public function targetPlanDetail(){
        return $this->belongsTo(PlanDetail::class, 'plan_target_detail_id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        switch ($eventName) {
            case 'updated':
                return ProjectArticulations::UPDATED;
                break;
            case 'created':
                return ProjectArticulations::CREATED;
                break;
            case 'deleted':
                return ProjectArticulations::DELETED;
                break;
        }
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'prj_project_id');
    }
}
