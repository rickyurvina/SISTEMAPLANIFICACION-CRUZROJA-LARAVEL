@if($viewPoa)
    @if( isset($activitiesPoa)  && $activitiesPoa->count()>0)
        <div class="d-flex align-items-start">
            <div class="w-100">
                <div class="table-responsive">
                    <table class="table table-light table-hover">
                        <thead>
                        <tr>
                            <th class="w-15">@sortablelink('planDetail.name', trans_choice('general.programs', 1))</th>
                            <th class="w-15">@sortablelink('indicator.name', trans_choice('general.indicators', 1))</th>
                            <th class="w-25">@sortablelink('name', __('poa.name'))</th>
                            <th class="w-25">Saldo</th>
                            <th class="w-15">@sortablelink('responsible.name', __('general.responsible'))</th>
                            <th class="w-25">{{trans('general.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($activitiesPoa as $item)
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
                                <td>{{ $item->getTotalBudget($transactionPr) }}</td>
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
                                    <a href="javascript:void(0)" class="mr-2" wire:click="loadPoaActivity({{$item->id}})"
                                       data-toggle="tooltip"
                                       data-placement="top" title=""
                                       data-original-title="{{trans('general.create')}}{{trans_choice('general.certifications',1)}}">
                                        <i class="fas fa-check-circle color-success-700"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endif

@if($viewPoaActivity)
    @include('modules.budget.certifications.create.header-poa')
    @if($expensesPoa->count()>0)
        <div class="table-responsive">
            <table class="table table-light table-hover">
                @include('modules.budget.certifications.create.header-table-form')
                <tbody>
                @foreach($expensesPoa as $item)
                    @include('modules.budget.certifications.create.body-table-form')
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endif
