<?php

namespace App\Models\Projects;

use App\Abstracts\Model;
use App\Models\Common\CatalogDetail;
use App\Traits\LogToProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class ProjectBeneficiaries extends Model
{
    use HasFactory, LogsActivity, LogToProject;

    protected $table = 'prj_project_beneficiaries';

    const UPDATED = 'El beneficiario fue actualizado';
    const CREATED =  'El beneficiario fue creado';
    const DELETED = 'El beneficiario fue eliominado';

    protected $fillable = ['project_id', 'type_id', 'beneficiary_id', 'amount', 'company_id'];

    public function types(): BelongsTo
    {
        return $this->belongsTo(CatalogDetail::class, 'type_id');
    }

    public function beneficiaries(): BelongsTo
    {
        return $this->belongsTo(CatalogDetail::class, 'beneficiary_id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        switch ($eventName) {
            case 'updated':
                return ProjectBeneficiaries::UPDATED;
                break;
            case 'created':
                return ProjectBeneficiaries::CREATED;
                break;
            case 'deleted':
                return ProjectBeneficiaries::DELETED;
                break;
        }
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

}