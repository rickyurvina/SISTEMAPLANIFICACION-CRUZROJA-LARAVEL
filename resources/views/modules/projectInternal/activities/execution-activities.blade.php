<div class="pl-2 pt-2">
    <div class="content-detail">
        <div class="d-flex flex-column">
            <div class="d-flex flex-nowrap mt-2">
                <div class="flex-grow-1 w-auto" style="overflow: hidden auto">
                    <div class="d-flex flex-wrap">
                        <x-label-section>Cronograma- Año Fiscal {{ date("Y")}}</x-label-section>
                        <div class="ml-auto">
                            <x-label-section>Avance Físico {{ number_format($projectAdvance,2) }}%</x-label-section>
                        </div>
                        <div class="ml-auto">
                            <button type="button" class="btn btn-sm btn-outline-secondary mr-2" data-toggle="modal" data-target="#project-activities-weight"
                                    data-id="{{ $project->id }}">
                                {{ __('general.weight') }} {{ trans_choice('general.result', 2) }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary mr-4" data-toggle="modal" data-target="#project-activities-wbs"
                                    data-id="{{ $project->id }}">
                                WBS
                            </button>
                        </div>
                    </div>
                    <div class="section-divider"></div>
                    <div class="row">
                        <div class="col-10">
                            <div class="d-flex flex-wrap">
                                <x-label-detail>{{ trans_choice('general.project',1) }}</x-label-detail>
                                <x-content-detail>{{ $project->name}}</x-content-detail>
                            </div>
                            <div class="d-flex flex-wrap">
                                <x-label-detail>{{ trans('general.start_date') }}</x-label-detail>
                                <x-content-detail>{{$project->start_date?  $project->start_date->format('j F, Y') :'' }} </x-content-detail>
                            </div>
                            <div class="d-flex flex-wrap">
                                <x-label-detail>{{ trans('general.end_date') }}</x-label-detail>
                                <x-content-detail>{{$project->end_date? $project->end_date->format('j F, Y') :'' }}</x-content-detail>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="d-flex flex-wrap">
                                <x-label-detail>Terminada</x-label-detail>
                                <i class="fas fa-circle color-success-700 mt-2"></i>
                            </div>
                            <div class="d-flex flex-wrap">
                                <x-label-detail>En tiempo</x-label-detail>
                                <i class="fas fa-circle color-info-700 mt-2"></i>
                            </div>
                            <div class="d-flex flex-wrap">
                                <x-label-detail>Atraso</x-label-detail>
                                <i class="fas fa-circle color-danger-700 mt-2"></i>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="w-50">
                    <div class="row">
                        <div class="col-4 text-center">
                            <x-label-section> Estado A la Fecha</x-label-section>
                            <div class="mt-4" wire:ignore>
                                <div class="js-easy-pie-chart {{$project->calcSemaphore()}}
                                                                position-relative d-inline-flex align-items-center justify-content-center"
                                     data-percent="{{$project->getProgressUpDate()}}" data-piesize="100" data-linewidth="7" data-linecap="round"
                                     data-scalelength="7">
                                    <div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-xl">
                                        <span class="js-percent d-block text-dark"></span>
                                        <div class="d-block fs-xs text-dark opacity-70">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <x-label-section> Estado Actual Del Proyecto</x-label-section>
                            <div class="mt-4" wire:ignore>
                                <div class="js-easy-pie-chart color-info-700
                                                                position-relative d-inline-flex align-items-center justify-content-center"
                                     data-percent="{{$projectAdvance}}" data-piesize="100" data-linewidth="7" data-linecap="round" data-scalelength="7">
                                    <div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-xl">
                                        <span class="js-percent d-block text-dark"></span>
                                        <div class="d-block fs-xs text-dark opacity-70">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <x-label-section> % Avance de Tiempo</x-label-section>
                            <div class="mt-4">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                         style="width: {{$project->getProgressTimeUpDate()}}%" aria-valuenow="{{$project->getProgressTimeUpDate()}}"
                                         aria-valuemin="0" aria-valuemax="100">{{$project->getProgressTimeUpDate()}}%
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="section-divider"></div>
            <div class="d-flex flex-nowrap mt-2">
                <div class="w-100">
                    <div class="table-responsive">
                        <table class="table table-light table-hover">
                            <thead>
                            <tr>
                                <th class="w-5 table-th">{{__('general.code')}}</th>
                                <th class="w-auto table-th">{{__('general.activity')}}</th>
                                <th class="w-10 table-th">{{__('general.start_date')}}</th>
                                <th class="w-10 table-th">{{__('general.end_date')}}</th>
                                <th class="w-15 table-th">Tiempo Transcurrido</th>
                                <th class="w-5 table-th">Ponderación</th>
                                <th class="w-15 table-th">Progreso-SubTareas</th>
                                <th class="w-5 table-th">Estado</th>
                                <th class="w-5 table-th">Semaforo</th>
                                <th class="w-10 text-center table-th"><a href="#">{{ trans('general.actions') }} </a></th>
                            </tr>
                            <tr class="h-40px">
                                <th colspan="12" class="table-info h-25">
                                    Ejecución de Resultados y Actividades
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($results as $result)

                                <tr class="table-bordered table-secondary table-striped">
                                    <td>{{ $result->code}}</td>
                                    <td>
                                        @if($result->responsible)
                                            <a href="#" data-placement="top" title="{{$result->responsible->getFullName()}}"
                                               data-original-title="{{$result->responsible->getFullName()}}">
                                                ({{$result->responsible->shortNickName()??''}})
                                            </a>
                                        @endif
                                        {{$result->text}}
                                    </td>
                                    <td>{{ $result->start_date ? $result->start_date->format('j F, Y') :''}}</td>
                                    <td>{{ $result->end_date ? $result->end_date->format('j F, Y') : ''}}</td>
                                    <td>-</td>
                                    <td>{{ number_format($result->weight,2) }}</td>
                                    <td class="text-center">
                                        @if(number_format($result->progress) >0)
                                            <div class="progress">
                                                <div class="progress-bar bg-danger-300 bg-warning-gradient" role="progressbar"
                                                     style="width: {{ number_format($result->progress) }}%"
                                                     aria-valuenow="{{ number_format($result->progress) }}" aria-valuemin="0"
                                                     aria-valuemax="100"> {{ number_format($result->progress) }}%
                                                </div>
                                            </div>
                                        @else
                                            <span class="badge badge-secondary badge-pill">{{ number_format($result->progress) }}%</span>
                                        @endif
                                    </td>
                                    <td><i class="fal fa-minus color-light-700 fs-2x"></i></td>
                                    <td><i class="fal fa-minus color-light-700 fs-2x"></i></td>
                                    <td class="text-center"><i class="fal fa-minus color-danger-700 fs-2x"></i></td>
                                </tr>
                                @foreach($activities->where('parent',$result->id) as $activity)
                                    <tr>
                                        <td>{{$activity->code}}</td>
                                        <td> @if($activity->responsible)
                                                <a href="#" data-placement="top" title="{{$activity->responsible->getFullName()}}"
                                                   data-original-title="{{$activity->responsible->getFullName()}}">
                                                    ({{$activity->responsible->shortNickName()??''}})
                                                </a> @endif
                                            {{$activity->text}}-{{$activity->company->name}}
                                        </td>
                                        <td>{{ $activity->start_date ? $activity->start_date->format('j F, Y') :''}} </td>
                                        <td>{{$activity->end_date ? $activity->end_date->format('j F, Y'):''}}</td>
                                        @if($activity->start_date>=now())
                                            <td class="text-center"><span class="badge badge-secondary badge-pill">No Empieza</span></td>
                                        @else
                                            <td class="text-center">
                                                <div class="progress">
                                                    <div class="progress-bar bg-primary-700 bg-success-gradient" role="progressbar"
                                                         style="width: {{$activity->getProgressTimeUpDate()}}%"
                                                         aria-valuenow="{{$activity->getProgressTimeUpDate()}}" aria-valuemin="0"
                                                         aria-valuemax="100"> {{$activity->getProgressTimeUpDate()}}%
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                        <td>{{number_format($activity->weight,2) }}</td>
                                        <td class="text-center">
                                            @if(number_format($activity->progress) >0)
                                                <div class="progress">
                                                    <div class="progress-bar bg-danger-300 bg-warning-gradient" role="progressbar"
                                                         style="width: {{ number_format($activity->progress) }}%"
                                                         aria-valuenow="{{ number_format($activity->progress) }}" aria-valuemin="0"
                                                         aria-valuemax="100"> {{ number_format($activity->progress) }}%
                                                    </div>
                                                </div>
                                            @else
                                                <span class="badge badge-secondary badge-pill">{{ number_format($activity->progress) }}%</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ \App\Models\Projects\Activities\Task::STATUS_BGC[$activity->status] }} badge-primary badge-pill"> {{$activity->status}}</span>
                                        </td>
                                        <td class="text-center"><i
                                                    class="fas fa-circle {{$activity->calcSemaphore()}}"></i></td>
                                        <td class="text-center">
                                            <a href="javascript:void(0);" aria-expanded="false"
                                               wire:click="$emit('registerAdvance', '{{ $activity->id }}')">
                                                <i class="fas fa-edit mr-1 text-info"
                                                   data-toggle="tooltip" data-placement="top" title=""
                                                   data-original-title="Detalles Actividad"></i>
                                            </a>
                                            <button class="border-0 bg-transparent"
                                                    wire:click="$emit('triggerDeleteResult', '{{ $activity->id }}')" data-toggle="tooltip"
                                                    data-placement="top" title="Eliminar"
                                                    data-original-title="Eliminar"><i class="fas fa-trash mr-1 text-danger"></i>
                                            </button>
                                        </td>
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
