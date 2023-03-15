<?php

namespace App\Models\Projects\Catalogs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRiskClassification extends Model
{
    use HasFactory;

    protected $table = 'prj_project_catalog_risk_classification';

    protected $fillable = [
        'name',
    ];
}
