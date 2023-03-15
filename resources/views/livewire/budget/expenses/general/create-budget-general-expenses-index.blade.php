<div>
    <div class="d-flex flex-column mt-3">
        <x-label-section>
            <i class="fa fa-money-bill mr-2"></i> Partidas Presupuestarias /
            <small class="text-black-50 d-inline"> Gastos Administrativos /</small>
            <small class="text-primary d-inline"> {{$budgetGeneralExpensesStructure->name}}</small>
        </x-label-section>
        <div class="section-divider"></div>
    </div>
    <div class="d-flex flex-row mb-2 align-items-center justify-content-between">
        <a href="javascript:void(0);" class="btn btn-outline-success btn-sm ml-auto" data-toggle="modal"
           data-target="#budget-expense-general-create"
           class="btn btn-success btn-sm"><span class="fas fa-plus mr-1"></span>
            &nbsp;{{ trans('general.add_new') }}
        </a>
    </div>
    @if($expenses->count()>0)
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
                @foreach($expenses as $item)
                    <tr class="tr-hover">
                        <td>
                            <span class="badge {{$item->is_new ? 'badge-warning' : '' }}  badge-pill fs-1x fw-700">{{ $item->code }}</span>
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->balanceDraft($transaction->status) }} </td>
                        <td>
                            <div class="d-flex flex-wrap w-100">
                                <div class="p-2" aria-expanded="false"
                                     data-toggle="tooltip" data-placement="top" title=""
                                     data-original-title=" {{trans('general.edit')}}">
                                    <a href="#" data-toggle="modal" data-expense-id="{{ $item->id }}"
                                       data-target="#budget-expense-general-edit">
                                        <i class="fas fa-edit mr-1 text-info"></i>
                                    </a>
                                </div>
                                <div class="p-2">
                                    <x-delete-link action="{{ route('budget-general.delete', $item->id ) }}" id="{{ $item->id }}"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                <tr style="background-color: #e0e0e0">
                    <td colspan="3"></td>
                    <td style="color: #008000" class="fs-2x fw-700">Total: {{$total}}</td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
        <x-pagination :items="$expenses"/>
    @else
        <x-empty-content>
            <x-slot name="img">
                <i class="fas fa-money-bill-wave" style="color: #2582fd;"></i>
            </x-slot>
            <x-slot name="title">
                No existen partidas presupuestarias creadas
            </x-slot>
            <div class="d-flex flex-column">
                <a href="javascript:void(0);" class="btn btn-outline-success btn-sm ml-auto" data-toggle="modal"
                   data-target="#budget-expense-general-create"
                   class="btn btn-success btn-sm"><span class="fas fa-plus mr-1"></span>
                    &nbsp;{{ trans('general.add_new') }}
                </a>
            </div>
        </x-empty-content>
    @endif

    <div wire:ignore>
        <livewire:budget.expenses.general.budget-create-general-expense :budgetGeneralExpensesStructure="$budgetGeneralExpensesStructure"/>
    </div>
    <div wire:ignore>
        <livewire:budget.expenses.general.budget-edit-general-expense :budgetGeneralExpensesStructure="$budgetGeneralExpensesStructure"/>
    </div>
</div>
@push('page_script')
    <script>
        $('#budget-expense-general-edit').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let expenseId = $(e.relatedTarget).data('expense-id');
            //Livewire event trigger
            debugger;
            Livewire.emit('loadExpense', expenseId);
        });

    </script>
@endpush