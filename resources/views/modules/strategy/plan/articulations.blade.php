@extends('layouts.admin')

@section('title', trans_choice('general.articulations', 1))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-arrow-alt-right"></i> {{ trans_choice('general.articulations', 1) }} - {{$plan->name}}
    </h1>
@endsection

@section('content')
    <livewire:strategy.plan-articulations  :planId="$planId"/>
@endsection

@push('page_script')

@endpush