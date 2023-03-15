@extends('layouts.admin')

@section('title', trans('general.module_strategy'))


@section('subheader')

    <h1 class="subheader-title">
        <x-layout.title title="{{ trans_choice('general.templates', 2) }}" class="fal fa-folder-tree text-primary"></x-layout.title>
    </h1>
    @if(Gate::check('strategy-template-crud-strategy') || Gate::check('strategy-crud-strategy'))
        <div class="subheader-block d-lg-flex align-items-center">
            <x-layout.button name="{{ __('general.add_template_strategy') }}"
                            class="btn btn-success btn-sm"
                            data-toggle="modal"
                            data-target="#new-modal-template">
                <span class="fas fa-plus mr-1"></span>
            </x-layout.button>
        </div>
    @endif

@endsection

@section('content')
    <livewire:strategy.template-list/>
@endsection

@include('partials.admin.flash-message-event')