<?php

namespace App\Models\Auth;

use App\Traits\Tenants;
use Eloquent;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Kyslik\ColumnSortable\Sortable;
use Lorisleiva\LaravelSearchString\Concerns\SearchString;
use Spatie\Permission\Models\Role as BaseRole;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\Auth\Role
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string|null $description
 * @property string $guard_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $id_azuread_rol
 * @property boolean $is_project_role
 * @property-read Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @method static Builder|Role collect($sort = 'name')
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role permission($permissions)
 * @method static Builder|Role query()
 * @method static Builder|Role sortable($defaultParameters = null)
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereDescription($value)
 * @method static Builder|Role whereDisplayName($value)
 * @method static Builder|Role whereGuardName($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @method static Builder|Role whereIdAzureadRol($value)
 * @mixin Eloquent
 */
class Role extends BaseRole
{
    use Sortable, Tenants, HasFactory, SearchString, Cachable;

    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'guard_name', 'id_azuread_rol','is_project_role'];

    protected array $sortable = ['name'];

    /**
     * Scope to get all rows filtered, sorted and paginated.
     *
     * @param Builder $query
     *
     * @return mixed
     */

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = strtoupper($model->name);
        });
        static::updating(function ($model){
            $model->name = strtoupper($model->name);
        });
        static::deleting(function ($model)
        {
            $model->syncPermissions([]);
        });
    }

    public function scopeCollect(Builder $query)
    {
        $request = request();

        $search = $request->get('search');
        $limit = $request->get('limit', setting('default.list_limit', '25'));

        return $query->usingSearchString($search)->sortable()->paginate($limit);
    }

    /**
     * Scope to not super-admin roles
     *
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeNotSuperAdmin(Builder $query)
    {
        return $query->where('name', '<>', 'super-admin');
    }

    /**
     * Scope to not super-admin roles
     *
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeIsSuperAdmin(Builder $query)
    {
        return $query->where('name',  'super-admin');
    }

}
