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
        <li class="breadcrumb-item">
            <a href="{{ route('budgets.expenses',$transaction->id) }}">
                {{ trans('budget.expense') }}
            </a>
        </li>

        @if(isset($activities)  && $activities->count()>0)
            <li class="breadcrumb-item active">  {{ $activities->first()->program->poa->name }}</li>
        @endif
    </ol>
@endsection