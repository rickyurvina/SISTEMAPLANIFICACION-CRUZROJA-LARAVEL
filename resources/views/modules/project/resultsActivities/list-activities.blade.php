<div class="pl-2 pt-2">
    <div class="content-detail">
        <div class="d-flex flex-column">
            @include('modules.project.resultsActivities.summary-progress')
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
                                <th class="w-10 text-center table-th"><a
                                            href="#">{{ trans('general.actions') }} </a></th>
                            </tr>
                            <tr class="h-40px">
                                <th colspan="12" class="table-info h-25">
                                    Ejecución de Resultados y Actividades
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($objectives as  $objective)
                                <tr>
                                    <td colspan="5" class="text-center fw-700 fs-1x bg-info-200">{{$objective->name}}</td>
                                    <td colspan="1" class="fw-700 fs-1x bg-info-200">{{$objective->weight}}</td>
                                    <td colspan="1" class="fw-700 fs-1x bg-info-200">
                                        @php
                                            $progressByObjective=$objective->getProgressByResults();
                                        @endphp
                                        <div class="progress-bar bg-primary-600"
                                             role="progressbar"
                                             style="width: {{$progressByObjective}}%"
                                             aria-valuenow="{{ $progressByObjective}}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"> {{$progressByObjective }}
                                            %
                                        </div>
                                    </td>
                                    <td colspan="2" class="fw-700 fs-2x bg-info-200"></td>
                                    <td class="text-center">
                                        <div class="frame-wrap">
                                            <div class="d-flex justify-content-center">
                                                <div class="p-2">
                                                    <a href="#"
                                                       data-toggle="modal"
                                                       data-target="#project-activities-weight"
                                                       data-objective-id="{{ $objective->id }}">
                                                        <i class="fas fa-balance-scale mr-1 text-info"
                                                           data-toggle="tooltip" data-placement="top"
                                                           data-original-title="Editar Pesos"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @foreach($objective->results as $result)

                                    <tr class="table-bordered table-secondary table-striped">
                                        <td>{{ $result->code}}</td>
                                        <td>
                                            @if($result->responsible)
                                                <a href="#" data-placement="top"
                                                   title="{{$result->responsible->getFullName()}}"
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
                                                    <div class="progress-bar bg-primary-600 bg-warning-gradient"
                                                         role="progressbar"
                                                         style="width: {{ number_format($result->progress) }}%"
                                                         aria-valuenow="{{ number_format($result->progress) }}"
                                                         aria-valuemin="0"
                                                         aria-valuemax="100"> {{ number_format($result->progress) }}
                                                        %
                                                    </div>
                                                </div>
                                            @else
                                                <span class="badge badge-secondary badge-pill">{{ number_format($result->progress) }}%</span>
                                            @endif
                                        </td>
                                        <td><i class="fal fa-minus color-light-700 fs-2x"></i></td>
                                        <td><i class="fal fa-minus color-light-700 fs-2x"></i></td>
                                        <td class="text-center"><i
                                                    class="fal fa-minus color-danger-700 fs-2x"></i>
                                        </td>
                                    </tr>
                                    @foreach($result->childrenTasks()->get() as $activity)
                                        <tr>
                                            <td>{{$activity->code}}</td>
                                            <td> @if($activity->responsible)
                                                    <a href="#" data-placement="top"
                                                       title="{{$activity->responsible->getFullName()}}"
                                                       data-original-title="{{$activity->responsible->getFullName()}}">
                                                        ({{$activity->responsible->shortNickName()??''}}
                                                        )
                                                    </a>
                                                @endif
                                                {{$activity->text}}-{{$activity->company->name}}
                                            </td>
                                            <td>{{ $activity->start_date ? $activity->start_date->format('j F, Y') :''}} </td>
                                            <td>{{$activity->end_date ? $activity->end_date->format('j F, Y'):''}}</td>
                                            @if($activity->start_date>=now())
                                                <td class="text-center"><span
                                                            class="badge badge-secondary badge-pill">No Empieza</span>
                                                </td>
                                            @else
                                                <td class="text-center">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-primary-700 bg-success-gradient"
                                                             role="progressbar"
                                                             style="width: {{$activity->getProgressTimeUpDate()}}%"
                                                             aria-valuenow="{{$activity->getProgressTimeUpDate()}}"
                                                             aria-valuemin="0"
                                                             aria-valuemax="100"> {{$activity->getProgressTimeUpDate()}}
                                                            %
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                            <td>{{number_format($activity->weight,2) }}</td>
                                            <td class="text-center">
                                                @if(number_format($activity->progress) >0)
                                                    <div class="progress">
                                                        <div class="progress-bar bg-info-600 bg-warning-gradient"
                                                             role="progressbar"
                                                             style="width: {{ number_format($activity->progress) }}%"
                                                             aria-valuenow="{{ number_format($activity->progress) }}"
                                                             aria-valuemin="0"
                                                             aria-valuemax="100"> {{ number_format($activity->progress) }}
                                                            %
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="badge badge-secondary badge-pill">{{ number_format($activity->progress) }}%</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($activity->status)
                                                    <span class="badge {{ \App\Models\Projects\Activities\Task::STATUS_BGC[$activity->status] }} badge-primary badge-pill"> {{$activity->status}}</span>
                                                @endif
                                            </td>
                                            <td class="text-center"><i
                                                        class="fas fa-circle {{$activity->calcSemaphore()}}"></i>
                                            </td>
                                            <td class="text-center">
                                                <div class="frame-wrap">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="p-2">
                                                            <a href="javascript:void(0);" aria-expanded="false"
                                                               wire:click="$emit('registerAdvance', '{{ $activity->id }}')">
                                                                <i class="fas fa-edit mr-1 text-info"
                                                                   data-toggle="tooltip" data-placement="top"
                                                                   title=""
                                                                   data-original-title="Detalles Actividad"></i>
                                                            </a>
                                                        </div>
                                                        <div class="p-2">
                                                            @if($activity->goals->count()==0 && $activity->accounts->count()==0 && $activity->activitiesTask->count()==0)
                                                                <button class="border-0 bg-transparent"
                                                                        wire:click="$emit('triggerDeleteResult', '{{ $activity->id }}')"
                                                                        data-toggle="tooltip"
                                                                        data-placement="top" title="Eliminar"
                                                                        data-original-title="Eliminar"><i
                                                                            class="fas fa-trash mr-1 text-danger"></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                        @if($activity->validateCrateBudget())
                                                            <div class="p-2">
                                                                @if($project->isMisional())
                                                                    <a href="{{route('projects.expenses_activity',$activity)}}">
                                                                        <i class="fas fa-money-bill mr-1 text-success"
                                                                           data-toggle="tooltip" data-placement="top" title=""
                                                                           data-original-title="Presupuesto"></i>
                                                                    </a>
                                                                @else
                                                                    <a href="{{route('projectsInternal.expenses_activity',$activity)}}">
                                                                        <i class="fas fa-money-bill mr-1 text-success"
                                                                           data-toggle="tooltip" data-placement="top" title=""
                                                                           data-original-title="Presupuesto"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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
