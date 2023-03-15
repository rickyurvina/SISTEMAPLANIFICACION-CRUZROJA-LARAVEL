@extends('layouts.admin')

@section('title', trans_choice('budget.reforms', 1))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fas fa-money-bill"></i> {{ trans_choice('general.reforms', 2) }} {{$transaction->year}}
    </h1>
    <form action="{{route('budget.create-reform',$transaction)}}" method="post" style="display: contents !important">
        @csrf
        <button class="mr-2 border-0"
                id="btn-create-reform"
                style="border: 0 !important; background-color: transparent !important;">
            <i class="fas fa-plus mr-1 text-success"></i> {{ trans('general.create_reform') }}
        </button>
    </form>

@endsection

@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0 mb-0 mt-0">
        <li class="breadcrumb-item">
            <a href="{{ route('budgets.index') }}">
                Presupuestos
            </a>
        </li>
        <li class="breadcrumb-item active"> Reformas {{ $transaction->year }}</li>
    </ol>
@endsection


@section('content')
    <div wire:ignore>
        <livewire:budget.reforms.budget-reforms-index :transaction="$transaction"/>
    </div>
@endsection
@push('page_script')
    <script>
        $('#btn-create-reform').on('click', (e) => {
            e.preventDefault();
            let $form = e.currentTarget.form;
            Swal.fire({
                title: 'Confirmación',
                text: 'Se creará una nueva Reforma Presupuestaria, desea continuar?',
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: 'var(--success)',
                confirmButtonText: '<i class="fas fa-check-circle"></i> {{ trans('general.yes') . ', ' . trans('general.save') }}',
                cancelButtonText: '<i class="fas fa-times"></i> {{ trans('general.no') . ', ' . trans('general.cancel') }}'
            }).then((result) => {
                if (result.value) {
                    $form.submit();
                }
            });
        })

    </script>
@endpush