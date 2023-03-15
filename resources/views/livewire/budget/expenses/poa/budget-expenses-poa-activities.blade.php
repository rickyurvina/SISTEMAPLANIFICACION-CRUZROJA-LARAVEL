@include('modules.budget.expenses.poa.index.breadcrumb')
<div>
    @include('modules.budget.expenses.poa.index.search-navigation')
    @if( isset($activities)  && $activities->count()>0)
        <div class="d-flex align-items-start">
            <div class="w-100">
                <div class="table-responsive">
                    <table class="table table-light table-hover">
                        <thead>
                        <tr>
                            <th class="w-15">@sortablelink('planDetail.name', trans_choice('general.programs', 1))</th>
                            <th class="w-15">@sortablelink('indicator.name', trans_choice('general.indicators', 1))</th>
                            <th class="w-25">@sortablelink('name', __('poa.name'))</th>
                            <th class="w-25">@sortablelink('name', __('poa.budget'))</th>
                            <th class="w-15">@sortablelink('responsible.name', __('general.responsible'))</th>
                            <th class="w-25">{{trans('general.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($activities as $item)
                            <tr class="tr-hover" wire:loading.class.delay="opacity-50">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="w-35">
                                            <span class="color-item shadow-hover-5 mr-2 cursor-default" style="background-color: {{ $item->program->color }}"></span>

                                        </div>
                                        <div class="w-65">
                                            <span>{{ $item->planDetail->name }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->measure->name }}</td>
                                <td>
                                    <a href="javascript:void(0);" aria-expanded="false"
                                       data-toggle="modal"
                                       data-target="#show-budget-expenses-poa-activity"
                                       data-activity-id="{{$item->id}}">{{ $item->code ? $item->code . ' - ':'' }}{{ $item->name }}
                                    </a>
                                </td>
                                <td>{{ $item->getTotalBudget($transaction) }}</td>
                                <td>
                                    @if($item->responsible)
                                        <span class="mr-2">
                                        <img src="{{ asset_cdn('img/user.svg') }}" class="rounded-circle width-1">
                                    </span>
                                        {{ $item->responsible->name }}
                                    @else
                                        <span class="mr-2">
                                        <img src="{{ asset_cdn('img/user_off.png') }}" class="rounded-circle width-1">
                                    </span>
                                        {{ trans('general.not_assigned') }}
                                    @endif
                                </td>
                                <td>
                                    @if($item->validateCrateBudget())
                                        <a href="{{route('budgets.expenses_poa_activity',['transaction'=>$transaction,'activity'=>$item->id])}}" class="mr-2"
                                           data-toggle="tooltip"
                                           data-placement="top" title=""
                                           data-original-title="{{ trans('budget.budget_items') }}">
                                            <i class="fas fa-money-bill"></i>
                                        </a>
                                    @endif
                                    <a href="javascript:void(0);" aria-expanded="false"
                                       data-toggle="modal"
                                       data-target="#show-budget-expenses-poa-activity"
                                       data-activity-id="{{$item->id}}">
                                        <i class="fas fa-search mr-1 text-info"
                                           data-toggle="tooltip" data-placement="top" title=""
                                           data-original-title="Ver Actividad"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <x-pagination :items="$activities"/>
            </div>
        </div>
    @else
        <x-empty-content>
            <x-slot name="title">
                {{ trans('general.there_are_no_activities') }}
            </x-slot>
        </x-empty-content>
    @endif
    <div wire:ignore>
        <livewire:budget.expenses.poa.budget-expenses-show-poa-activity :transaction="$transaction"/>
    </div>
</div>
@push('page_script')
    <script>
        $('#show-budget-expenses-poa-activity').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let activityId = $(e.relatedTarget).data('activity-id');

            //Livewire event trigger
            Livewire.emit('loadActivity', activityId);
        });
    </script>
@endpush