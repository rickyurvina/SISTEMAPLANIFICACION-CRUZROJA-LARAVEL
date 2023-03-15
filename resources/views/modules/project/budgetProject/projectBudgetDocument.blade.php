@extends('modules.project.project')


@section('title', trans('poa.card_reports'))
@section('subheader')
    <h1 class="p-2">
        <i class="fal fa-table text-primary"></i> CÉDULA PRESUPUESTARIA DEL PROYECTO
    </h1>
@endsection

@section('project-page')
    <livewire:projects.budget-project.project-budget-document :project="$project"/>
@endsection