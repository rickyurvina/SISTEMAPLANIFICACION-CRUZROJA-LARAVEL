<?php

namespace App\Models\Admin;

use App\Models\Auth\User;
use App\Models\Common\Setting;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaActivity;
use App\Traits\Tenants;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Kyslik\ColumnSortable\Sortable;
use Plank\Mediable\Mediable;

/**
 * App\Models\Admin\Company
 *
 * @property int $id
 * @property string|null $domain
 * @property int|null $parent_id
 * @property int $enabled
 * @property int $level
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read string $company_logo
 * @property-read Collection|Setting[] $settings
 * @property-read int|null $settings_count
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @method static Builder|Company collect($sort = 'name')
 * @method static Builder|Company enabled($value = 1)
 * @method static Builder|Company newModelQuery()
 * @method static Builder|Company newQuery()
 * @method static \Illuminate\Database\Query\Builder|Company onlyTrashed()
 * @method static Builder|Company query()
 * @method static Builder|Company sortable($defaultParameters = null)
 * @method static Builder|Company whereCreatedAt($value)
 * @method static Builder|Company whereDeletedAt($value)
 * @method static Builder|Company whereDomain($value)
 * @method static Builder|Company whereEnabled($value)
 * @method static Builder|Company whereId($value)
 * @method static Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Company withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Company withoutTrashed()
 * @mixin \Eloquent
 */
class Company extends Eloquent
{
    use SoftDeletes, Sortable, Tenants, Mediable;

    protected $table = 'companies';

    protected $tenantable = false;

    protected $dates = ['deleted_at'];

    protected $fillable = ['domain', 'enabled', 'parent_id', 'level'];

    /**
     * Sortable columns.
     *
     * @var array
     */
    public $sortable = ['name', 'domain', 'email', 'enabled', 'created_at'];

    public static function boot()
    {
        parent::boot();

        static::retrieved(function ($model) {
            $model->setSettings();
        });

        static::saving(function ($model) {
            $model->unsetSettings();
        });
    }

    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'user', 'user_companies', 'company_id', 'user_id');
    }

    public function setSettings()
    {
        $settings = $this->settings;

        $groups = [
            'company',
            'default',
        ];

        foreach ($settings as $setting) {
            list($group, $key) = explode('.', $setting->getAttribute('key'));

            // Load only general settings
            if (!in_array($group, $groups)) {
                continue;
            }

            $value = $setting->getAttribute('value');

            if (($key == 'logo') && empty($value)) {
                $value = 'public/img/company.png';
            }

            $this->setAttribute($key, $value);
        }

        // Set default default company logo if empty
        if ($this->getAttribute('logo') == '') {
            $this->setAttribute('logo', 'public/img/company.png');
        }
    }

    public function unsetSettings()
    {
        $settings = $this->settings;

        $groups = [
            'company',
            'default',
        ];

        foreach ($settings as $setting) {
            list($group, $key) = explode('.', $setting->getAttribute('key'));

            // Load only general settings
            if (!in_array($group, $groups)) {
                continue;
            }

            $this->offsetUnset($key);
        }

        $this->offsetUnset('logo');
    }

    /**
     * Scope to get all rows filtered, sorted and paginated.
     *
     * @param Builder $query
     * @param string $sort
     *
     * @return mixed
     */
    public function scopeCollect(Builder $query, $sort = 'name')
    {
        $request = request();

        $limit = $request->get('limit', setting('default.list_limit', '25'));

        return user()->companies()->sortable($sort)->paginate($limit);
    }

    /**
     * Scope to only include companies of a given enabled value.
     *
     * @param Builder $query
     * @param mixed $value
     *
     * @return Builder
     */
    public function scopeEnabled(Builder $query, $value = 1): Builder
    {
        return $query->where('enabled', $value);
    }

    /**
     * Sort by company name
     *
     * @param Builder $query
     * @param $direction
     *
     * @return Builder
     */
    public function nameSortable(Builder $query, $direction): Builder
    {
        return $query->join('settings', 'companies.id', '=', 'settings.company_id')
            ->where('key', 'company.name')
            ->orderBy('value', $direction)
            ->select('companies.*');
    }

    /**
     * Sort by company email
     *
     * @param Builder $query
     * @param $direction
     *
     * @return Builder
     */
    public function emailSortable(Builder $query, $direction): Builder
    {
        return $query->join('settings', 'companies.id', '=', 'settings.company_id')
            ->where('key', 'company.email')
            ->orderBy('value', $direction)
            ->select('companies.*');
    }

    public function getCompanyLogoAttribute()
    {
        return $this->getMedia('company_logo')->last();
    }

    public function scopeGetParents($query, $level)
    {
        return $query->collect()->where('level', $level - 1);
    }

    public function children()
    {
        return $this->hasMany(Company::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Company::class, 'parent_id');
    }

    public function getProvinces()
    {
        return $this->where('level', 2);
    }

    public function getCantones($provinceId)
    {
        return $this->where('parent_id', $provinceId)->get();
    }

    public function getExecutionCompanies($background_colors, $filter = null)
    {
        $poaActivity = new PoaActivity;
        $contColor = 0;
        $mayor = 0;
        $menor = 0;
        $i = 0;
        $j = 0;
        $sumProgress = 0;
        $sumGoal = 0;
        $ejectuadoJuntasArr = array();
        $listOfProvinces = array();
        $canton = $filter['canton'] ?? null;
        $province_ = $filter['province'] ?? null;
        $provinces = $this->getProvinces()
            ->when($province_, function ($q, $province_) {
                $q->where('id',$province_);
            })->get();
        if (!is_null($canton)){
            $canton = $this->find($filter['canton']);
            $province = $canton->parent()->first();
            if ($poaActivity->getGoalCanton($canton->id) > 0) {
                $poaActivityProgress = $poaActivity->getProgressCanton($canton->id, $filter ?? null);
                $poaActivityGoal = $poaActivity->getGoalCanton($canton->id);
                $percentagePerAction = $poaActivityProgress / $poaActivityGoal * 100;
                $ejectuadoJuntasArr[$i] =
                    [
                        'province' => $province->name,
                        'canton' => $canton->name,
                        'percentage' => number_format($percentagePerAction, 2)];
                $sumProgress += $poaActivityProgress;
                $sumGoal += $poaActivityGoal;
                $i++;
                $mayor = $percentagePerAction;
                $menor = $mayor;
                $nombreCantonMayor = $canton->name;
                $nombreCantonMenor = $canton->name;
            }
            if ($sumGoal > 0) {
                $advanceProvince = $sumProgress / $sumGoal * 100;
            } else {
                $advanceProvince = 0;
            }
            if ($advanceProvince > 0) {
                $listOfProvinces[$j] =
                    [
                        'id' => $province->id,
                        'country' => $province->name,
                        'id_country' => $province->id,
                        'visits' => number_format($advanceProvince, 1),
                        'menor' => $nombreCantonMenor ?? "",
                        'mayor' => $nombreCantonMayor ?? "",
                        'color' => $background_colors[$contColor]
                    ];
                $j++;
                $contColor++;
                if ($contColor > 3) {
                    $contColor = 0;
                }
            }
        }else{
            foreach ($provinces as $province) {
                foreach ($this->getCantones($province->id) as $index => $canton) {
                    if ($poaActivity->getGoalCanton($canton->id) > 0) {
                        $poaActivityProgress = $poaActivity->getProgressCanton($canton->id, $filter ?? null);
                        $poaActivityGoal = $poaActivity->getGoalCanton($canton->id);
                        $percentagePerAction = $poaActivityProgress / $poaActivityGoal * 100;
                        $ejectuadoJuntasArr[$i] =
                            [
                                'province' => $province->name,
                                'canton' => $canton->name,
                                'id_canton' => $canton->id,
                                'percentage' => number_format($percentagePerAction, 2)
                            ];
                        $sumProgress += $poaActivityProgress;
                        $sumGoal += $poaActivityGoal;
                        $i++;
                        if ($percentagePerAction > $mayor) {
                            $menor = $mayor;
                            $mayor = $percentagePerAction;
                            $nombreCantonMayor = $canton->name;
                        } else {
                            $menor = $percentagePerAction;
                            $nombreCantonMenor = $canton->name;
                        }
                    }
                }
                if ($sumGoal > 0) {
                    $advanceProvince = $sumProgress / $sumGoal * 100;
                } else {
                    $advanceProvince = 0;
                }
                if ($advanceProvince > 0) {
                    $listOfProvinces[$j] =
                        [
                            'id' => $province->id,
                            'country' => $province->name,
                            'id_country' => $province->id,
                            'visits' => number_format($advanceProvince, 1),
                            'menor' => $nombreCantonMenor ?? '',
                            'mayor' => $nombreCantonMayor,
                            'color' => $background_colors[$contColor]
                        ];
                    $j++;
                    $contColor++;
                    if ($contColor > 3) {
                        $contColor = 0;
                    }
                }
                $sumProgress = 0;
                $sumGoal = 0;
                $mayor = 0;
                $menor = 0;
                $nombreCantonMenor = '';
                $nombreCantonMayor = '';
            }
        }

        return
            ['ejectuadoJuntasArr' => $ejectuadoJuntasArr,
                'listOfProvinces' => $listOfProvinces];
    }

    public function poas(){
        return $this->hasMany(Poa::class,'company_id');
    }

}
