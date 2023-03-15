@extends('modules.project.project')

@section('title', trans('general.budget_execution'))

@section('project-page')

    <div class="p-2">
        <livewire:budget.expenses.project.budget-project-activity-index :idTransaction="$transaction->id" :idActivity="$activity->id" :source="$source"/>
    </div>
@endsection