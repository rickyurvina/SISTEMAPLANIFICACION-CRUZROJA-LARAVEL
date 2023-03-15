<?php

namespace App\Models\Poa\Piat;

use App\Models\Auth\User;
use App\Models\Comment;
use App\Models\Common\CatalogGeographicClassifier;
use App\Models\Poa\PoaActivity;
use App\States\Poa\Piat\ApprovedPiat;
use App\States\Poa\Piat\Confirmed;
use App\States\Poa\Piat\Pending;
use App\States\Poa\Piat\PiatState;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;
use Spatie\ModelStates\HasStates;

class PoaActivityPiat extends Model
{
    use HasStates, SoftDeletes, Mediable;

    const STATUS_PENDING = 'PENDIENTE';
    const STATUS_APPROVED = 'APROBADO';
    const STATUS_CONFIRMED = 'CONFIRMADO';

    const STATUSES = [
        Pending::class,
        ApprovedPiat::class,
        Confirmed::class,
    ];

    protected $table = 'poa_activity_piat';

    protected $casts = [
        'status' => PiatState::class,
    ];

    /**
     * Fillable fields.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'place',
        'date',
        'end_date',
        'initial_time',
        'end_time',
        'province',
        'canton',
        'parish',
        'number_male_respo',
        'number_female_respo',
        'males_beneficiaries',
        'females_beneficiaries',
        'males_volunteers',
        'females_volunteers',
        'goals',
        'status',
        'created_by',
        'approved_by',
        'is_terminated',
        'piatable_type',
        'piatable_id',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = strtoupper($model->name);
            $model->place = strtoupper($model->place);
            $model->goals = strtoupper($model->goals);
        });
        static::updating(function ($model) {
            $model->name = strtoupper($model->name);
            $model->place = strtoupper($model->place);
            $model->goals = strtoupper($model->goals);
        });
    }

    /**
     * @return MorphTo
     */
    public function piatable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Sortable columns.
     *
     * @var array
     */
    public $sortable = ['name', 'place', 'date', 'initial_time', 'province', 'canton', 'parish',
        'status', 'responsable_to_create', 'responsable_to_approve'];

    /**
     * Scope to only include active currencies.
     *
     * @param Builder $query
     *
     * @return Builder
     */


    public function scopeEnabled(Builder $query): Builder
    {
        return $query->whereIn('status', PoaActivityPiat::STATUSES);
    }

    /**
     * PoaActivityPiat responsableToCreate
     *
     * @return BelongsTo
     */
    public function responsableToCreate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * PoaActivityPiat responsableToApprove
     *
     * @return BelongsTo
     */
    public function responsableToApprove(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * PoaActivityPiat plans
     *
     * @return HasMany
     */
    public function poaActivityPiatPlan(): HasMany
    {
        return $this->hasMany(PoaActivityPiatPlan::class, 'id_poa_activity_piat');
    }

    /**
     * PoaActivityPiat requirements
     *
     * @return HasMany
     */
    public function poaActivityPiatRequirements(): HasMany
    {
        return $this->hasMany(PoaActivityPiatRequirements::class, 'id_poa_activity_piat');
    }

    public function statusChanges(): Collection
    {
        return $this->activities()->where([
            ['description', '=', 'updated'],
            ['properties->attributes->status', '!=', ''],
        ])->get();
    }

    public static function statusColor(string $status)
    {
        foreach (self::STATUSES as $st) {
            if ($st::$name == $status) {
                return $st::color();
            }
        }
        return '';
    }

    /**
     * @return HasMany
     */
    public function reschedulings(): HasMany
    {
        return $this->hasMany(PoaActivityPiatRescheduling::class, 'poa_activity_piat_id');
    }

    /**
     * @return HasMany
     */
    public function poaActivityReport(): HasMany
    {
        return $this->hasMany(PoaActivityPiatReport::class, 'id', 'id_poa_activity_piat');
    }

    /**
     * @return HasMany
     */
    public function poaPiatRequestsSivol(): HasMany
    {
        return $this->hasMany(PoaPiatRequestSivol::class, 'poa_activity_piat_id');
    }

    /**
     * @return HasMany
     */
    public function responsibles(): HasMany
    {
        return $this->hasMany(PoaPiatActivityResponsibles::class, 'poa_activity_piat_id');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->withoutGlobalScope(\App\Scopes\Company::class);
    }

    /**
     * @param $query
     * @return CatalogGeographicClassifier
     */
    public function location($query)
    {
        return CatalogGeographicClassifier::where('id', $query)->first();
    }

    /**
     * @return int
     */
    public function manResponsibles()
    {
        return $this->responsibles->where('gender', 'H')->count();
    }

    /**
     * @return int
     */
    public function womenResponsibles()
    {
        return $this->responsibles->where('gender', 'M')->count();
    }

    public function getTimeHours()//TODO VERIFICAR FUINCION PARA RESTAR LAS HORAS
    {
        return date($this->end_time)->diff(date($this->initial_time));
//        return abs($this->end_time - $this->initial_time);
    }

}
