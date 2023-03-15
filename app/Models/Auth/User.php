<?php

namespace App\Models\Auth;

use App\Models\Admin\Company;
use App\Models\Admin\Department;
use App\Models\Comment;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Measure\Measure;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaActivity;
use App\Models\Process\Process;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectMember;
use App\Models\Vendor\Spatie\Activity;
use App\Traits\Tenants;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Kyslik\ColumnSortable\Sortable;
use Laravel\Sanctum\HasApiTokens;
use Lorisleiva\LaravelSearchString\Concerns\SearchString;
use Plank\Mediable\Mediable;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Permission\Traits\HasRoles;
use Thomasjohnkane\Snooze\Traits\SnoozeNotifiable;

/**
 * App\Models\Auth\User
 *
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasRoles, Sortable, Tenants, Mediable, HasFactory, Cachable, SearchString, CausesActivity, SnoozeNotifiable, HasApiTokens;

    protected $table = 'users';

    protected bool $tenantable = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'locale',
        'enabled',
        'job_title',
        'business_phone',
        'personal_phone',
        'gender',
        'date_birth',
        'photo',
        'personal_notes',
        'employer_cost',
        'competencies',
        'working_skills',
        'work_experience',
        'contract_type',
        'contract_start',
        'contract_end',
        'company_id',
    ];

    protected $casts = [
        'competencies' => 'array',
        'working_skills' => 'array',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['last_logged_in_at', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * Sortable columns.
     *
     * @var array
     */
    public array $sortable = ['name', 'email', 'enabled'];

    public static function boot()
    {
        parent::boot();

        static::retrieved(function ($model) {
            $model->setCompanyIds();
        });

        static::saving(function ($model) {
            $model->unsetCompanyIds();
        });

        static::creating(function ($model) {
            $model->name = strtoupper($model->name);
            $model->surname = strtoupper($model->surname);
        });
        static::updating(function ($model){
            $model->name = strtoupper($model->name);
            $model->surname = strtoupper($model->surname);
        });
    }

    public function companies(): MorphToMany
    {
        return $this->morphToMany(Company::class, 'user', 'user_companies', 'user_id', 'company_id');
    }

    /**
     * Always capitalize the name when we retrieve it
     *
     * @param $value
     *
     * @return string
     */
    public function getNameAttribute($value): string
    {
        return ucfirst($value);
    }

    /**
     * Always return a valid picture when we retrieve it
     *
     * @param $value
     *
     * @return mixed
     */
    public function getPictureAttribute($value)
    {

        if (!empty($value) && !$this->hasMedia('picture')) {
            return $value;
        } elseif (!$this->hasMedia('picture')) {
            return false;
        }

        return $this->getMedia('picture')->last();
    }

    /**
     * Always return a valid picture when we retrieve it
     *
     * @param $value
     *
     * @return array|Application|Translator|string|null
     */
    public function getLastLoggedInAtAttribute($value)
    {
        if (!empty($value)) {
            return Carbon::parse($value)->diffForHumans();
        } else {
            return trans('auth.never');
        }
    }

    /**
     * Always capitalize the name when we save it to the database
     *
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    /**
     * Always hash the password when we save it to the database
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function activityLog()
    {
        return $this->hasMany(Activity::class, 'causer_id')->where('log_name', 'login');
    }


    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'responsible_id');
    }

    public function process()
    {
        return $this->hasMany(Process::class, 'owner');
    }

    public function indicators()
    {
        return $this->hasMany(Indicator::class, 'user_id');
    }

    public function measures()
    {
        return $this->hasMany(Measure::class, 'user_id');
    }

    public function changesActivityLog()
    {
        return $this->hasMany(Activity::class, 'causer_id');
    }

    public function poas()
    {
        return $this->hasMany(Poa::class, 'user_id_in_charge')->withoutGlobalScope(\App\Scopes\Company::class);
    }

    public function activitiesPoa(): HasMany
    {
        return $this->hasMany(PoaActivity::class,'user_id_in_charge');
    }


    /**
     * Scope to only include active currencies.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeEnabled(Builder $query): Builder
    {
        return $query->where('enabled', 1);
    }

    /**
     * Scope to get all rows filtered, sorted and paginated.
     *
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeCollect(Builder $query)
    {
        $request = request();

        $search = $request->get('search');
        $limit = $request->get('limit', setting('default.list_limit', '25'));

        return $query->usingSearchString($search)->sortable()->paginate($limit);
    }

    /**
     * Companies Array.
     *
     * @return void
     */
    public function setCompanyIds()
    {
        $this->attributes['company_ids'] = $this->companies->pluck('id')->toArray();
    }

    public function unsetCompanyIds()
    {
        $this->offsetUnset('company_ids');
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'user_departments', 'user_id', 'department_id')->withoutGlobalScopes();
    }

    public function getFullName()
    {
        return $this->name . " " . $this->surname;
    }

    public function shortNickName()
    {
        return substr($this->name, 0, 3) . " " . substr($this->surname, 0, 1);
    }

    public static function isMember($user_id, $project_id): bool
    {
        return !is_null(ProjectMember::where('user_id', $user_id)
            ->where('project_id', $project_id)
            ->first());
    }

    public function isMemberOfDepartment(int $departmentId)
    {
        $departments = $this->departments->pluck('id')->toArray();
        if (in_array($departmentId, $departments)) {
            return true;
        } else {
            return false;
        }

    }
}
