@extends('layouts.admin')

@section('title', trans_choice('general.plan', 2))

@section('subheader-title')
    <i class="fal fa-align-left text-primary"></i>
@endsection
@push('css')
    <style>
        .subheader {
            margin-bottom: 0 !important;
        }
    </style>
@endpush

@section('content')

    <livewire:strategy.strategy-show-indicators-plan-details :planDetailId="$planDetailId" :type="$type" :navigation="$navigation"/>

@endsection


