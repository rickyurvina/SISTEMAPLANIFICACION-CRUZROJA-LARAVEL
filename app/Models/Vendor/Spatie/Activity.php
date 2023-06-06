<?php

namespace App\Models\Vendor\Spatie;

use App\Abstracts\Model;
use App\Models\Admin\Company;
use App\Models\Auth\User;
use App\Scopes\Company as CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;

class Activity extends \Spatie\Activitylog\Models\Activity
{

    protected bool $tenantable = true;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new CompanyScope);

        static::creating(function ($model) {
            $model->company_id = session('company_id');
            $ipSettings = [
                'ip' => request()->ip(),
                'requestUri' => request()->getRequestUri(),
                'os' => request()->userAgent(),
                'url' => request()->fullUrl()
            ];
            if (!$model->properties) {
                $ipSettings = ['browser_information' => $ipSettings];
                $model->properties = $ipSettings;
            } else {
                $properties = $model->properties->put('browser_information', $ipSettings);
                $model->properties = $properties;
            }
        });

        static::addGlobalScope('sortOrder', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
