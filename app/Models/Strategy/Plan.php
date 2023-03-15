<?php

namespace App\Models\Strategy;

use App\Abstracts\Model;
use App\Events\Strategy\PlanDetailCreated;
use App\Models\Auth\User;
use App\Traits\HasScore;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Plank\Mediable\Mediable;

/**
 * @method static Builder|PLan collect($sort = 'name')
 * @property Collection|array $planRegisteredTemplateDetails
 * @property Collection|array $planDetails;
 * @property int $id;
 */
class Plan extends Model
{
    use  SoftCascadeTrait, Mediable, HasScore;

    const DRAFT = "draft";
    const ACTIVE = "active";
    const ARCHIVED = "archived";
    const TYPE_STRATEGY = "ESTRATEGIA CRE";

    /**
     * Fillable fields.
     *
     * @var string[]
     */
    protected $fillable = [
        'plan_template_id',
        'code',
        'name',
        'description',
        'plan_type',
        'showVision',
        'vision',
        'showMission',
        'mission',
        'showTemporality',
        'temporality_start',
        'temporality_end',
        'responsable',
        'company_id',
        'status',
    ];

    protected bool $tenantable = false;

    /**
     * Sortable columns.
     *
     * @var array
     */
    public $sortable = ['name', 'description'];

    protected $dispatchesEvents = [
        'created' => PlanDetailCreated::class
    ];

    /**
     * Plan details soft cascading delete
     *
     * @var string[]
     */
    protected $softCascade = ['planDetails'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = mb_strtoupper($model->name);
            $model->description = mb_strtoupper($model->description);
            $model->vision = mb_strtoupper($model->vision);
            $model->mission = mb_strtoupper($model->mission);
        });
        static::updating(function ($model) {
            $model->name = mb_strtoupper($model->name);
            $model->description = mb_strtoupper($model->description);
            $model->vision = mb_strtoupper($model->vision);
            $model->mission = mb_strtoupper($model->mission);
        });
    }

    /**
     * Plan template reference
     *
     * @return BelongsTo
     */
    public function planTemplate(): BelongsTo
    {
        return $this->belongsTo(PlanTemplate::class);
    }

    /**
     * Plan detail elements
     *
     * @return HasMany
     */
    public function planDetails(): HasMany
    {
        return $this->hasMany(PlanDetail::class, 'plan_id');
    }

    public function children()
    {
        return $this->planDetails()->whereNull('parent_id');
    }

    /**
     * Plan detail elements
     *
     * @return HasMany
     */
    public function planRegisteredTemplateDetails(): HasMany
    {
        return $this->hasMany(PlanRegisteredTemplateDetails::class, 'plan_id');
    }

    public function getPlanStrategic($id)
    {
        return $this->where('plan_template_id', $id)->first();
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsable');
    }


    public function canBeRelated()
    {
        $result = false;
        foreach ($this->planRegisteredTemplateDetails as $item) {
            if ($item->articulations) {
                $result = true;
            }
        }
        return $result;
    }

    public function countChilds()
    {
        return $this->planDetails->where('parent_id', null)->count();
    }

    public function scopeInCompany($query): Builder
    {
        return $query->where('company_id', session('company_id'));
    }

    public function scopeType($query, $type): Builder
    {
        return $query->where('plan_type', $type);
    }

    public function scopeActive($query): Builder
    {
        return $query->where('status', self::ACTIVE);
    }
}
