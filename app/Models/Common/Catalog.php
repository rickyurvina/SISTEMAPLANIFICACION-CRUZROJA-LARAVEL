<?php

namespace App\Models\Common;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Kyslik\ColumnSortable\Sortable;

class Catalog extends Model
{
    use Sortable;

    protected $table = 'catalogs';

    protected static $recordEvents = [];

    protected bool $tenantable = false;

    protected $fillable = ['name', 'description', 'enabled'];

    public function details(): HasMany
    {
        return $this->hasMany(CatalogDetail::class, 'catalog_id');
    }

    /**
     * Scope to only include specific catalog name.
     *
     * @param Builder $query
     * @param $name
     * @return Builder
     */
    public static function boot()
    {
        parent::boot();

    }

    public function scopeCatalogName($query, $name): Builder
    {
        return $query->where($this->table . '.name', '=', $name);
    }
}