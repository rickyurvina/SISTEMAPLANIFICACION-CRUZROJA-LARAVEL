@extends('layouts.admin')

@section('title', trans_choice('project.line_actions', 2))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-folder text-primary"></i> <span
                class="fw-300">{{ trans_choice('project.line_actions', 2) }}</span>
    </h1>

    <button type="button"
            class="btn btn-success btn-sm mb-2 mr-2"
            data-toggle="modal"
            data-target="#createModal">
        {{ trans('general.create') }} {{ trans('general.line_action') }}
    </button>
@endsection

@section('content')

    @livewire('projects.catalogs.project-line-actions')

@endsection


