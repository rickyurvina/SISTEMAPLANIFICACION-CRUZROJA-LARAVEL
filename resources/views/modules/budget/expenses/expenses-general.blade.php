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


        <li class="breadcrumb-item active"> Gastos Administrativos</li>
    </ol>
@endsection
@section('expenses-page')
    <div>
        <livewire:budget.expenses.general.budget-expenses-index :transaction="$transaction"/>
    </div>
@endsection
