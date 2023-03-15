@extends('layouts.admin')

@section('title', trans_choice('general.catalog', 2))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-folder text-primary"></i> <span class="fw-300">{{ trans_choice('general.catalog', 2) }}</span>
    </h1>
@endsection

@section('content')

    <div class="row row-cols-1 row-cols-md-3 justify-content-center">
        <div class="col mb-4">
            <a href="{{ route('indicatorSources.index') }}" class="card border-dashed btn-select">
                <div class="card-body d-flex align-items-center">
                    <h5 class="card-title mx-auto my-3">
                    <span class="fs-xl fw-700 color-fusion-700 d-block">
                        {{ trans('general.module_sources')  }}
                    </span>
                    </h5>
                </div>
            </a>
        </div>
        <div class="col mb-4">
            <a href="{{ route('thresholds.index') }}" class="card border-dashed btn-select">
                <div class="card-body d-flex align-items-center">
                    <h5 class="card-title mx-auto my-3">
                    <span class="fs-xl fw-700 color-fusion-700 d-block">
                        {{ trans('general.module_threshold') }}
                    </span>
                    </h5>
                </div>
            </a>
        </div>
        <div class="col mb-4">
            <a href="{{ route('indicatorUnits.index') }}" class="card border-dashed btn-select">
                <div class="card-body d-flex align-items-center">
                    <h5 class="card-title mx-auto my-3">
                    <span class="fs-xl fw-700 color-fusion-700 d-block">
                        {{ trans('general.module_units')  }}
                    </span>
                    </h5>
                </div>
            </a>
        </div>
        <div class="col mb-4">
            <a href="{{ route('perspectives.index') }}" class="card border-dashed btn-select">
                <div class="card-body d-flex align-items-center">
                    <h5 class="card-title mx-auto my-3">
                    <span class="fs-xl fw-700 color-fusion-700 d-block">
                        {{ trans('general.perspectives') }}
                    </span>
                    </h5>
                </div>
            </a>
        </div>
    </div>

@endsection