@extends('layouts.admin')

@section('title', trans_choice('budget.classifier',1))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-archive"></i> {{trans_choice('budget.classifier',1) }}
    </h1>
    @can('budget-crud-budget')
    <a href="javascript:void(0);" class="btn btn-success btn-sm"><span class="fas fa-plus mr-1"></span>
        &nbsp;{{ trans('general.add_new') }}
    </a>
    @endcan
@endsection

@section('content')

{{--    <livewire:budget.catalogs.budget-classifier/>--}}
@endsection
@push('page_script')
    <script>

    </script>
@endpush