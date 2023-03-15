@extends('layouts.admin')

@section('title', trans('general.module_strategy'))


@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-folder-tree text-primary"></i> <span class="fw-300">{{ __('general.edit') . ' ' . trans_choice('general.templates', 1) }}</span>
    </h1>

    <div class="subheader-block d-lg-flex align-items-center">
        <a href="{{ route('templates.index') }}" class="btn btn-info btn-sm"><span class="fas fa-reply mr-1"></span>
            {{ __('general.go_back') }}</a>
    </div>

@endsection

@section('content')
    <livewire:strategy.template-edit :templateId="$id"/>
@endsection


