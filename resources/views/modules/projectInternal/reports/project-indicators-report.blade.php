@extends('modules.projectInternal.project')

@section('title', 'Informe de Indicadores')


@section('project-page')
    <ol class="breadcrumb bg-transparent pl-2 pr-0 mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('projects.reportsIndex', $project->id) }}">
                Informes del Proyecto
            </a>
        </li>

        <li class="breadcrumb-item active"> INFORME DE INDICADORES</li>
    </ol>

    <div style="display: grid !important;">
        <div class="w-100 p-2">
            <x-label-section> INFORME DE INDICADORES</x-label-section>
        </div>

        <table class="border p-2 m-4">
            <thead>
            <tr>
                <th class="border bold-h4 p-2" style="background-color: #C00000; color: #fffffd">NOMBRE DEL PROYECTO:</th>
                <td colspan="2" class="border p-2">{{$project->name ?? ''}}</td>
                <th colspan="2" class="border bold-h4 p-2" style="background-color: #C00000; color: #fffffd">NÚMERO DEL
                    PROYECTO:
                </th>
                <td colspan="2" class="border p-2">{{$project->code ?? ''}}</td>
            </tr>
            <tr>
                <th class="border bold-h4 p-2" style="background-color: #C00000; color: #fffffd">COORDINADR DEL PROYECTO:
                </th>
                <td colspan="6" class="border p-2">{{$project->responsible->name ?? ''}}</td>
            </tr>
            <tr>
                <th class="border bold-h4 p-2" style="background-color: #C00000; color: #fffffd">PRESUPUESTO:</th>
                <td colspan="6" class="border p-2">$100.000.000</td>
            </tr>
            <tr>
                <th class="border bold-h4 p-2"
                    style="background-color: #C00000; color: #fffffd">{{trans_choice('general.start_date',2)}}:
                </th>
                <td colspan="6" class="border p-2">{{$project->start_date ? $project->start_date->format('d-m-Y') : ''}}</td>
            </tr>
            <tr>
                <th class="border bold-h4 p-2"
                    style="background-color: #C00000; color: #fffffd">{{trans_choice('general.end_date',2)}}:
                </th>
                <td colspan="6" class="border p-2">{{$project->end_date ? $project->end_date->format('d-m-Y') : ''}}</td>
            </tr>
            <tr>
                <th class="border bold-h4 p-2" style="background-color: #C00000; color: #fffffd">TIEMPO TRANSCURRIDO:</th>
                <td class="border p-2" colspan="7">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{$project->getProgressTimeUpDate()}}%"
                             aria-valuenow="{{$project->getProgressTimeUpDate()}}" aria-valuemin="0" aria-valuemax="100">{{$project->getProgressTimeUpDate()}}%
                        </div>
                    </div>
                </td>
            </tr>
            </thead>
            <tr>
                <th class="border bold-h4 p-2" style="background-color: #203764; color: #fffffd">OBJETIVO GENERAL:</th>
                <td colspan="6" class="border p-2 text-center align-items-center align-content-center">{!! $project->general_objective ?? ''!!}</td>
            </tr>
            <tr class="text-center">
                <th class="border bold-h4">CÓDIGO:</th>
                <th class="border bold-h4">DETALLE:</th>
                <th class="border bold-h4">INDICADOR:</th>
                <th class="border bold-h4">META PLANIFICADA:</th>
                <th class="border bold-h4">META EJECUTADA:</th>
                <th class="border bold-h4">AVANCE:</th>
                <th class="border bold-h4">MEDIO DE VERIFICACIÓN:</th>
            </tr>
            <tr>
                <th colspan="7" style="background-color: #203764; color: #fffffd" class="border text-center bold-h4 p-2">
                    OBJETIVO ESPECÍFICO
                </th>
            </tr>
            @foreach($project->objectives as $objective)
                @foreach($objective->indicators as $indicator)
                    <tr class="border text-center">
                        @if($loop->first)
                            <td class="w-20 table-th align-middle align-items-center text-center p-2"
                                rowspan="{{$objective->indicators->count()}}">{{$objective->code ?? ''}}</td>
                            <td class="w-20 table-th align-middle align-items-center text-center p-2"
                                rowspan="{{$objective->indicators->count()}}">{{$objective->name ?? ''}}</td>
                        @endif
                        <td class="border p-2">{{$indicator->name ?? ''}}</td>
                        <td class="border p-2" style="padding: 4px">{{$indicator->goalsRegister() ?? ''}}</td>
                        <td class="border p-2" style="padding: 4px">{{$indicator->progressIndicator() ?? ''}}</td>
                        <td class="border">
                            <div class="progress">
                                <div class="progress-bar bg-info bg-info-gradient" role="progressbar" style="width: {{intval( $indicator->getStateIndicator()[1])}}%"
                                     aria-valuenow="{{intval( $indicator->getStateIndicator()[1])}}" aria-valuemin="0"
                                     aria-valuemax="100">{{intval( $indicator->getStateIndicator()[1])}}%
                                </div>
                            </div>
                        </td>
                        <td class="border p-2" style="padding: 4px">{{$indicator->sourceIndicator->name ?? ''}}</td>
                    </tr>
                @endforeach
            @endforeach
            <tr>
                <th colspan="7" style="background-color: #203764; color: #fffffd"
                    class="border bold-h4 text-center p-2">RESULTADOS
                </th>
            </tr>

            @foreach($project->objectives as $objective)
                @foreach($objective->results as $result)
                    @foreach($result->indicators as $indicator)
                        <tr class="border">
                            @if(($result->indicators)->count()>=2)
                                <td rowspan="{{$result->indicators->count()}}" class="w-20 table-th align-middle align-items-center text-center p-2"
                                    style="padding: 4px">{{$result->code}}</td>
                                <td rowspan="{{$result->indicators->count()}}" class="w-20 table-th align-middle align-items-center text-center p-2"
                                    style="padding: 4px">{{$result->name ?? ''}}</td>
                            @else
                                <td class="w-20 table-th align-middle align-items-center text-center p-2" style="padding: 4px">{{$result->code ?? ''}}</td>
                                <td class="w-20 table-th align-middle align-items-center text-center p-2" style="padding: 4px">{{$result->name ?? ''}}</td>
                            @endif
                            <td class="border p-2">{{$indicator->name ?? ''}}</td>
                            <td class="border p-2 text-center" style="padding: 4px">{{$indicator->goalsRegister() ?? ''}}</td>
                            <td class="border p-2 text-center" style="padding: 4px">{{$indicator->progressIndicator() ?? ''}}</td>
                            <td class="border">
                                <div class="progress">
                                    <div class="progress-bar bg-info bg-info-gradient" role="progressbar" style="width: {{intval( $indicator->getStateIndicator()[1])}}%"
                                         aria-valuenow="{{intval( $indicator->getStateIndicator()[1])}}" aria-valuemin="0"
                                         aria-valuemax="100">{{intval( $indicator->getStateIndicator()[1])}}%
                                    </div>
                                </div>
                            </td>
                            <td class="border p-2 text-center" style="padding: 4px">{{$indicator->sourceIndicator->name ?? ''}}</td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
        </table>
    </div>

@endsection

