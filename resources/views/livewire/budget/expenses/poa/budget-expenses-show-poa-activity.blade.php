<div wire:ignore.self class="modal fade in" id="show-budget-expenses-poa-activity" tabindex="-1" role="dialog"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" wire:click="resetForm()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>

            <div class="modal-body">
                @if($activity)
                    <div class="d-flex flex-column">
                        <x-label-section>{{ trans_choice('general.details', 2) }}</x-label-section>
                        <div class="section-divider"></div>
                        <div class="d-flex">
                            <div class="flex-grow-1 w-50" style="overflow: hidden auto">
                                <div class="pl-2 content-detail">
                                    <div class="d-flex flex-wrap">
                                        <x-label-detail>{{ trans('general.name') }}</x-label-detail>
                                        <x-content-detail>
                                            {{ $activity->name }}
                                        </x-content-detail>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <x-label-detail>{{ trans('general.description') }}</x-label-detail>
                                        <x-content-detail>
                                            {!! $activity->description  !!}
                                        </x-content-detail>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <x-label-detail>{{ trans('general.responsible') }}</x-label-detail>
                                        <x-content-detail>
                                            @if($activity->responsible)
                                                <span class="mr-2">
                                                    <img src="{{ asset_cdn('img/user.svg') }}" class="rounded-circle width-1">
                                                </span>
                                                {{ $activity->responsible->name }}
                                            @else
                                                <span class="mr-2">
                                                    <img src="{{ asset_cdn('img/user_off.png') }}" class="rounded-circle width-1">
                                                </span>
                                                {{ trans('general.not_assigned') }}
                                            @endif
                                        </x-content-detail>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <x-label-detail>{{ trans('general.poa_activity_impact') }}</x-label-detail>
                                        <x-content-detail>
                                            <i class="{{ \App\Models\Poa\PoaActivity::CATEGORIES[$activity->impact]['icon'] }} mx-1 fw-700"></i>
                                            <span>{{ \App\Models\Poa\PoaActivity::CATEGORIES[$activity->impact]['text'] }}</span>
                                        </x-content-detail>
                                    </div>

                                    <div class="d-flex flex-wrap">
                                        <x-label-detail>{{ trans('general.poa_activity_complexity') }}</x-label-detail>
                                        <x-content-detail>
                                            <i class="{{ \App\Models\Poa\PoaActivity::CATEGORIES[$activity->complexity]['icon'] }} mx-1 fw-700"></i>
                                            <span>{{ \App\Models\Poa\PoaActivity::CATEGORIES[$activity->complexity]['text'] }}</span>
                                        </x-content-detail>
                                    </div>

                                    <div class="d-flex flex-wrap">
                                        <x-label-detail>{{ trans('general.poa_activity_cost') }}</x-label-detail>
                                        <x-content-detail>{{ $activity->getTotalBudget($transaction) }}</x-content-detail>
                                    </div>

                                </div>
                            </div>
                            <div class="flex-grow-1 w-50" style="overflow: hidden auto">
                                <div class="pl-2 content-detail">
                                    <div class="d-flex flex-wrap">
                                        <x-label-detail>{{ trans('general.poa_activity_location') }}</x-label-detail>
                                        <x-content-detail>{{ $activity->location->description }}</x-content-detail>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <x-label-detail>{{ trans('general.goal') }}</x-label-detail>
                                        <x-content-detail>{{ $activity->goal}}</x-content-detail>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <x-label-detail>{{ trans('general.progress') }}</x-label-detail>
                                        <x-content-detail>{{ $activity->progress }}</x-content-detail>
                                    </div>
                                </div>

                                <div class="content-detail">
                                    <x-label-section>{{ trans('general.alignment') }}</x-label-section>
                                    <div class="section-divider"></div>

                                    <div class="d-flex flex-wrap">
                                        <x-label-detail>{{ trans_choice('general.poa_program', 1) }}</x-label-detail>
                                        <x-content-detail>{{ $activity->planDetail ? $activity->planDetail->name:'' }}</x-content-detail>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <x-label-detail>{{ trans_choice('general.indicators', 1) }}</x-label-detail>
                                        <x-content-detail>{{ $activity->indicator ? $activity->indicator->name:'' }}</x-content-detail>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column">
                        <x-label-section>{{ trans_choice('budget.budget',1) }}</x-label-section>
                        <div class="section-divider"></div>
                        @if($expenses->count()>0)
                            <div class="table-responsive">
                                <table class="table table-light table-hover">
                                    <thead>
                                    <tr>
                                        <th class="table-th w-30"> {{trans('general.item')}}</th>
                                        <th class="table-th w-30">{{ trans('general.name')}}</th>
                                        <th class="table-th w-10">{{trans('general.description')}}</th>
                                        <th class="table-th w-20">{{trans('general.value')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($expenses as $item)
                                        <tr class="tr-hover">
                                            <td>{{ $item->code }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->description }}</td>
{{--                                            <td>{{ $item->balance }} </td>--}}
                                            <td>{{ $item->balanceDraft($transaction->status) }} </td>

                                        </tr>
                                    @endforeach
{{--                                    <tr style="background-color: #e0e0e0">--}}
{{--                                        <td colspan="3"></td>--}}
{{--                                        <td style="color: #008000" class="fs-2x fw-700">{{ $activity->getTotalBudget($transaction) }}</td>--}}
{{--                                    </tr>--}}
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <x-empty-content>
                                <x-slot name="img">
                                    <i class="fas fa-money-bill-wave" style="color: #2582fd;"></i>
                                </x-slot>
                                <x-slot name="title">
                                    No existen partidas presupuestarias creadas
                                </x-slot>
                            </x-empty-content>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

