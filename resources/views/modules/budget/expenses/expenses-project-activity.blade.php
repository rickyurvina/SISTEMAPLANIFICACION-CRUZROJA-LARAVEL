@extends('modules.budget.expenses.expenses')
@section('title', trans_choice('budget.expense',1))

@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0 mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('budgets.index') }}">
                Presupuestos
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('budgets.show',$transaction->id) }}">
                Presupuesto {{$transaction->year}}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('budgets.expenses',$transaction->id) }}">
                {{trans('budget.expense')}}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('budgets.expenses_projects',$transaction->id) }}">
                {{$activity->project->name}}
            </a>
        </li>

        <li class="breadcrumb-item active"> {{$activity->text}}</li>
    </ol>
@endsection
@section('expenses-page')
    <div>
        <livewire:budget.expenses.project.budget-project-activity-index :idTransaction="$transaction->id" :idActivity="$activity->id"/>
    </div>
@endsection
