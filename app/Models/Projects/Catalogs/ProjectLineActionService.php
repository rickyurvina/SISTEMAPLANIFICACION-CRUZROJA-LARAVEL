<?php

namespace App\Models\Projects\Catalogs;

use App\Abstracts\Model;
use App\Models\Projects\Activities\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Enumerable;
use Plank\Mediable\Mediable;

/**
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $prj_project_catalog_line_actions_id
 * @property Builder|ProjectLineActionServiceActivity $lineActionActivities
 * @method static Builder|ProjectLineAction collect($sort = 'name')
 * @method static ProjectLineActionService find($id)
 * @method static ProjectLineActionService create([]$attributes)
 * @method static findOrFail($id)
 * @method static Enumerable where($key, $operator = null, $value = null)
 */
class ProjectLineActionService extends Model
{
    use HasFactory,Mediable;

    protected bool $tenantable = false;

    protected $table = 'prj_project_catalog_line_action_services';

    protected $fillable = ['code', 'name', 'description', 'prj_project_catalog_line_actions_id'];

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

    public function lineAction(): BelongsTo
    {
        return $this->belongsTo(ProjectLineAction::class,
            'prj_project_catalog_line_actions_id');
    }

    public function lineActionActivities(): HasMany
    {
        return $this->hasMany(ProjectLineActionServiceActivity::class,'service_id');
    }

    public function task()
    {
        return $this->morphOne(Task::class, 'taskable');
    }
}
