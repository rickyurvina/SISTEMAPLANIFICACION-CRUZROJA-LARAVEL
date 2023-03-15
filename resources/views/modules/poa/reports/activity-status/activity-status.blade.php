@extends('layouts.admin')

@section('title', trans('poa.activity_status'))

@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0">
        <li class="breadcrumb-item">
            <a href="{{ route('poa.reports.index') }}">
                {{trans('general.reports')}}
            </a>
        </li>
        <li class="breadcrumb-item">
         <span>
             {{ trans('general.activity_status_report') }}
         </span>
        </li>
    </ol>
@endsection

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-table text-primary"></i> {{ __('poa.activity_status') }}
    </h1>
@endsection

@section('content')
    <livewire:poa.reports.poa-report-by-activities/>
@endsection