<?php

namespace App\Models\Projects\Catalogs;


use App\Models\Projects\Activities\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectServicesTasks extends Model
{

    protected $table='prj_tasks_services';

    public function services(){
        return $this->hasMany(ProjectLineActionService::class,'service_id');
    }

    public function tasks(){
        return $this->hasMany(Task::class,'task_id');
    }
}
