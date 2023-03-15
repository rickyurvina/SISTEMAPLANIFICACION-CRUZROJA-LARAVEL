<?php

namespace App\Models\Projects;


use App\Abstracts\Model;
use App\Models\Auth\User;

class ProjectStateValidations extends Model
{
    const STATUS_VALIDATED='Validado';
    const STATUS_NO_VALIDATED='No Validado';

    const STATUSES_BG = [
        self::STATUS_VALIDATED => 'badge-success',
        self::STATUS_NO_VALIDATED => 'badge-warning',
    ];

    protected $table = 'prj_state_validations';

    protected bool $tenantable = false;

    protected $fillable = ['state', 'status', 'validations', 'prj_project_id', 'user_id','settings'];

    protected $casts = [
        'validations' => 'array',
        'settings' => 'array',
    ];

    public function project(){
        return $this->belongsTo(Project::class,'prj_project_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

}
