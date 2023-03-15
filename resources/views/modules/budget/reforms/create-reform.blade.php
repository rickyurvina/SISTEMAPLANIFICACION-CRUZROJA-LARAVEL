@extends('layouts.admin')

@section('title', trans_choice('budget.reform', 2))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fas fa-money-bill mr-2"></i>{{trans('general.create')}} {{ trans_choice('general.reforms', 2) }} {{$transaction->number}}
    </h1>

@endsection

@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0 mb-0 mt-0">
        <li class="breadcrumb-item">
            <a href="{{ route('budgets.index') }}">
                Presupuestos
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('budgets.reforms', $transaction->id) }}">
                Reformas {{ $transaction->year }}
            </a>
        </li>
        <li class="breadcrumb-item active"> Crear Reforma </li>
    </ol>
@endsection


@section('content')
    <div wire:ignore>
        <livewire:budget.reforms.create-reform :transaction="$transaction"/>
    </div>
@endsection
