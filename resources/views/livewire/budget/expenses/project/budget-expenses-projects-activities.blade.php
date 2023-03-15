@include('modules.budget.expenses.project.index.breadcrumb')
<div>
    @if(count($projects) > 0)
        @include('modules.budget.expenses.project.index.search-navigation')
        <div class="d-flex align-items-start">
            <div class="w-100">
                @if($activities->count()>0)
                    <div class="table-responsive">
                        <table class="table table-light table-hover">
                            <thead>
                            <tr>
                                <th class="w-15">@sortablelink('planDetail.name', trans_choice('general.project', 1))
                                </th>
                                <th class="w-25">@sortablelink('name', __('poa.name'))</th>
                                <th class="w-15">@sortablelink('indicator.name', trans_choice('general.indicators',
                                    1))
                                </th>
                                <th class="w-15">@sortablelink('responsible.name', __('general.responsible'))</th>
                                <th class="w-25">@sortablelink('name', __('poa.budget'))</th>
                                <th class="w-25">{{trans('general.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($activities as $item)
                                <tr class="tr-hover" wire:loading.class.delay="opacity-50">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span>{{ $item->project->name }}</span>
                                        </div>
                                    </td>
                                    <td><a href="javascript:void(0);" aria-expanded="false"
                                           data-toggle="modal"
                                           data-target="#show-budget-expenses-project-activity"
                                           data-activity-id="{{$item->id}}">{{ $item->code ? $item->code . ' - ':'' }}{{ $item->text }}</a>
                                    </td>
                                    <td>{{ $item->measure ? $item->measure->name: 'Sin Indicador Asociado' }}</td>
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
                                    <td>{{ $item->getTotalBudget($transaction)}}</td>
                                    <td>
                                        <div class="d-flex flex-wrap">
                                            @if($item->validateCrateBudget())
                                                <a href="{{route('budgets.expenses_project_activity',['transaction'=>$transaction,'activity'=>$item->id])}}"
                                                   class="mr-2"
                                                   data-toggle="tooltip"
                                                   data-placement="top" title=""
                                                   data-original-title="{{ trans('budget.budget_items') }}">
                                                    <i class="fas fa-money-bill"></i>
                                                </a>
                                            @endif
                                            <a href="javascript:void(0);" aria-expanded="false"
                                               data-toggle="modal"
                                               data-target="#show-budget-expenses-project-activity"
                                               data-activity-id="{{$item->id}}">
                                                <i class="fas fa-search mr-1 text-info"
                                                   data-toggle="tooltip" data-placement="top" title=""
                                                   data-original-title="Ver Actividad"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <span class="color-fusion-500 fs-3x py-3"><i
                                                        class="fas fa-exclamation-triangle color-warning-900"></i>
                                                No se encontraron actividades
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <x-pagination :items="$activities"/>
                @else
                    <x-empty-content>
                        <x-slot name="title">
                            {{ trans('general.there_are_no_activities') }}
                        </x-slot>
                    </x-empty-content>
                @endif
            </div>
        </div>
        <div wire:ignore>
            <livewire:budget.expenses.project.budget-expenses-show-project-activity :transaction="$transaction"/>
        </div>
    @else
        <x-empty-content>
            <x-slot name="title">
                {{ trans('general.there_are_no_projects') }}
            </x-slot>
        </x-empty-content>
    @endif
</div>
@push('page_script')
    <script>
        $('#show-budget-expenses-project-activity').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let activityId = $(e.relatedTarget).data('activity-id');

            //Livewire event trigger
            Livewire.emit('loadActivity', activityId);
        });
    </script>
@endpush