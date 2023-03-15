@extends('layouts.admin')

@section('title', __('poa.activities_poa'))

@push('css')
    <style>
        .subheader {
            margin-bottom: 8px !important;
        }
    </style>
@endpush

@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0 mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('poa.poas') }}">
                {{ trans('poa.list_poas') }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('poas.activities.index', ['poa' => $activity->program->poa->id]) }}">
                {{ trans_choice('general.activities', 2) }}
            </a>
        </li>
        <li class="breadcrumb-item active">{{ $activity->name }}</li>
    </ol>
@endsection

@section('content')

    <livewire:budget.expenses.poa.expense-poa-activity-index :idTransaction="$transaction->id" :idActivity="$activity->id" :source="$source"/>

@endsection
