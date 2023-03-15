@extends('modules.budget.show')

@section('title', trans('budget.expense'))

@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0 mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('budgets.index') }}">
                Presupuestos
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('budgets.show',$transaction->id) }}">
                Presupuesto {{ $transaction->year }}
            </a>
        </li>
        <li class="breadcrumb-item active">   {{ trans('budget.expense') }} </li>
    </ol>
@endsection


@section('budget-page')
    @if($page=='expenses')
        <div class="btn-group btn-group-sm">
            <a href="{{ route('budgets.expenses_poas',$transaction->id) }}" class="btn btn-outline-success">{{ trans('general.poa') }}</a>
            <a href="{{ route('budgets.expenses_projects',$transaction->id) }}" class="btn btn-outline-success">{{ trans_choice('general.project',2) }}</a>
            <a href="{{ route('budgets.general_expenses',$transaction->id) }}" class="btn btn-outline-success">{{ trans_choice('general.general_expenses',2) }}</a>
        </div>
    @endif
    <div class="w-100">
        @yield('expenses-page')
    </div>

@endsection
