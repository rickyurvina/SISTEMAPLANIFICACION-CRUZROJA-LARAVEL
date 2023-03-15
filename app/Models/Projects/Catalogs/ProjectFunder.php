<?php

namespace App\Models\Projects\Catalogs;

use App\Abstracts\Model;
use App\Models\Projects\Project;

/**
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $type
 */
class ProjectFunder extends Model
{
    protected bool $tenantable = false;

    protected $fillable = ['code', 'name', 'type'];

    protected $table = 'prj_project_catalog_funders';

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = mb_strtoupper($model->name);
            $model->code = mb_strtoupper($model->code);
        });
        static::updating(function ($model) {
            $model->name = mb_strtoupper($model->name);
            $model->code = mb_strtoupper($model->code);
        });
    }

}
