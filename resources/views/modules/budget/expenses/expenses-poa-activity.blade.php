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
            <a href="{{ route('budgets.expenses_poas',$transaction->id) }}">
                {{$activity->first()->program->poa->name}}
            </a>
        </li>

        <li class="breadcrumb-item active"> {{$activity->name}}</li>
    </ol>
@endsection
@section('expenses-page')
    <livewire:budget.expenses.poa.expense-poa-activity-index :idTransaction="$transaction->id" :idActivity="$activity->id"/>
@endsection
