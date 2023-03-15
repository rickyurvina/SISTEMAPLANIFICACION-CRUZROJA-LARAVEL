@extends('layouts.admin')

@section('title', trans_choice('process.process',0))
@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0">
        <li class="breadcrumb-item">

            <a href="{{ route('processes.index') }}">
                Gerencias
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('process.showProcess', $process->department_id) }}">
                {{ trans_choice('process.process',1) .' de '.  $process->department->name }}
            </a>
        </li>
        <li class="breadcrumb-item active" style="overflow: unset"> {{ trans_choice('process.process',0) .': '.$process->name }}</li>
    </ol>
@endsection
@push('css')
    <style>

        .subheader {
            margin-bottom: 0 !important;
        }
    </style>
@endpush
@section('content')
    <livewire:process.process-navigation :process="$process" :page="$page" :subMenu="$subMenu"/>
    <div class="w-100">
        @yield('process-page')
    </div>
@endsection

