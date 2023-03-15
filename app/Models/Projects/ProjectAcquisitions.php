<?php

namespace App\Models\Projects;

use App\Abstracts\Model;
use App\Models\Common\CatalogDetail;
use App\Models\Common\CatalogPurchase;
use App\Traits\LogToProject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\Traits\LogsActivity;

class ProjectAcquisitions extends Model
{
    use LogsActivity, LogToProject;

    protected bool $tenantable = false;


    const UPDATED = 'La adquisción fue actualizada';
    const CREATED = 'La adquisción fue creada';
    const DELETED = 'La adquisción fue eliominada';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prj_project_acquisitions';

    protected $fillable = [
        'prj_project_id',
        'product_id',
        'description',
        'unit_id',
        'quantity',
        'price',
        'total_price',
        'type_id',
        'date',
    ];

    public static function boot()
    {
        parent::boot();
        /*static::deleted(function ($model) {
            $model->actions->each->delete();
        });*/
        static::creating(function ($model) {
            $model->description = mb_strtoupper($model->description);
        });
        static::updating(function ($model) {
            $model->description = mb_strtoupper($model->description);
        });
    }

    public function product(): HasOne
    {
        return $this->hasOne(CatalogPurchase::class, 'id', 'product_id');
    }

    public function unit(): HasOne
    {
        return $this->hasOne(CatalogDetail::class, 'id', 'unit_id');
    }

    public function mode(): HasOne
    {
        return $this->hasOne(CatalogDetail::class, 'id', 'type_id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        switch ($eventName) {
            case 'updated':
                return ProjectAcquisitions::UPDATED;
                break;
            case 'created':
                return ProjectAcquisitions::CREATED;
                break;
            case 'deleted':
                return ProjectAcquisitions::DELETED;
                break;
        }
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'prj_project_id');
    }
}
