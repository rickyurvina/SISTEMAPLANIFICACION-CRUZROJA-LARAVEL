@extends('layouts.admin')

@section('title', trans('general.change_control'))

@push('css')
    <style>
        .subheader {
            margin-bottom: 8px !important;
        }
    </style>
@endpush

@section('subheader')
@endsection

@section('content')
    <livewire:poa.change-control.poa-change-control :poaId="$poaId"/>
@endsection