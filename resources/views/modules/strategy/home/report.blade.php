@extends('layouts.admin')

@section('title', trans('auth.login'))

@section('content')
    <livewire:common.index-poa/>
@endsection
@push('page_script')
    <script>
        $('subheader').hide();
    </script>
@endpush