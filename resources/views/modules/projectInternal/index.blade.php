@extends('layouts.admin')

@section('title', trans('general.module_projects'))
@push('css')
    <style>
        .subheader {
            margin-bottom: 8px !important;
        }
    </style>
@endpush
@section('content')
    <div class="panel-1" style="display: block">
        <livewire:projects.c-r-u-d.projects/>
    </div>

@endsection
