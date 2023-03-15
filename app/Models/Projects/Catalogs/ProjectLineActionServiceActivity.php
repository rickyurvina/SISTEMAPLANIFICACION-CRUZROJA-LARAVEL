<?php

namespace App\Models\Projects\Catalogs;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Enumerable;

/**
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property int $service_id
 * @property ProjectLineActionService $service
 * @method static Builder|ProjectLineActionService collect($sort = 'name')
 * @method static ProjectLineActionServiceActivity find($id)
 * @method static ProjectLineActionServiceActivity create([]$attributes)
 * @method static findOrFail($id)
 * @method static Enumerable where($key, $operator = null, $value = null)
 */
class ProjectLineActionServiceActivity extends Model
{
    use HasFactory;

    protected bool $tenantable = false;

    protected $table = 'prj_project_catalog_line_action_service_activities';

    protected $fillable = ['code', 'name', 'description', 'service_id'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
                $model->code = mb_strtoupper($model->code);
                $model->name = mb_strtoupper($model->name);
                $model->description = mb_strtoupper($model->description);
            });
        static::updating(function ($model){
                $model->code = mb_strtoupper($model->code);
                $model->name = mb_strtoupper($model->name);
                $model->description = mb_strtoupper($model->description);
            });
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(ProjectLineActionService::class, 'service_id');
    }
}
