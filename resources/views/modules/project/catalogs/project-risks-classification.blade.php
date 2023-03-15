@extends('layouts.admin')

@section('title', trans('project.risks_classification'))
@push('css')
    <style>
        .subheader {
            margin-bottom: 0 !important;
        }
    </style>
@endpush

@section('subheader')

    <h1 class="subheader-title">
        <span class="fw-300">{{ trans('project.risks_classification') }}</span>
    </h1>
    @can('project-crud-project')
        <div class="subheader-block d-lg-flex align-items-center">
            <button type="button"
                    class="btn btn-success btn-sm mb-2"
                    data-toggle="modal"
                    data-target="#createModal">
                {{ trans('general.create') }} {{ trans('general.risk_classification') }}
            </button>
        </div>
    @endcan
@endsection
@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0">
        <li class="breadcrumb-item">
            <a href="{{ route('projects.catalogs') }}">
                {{trans_choice('general.catalog',2)}}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('risks_classification.index') }}">
                {{ trans('general.risk_classification') }}
            </a>
        </li>
    </ol>
@endsection

@section('content')

    @livewire('projects.catalogs.project-risks-classification')
@endsection


