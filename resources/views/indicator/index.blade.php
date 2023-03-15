@extends('layouts.admin')
@inject('Indicator','\App\Models\Indicators\Indicator\Indicator')
@section('title', trans_choice('general.indicators', 2))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-analytics text-primary"></i> {{ trans_choice('general.indicators', 2) }}
    </h1>
    @can('admin-crud-admin')
        <a href="javascript:void(0);" data-toggle="modal" data-target="#indicator-create-modal"
           class="btn btn-success btn-sm"><span class="fas fa-plus mr-1"></span>
            {{ trans('general.create') }} {{ trans('general.indicator') }}
        </a>
    @endcan
@endsection

@section('content')


    <livewire:indicators.indicators/>
    <livewire:indicators.indicator-create/>
@endsection
@push('page_script')
    <script>
        $('#indicator-edit-modal').on('hidden.bs.modal', function () {
            $('#registerAdvance').modal('hide');
        });

        @if($errors->any())
        $('#indicator-create-modal').modal('show');
        @endif
    </script>
@endpush