@extends('layouts.admin')

@section('title', trans('general.strategy'))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-chart-line text-primary"></i> Actualizar Indicadores Por Periodo
    </h1>
@endsection
@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0">
        <li class="breadcrumb-item">
            <a href="{{ route('index.measure.strategy') }}">
                {{trans('general.index_update_measures')}}
            </a>
        </li>
        <li class="breadcrumb-item active">Actualizar Indicadores Por Periodo</li>
    </ol>
@endsection

@section('content')
    <livewire:measure.filter-periods :periodId="$periodId"/>
    <livewire:measure.measure-update :periodId="$periodId"/>
@endsection
