@extends('layouts.admin')

@section('title', trans('general.module_projects'))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-sort-circle text-primary"></i> {{ trans_choice('general.thresholds', 2) }}
    </h1>
@endsection

@section('content')

    <livewire:projects.configuration.project-thresholds-index/>

@endsection