@extends('layouts.admin')

@section('title', trans_choice('budget.budget', 1))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fas fa-dollar-sign"></i> {{ trans_choice('budget.budget', 2) }}
    </h1>

    <a href="javascript:void(0);" class="btn btn-success btn-sm" data-toggle="modal" data-target="#budgets-create"
       class="btn btn-success btn-sm"><span class="fas fa-plus mr-1"></span>
        &nbsp;{{ trans('general.add_new') }}
    </a>

@endsection

@section('content')

    @if($budgets->count()>0)
        <div class="table-responsive">
            <table class="table table-light">
                <thead>
                <tr>
                    <th class="table-th">@sortablelink('year', trans('general.year'))</th>
                    <th class="table-th">@sortablelink('description', trans('general.description'))</th>
                    <th class="table-th">@sortablelink('status', trans('general.status'))</th>
                    <th class="table-th">@sortablelink('approved_by', trans('general.approved_by'))</th>
                    <th class="table-th">@sortablelink('approved_date', trans('general.date_approved'))</th>
                    <th class="table-th"><a href="#">{{  trans('budget.incomes') }}</a></th>
                    <th class="table-th"><a href="#">{{  trans('budget.expense') }}</a></th>
                    <th class="table-th"><a href="#">{{  trans('general.actions') }}</a></th>
                </tr>
                </thead>
                <tbody>
                @foreach($budgets as $item)
                    <tr>
                        <td>
                            <a href="{{ route('budgets.show', $item->id) }}">{{ $item->year }}</a>
                        </td>
                        <td>{{ $item->description }}</td>
                        <td>
                        <span class="badge {{ $item->status->color() }}">
                            {{ $item->status->label() }}
                        </span>
                        </td>
                        <td>
                            @if($item->approver)
                                <div class="d-flex">
                                    <div class="" data-toggle="tooltip" data-placement="top"
                                         title="{{ $item->approver->getFullName() }}" data-original-title="{{ $item->approver->getFullName() }}">
                                    <span class="mr-2">
                                        <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle width-1">
                                    </span>
                                        <span class="pt-1">{{ $item->approver->getFullName() }}</span>
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td>{{  $item->approved_date ? $item->approved_date->format('F j, Y'): '' }}</td>
                        @if($item->status instanceof \App\States\Transaction\Approved)
                            <td class="@if( $item->codedBalanceBudgetIncomes()->getAmount() !=  $item->codedBalanceBudgetExpenses()->getAmount()) color-warning-900 @else color-success-500 @endif">
                                {{ $item->codedBalanceBudgetIncomes() }}
                            </td>
                            <td class="@if( $item->codedBalanceBudgetIncomes()->getAmount() !=  $item->codedBalanceBudgetExpenses()->getAmount())  color-warning-900 @else color-success-500 @endif">
                                {{ $item->codedBalanceBudgetExpenses() }}
                            </td>
                        @else
                            <td class="@if( $item->codedBalanceBudgetIncomes()->getAmount() !=  $item->codedBalanceBudgetExpenses()->getAmount()) color-warning-900 @else color-success-500 @endif">
                                {{ $item->codedBalanceBudgetIncomes() }}
                            </td>
                            <td class="@if( $item->codedBalanceBudgetIncomes()->getAmount() !=  $item->codedBalanceBudgetExpenses()->getAmount())  color-warning-900 @else color-success-500 @endif">
                                {{ $item->codedBalanceBudgetExpenses() }}
                            </td>
                        @endif
                        <td>
                            @if($item->totalBalance->isZero() && ($item->status instanceof  \App\States\Transaction\Draft))
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#budgets-approve" data-budget-id="{{$item->id}}" class="mr-2">
                                    <i class="fas fa-check-circle text-info"></i>
                                </a>
                            @endif
                            <a href="{{ route('budgets.show', $item->id) }}" title data-toggle="tooltip" data-placement="top" class="mr-2"
                               data-original-title="{{ trans_choice('general.details', 2) }}"><i class="fas fa-tasks-alt mr-1 text-info"></i>
                            </a>
                            @if($item->status instanceof  \App\States\Transaction\Approved)
                                <a href="{{ route('budgets.reforms', $item->id) }}" title data-toggle="tooltip" data-placement="top" class="mr-2"
                                   data-original-title="{{ trans_choice('general.reforms', 2) }}"><i class="fas fa-exchange ml-1 text-warning"></i>
                                </a>
                            @endif
                            @if($item->status instanceof  \App\States\Transaction\Approved)
                                <a href="{{ route('budgets.certifications', $item->id) }}" title data-toggle="tooltip" data-placement="top" class="mr-2"
                                   data-original-title="{{ trans_choice('general.certifications', 2) }}"><i class="fas fa-check-circle ml-1 text-success"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <x-pagination :items="$budgets"/>
        </div>
    @else
        <x-empty-content>
            <x-slot name="title">
                {{ trans('general.no_budget_found') }}
            </x-slot>
        </x-empty-content>
    @endif

    <livewire:budget.actions.budgets-create/>
    <livewire:budget.actions.budgets-approve/>

@endsection
@push('page_script')
    <script>

        $('#budgets-approve').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('budget-id');
            //Livewire event trigger
            Livewire.emit('openApproveBudget', id);
        });
    </script>
@endpush