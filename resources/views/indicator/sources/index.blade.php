@extends('layouts.admin')

@section('title', trans_choice('general.sources', 2))

@section('subheader')
    <h1 class="subheader-title">
        <span class="fw-300">{{ trans_choice('general.sources', 2) }}</span>
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
            {{ trans_choice('general.sources', 2) }}
        </li>
    </ol>
@endsection

@section('content')
    <livewire:admin.catalogs.sources.index-sources/>
@endsection