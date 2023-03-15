<?php

namespace App\Models\Poa;

use App\Abstracts\Model;
use App\Models\Admin\Company;
use App\Models\Admin\Department;
use App\Models\Auth\User;
use App\Models\Comment;
use App\States\Poa\Approved;
use App\States\Poa\Closed;
use App\States\Poa\Execution;
use App\States\Poa\InProgress;
use App\States\Poa\Planning;
use App\States\Poa\PoaPhase;
use App\States\Poa\PoaState;
use App\States\Poa\Reviewed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Plank\Mediable\Mediable;
use Spatie\ModelStates\HasStates;

class Poa extends Model
{
    use Mediable, HasStates, HasFactory;

    const PHASE_PLANNING = 'PLANIFICACIÓN';
    const PHASE_EXECUTION = 'EJECUCIÓN';
    const PHASE_CLOSED = 'CERRADO';

    const STATUS_IN_PROCESS = 'EN PROCESO';
    const STATUS_REVIEWED = 'REVISADO';
    const STATUS_ACCEPTED = 'APROBADO';

    const STATUSES_PHASE_PLANNING = [
        self::STATUS_IN_PROCESS,
        self::STATUS_REVIEWED,
        self::STATUS_ACCEPTED
    ];
    const STATUS_BG = [
        self::STATUS_IN_PROCESS => 'badge-warning',
        self::STATUS_REVIEWED => 'badge-info',
        self::STATUS_ACCEPTED => 'badge-success',
    ];

    const PHASE_BG = [
        self::PHASE_PLANNING => 'badge-secondary',
        self::PHASE_EXECUTION => 'badge-success',
        self::PHASE_CLOSED => 'badge-danger',
    ];

    const STATUSES = [
        InProgress::class,
        Reviewed::class,
        Approved::class
    ];

    const STATUES_LABELS = [
        self::STATUS_IN_PROCESS,
        self::STATUS_REVIEWED,
        self::STATUS_ACCEPTED,
    ];

    const PHASES = [
        Planning::class,
        Execution::class,
        Closed::class
    ];

    protected $table = 'poa_poas';

    protected $casts = [
        'status' => PoaState::class,
        'phase' => PoaPhase::class,
        'approved_date' => 'date:Y-m-d',
    ];


    /**
     * Fillable fields.
     *
     * @var string[]
     */
    protected $fillable = [
        'year',
        'name',
        'user_id_in_charge',
        'company_id',
        'status',
        'phase',
        'reviewed',
        'min',
        'max',
        'approved_by',
        'approved_date',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = strtoupper($model->name);
            $model->phase = strtoupper($model->phase);
            $model->status = strtoupper($model->status);
        });
        static::updating(function ($model) {
            $model->name = strtoupper($model->name);
            $model->phase = strtoupper($model->phase);
            $model->status = strtoupper($model->status);
        });
    }

    /**
     * Sortable columns.
     *
     * @var array
     */
    public $sortable = ['year', 'name', 'responsible', 'status', 'reviewed', 'progress'];

    /**
     * Scope to only include active currencies.
     *
     * @param Builder $query
     *
     * @return Builder
     */


    public function scopeEnabled(Builder $query): Builder
    {
        return $query->whereIn('status', Poa::STATUES_LABELS);
    }

    /**
     * Poa Responsible
     *
     * @return BelongsTo
     */
    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_in_charge');
    }

    /**
     * POA programs
     *
     * @return HasMany
     */
    public function programs(): HasMany
    {
        return $this->hasMany(PoaProgram::class)->orderBy('id');
    }

    public function configs(): HasMany
    {
        return $this->hasMany(PoaIndicatorConfig::class)->orderBy('id');
    }

    public function poaIndicatorConfigs()
    {
        return $this->hasMany(PoaIndicatorConfig::class, 'poa_id');
    }

    public function calcProgress()
    {
        $poaPrograms = $this->programs;
        $progressPoa = 0;
        foreach ($poaPrograms as $program) {
            $progressProgram = 0;
            foreach ($program->poaActivities as $poaActivity) {
                $progressActivity = 0;
                $measureAdvances = $poaActivity->poaActivityIndicator;
                $goalActivity = $measureAdvances->sum('goal');
                $actualActivity = $measureAdvances->sum('actual');
                if ($goalActivity > 0) {
                    if ($actualActivity > $goalActivity) {
                        $progressActivity = 100;
                    } else {
                        $progressActivity = ($actualActivity / $goalActivity) * 100;
                    }
                }
                if ($progressActivity > 0) {
                    $progressProgram += $progressActivity * $poaActivity->poa_weight;
                }
            }
            $progressPoa += $progressProgram * $program->weight / 100;
        }
        return $progressPoa;
    }

    public function thresholdProgress()
    {
        $result = number_format($this->calcProgress(), 2);
        if ($result <= $this->min) {
            return '<span class="badge badge-danger badge-pill">' . $result . '% </span>';
        } else if ($result >= $this->max) {
            return '<span class="badge badge-success badge-pill">' . $result . '% </span>';
        } else {
            return '<span class="badge badge-warning badge-pill">' . $result . '% </span>';
        }
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

    public function reschedulings()
    {
        return $this->hasMany(PoaRescheduling::class, 'poa_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function progressByUnit($unit = 1)
    {
        $progressByUnit = 0;
        $programs = $this->programs;
        $poaActivities = $programs->pluck('poaActivities')->collapse()->where('indicator_unit_id', $unit);
        $measureAdvances = $poaActivities->pluck('measureAdvances')->collapse();
        $goal = $measureAdvances->sum('goal');
        $advance = $measureAdvances->sum('actual');
        if ($goal > 0) {
            $progressByUnit = $advance / $goal * 100;
        }
        return [
            'progress' => floatval(number_format($progressByUnit, 2)),
            'actual' => $advance,
        ];
    }

    public function progressByUnitParticipation($companiesIds = [], $actualPoa, $year, $unit = 1)
    {
        $progressByUnitParticipation = 0;
        $poas = Poa::with(['programs.poaActivities.measureAdvances'])
            ->whereIn('company_id', $companiesIds)
            ->where('year', $year)
            ->get();
        $programs = $poas->pluck('programs')->collapse();
        $poaActivities = $programs->pluck('poaActivities')->collapse()->where('indicator_unit_id', $unit);
        $measureAdvances = $poaActivities->pluck('measureAdvances')->collapse();
        $goal = $measureAdvances->sum('goal');
        if ($goal > 0) {
            $progressByUnitParticipation = $actualPoa / $goal * 100;
        }
        return floatval(number_format($progressByUnitParticipation, 2));
    }

    /**
     * @return bool
     */
    public function hasActivities(): bool
    {
        $hasActivities = false;
        $programs = $this->programs;
        $poaActivities = $programs->pluck('poaActivities')->collapse();
        if ($poaActivities->count() > 0) {
            $hasActivities = true;
        }
        return $hasActivities;
    }

    public function poaActivities(): \Illuminate\Support\Collection
    {
        $programs = $this->programs;
        $poaActivities = $programs->pluck('poaActivities')->collapse();
        return $poaActivities;
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'poa_departments', 'poa_id', 'department_id');
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        return $this->phase instanceof Closed;
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->withoutGlobalScope(\App\Scopes\Company::class);
    }

    /**
     * @return BelongsTo
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * @return bool
     */
    public function canBeReplicated(): bool
    {
        $poas = Poa::where('company_id', $this->company_id)->get();
        $poaYear = $this->year;
        $yearToBeReplicate = $poaYear + 1;
        $yearsPoa = $poas->pluck('year')->unique()->toArray();
        if (in_array($yearToBeReplicate, $yearsPoa))
            return false;
        return true;

    }
}
