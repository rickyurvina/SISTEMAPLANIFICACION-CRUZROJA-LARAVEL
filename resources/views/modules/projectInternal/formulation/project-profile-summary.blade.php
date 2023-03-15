@extends('modules.projectInternal.project')

@section('project-page')
    <div>
        <div class="card-body">
            <div class="text-right w-100 m-3">
                <a href="{{route('projects.reportProfileInternal',$project)}}" class="btn btn-outline-primary btn-xs shadow-0"><i class="fas fa-file-pdf"></i> Perfil de Proyecto</a>
                <a href="{{route('projects.reportConstitutionalActInternal',$project)}}" class="btn btn-outline-primary btn-xs shadow-0"><i class="fas fa-file-pdf"></i> Acta de
                    Constitución</a>
            </div>
            <div class="row">

                <div class="col-12 border border-danger p-2" style="border-radius: 25px; border-color: #D52B1E;">
                    <x-tooltip-help message="{{$messages->where('code','resumen')->first()->description}}"> </x-tooltip-help>

                    <div class="text-center"><h1> Proyecto:"{{$project->name ?? ''}}"</h1></div>
                    <div class="text-center"><h2> Fecha:{{$project->start_date ?? ''}}</h2></div>
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead class="table-bordered text-white" style="background-color: #D52B1E">
                            <tr>
                                <th colspan="2" class="text-center fs-3x fw-700">Información del proyecto</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="border-dark w-20 fs-2x fw-700" style="background-color: #848484; color:#ffffff">{{trans('general.code')}}</td>
                                @if($project->code)
                                    <td class="text-cente fs-2x fw-700">{{$project->code}}</td>
                                @else
                                    <td class="text-center fs-2x fw-700">
                                        <i class="fal fa-times-circle fa-2x" style="color: #D52B1E"></i>
                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td class="border-dark w-20 fs-2x fw-700" style="background-color: #848484; color:#ffffff">Monto estimado</td>
                                @if($project->estimated_amount)
                                    <td class="text-cente fs-2x fw-700">{{'$'.number_format($project->estimated_amount, 2) }}</td>
                                @else
                                    <td class="text-center fs-2x fw-700"><i class="fal fa-times-circle fa-2x" style="color: #D52B1E"></i>
                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td class="border-dark w-20 fs-2x fw-700" style="background-color: #848484; color:#ffffff">{{trans('general.start_date')}}</td>
                                @if($project->start_date)
                                    <td class="text-cente fs-2x">{{$project->start_date->format('d-m-Y')}}</td>
                                @else
                                    <td class="text-center fs-2x fw-700"><i class="fal fa-times-circle fa-2x" style="color: #D52B1E"></i>
                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td class="border-dark w-20 fs-2x fw-700" style="background-color: #848484; color:#ffffff">{{trans('general.end_date')}}</td>
                                @if($project->end_date)
                                    <td class="text-cente fs-2x">{{$project->end_date->format('d-m-Y')}}</td>
                                @else
                                    <td class="text-center fs-2x fw-700"><i class="fal fa-times-circle fa-2x" style="color: #D52B1E"></i>
                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td class="border-dark w-20 fs-2x fw-700" style="background-color: #848484; color:#ffffff">Plazo Estimado</td>
                                @if($project->estimated_time)
                                    <td class="fs-2x fw-700">{{explode(',',$project->estimated_time)[3]??0 }}-Meses</td>
                                @else
                                    <td class="text-center fs-2x fw-700"><i class="fal fa-times-circle fa-2x" style="color: #D52B1E"></i>
                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td class="border-dark w-20 fs-2x fw-700" style="background-color: #848484; color:#ffffff">{{trans('general.location')}}</td>
                                @if($project->locations->count()>0)
                                    <td class="fs-2x fw-600">
                                        @if($project->locations->count()>0)
                                            <ol>
                                                @foreach($project->locations as $item)
                                                    <li class="fs-2x fw-700">{{$item->getPath()}}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <div class="alert border-danger bg-transparent text-danger mt-2 mb-2 w-80" role="alert">
                                                <strong>No existen </strong>Localizaciones
                                            </div>
                                        @endif
                                    </td>
                                @else
                                    <td class="text-center fs-2x fw-700"><i class="fal fa-times-circle fa-2x" style="color: #D52B1E"></i>
                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td class="border-dark w-20 fs-2x fw-700" style="background-color: #848484; color:#ffffff">{{trans('general.project_team')}}</td>
                                <td>
                                    @if($project->members->count()>0)
                                        <table class="table m-0">
                                            <thead class="bg-primary-50">
                                            <tr>
                                                <th style="vertical-align: middle !important;" scope="col" rowspan="2">N°</th>
                                                <th style="vertical-align: middle !important;" scope="col" rowspan="2">Cargo Dentro del
                                                    Proyecto
                                                </th>
                                                <th style="vertical-align: middle !important;" scope="col" rowspan="2">Responsabilidades
                                                </th>
                                                <th style="vertical-align: middle !important;" scope="col" rowspan="2">% de aporte al
                                                    proyecto
                                                </th>

                                                <th style="vertical-align: middle !important;" scope="col" rowspan="2">Lugar(SC, JP o
                                                    terreno)
                                                </th>
                                                <th style="vertical-align: middle !important;" scope="col" rowspan="2">Nombre</th>
                                            </tr>

                                            </thead>

                                            <tbody>
                                            @foreach($project->members as $item)
                                                <tr>
                                                    <th scope="row">{{ ++$loop->index }}</th>
                                                    <td>{{ $item->role ? $item->role->description : ''}}</td>
                                                    <td>{{ $item->responsibilities ?? '' }}</td>
                                                    <td>{{ $item->contribution ?? 0 }}%</td>
                                                    <td>{{ $item->place ? $item->place->description :'' }}</td>
                                                    <td>{{ $item->user ? $item->user->getFullName() : '' }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="alert border-danger bg-transparent text-danger mt-2 mb-2 w-80" role="alert">
                                            <strong>No existe </strong>equipo de proyecto definido.
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border-dark w-20 fs-2x fw-700" style="background-color: #848484; color:#ffffff">{{trans('general.problem_identified')}}</td>
                                @if($project->problem_identified)
                                    <td class="">{!! $project->problem_identified !!}</td>
                                @else
                                    <td class="text-center fs-2x fw-700"><i class="fal fa-times-circle fa-2x" style="color: #D52B1E"></i>
                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td class="border-dark w-20 fs-2x fw-700" style="background-color: #848484; color:#ffffff">{{trans('general.general_objective')}}</td>
                                @if($project->general_objective)
                                    <td class="">{!! $project->general_objective !!}</td>
                                @else
                                    <td class="text-center fs-2x fw-700"><i class="fal fa-times-circle fa-2x" style="color: #D52B1E"></i>
                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td class="border-dark w-20 fs-2x fw-700" style="background-color: #848484; color:#ffffff">{{trans('general.specific_objective')}}</td>
                                <td>
                                    @if($project->objectives->count()>0)
                                        <ul role="tree">

                                            @foreach($project->objectives as $index =>$objective)
                                                <li class="parent_li" role="treeitem">
                                                    {{$objective->name}}
                                                    <ul>
                                                        @foreach($objective->results as $index =>$result)
                                                            <li>
                                                                {{$result->text}}
                                                                <ul>
                                                                    @foreach($result->services as $index =>$service)
                                                                        <li>
                                                                            {{$service->name}}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="alert border-danger bg-transparent text-danger mt-2 mb-2 w-80" role="alert">
                                            <strong>No existen </strong>{{trans('general.objectivesSpecifics')}}
                                        </div>
                                    @endif

                                </td>
                            </tr>
                            <tr>
                                <td class="border-dark w-20 fs-2x fw-700" style="background-color: #848484; color:#ffffff">{{trans_choice('general.articulations',1)}}</td>
                                <td>
                                    <div class="table-responsive">
                                        <table class="table m-0 border-1">
                                            <thead class="bg-primary-50">
                                            <tr>
                                                <th colspan="2" class="text-center">Articulaciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($project->articulations->groupBy('plan_target_id') as $articulations2)
                                                @foreach($articulations2->groupBy('prj_project_id')  as  $index => $articulation)
                                                    @foreach($articulation as $planArticulation)

                                                        <tr>
                                                            @if($loop->index==0 && $loop->parent->index==0)
                                                                <td rowspan="{{$articulation->count()}}"
                                                                    class="bg-gray-100 color-info-600">{{$planArticulation->targetPlan->name}}</td>
                                                            @endif
                                                            <td>{{$planArticulation->targetPlanDetail->name}}</td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="border-dark w-20 fs-2x fw-700"
                                    style="background-color: #848484; color:#ffffff">{{trans('general.cooperators')}}{{trans('general.funder')}}</td>
                                <td>
                                    @if($project->funders->count()>0)
                                        <div class="table-responsive">
                                            <table class="table table-hover m-0">
                                                <thead class="bg-primary-50">
                                                <tr>
                                                    <th>{{trans('general.funder')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        @if($project->funders->count()>0)
                                                            <ul>
                                                                @foreach($project->funders as $funder)
                                                                    <li>{{$funder->name ?? ''}}</li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            <div class="alert border-danger bg-transparent text-danger mt-2 mb-2 w-80" role="alert">
                                                                <strong>No existen </strong>Financiadores
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert border-danger bg-transparent text-danger mt-2 mb-2 w-80" role="alert">
                                            <strong>No existen </strong>Financiadores y Cooperantes
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border-dark w-20 fs-2x fw-700" style="background-color: #848484; color:#ffffff">{{trans('general.beneficiaries')}}</td>
                                <td>
                                    <div>
                                        {!! $project->description_beneficiaries !!}
                                    </div>
                                    @if($project->beneficiaries->count()>0)
                                        <ol>
                                            @foreach($project->beneficiaries as $item)
                                                <li class="fs-2x fw-700">
                                                     {{$item->types->description??''}}: {{$item->amount}}
                                                </li>
                                            @endforeach
                                        </ol>
                                    @else
                                        <div class="alert border-danger bg-transparent text-danger mt-2 mb-2 w-80" role="alert">
                                            <strong>No existen </strong>beneficiarios.
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border-dark w-20 fs-2x fw-700" style="background-color: #848484; color:#ffffff">Cronograma</td>
                                <td>
                                    @php
                                        $maxCols=8;
                                         $max=8;
                                        $aux=$time;
                                        $k=1;
                                         $l=1;
                                         $aux2=0;
                                         if ($maxCols>=$time)
                                             {
                                                 $maxCols=$time;
                                             }
                                    @endphp
                                    @while($maxCols<=$time && $k<=$time)
                                        @if($project->objectives->pluck('results')->count()>0)
                                            <div class="table-responsive">
                                                <table class="table m-0">
                                                    <tr class="bg-primary-50">
                                                        <th>Nombre Resultado</th>
                                                        @for($i=1; $i<=min($max,$aux);$i++)
                                                            <th>Mes-{{$k}}</th>
                                                            @php
                                                                $k++;
                                                            @endphp
                                                        @endfor
                                                    </tr>

                                                    @foreach($project->objectives as $objective)
                                                        @foreach($objective->results as $result)
                                                            <tr>
                                                                <td class="text-truncate-lg text-truncate w-25">{{$result->text}}</td>
                                                                @php
                                                                    $l=1+$aux2;
                                                                @endphp
                                                                @for($i=1; $i<=min($max,$aux);$i++)

                                                                    <td class="">
                                                                        @isset($plans[$result->id][$l])
                                                                            <i class="fal fa-check fa-2x" style="color: green"></i>
                                                                        @else
                                                                            <i class="fal fa-times-circle fa-1x" style="color: #D52B1E"></i>
                                                                        @endisset
                                                                    </td>
                                                                    @php
                                                                        $l++;
                                                                    @endphp
                                                                @endfor
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </table>
                                            </div>
                                            @php
                                                $maxCols=$maxCols+8;
                                                if ($maxCols>$time){
                                                    $maxCols=$time;
                                                }
                                                 $aux=$aux-$max;
                                                $aux2=$aux2+8;
                                            @endphp

                                        @else
                                            <div class="alert border-danger bg-transparent text-danger mt-2 mb-2 w-80" role="alert">
                                                <strong>No existe </strong>cronograma de actividades.
                                            </div>
                                        @endif
                                    @endwhile
                                </td>
                            </tr>
                            <tr>
                                <td class="border-dark w-20 fs-2x fw-700" style="background-color: #848484; color:#ffffff">{{trans('general.stakeholders')}}</td>
                                <td>
                                    @if($project->stakeholders->count()>0)
                                        <div class="table-responsive">
                                            <table class="table table-hover m-0">
                                                <thead class="bg-primary-50">
                                                <tr>
                                                    <th> {{trans('general.assigned_to')}}</th>
                                                    <th> {{trans('general.priority')}}</th>
                                                    <th> {{trans('general.strategy')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($project->stakeholders as $item)
                                                    <tr>
                                                        <td>
                                                            {{ $item->interested->getFullName()??'' }}
                                                        </td>
                                                        <td>
                                                            @switch($item->priority)
                                                                @case(\App\Models\Projects\Stakeholders\ProjectStakeholder::URGENT)
                                                                <span style="color: red">
                                    <i class='red fa fa-bell w-10 text-center'></i> {{ trans('general.labels.priority_' . $item->priority) }}
                                </span>
                                                                @break
                                                                @case(\App\Models\Projects\Stakeholders\ProjectStakeholder::IMPORTANT)
                                                                <span style="color: red">
                                    <i class='red fa fa-exclamation w-10 text-center'></i> {{ trans('general.labels.priority_' . $item->priority) }}
                                </span>
                                                                @break
                                                                @case(\App\Models\Projects\Stakeholders\ProjectStakeholder::HALF)
                                                                <span style="color: green">
                          <i class='green fa fa-minus w-10 text-center'></i> {{ trans('general.labels.priority_' . $item->priority) }}
                                </span>
                                                                @break
                                                                @case(\App\Models\Projects\Stakeholders\ProjectStakeholder::LOW)
                                                                <span style="color: blue">
                                    <i class='color-blue fa fa-long-arrow-down w-10 text-center'></i> {{ trans('general.labels.priority_' . $item->priority) }}
                                </span>
                                                                @break
                                                            @endswitch
                                                        </td>
                                                        <td>{{ $item->strategy ?? '' }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert border-danger bg-transparent text-danger mt-2 mb-2 w-80" role="alert">
                                            <strong>No existen </strong>actores clave.
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border-dark w-20 fs-2x fw-700" style="background-color: #848484; color:#ffffff">{{trans_choice('general.risks',2)}}</td>
                                <td>
                                    @if($project->risks->count()>0)
                                        <ul>
                                            @foreach($project->risks as $item)
                                                <li>
                                                    {{$item->name ?? ''}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="alert border-danger bg-transparent text-danger mt-2 mb-2 w-80" role="alert">
                                            <strong>No existen </strong>riesgos creados.
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <span class="fs-2x w-40px"><i class="fal fa-comment-dots"></i></span>
                        <span class="fs-2x fw-700">Comentarios</span>
                    </div>

                    <livewire:components.comments :modelId="$project->id" class="\App\Models\Projects\Project" identifier="summary"
                                                  :key="time().$project->id"/>
                </div>
                <div class="col-6">
                    <livewire:projects.files.project-files :project="$project" identifier="summary"/>

                </div>
            </div>
        </div>
    </div>

@endsection

