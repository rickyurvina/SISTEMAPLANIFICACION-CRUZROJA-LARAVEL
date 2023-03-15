<?php

namespace App\Models\Projects;

use App\Models\Projects\Activities\Task;
use Illuminate\Database\Eloquent\Model;

class ProjectReferentialBudget extends Model
{
    protected $table = 'prj_project_referential_budget';

    protected $fillable = ['name', 'funders_amount', 'amount', 'project_id', 'task_id'];

    protected $casts = ['funders_amount' => 'array'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = mb_strtoupper($model->name);
        });
        static::updating(function ($model) {
            $model->name = mb_strtoupper($model->name);
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function result()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
