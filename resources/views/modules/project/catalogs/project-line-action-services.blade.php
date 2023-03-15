@extends('layouts.admin')

@section('title', trans_choice('project.line_action_services', 2))

@section('subheader')
    <h1 class="subheader-title">
        <span class="fw-300">{{ trans_choice('project.line_action_services', 2) }}</span>
    </h1>
    <div class="subheader-block d-lg-flex align-items-center">
        @can('project-crud-project')
            <button type="button"
                    class="btn btn-success btn-sm mb-2"
                    data-toggle="modal"
                    data-target="#createModal">
                {{ trans('general.create') }} {{ trans('general.service') }}
            </button>
        @endcan
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
    <ol class="breadcrumb bg-transparent pl-0 pr-0 mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('projects.catalogs') }}">
                {{trans_choice('general.catalog',2)}}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('line-action.services.index') }}">
                {{trans_choice('project.line_action_services', 2)}}
            </a>
        </li>
    </ol>
@endsection

@section('content')

    @livewire('projects.catalogs.project-line-action-services')

@endsection


