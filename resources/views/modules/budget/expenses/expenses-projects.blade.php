@extends('modules.budget.expenses.expenses')
@section('title', trans('budget.expense'))

@section('expenses-page')

    <livewire:budget.expenses.project.budget-expenses-projects-activities :transaction="$transaction"/>

@endsection
