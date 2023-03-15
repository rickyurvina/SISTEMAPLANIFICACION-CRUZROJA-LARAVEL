@extends('layouts.admin')

@section('title', trans('general.title.edit', ['type' => trans_choice('general.companies', 1)]))

@section('subheader-title')
    <i class="fal fa-plus text-primary"></i>
    {{ trans('general.title.edit', ['type' => trans_choice('general.companies', 1)]) }}

@section('subheader')
    <h1 class="subheader-title pl-1">
        <i class="fal fa-landmark text-primary"></i>
        {{ trans('general.title.edit', ['type' => trans_choice('general.companies', 1)]) }}
    </h1>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">{{ trans_choice('general.companies', 2) }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('companies.show', $company) }}">{{ $company->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('general.edit') }}</li>
        </ol>
    </nav>

    <div class="border px-3 pt-3 pb-0 rounded">
        <ul class="nav nav-justified nav-pills" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#information">
                    <i class="fal fa-home mr-1"></i>{{ trans('general.general_information') }}</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#addresses">
                    <i class="fas fa-map-marker-alt mr-1"></i>{{ trans_choice('general.address', 0) }}</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#social_profiles">
                    <i class="fas fa-users mr-1"></i>{{ trans('general.social_profiles') }}</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#daughter_institutions">
                    <i class="fas fa-school mr-1"></i>{{ trans('general.daughter_institutions') }}</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#associated_documents">
                    <i class="fas fa-folder-open mr-1"></i>{{ trans('general.associated_documents') }}</a></li>
        </ul>

        <div class="tab-content py-3">

            <livewire:admin.company-edit :idCompany="$id" />

            <livewire:admin.addresses-form :idCompany="$id" />

            <livewire:admin.social-net-works-form :idCompany="$id" />

            <livewire:admin.daughter-institutions-form :idCompany="$id" />

            <livewire:admin.associated-documents-form />

        </div>

    </div>

@endsection
