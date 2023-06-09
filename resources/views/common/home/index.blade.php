@extends('layouts.admin')

@section('title', trans('general.start'))

@push('css')
    <style>
        .subheader {
            margin-bottom: 0 !important;
        }
    </style>
@endpush

@section('content')
    <h3>{{ trans('general.modules') }}</h3>
    <div class="row">
        @if(Gate::check('strategy-view') || Gate::check('strategy-manage') )
            <div class="col-4 col-sm-4 col-lg-3 col-xl-2 d-flex justify-content-center align-items-center mb-g">
                <div class="rounded bg-white p-0 m-0 d-flex flex-column w-100 h-100">
                    <div class="rounded-top w-100 bg-fusion-50">
                        <a href="{{ route('strategy.home') }}" class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 hover-bg">
                        <span class="icon-stack fa-6x">
                            <i class="base-2 icon-stack-3x color-fusion-600"></i>
                            <i class="base-3 icon-stack-2x color-fusion-700"></i>
                            <i class="ni ni-settings icon-stack-1x text-white"></i>
                        </span>
                        </a>
                    </div>
                    <div class="rounded-bottom p-1 w-100 d-flex justify-content-center align-items-center text-center">
                        <span class="d-block text-truncate text-muted fs-xl">{{ trans('general.module_strategy') }}</span>
                    </div>
                </div>
            </div>
        @endif
        @if(Gate::check('project-view') || Gate::check('project-manage') )
            <div class="col-4 col-sm-4 col-lg-3 col-xl-2 d-flex justify-content-center align-items-center mb-g">
                <div class="rounded bg-white p-0 m-0 d-flex flex-column w-100 h-100">
                    <div class="rounded-top w-100 bg-info-50">
                        <a href="{{ route('projects.index') }}" class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 hover-bg">
                            <span class="icon-stack fa-6x">
                                <i class="base-7 icon-stack-3x color-info-500"></i>
                                <i class="base-7 icon-stack-2x color-info-700"></i>
                                <i class="ni ni-graph icon-stack-1x text-white"></i>
                            </span>
                        </a>
                    </div>
                    <div class="rounded-bottom p-1 w-100 d-flex justify-content-center align-items-center text-center">
                        <span class="d-block text-truncate text-muted fs-xl">{{ trans('general.module_projects') }}</span>
                    </div>
                </div>
            </div>
        @endif
        @if(Gate::check('budget-view') || Gate::check('budget-manage') )
            <div class="col-4 col-sm-4 col-lg-3 col-xl-2 d-flex justify-content-center align-items-center mb-g">
                <div class="rounded bg-white p-0 m-0 d-flex flex-column w-100 h-100">
                    <div class="rounded-top w-100 bg-danger-50">
                        <a href="{{ route('budget.home') }}" class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 hover-bg">
                            <span class="icon-stack fa-6x">
                                <i class="base-4 icon-stack-3x color-danger-500"></i>
                                <i class="base-4 icon-stack-1x color-danger-400"></i>
                                <i class="fas fa-dollar-sign icon-stack-1x text-white"></i>
                            </span>
                        </a>
                    </div>
                    <div class="rounded-bottom p-1 w-100 d-flex justify-content-center align-items-center text-center">
                        <span class="d-block text-truncate text-muted fs-xl">{{ trans('general.module_budget') }}</span>
                    </div>
                </div>
            </div>
        @endif
        @if(Gate::check('poa-view') || Gate::check('poa-manage') )
            <div class="col-4 col-sm-4 col-lg-3 col-xl-2 d-flex justify-content-center align-items-center mb-g">
                <div class="rounded bg-white p-0 m-0 d-flex flex-column w-100 h-100">
                    <div class="rounded-top w-100 bg-info-50">
                        <a href="{{ route('poa.poas') }}" class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 hover-bg">
                            <span class="icon-stack fa-6x">
                                <i class="base-14 icon-stack-3x color-info-500"></i>
                                <i class="base-7 icon-stack-2x color-info-700"></i>
                                <i class="fas fa-sliders-v icon-stack-1x text-white"></i>
                            </span>
                        </a>
                    </div>
                    <div class="rounded-bottom p-1 w-100 d-flex justify-content-center align-items-center text-center">
                        <span class="d-block text-truncate text-muted fs-xl">{{ trans('general.poa') }}</span>
                    </div>
                </div>
            </div>
        @endcan
        @if(Gate::check('administrative-view') || Gate::check('administrative-manage') )
            <div class="col-4 col-sm-4 col-lg-3 col-xl-2 d-flex justify-content-center align-items-center mb-g">
                <div class="rounded bg-white p-0 m-0 d-flex flex-column w-100 h-100">
                    <div class="rounded-top w-100 bg-info-50">
                        <a href="{{ route('admin.administrativeTasks') }}" class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 hover-bg">
                            <span class="icon-stack fa-6x">
                                <i class="base-4 icon-stack-3x color-info-500"></i>
                                <i class="base-7 icon-stack-2x color-info-700"></i>
                                <i class="fas fa-address-card icon-stack-1x text-white"></i>
                            </span>
                        </a>
                    </div>
                    <div class="rounded-bottom p-1 w-100 d-flex justify-content-center align-items-center text-center">
                        <span class="d-block text-truncate text-muted fs-xl">{{ trans('general.administrative_tasks') }}</span>
                    </div>
                </div>
            </div>
        @endcan
        @if(Gate::check('process-view') || Gate::check('process-manage') )
            <div class="col-4 col-sm-4 col-lg-3 col-xl-2 d-flex justify-content-center align-items-center mb-g">
                <div class="rounded bg-white p-0 m-0 d-flex flex-column w-100 h-100">
                    <div class="rounded-top w-100 bg-info-50">
                        <a href="{{ route('processes.index') }}" class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 hover-bg">
                            <span class="icon-stack fa-6x">
                                <i class="fa fa-spinner color-warning-500"></i>
                            </span>
                        </a>
                    </div>
                    <div class="rounded-bottom p-1 w-100 d-flex justify-content-center align-items-center text-center">
                        <span class="d-block text-truncate text-muted fs-xl">{{trans_choice('general.module_process', 2) }}</span>
                    </div>
                </div>
            </div>
        @endcan
        @if(Gate::check('admin-view') || Gate::check('admin-manage') )
            <div class="col-4 col-sm-4 col-lg-3 col-xl-2 d-flex justify-content-center align-items-center mb-g">
                <div class="rounded bg-white p-0 m-0 d-flex flex-column w-100 h-100">
                    <div class="rounded-top w-100 bg-success-50">
                        <a href="{{ route('companies.index') }}" class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 hover-bg">
                        <span class="icon-stack fa-6x">
                            <i class="base-9 icon-stack-3x color-success-400"></i>
                            <i class="base-2 icon-stack-2x color-success-500"></i>
                            <i class="ni ni-shield icon-stack-1x text-white"></i>
                        </span>
                        </a>
                    </div>
                    <div class="rounded-bottom p-1 w-100 d-flex justify-content-center align-items-center text-center">
                        <span class="d-block text-truncate text-muted fs-xl">{{ trans('general.module_admin') }}</span>
                    </div>
                </div>
            </div>
        @endcan
        @if(Gate::check('audit-view') || Gate::check('audit-manage') )
            <div class="col-4 col-sm-4 col-lg-3 col-xl-2 d-flex justify-content-center align-items-center mb-g">
                <div class="rounded bg-white p-0 m-0 d-flex flex-column w-100 h-100">
                    <div class="rounded-top w-100 bg-success-50">
                        <a href="{{ route('audit.home') }}" class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 hover-bg">
                         <span class="icon-stack fa-6x">
                                    <i class="base-18 icon-stack-3x color-info-700"></i>
                                    <span class="position-absolute pos-top pos-left pos-right color-white fs-md mt-2 fw-400">28</span>
                                </span>
                        </a>
                    </div>
                    <div class="rounded-bottom p-1 w-100 d-flex justify-content-center align-items-center text-center">
                        <span class="d-block text-truncate text-muted fs-xl">{{ trans('general.module_audit') }}</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection