@extends('layouts.admin')

@section('title', trans('general.strategy'))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-sort-circle text-primary"></i> {{ $model->name ?? '' }}
    </h1>
    <div class="subheader-block d-lg-flex align-items-center">
        <a href="{{ URL::previous()}}" class="btn btn-info btn-sm"><span class="fas fa-house-return mr-1"></span>
            &nbsp;{{ trans('general.return_back') }}</a>
    </div>
@endsection

@push('css')
    <style>
        .subheader {
            margin-bottom: 0 !important;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex w-100 align-content-lg-start">
        <livewire:strategy.navigation.navigation :planId="$planId" :modelId="$model->id"/>
        <div class="flex-grow-1 mw-100 p-2">
            <div class="d-flex">
                <div class="d-flex align-items-center justify-content-center mb-3 w-50" style="height: 100px">
                    <livewire:measure.filter-periods :periodId="$periodId"/>
                </div>
                <div class="flex-grow-1">
                    <livewire:strategy.advances-by-unit-dashboard :periodId="$periodId"/>
                </div>
            </div>
            <div class="flex-grow-1 w-100" style="overflow: hidden auto" x-data="{ tab: 'details' }" x-cloak="">
                <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" :class="{ 'active': tab === 'details' }" x-on:click.prevent="tab = 'details'" href="#" role="tab">Detalles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" :class="{ 'active': tab === 'indicator' }" x-on:click.prevent="tab = 'indicator'" href="#" role="tab">Reporte de Indicador</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane pt-2 fade" :class="{ 'active show': tab === 'details' }">
                        <livewire:strategy.dashboard :periodId="$periodId" :model="$model" :type="$type"/>
                    </div>
                    <div class="tab-pane pt-2 fade" :class="{ 'active show': tab === 'indicator' }">
                        <livewire:measure.report :periodId="$periodId" :model="$model"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
