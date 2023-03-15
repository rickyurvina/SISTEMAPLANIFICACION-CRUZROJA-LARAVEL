<?php

namespace App\Models\Projects;

use App\Abstracts\Model;
use App\Models\Admin\Company;
use App\Traits\LogToProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;

class ProjectMemberSubsidiary extends Model
{
    use HasFactory, LogsActivity, LogToProject;

    const UPDATED = 'El miembro subsidiario fue actualizado';
    const CREATED = 'El miembro subsidiario fue creado';
    const DELETED = 'El miembro subsidiario  fue eliminado';

    protected bool $tenantable = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prj_project_members_subsidiaries';


    protected $fillable = [
        'project_id',
        'company_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $tasks = $model->project->tasks->where('company_id',$model->company_id);
            $tasks->each->delete();
        });


    }


    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }


    public function getDescriptionForEvent(string $eventName): string
    {
        switch ($eventName) {
            case 'updated':
                return ProjectMemberSubsidiary::UPDATED;
                break;
            case 'created':
                return ProjectMemberSubsidiary::CREATED;
                break;
            case 'deleted':
                return ProjectMemberSubsidiary::DELETED;
                break;
        }
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
