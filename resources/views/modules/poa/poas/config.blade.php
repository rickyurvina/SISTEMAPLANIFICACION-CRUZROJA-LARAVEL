@extends('layouts.admin')

@section('title', trans('poa.config'))

@push('css')
    <style>
        .subheader {
            margin-bottom: 8px !important;
        }
    </style>
@endpush

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-table text-primary"></i> {{ trans_choice('general.config', 2) }}
    </h1>
@endsection

@section('content')
    <div class="text-info ml-4 mt-2">
        <h3>@if (isset($poa->name)) {{$poa->name}} ({{ $poa->year }}) @endif</h3>
    </div>
    <livewire:poa.config.poa-indicator-config :poaId="$poaId"/>
@endsection
