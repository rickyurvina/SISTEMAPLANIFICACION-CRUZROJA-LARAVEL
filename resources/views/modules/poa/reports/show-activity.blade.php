@extends('layouts.admin')

@section('title', trans('poa.reports'))
@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0">
        <li class="breadcrumb-item">
            <a href="{{ route('poa.reports.index') }}">
                {{trans('general.reports')}}
            </a>
        </li>
        <li class="breadcrumb-item">
            <span>
                {{ trans('general.poa_report') }}
            </span>
        </li>
    </ol>
@endsection
@push('css')
    <style>
        .subheader{
            margin-bottom: 8px!important;
        }
    </style>
@endpush

@section('content')
    <livewire:poa.reports.poa-reports />
@endsection
