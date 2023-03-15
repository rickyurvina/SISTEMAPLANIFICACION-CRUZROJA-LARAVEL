@extends('layouts.admin')

@section('title', __('general.budget_execution'))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-money-bill text-success"></i> {{ __('general.budget_execution') }}
    </h1>
@endsection

@section('content')
    <livewire:poa.poa-budget-index :poaId="$poa->id"/>
@endsection
