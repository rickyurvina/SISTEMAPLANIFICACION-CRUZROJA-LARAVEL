@extends('layouts.admin')

@section('title',  trans('poa.card_reports') )

@section('subheader')
    <h1 class="subheader-title">
        <i class="fas fa-table text-primary"></i> <span class="fw-300">{{ trans('poa.card_reports') }}</span>
    </h1>
@endsection

@section('content')

    <div class="row row-cols-1 row-cols-md-3 justify-content-center">
        <div class="col mb-4">
            <a href="{{ route('process.nonConformitiesReport') }}" class="card border-dashed btn-select">
                <div class="card-body d-flex align-items-center">
                    <h5 class="card-title mx-auto my-3">
                    <span class="fs-xl fw-700 color-fusion-700 d-block">
                        {{ trans('general.non_conformities_report') }}
                    </span>
                    </h5>
                </div>
            </a>
        </div>
    </div>

@endsection