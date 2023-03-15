<?php

namespace App\Models\Projects\Catalogs;

use App\Abstracts\Model;
use App\Models\Projects\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 *
 */
class ProjectAssistant extends Model
{
    use HasFactory;

    protected bool $tenantable = false;

    protected $fillable = ['code', 'name'];

    protected $table = 'prj_project_catalog_assistants';

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
