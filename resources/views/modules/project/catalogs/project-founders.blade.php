@extends('layouts.admin')

@section('title', trans_choice('project.funders', 2))

@section('subheader')
    <h1 class="subheader-title">
        <span class="fw-300">{{ trans_choice('project.funders', 2) }}</span>
    </h1>
    @can('project-crud-project')
        <div class="subheader-block d-lg-flex align-items-center">
            <button type="button"
                    class="btn btn-success btn-sm mb-2 "
                    data-toggle="modal"
                    data-target="#createModal">
                &nbsp;{{ trans('general.create') }} {{ trans_choice('general.funder',1) }}
            </button>
        </div>
    @endcan
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
            <a href="{{ route('projects.catalogs') }}">
                {{trans_choice('general.catalog',2)}}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('founders.index') }}">
                {{ trans_choice('general.funders',2) }}
            </a>
        </li>
    </ol>
@endsection

@section('content')

    @livewire('projects.catalogs.project-founders')

@endsection


