@extends('layouts.admin')

@section('title', trans('general.title.create', ['type' => trans_choice('general.companies', 1)]))

@section('subheader-title')
    <i class="fal fa-plus text-primary"></i> {{ trans('general.title.create', ['type' => trans_choice('general.companies', 1)]) }}
@endsection

@section('content')
    <div class="border px-3 pt-3 pb-0 rounded">
        <ul class="nav nav-pills" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#information"><i
                            class="fal fa-home mr-1"></i>{{ trans('general.general_information') }}</a></li>
        </ul>
        <div class="tab-content py-3">
            <livewire:admin.company-form/>
        </div>
    </div>
@endsection