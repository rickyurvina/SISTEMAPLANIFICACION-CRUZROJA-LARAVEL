@extends('layouts.admin')

@section('title', trans('general.module_audit'))
@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-tasks text-primary"></i> Logs del Sistema

    </h1>
@endsection

@section('content')
    <livewire:audit.index-activity-log/>
@endsection
