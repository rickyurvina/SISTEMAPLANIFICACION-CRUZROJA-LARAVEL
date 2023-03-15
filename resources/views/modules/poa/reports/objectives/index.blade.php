@extends('layouts.admin')

@section('title', trans('poa.report_general_by_objectives'))

@push('css')
    <style>
        .subheader {
            margin-bottom: 8px !important;
        }
    </style>
@endpush

@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0">
        <li class="breadcrumb-item">
            <a href="{{ route('poa.reports.index') }}">
                {{trans('general.reports')}}
            </a>
        </li>
        <li class="breadcrumb-item">
            <span>{{ trans('general.report_general') }}</span>
        </li>
    </ol>
@endsection

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-table text-primary"></i> {{ __('poa.report_general_by_objectives') }}
    </h1>
@endsection

@section('content')
    <div>
        <livewire:poa.reports.poa-report-by-objectives />
    </div>
@endsection
