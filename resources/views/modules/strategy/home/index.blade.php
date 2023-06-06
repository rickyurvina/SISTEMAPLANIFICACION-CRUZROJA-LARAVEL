@extends('layouts.admin')

@section('title', trans('general.strategy'))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-sort-circle text-primary"></i> {{ $plan->name ?? '' }}
    </h1>
    <div class="subheader-block d-lg-flex align-items-center">
        <a href="{{ route('strategy.updateScores')}}" class="btn btn-success btn-sm"><span class="fas fa-check-circle mr-2"></span>
            &nbsp;{{ trans('general.update').'-'.trans('general.strategy') }}</a>
    </div>
@endsection

@section('content')
    @if($plan)
        <div class="d-flex flex-wrap">
            <livewire:strategy.navigation.navigation :planId="$plan->id"/>
            <div class="flex-grow-1 w-65 p-2">
                <div class="d-flex">
                    <div class="d-flex align-items-center justify-content-center mb-3 w-50" style="height: 100px">
                        <livewire:measure.filter-periods :periodId="$periodId"/>
                    </div>
                    <div class="flex-grow-1">
                        <livewire:strategy.advances-by-unit-dashboard :periodId="$periodId"/>
                    </div>
                </div>
                <livewire:strategy.dashboard :periodId="$periodId" :model="$plan" :type="$type"/>
            </div>
        </div>
    @endif
@endsection

