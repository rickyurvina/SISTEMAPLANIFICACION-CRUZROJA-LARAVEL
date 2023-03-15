@extends('layouts.admin')

@section('title', trans('poa.card_reports'))
@section('subheader')
    <h1 class="p-2">
        <i class="fal fa-table text-primary"></i> CÉDULA PRESUPUESTARIA
    </h1>
@endsection

@section('content')

    <livewire:budget.reports.budget-document-report/>

@endsection