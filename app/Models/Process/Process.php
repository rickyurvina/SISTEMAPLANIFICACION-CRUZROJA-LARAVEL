<?php

namespace App\Models\Process;

use App\Abstracts\Model;
use App\Models\Admin\Department;
use App\Models\Auth\User;
use App\Models\Comment;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Risk\Risk;
use App\States\Process\Act;
use App\States\Process\Check;
use App\States\Process\DoProcess;
use App\States\Process\Plan;
use App\States\Process\ProcessPhase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Plank\Mediable\Mediable;
use Spatie\ModelStates\HasStates;

class Process extends Model
{
    use HasFactory, HasStates, Mediable;

    const PHASES = [
        Plan::class,
        Act::class,
        DoProcess::class,
        Check::class,
    ];

    const PHASE_PLAN = 'Planear';
    const PHASE_DO_PROCESS = 'Hacer';
    const PHASE_ACT = 'Actuar';
    const PHASE_CHECK = 'Verificar';
    const TYPE_DIRECTIVE = 'DIRECTIVOS';
    const TYPE_HELP = 'APOYO';
    const TYPE_PRODUCT = 'PRODUCTO';
    const INTERN_CLIENT = 'INTERNO';
    const EXTERN_CLIENT = 'EXTERNO';
    const COLOR_NO_INVEST = '#33CC33';
    const COLOR_CONTINUE_IMPROVE = '#FFFF00';
    const COLOR_RETEST = '#F69200';
    const COLOR_REENGINEERING = '#CC0027';

    const TYPES_CLIENTS =
        [
            self::INTERN_CLIENT => self::INTERN_CLIENT,
            self::EXTERN_CLIENT => self::EXTERN_CLIENT,
        ];
    const TYPES_CLIENTS_BG =
        [
            self::INTERN_CLIENT => 'badge-secondary',
            self::EXTERN_CLIENT => 'badge-primary',
        ];

    const TYPES =
        [
            self::TYPE_DIRECTIVE => self::TYPE_DIRECTIVE,
            self::TYPE_HELP => self::TYPE_HELP,
            self::TYPE_PRODUCT => self::TYPE_PRODUCT
        ];

    const TYPES_BG = [
        self::TYPE_DIRECTIVE => 'badge-info',
        self::TYPE_HELP => 'badge-success',
        self::TYPE_PRODUCT => 'badge-danger',
    ];

    const COLOR_PROCESS_EVALUATION = [
        self::COLOR_NO_INVEST => [
            0 => 'general.No_Invest',
            1 => 'general.no_invest_description',
            2 => self::COLOR_NO_INVEST
        ],
        self::COLOR_CONTINUE_IMPROVE => [
            0 => 'general.continue_improve',
            1 => 'general.continue_improve_description',
            2 => self::COLOR_CONTINUE_IMPROVE
        ],
        self::COLOR_RETEST => [
            0 => 'general.retest',
            1 => 'general.retest_description',
            2 => self::COLOR_RETEST
        ],
        self::COLOR_REENGINEERING => [
            0 => 'general.reengineering',
            1 => 'general.reengineering_description',
            2 => self::COLOR_REENGINEERING
        ],
    ];

    protected $table = 'processes';

    protected $fillable =
        [
            'code',
            'name',
            'description',
            'owner_id',
            'company_id',
            'enabled',
            'phase',
            'department_id',
            'owner_id',
            'type',
            'inputs',
            'outputs',
            'attributions',
            'cycle_time',
            'people_number',
            'client_type',
            'services',
            'importance',
            'performance',
            'evaluation_result',
            'product_services',
        ];

    protected $casts =
        [
            'phase' => ProcessPhase::class,
            'inputs' => 'array',
            'outputs' => 'array',
        ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->code = mb_strtoupper($model->code);
            $model->name = mb_strtoupper($model->name);
            $model->description = mb_strtoupper($model->description);
            $model->type = mb_strtoupper($model->type);
            $model->attributions = mb_strtoupper($model->attributions);
            $model->client_type = mb_strtoupper($model->client_type);
            $model->services = mb_strtoupper($model->services);

        });
        static::updating(function ($model) {
            $model->code = mb_strtoupper($model->code);
            $model->name = mb_strtoupper($model->name);
            $model->description = mb_strtoupper($model->description);
            $model->type = mb_strtoupper($model->type);
            $model->attributions = mb_strtoupper($model->attributions);
            $model->client_type = mb_strtoupper($model->client_type);
            $model->services = mb_strtoupper($model->services);
        });
    }

    public static function statusColor(string $status)
    {
        foreach (self::PHASES as $st) {
            if ($st::$name == $status) {
                return $st::color();
            }
        }
        return '';
    }

    public function phaseChanges(): \Illuminate\Support\Collection
    {
        $activities = $this->activities()
            ->where('description', '=', 'updated')
            ->orderBy('id')
            ->get();
        $activitiesCollection = new Collection();
        foreach ($activities as $activity) {
            $new = $activity->properties['attributes']['phase'];
            $old = $activity->properties['old']['phase'];
            if ($new != $old)
                $activitiesCollection->push($activity);
        }
        return collect($activitiesCollection);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->withoutGlobalScope(\App\Scopes\Company::class);
    }

    public function indicators(): MorphMany
    {
        return $this->morphMany(Indicator::class, 'indicatorable');
    }

    public function activitiesProcess()
    {
        return $this->hasMany(Activity::class, 'process_id')->orderBy('id', 'asc');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function risks()
    {
        return $this->morphMany(Risk::class, 'riskable');
    }

    public function nonConformities()
    {
        return $this->hasMany(NonConformities::class, 'process_id');
    }

}
