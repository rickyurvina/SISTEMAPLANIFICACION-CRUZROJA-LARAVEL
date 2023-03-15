@extends('layouts.admin')

@section('title', trans('general.module_projects'))

@push('stylesheet')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.css">
@endpush

@push('css')
    <style>
        .page-content {
            padding: 0 4px;
        }

        .subheader {
            margin-bottom: 0 !important;
        }
    </style>
@endpush

@section('content')
    <livewire:projects.layout.project-navigation :project="$project" :page="$page"/>
    <div class="w-100">
        @yield('project-page')
    </div>

@endsection

@push('page_script')
    <script></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales-all.js"></script>
@endpush
