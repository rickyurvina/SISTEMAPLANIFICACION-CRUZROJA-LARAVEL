@extends('layouts.admin')

@section('title', trans('general.module_strategy'))

@section('content')
    <livewire:strategy.report-indicators-strategy/>
@endsection
@push('page_script')
    <script>
        $('subheader').hide();
    </script>
@endpush