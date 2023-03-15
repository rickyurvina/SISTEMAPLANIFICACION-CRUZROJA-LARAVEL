@extends('layouts.admin')

@section('title', trans_choice('budget.incomes',1))

@section('subheader')
    <style>
        .subheader {
            margin-bottom: 0 !important;
            margin-top: 0 !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0 mb-0 mt-0">
        <li class="breadcrumb-item">
            <a href="{{ route('budgets.index') }}">
                Presupuestos
            </a>
        </li>
        <li class="breadcrumb-item active"> Presupuesto {{ $transaction->year }}</li>
    </ol>
@endsection


@section('content')

    <div class="d-flex flex-row">
        <div class="card mb-2 mr-3 w-15 @if($page == 'incomes') bg-gray-200 @endif">
            <div class="card-body">
                <a href="{{ route('budgets.incomes', $transaction->id) }}"
                   class="d-flex flex-row align-items-center @if($incomesBalanceShow !=  $expensesBalanceShow)  color-warning-900 @else color-success-500 @endif">
                    <div class="icon-stack display-3 flex-shrink-0">
                        <i class="fal fa-circle icon-stack-3x opacity-100 @if($incomesBalanceShow !=  $expensesBalanceShow)  color-warning-900 @else color-success-500 @endif"></i>
                        <i class="fas fa-sack-dollar icon-stack-1x opacity-100 @if($incomesBalanceShow !=  $expensesBalanceShow) color-warning-900 @else color-success-500 @endif"></i>
                    </div>
                    <div class="ml-3 fs-2x">
                        <strong>
                            {{ trans('budget.incomes') }}
                        </strong>
                        <br>
                        {{$incomesBalanceShow}}
                    </div>
                </a>
            </div>
        </div>

        <div class="card mb-2 mr-3 w-15 @if(in_array($page,['expenses','expensesPoaActivity','expensesPoa','expensesProject','expensesProjectActivity'])) bg-gray-200 @endif">
            <div class="card-body">
                <a href="{{ route('budgets.expenses', $transaction->id) }}"
                   class="d-flex flex-row align-items-center @if($incomesBalanceShow !=  $expensesBalanceShow) color-warning-900 @else color-success-500 @endif">
                    <div class="icon-stack display-3 flex-shrink-0">
                        <i class="fal fa-circle icon-stack-3x opacity-100 @if($incomesBalanceShow !=  $expensesBalanceShow) color-warning-900 @else color-success-500 @endif"></i>
                        <i class="fas fa-funnel-dollar icon-stack-1x opacity-100 @if($incomesBalanceShow !=  $expensesBalanceShow) color-warning-900 @else color-success-500 @endif"></i>
                    </div>
                    <div class="ml-3 fs-2x">
                        <strong>
                            {{ trans('budget.expense') }}
                        </strong>
                        <br>
                        {{ $expensesBalanceShow }}
                    </div>
                </a>
            </div>
        </div>

        <div class="card mb-2 w-15">
            <div class="card-body">
                <div class="d-flex flex-row align-items-center @if($incomesBalanceShow !=  $expensesBalanceShow)color-danger-500 @else color-success-500 @endif">
                    <div class="icon-stack display-3 flex-shrink-0">
                        <i class="fal fa-circle icon-stack-3x opacity-100 @if($incomesBalanceShow !=  $expensesBalanceShow) color-danger-500 @else color-success-500 @endif"></i>
                        <i class="fas fa-equals icon-stack-1x opacity-100 @if($incomesBalanceShow !=  $expensesBalanceShow) color-danger-500 @else color-success-500 @endif"></i>
                    </div>
                    <div class="ml-3 fs-2x">
                        <strong>
                            {{ trans('budget.balance') }}
                        </strong>
                        <br>
                        {{ $transaction->totalBalance }}
                    </div>
                </div>
            </div>
        </div>
        <div class="ml-4 w-20 align-items-center align-middle">
            <h1>
                <i class="fas fa-dollar-sign"></i> {{ trans_choice('budget.budget', 1) }} {{ trans('general.year') }}: {{ $transaction->year }}
            </h1>
        </div>
    </div>

    <div class="w-100">
        @yield('budget-page')
    </div>

@endsection
