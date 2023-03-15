<?php

namespace App\Models\Projects\Objectives;


use App\Abstracts\Model;
use App\Events\Projects\ProjectColorUpdated;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Project;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ProjectObjectives extends Model
{
    protected $table = 'prj_project_objectives';

    protected bool $tenantable = false;


    protected $fillable = ['code', 'name', 'description', 'prj_project_id', 'color'];

    public static function boot()
    {
        parent::boot();
        static::updated(function ($model) {
            event(new ProjectColorUpdated($model));
        });
        static::creating(function ($model) {
            $model->name = mb_strtoupper($model->name);
            $model->code = mb_strtoupper($model->code);
            $model->description = mb_strtoupper($model->description);
        });
        static::updating(function ($model) {
            $model->name = mb_strtoupper($model->name);
            $model->code = mb_strtoupper($model->code);
            $model->description = mb_strtoupper($model->description);
        });
    }


    public function project()
    {
        return $this->belongsTo(Project::class, 'prj_project_id');
    }

    public function indicators(): MorphMany
    {
        return $this->morphMany(Indicator::class, 'indicatorable');
    }

    public function results()
    {
        return $this->hasMany(Task::class, 'objective_id');
    }

    public function getProgressByResults()
    {
        try {
            $progressObjective = 0;
            if ($this) {
                foreach ($this->results as $result) {
                    $progressResult = 0;
                    foreach ($result->childrenTasks()->get() as $activity) {
                        $progressResult = 0;
                        $progressResult += $activity->progress * $activity->weight;
                    }
                    $progressObjective += $progressResult * $result->weight;
                }
                return number_format($progressObjective, 0);
            } else {
                return 0;
            }
        } catch (\Exception $exception) {
            throw new  \Exception($exception->getMessage());
        }
    }
}
