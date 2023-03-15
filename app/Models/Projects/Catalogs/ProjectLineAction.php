<?php

namespace App\Models\Projects\Catalogs;


use App\Abstracts\Model;
use App\Models\Strategy\PlanDetail;
use Database\Factories\Projects\Catalogs\ProjectLineActionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Enumerable;

/**
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property HasMany $services
 * @method static Builder|ProjectLineAction collect($sort = 'name')
 * @method static ProjectLineAction find($id)
 * @method static ProjectLineAction create([] $attributes)
 * @method static findOrFail($id)
 * @method static Enumerable where($key, $operator = null, $value = null)
 */
class ProjectLineAction extends Model
{
    use HasFactory;

    protected bool $tenantable = false;

    protected $table = 'prj_project_catalog_line_actions';

    protected $fillable = ['id', 'code', 'name', 'description', 'plan_detail_id'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = mb_strtoupper($model->name);
            $model->code = mb_strtoupper($model->code);
            $model->description = mb_strtoupper($model->description);
        });
        static::updating(function ($model) {
            $model->name = mb_strtoupper($model->name);
            $model->code = mb_strtoupper($model->code);
            $model->description = mb_strtoupper($model->description);
        });
    }

    public function services(): HasMany
    {
        return $this->hasMany(ProjectLineActionService::class,
            'prj_project_catalog_line_actions_id');
    }

    public function program()
    {
        return $this->belongsTo(PlanDetail::class, 'plan_detail_id');
    }
}
