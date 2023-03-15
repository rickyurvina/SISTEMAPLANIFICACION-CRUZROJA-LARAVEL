<div class="pl-2 pt-2">
    <div class="content-detail">
        <div class="d-flex flex-column">
            <div class="d-flex flex-nowrap mt-2">
                <div class="w-100">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped w-100 dataTable no-footer dtr-inline">
                            <thead>
                            <tr>
                                <th class="w-20 table-th">{{__('general.name')}}</th>
                                <th class="w-5 table-th">{{__('general.code')}}</th>
                                <th class="w-auto table-th">{{trans_choice('general.indicators',2)}}</th>
                                <th class="w-10 table-th">Meta</th>
                                <th class="w-10 table-th">Avance</th>
                                <th class="w-15 table-th">Progreso</th>
                                <th>{{trans('general.responsible')}}</th>
                                <th class="w-10 text-center table-th">{{ trans('general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="8" class="table-info h-25 text-center">Objetivos</td>
                            </tr>
                            @foreach($objectives as $objective)
                                @foreach($objective->indicators as $indicator)
                                    <tr>
                                        @if($loop->first)
                                            <th class="w-20 table-th align-middle align-items-center text-center"
                                                rowspan="{{$objective->indicators->count()}}">{{$objective->name}}</th>
                                        @endif
                                        <th class="w-5 table-th">{{$indicator->code}}</th>
                                        <th class="w-auto table-th">{{$indicator->name}}</th>
                                        <th class="w-15 table-th">{{$indicator->total_goal_value}}</th>
                                        <th class="w-5 table-th">{{$indicator->total_actual_value}}</th>
                                        <td>
                                            <span class="form-label badge {{$indicator->getStateIndicator()[0]?? null}}  badge-pill">{{$indicator->getStateIndicator()[1]?? null}}%</span>
                                        </td>
                                        <th>
                                            <div class="dropdown-item">
                                                                            <span class="mr-2">
                                                                                <img src="http://cre.test/img/user.svg" class="rounded-circle width-1">
                                                                            </span>
                                                <span class="pt-1">{{ $indicator->user->getFullName() }}</span>
                                            </div>
                                        </th>
                                        <th class="w-10 text-center table-th">
                                            <div class="d-flex flex-wrap"
                                                 wire:key="{{ 'r.i.' . $loop->index }}">
                                                <div class="w-25 cursor-pointer"
                                                     wire:click="$emitTo('indicators.indicator-show', 'open', {{ $indicator->id }})">
                                                                            <span class="color-info-700"><i class="far fa-eye" aria-expanded="false"
                                                                                                            data-toggle="tooltip" data-placement="top" title=""
                                                                                                            data-original-title="Ver"></i></span>
                                                </div>
                                                <div class="w-25 cursor-pointer"
                                                     wire:click="$emit('triggerAdvance','{{ $indicator->id }}')">
                                                                            <span class="color-success-700"><i class="far fa-calendar-alt" aria-expanded="false"
                                                                                                               data-toggle="tooltip" data-placement="top" title=""
                                                                                                               data-original-title="Avance"></i></span>
                                                </div>
                                                <div class="w-25 cursor-pointer"
                                                     wire:click="$emit('triggerEdit', '{{ $indicator->id }}')">
                                                                            <span class="color-info-700"><i class="fas fa-pencil-alt" aria-expanded="false"
                                                                                                            data-toggle="tooltip" data-placement="top" title=""
                                                                                                            data-original-title="Editar"></i></span>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                @endforeach
                            @endforeach
                            <tr>
                                <td colspan="8" class="table-info h-25 text-center">Indicadores de Resultados</td>
                            </tr>
                            @foreach($results as $result)
                                @foreach($result->indicators as $indicatorR)
                                    <tr>
                                        @if($loop->first)
                                            <th class="w-20 table-th align-middle align-items-center text-center"
                                                rowspan="{{$result->indicators->count()}}">{{$result->text}}</th>
                                        @endif
                                        <th class="w-5 table-th">{{$indicatorR->code}}</th>
                                        <th class="w-auto table-th">{{$indicatorR->name}}</th>
                                        <th class="w-15 table-th">{{$indicatorR->total_goal_value}}</th>
                                        <th class="w-5 table-th">{{$indicatorR->total_actual_value}}</th>
                                        <td>
                                            <span class="form-label badge {{$indicatorR->getStateIndicator()[0]?? null}}  badge-pill">{{$indicatorR->getStateIndicator()[1]?? null}}%</span>
                                        </td>
                                        <th>
                                            <div class="dropdown-item">
                                                                            <span class="mr-2">
                                                                                <img src="http://cre.test/img/user.svg" class="rounded-circle width-1">
                                                                            </span>
                                                <span class="pt-1">{{ $indicatorR->user->getFullName() }}</span>
                                            </div>
                                        </th>
                                        <th class="w-10 text-center table-th">
                                            <div class="d-flex flex-wrap"
                                                 wire:key="{{ 'r.i.' . $loop->index }}">
                                                <div class="w-25 cursor-pointer"
                                                     wire:click="$emitTo('indicators.indicator-show', 'open', {{ $indicatorR->id }})">
                                                                            <span class="color-info-700"><i class="far fa-eye" aria-expanded="false"
                                                                                                            data-toggle="tooltip" data-placement="top" title=""
                                                                                                            data-original-title="Ver"></i></span>
                                                </div>
                                                <div class="w-25 cursor-pointer"
                                                     wire:click="$emit('triggerAdvance','{{ $indicatorR->id }}')">
                                                                            <span class="color-success-700"><i class="far fa-calendar-alt" aria-expanded="false"
                                                                                                               data-toggle="tooltip" data-placement="top" title=""
                                                                                                               data-original-title="Avance"></i></span>
                                                </div>
                                                <div class="w-25 cursor-pointer"
                                                     wire:click="$emit('triggerEdit', '{{ $indicatorR->id }}')">
                                                                            <span class="color-info-700"><i class="fas fa-pencil-alt" aria-expanded="false"
                                                                                                            data-toggle="tooltip" data-placement="top" title=""
                                                                                                            data-original-title="Editar"></i></span>
                                                </div>

                                            </div>
                                        </th>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
