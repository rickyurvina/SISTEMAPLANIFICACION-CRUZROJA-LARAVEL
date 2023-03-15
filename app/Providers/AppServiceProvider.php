<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        view::share('asset_template', '/vendor/template');

        Builder::macro('search', function ($field, $string) {
            return $string ? $this->where($field, 'like', '%' . $string . '%') : $this;
        });

        Validator::extend('morph_exists_indicator', function ($attribute, $value, $parameters, $validator) {
            if (!$type = Arr::get($validator->getData(), $parameters[0], false)) {
                return false;
            }

            $type = Relation::getMorphedModel($type) ?? $type;

            if (!class_exists($type)) {
                return false;
            }
            $model = App::make($type)::find($validator->getData()['indicatorableId']);
            $existIndicator = $model->indicators->when($validator->getData()['indicatorId'], function ($query) use ($validator) {
                return $query->where('id', '<>', $validator->getData()['indicatorId']);
            })->where('code', $value);

            return $existIndicator->count() < 1;
        });

        Validator::extend('morph_exists_measure', function ($attribute, $value, $parameters, $validator) {
            if (!$type = Arr::get($validator->getData(), $parameters[0], false)) {
                return false;
            }

            $type = Relation::getMorphedModel($type) ?? $type;

            if (!class_exists($type)) {
                return false;
            }
            $model = App::make($type)::find($validator->getData()['indicatorableId']);
            $existIndicator = $model->measures->when(isset($validator->getData()['measureId']), function ($query) use ($validator) {
                return $query->where('id', '<>', $validator->getData()['measureId']);
            })->where('code', $value);

            return $existIndicator->count() < 1;
        });

    }


}
