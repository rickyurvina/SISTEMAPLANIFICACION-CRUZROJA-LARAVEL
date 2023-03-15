@extends('layouts.admin')

@section('title', trans('poa.card_reports'))
@section('subheader')

@endsection
@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0 mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('budget.budgetDocumentReport') }}">
                CÉDULA PRESUPUESTARIA
            </a>
        </li>
        <li class="breadcrumb-item active"> {{$account->code}}</li>
    </ol>
@endsection
@section('content')


    <livewire:budget.reports.account-report :account="$account"/>

@endsection