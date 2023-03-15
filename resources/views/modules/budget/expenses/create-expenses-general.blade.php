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
            <a href="{{ route('budgets.general_expenses',$transaction->id) }}">
                Gastos Administrativos
            </a>
        </li>
        <li class="breadcrumb-item active"> Crear Gasto de {{$budgetGeneralExpensesStructure->name}}</li>
    </ol>
@endsection
@section('expenses-page')
    <div>
        <livewire:budget.expenses.general.create-budget-general-expenses-index :expenses="$expenses" :transaction="$transaction" :budgetGeneralExpensesStructure="$budgetGeneralExpensesStructure" />
    </div>
@endsection
@push('page_script')
    <script>
        $('#budget-expense-general-edit').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let expenseId = $(e.relatedTarget).data('expense-id');
            //Livewire event trigger
            Livewire.emit('loadExpense', expenseId);
        });

    </script>
@endpush