@extends('layouts.admin')

@section('title', trans('general.module_projects'))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-shopping-cart text-primary"></i> {{ trans_choice('general.public_purchases', 2) }}

    </h1>
    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add_public_purchases_modal">
        <i class="fas fa-plus mr-1"></i>
        {{ trans('general.create') }}
    </button>

@endsection

@section('content')

{{--  @include('flash::message')--}}
  <livewire:projects.configuration.public-purchases-create-form/>
  <livewire:projects.configuration.public-purchases-list/>

@endsection