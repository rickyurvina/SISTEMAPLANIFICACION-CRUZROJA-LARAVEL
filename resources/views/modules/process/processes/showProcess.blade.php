@extends('layouts.admin')

@section('title', trans_choice('general.module_process', 1))
@can('view-process'||'manage-process')
@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-balance-scale-right text-primary"></i> <span class="fw-300">{{trans_choice('process.process',1)}}</span>
    </h1>
    @can('manage-process')
        <div class="d-flex flex-row-reverse ml-auto ml-2">
            <button type="button" class="btn btn-success border-0 shadow-0" data-toggle="modal"
                    data-target="#create-process-modal">{{ trans('general.create')}} {{trans('general.process')}}
            </button>
        </div>
        <div class="subheader-block d-lg-flex align-items-center">
            <livewire:process.create-process :departmentId="$department->id"/>
        </div>
    @endcan
@endsection
@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0 mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('processes.index') }}">
              Gerencias
            </a>
        </li>
        <li class="breadcrumb-item active" style="overflow: unset">  {{ trans_choice('process.process',1) .' de '.  $department->name }}</li>
    </ol>
@endsection
@endcan
@can('view-process'||'manage-process')
@section('content')
    <livewire:process.show-list-process :departmentId="$department->id"/>
@endsection
@endcan
