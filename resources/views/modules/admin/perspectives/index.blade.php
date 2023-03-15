@extends('layouts.admin')

@section('title', trans('general.perspective'))

@section('subheader')

    <h1 class="subheader-title">
        <i class="fal fa-balance-scale text-primary"></i> {{ trans('general.perspective') }}
    </h1>
@endsection
@push('css')
    <style>
        .subheader {
            margin-bottom: 0 !important;
        }
    </style>
@endpush
@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.catalogs') }}">
                {{trans_choice('general.catalog',2)}}
            </a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                {{ trans('general.perspectives')  }}
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <livewire:admin.catalogs.perspectives.index-perspectives />
@endsection