<?php

namespace App\Models\Common;

use App\Models\Admin\Company;
use App\Scopes\Company as CompanyScope;
use App\Traits\Tenants;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * App\Models\Setting\Setting
 *
 * @property int $id
 * @property int $company_id
 * @property string $key
 * @property string|null $value
 * @property-read Company $company
 * @method static Builder|Setting companyId($company_id)
 * @method static Builder|Setting newModelQuery()
 * @method static Builder|Setting newQuery()
 * @method static Builder|Setting prefix($prefix = 'company')
 * @method static Builder|Setting query()
 * @method static Builder|Setting whereCompanyId($value)
 * @method static Builder|Setting whereId($value)
 * @method static Builder|Setting whereKey($value)
 * @method static Builder|Setting whereValue($value)
 * @mixin \Eloquent
 */
class Setting extends Eloquent
{
    use Tenants;

    protected $table = 'settings';

    protected $tenantable = true;

    public $timestamps = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'key', 'value'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
        static::creating(function ($model) {
            $model->value = mb_strtoupper($model->value);
        });
        static::updating(function ($model){
            $model->value = mb_strtoupper($model->value);
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Scope to only include by prefix.
     *
     * @param Builder $query
     * @param string $prefix
     *
     * @return Builder
     */
    public function scopePrefix($query, $prefix = 'company')
    {
        return $query->where('key', 'like', $prefix . '.%');
    }

    /**
     * Scope to only include company data.
     *
     * @param Builder $query
     * @param $company_id
     *
     * @return Builder
     */
    public function scopeCompanyId($query, $company_id)
    {
        return $query->where($this->table . '.company_id', '=', $company_id);
    }
}
