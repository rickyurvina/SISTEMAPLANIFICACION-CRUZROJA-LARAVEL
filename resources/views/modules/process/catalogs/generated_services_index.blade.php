@extends('layouts.admin')

@section('title', trans_choice('general.catalog', 2))
@section('subheader')
    <h1 class="subheader-title">
        <span class="fw-300">{{ trans('general.generated_services') }}</span>
    </h1>
    <div class="subheader-block d-lg-flex align-items-center">

        <button type="button"
                class="btn btn-success btn-sm mb-2"
                data-toggle="modal"
                data-target="#createModal">
            &nbsp;{{ trans('general.create') }} {{ trans('general.generated_services') }}
        </button>
    </div>
@endsection
@push('css')
    <style>
        .subheader {
            margin-bottom: 0 !important;
        }
    </style>
@endpush
@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0">
        <li class="breadcrumb-item">
            <a href="{{ route('process.catalogs') }}">
                {{trans_choice('general.catalog',2)}}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('generated_services.index') }}">
                {{ trans('general.generated_services') }}
            </a>
        </li>
    </ol>
@endsection
@section('content')
    <div>
        <livewire:process.catalogs.generated-services/>
    </div>
@endsection