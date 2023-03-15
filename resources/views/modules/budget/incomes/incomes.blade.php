@extends('modules.budget.show')
@section('title', trans('budget.incomes'))

@section('budget-page')

    <div>
        <div class="d-flex flex-row mb-2 align-items-center justify-content-between">
            <h3 class="mb-0">{{ trans('budget.budget_incomes') }}</h3>
            <a href="javascript:void(0);" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#budget-income-create"
               class="btn btn-success btn-sm"><span class="fas fa-plus mr-1"></span>
                &nbsp;{{ trans('general.add_new') }}
            </a>
        </div>
        @if($incomes->count()>0)
            <div class="table-responsive">
                <table class="table table-light table-hover">
                    <thead>
                    <tr>
                        <th class="table-th w-20">@sortablelink('code', trans('general.item'))</th>
                        <th class="table-th w-30">@sortablelink('name', trans('general.name'))</th>
                        <th class="table-th w-30">@sortablelink('description', trans('general.description'))</th>
                        <th class="table-th w-10">@sortablelink('debit', trans('general.value'))</th>
                        <th class="table-th w-10"><a href="#">{{  trans('general.actions') }}</a></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($incomes as $item)
                        <tr class="tr-hover">
                            <td><span class="badge {{$item->is_new ? 'badge-warning' : '' }}  badge-pill fs-1x fw-700">{{ $item->code }}</span></td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            @if($transaction->status instanceof  \App\States\Transaction\Approved)
                                <td>{{ $item->getBalanceEncodedApproved($transaction) }} </td>
                            @else
                                <td>{{ $item->getBalanceEncodedDraft($transaction) }} </td>
                            @endif
                            <td>
                                @if($item->balanceRe->getAmount()==0)
                                    <div class="d-flex flex-wrap w-100">
                                        <div class="ml-2">
                                            <a href="#" data-toggle="modal" data-income-id="{{ $item->id }}"
                                               data-target="#budget-income-edit">
                                                <i class="fas fa-edit mr-1 text-info"></i>
                                            </a>
                                        </div>
                                        @if($transaction->status instanceof  \App\States\Transaction\Draft)
                                            <div class="ml-2">
                                                <x-delete-link action="{{ route('income.delete', $item->id) }}" id="{{ $item->id }}"/>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr style="background-color: #e0e0e0">
                        <td colspan="3"></td>
                        <td style="color: #008000" class="fs-2x fw-700">Total: {{ $total }}</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <x-pagination :items="$incomes"/>
        @else
            <x-empty-content>
                <x-slot name="img">
                    <i class="fas fa-money-bill-wave" style="color: #2582fd;"></i>
                </x-slot>
                <x-slot name="title">
                    No existen partidas presupuestarias creadas
                </x-slot>
                <div class="d-flex flex-column">
                    <a href="javascript:void(0);" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#budget-income-create"
                       class="btn btn-success btn-sm"><span class="fas fa-plus mr-1"></span>
                        &nbsp;{{ trans('general.add_new') }}
                    </a>
                </div>

            </x-empty-content>
        @endif
        <div wire:ignore>
            <livewire:budget.incomes.incomes-create :id="$transaction->id"/>
        </div>
        <div wire:ignore>
            <livewire:budget.incomes.incomes-edit/>
        </div>
    </div>
@endsection

@push('page_script')
    <script>
        $('#budget-income-edit').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let incomeId = $(e.relatedTarget).data('income-id');
            //Livewire event trigger
            Livewire.emit('loadIncome', incomeId);
        });

    </script>
@endpush