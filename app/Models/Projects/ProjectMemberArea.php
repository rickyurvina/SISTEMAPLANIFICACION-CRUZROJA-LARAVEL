<?php

namespace App\Models\Projects;

use App\Abstracts\Model;
use App\Models\Admin\Department;
use App\Traits\LogToProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class ProjectMemberArea extends Model
{
    use HasFactory, LogsActivity, LogToProject;

    protected bool $tenantable = false;

    const UPDATED = 'El área fue actualizada';
    const CREATED = 'El área fue creada';
    const DELETED = 'El área fue eliominada';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prj_project_members_areas';


    protected $fillable = [
        'project_id',
        'department_id',
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        switch ($eventName) {
            case 'updated':
                return ProjectMemberArea::UPDATED;
                break;
            case 'created':
                return ProjectMemberArea::CREATED;
                break;
            case 'deleted':
                return ProjectMemberArea::DELETED;
                break;
        }
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
