@extends('modules.budget.expenses.expenses')
@section('title', trans('budget.expense'))

@section('expenses-page')

    <livewire:budget.expenses.poa.budget-expenses-poa-activities :transaction="$transaction"/>

@endsection
