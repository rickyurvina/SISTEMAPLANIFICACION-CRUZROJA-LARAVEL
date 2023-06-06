@extends('modules.project.project')


@section('title', 'Informe de actividades')


@section('subheader')

    {{--        <a href="{{ route('poa.reports.reached_people.export') }}" class="color-success-500"><span class="fas fa-file-excel fa-2x"></span> {{ trans('general.excel') }}</a>--}}
@endsection

@section('project-page')
    <ol class="breadcrumb bg-transparent pl-2 pr-0 mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('projects.reportsIndex', $project->id) }}">
                Informes del Proyecto
            </a>
        </li>

        <li class="breadcrumb-item active"> INFORME DE ACTIVIDADES</li>
    </ol>

    <div class="container-fluid">
        <div class="w-100 p-2">
            <x-label-section> INFORME DE ACTIVIDADES</x-label-section>
        </div>
        <div class="flex-grow-1 w-100" style="overflow: hidden auto">
            <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tab-activities" role="tab" aria-selected="true">INFORME DE ACTIVIDADES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-budget" role="tab" aria-selected="false">INFORME DE ACTIVIDADES DE PRESUPUESTO</a>
                </li>
            </ul>
            @if($activities)
            <div class="tab-content">
                <div class="tab-pane fade active show" id="tab-activities" role="tabpanel">
                    <div class="pl-2">
                        <div class="flex-grow-1 w-100" style="overflow: hidden auto">
                        <table class="p-2 m-4 table-responsive">
                                <tr>
                                    <th colspan="5"></th>
                                    <th class="text-center border p-2 bold-h4" colspan="{{count($periods)}}" style="background-color: rgba(40,40,47,0.59);color:#fffffd">CRONOGRAMA
                                        PLANIFICADO
                                    </th>
                                    <th class="text-center border p-2 bold-h4" colspan="{{count($periods)}}" style="background-color: rgba(199,151,31,0.59);color:#fffffd">
                                        CRONOGRAMA
                                        EJECUTADO
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-center border p-2 bold-h4">CÓDIGO</th>
                                    <th class="text-center border p-2 bold-h4">ACTIVIDAD</th>
                                    <th class="text-center border p-2 bold-h4">PROGRAMA/LÍNEA RESPONSABLE</th>
                                    <th class="text-center border p-2 bold-h4">META</th>
                                    <th class="text-center border p-2 bold-h4">TIPO DE MEDIDA</th>
                                    @foreach($periods as $period)
                                        <th class="text-center border p-2 bold-h4">{{  date('F Y', strtotime($period)) ?? ''}}</th>
                                    @endforeach
                                    @foreach($periods as $period)
                                        <th class="text-center border p-2 bold-h4">{{  date('F Y', strtotime($period)) ?? ''}}</th>
                                    @endforeach
                                </tr>
                                @foreach($activities as $task)
                                    <tr>
                                        <td class="text-center border p-2">{{$task->code ?? ''}}</td>
                                        <td class="text-center border p-2">{{$task->text ?? ''}}</td>
                                        <td class="text-center border p-2">{{$task->indicator->indicatorable->parent->name ?? ''}}</td>
                                        <td class="text-center border p-2">{{$task->goal ?? ''}} </td>
                                        <td class="text-center border p-2"> {{$task->indicator->indicatorUnit->name ?? ''}}</td>
                                        @foreach($periods as $period)
                                            <th class="text-center border p-2 bold-h4">{{ $task->goals->whereBetween('period', [date('Y-m-d', strtotime($period)) ,date('Y-m-d', strtotime($period. "+1 month")) ])->first()->goal ?? '-'}}</th>
                                        @endforeach
                                        @foreach($periods as $period)
                                            <th class="text-center border p-2 bold-h4">{{ $task->goals->whereBetween('period', [date('Y-m-d', strtotime($period)) ,date('Y-m-d', strtotime($period. "+1 month")) ])->first()->progress ?? '-'}}</th>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-budget" role="tabpanel">
                    <div class="pl-2">
                        <div class="flex-grow-1 w-100" style="overflow: hidden auto">

                        <table class="p-2 m-4 table-responsive">
                                <tr>
                                    <th colspan="5"></th>
                                    <th class="text-center border p-2 bold-h4" colspan="2" style="background-color: #C00000;color:#fffffd">PRESUPUESTO</th>
                                    <th class="text-center border p-2 bold-h4" colspan="{{count($periods)}}" style="background-color: rgba(40,40,47,0.59);color:#fffffd">CRONOGRAMA
                                        PLANIFICADO
                                    </th>
                                    <th class="text-center border p-2 bold-h4" colspan="{{count($periods)}}" style="background-color: rgba(199,151,31,0.59);color:#fffffd">
                                        CRONOGRAMA
                                        EJECUTADO
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-center border p-2 bold-h4">CÓDIGO</th>
                                    <th class="text-center border p-2 bold-h4">ACTIVIDAD</th>
                                    <th class="text-center border p-2 bold-h4">PROGRAMA/LÍNEA RESPONSABLE</th>
                                    <th class="text-center border p-2 bold-h4">META</th>
                                    <th class="text-center border p-2 bold-h4">TIPO DE MEDIDA</th>
                                    <th class="text-center border p-2 bold-h4">PRESUPUESTO PROGRAMADO</th>
                                    <th class="text-center border p-2 bold-h4">PRESUPUESTO EJECUTADO</th>
                                    @foreach($periods as $period)
                                        <th class="text-center border p-2 bold-h4">{{  date('F Y', strtotime($period)) ?? ''}}</th>
                                    @endforeach
                                    @foreach($periods as $period)
                                        <th class="text-center border p-2 bold-h4">{{  date('F Y', strtotime($period)) ?? ''}}</th>
                                    @endforeach
                                </tr>
                                @foreach($activities as $task)
                                    <tr>
                                        <td class="text-center border p-2">{{$task->code ?? ''}}</td>
                                        <td class="text-center border p-2">{{$task->text ?? ''}}</td>
                                        <td class="text-center border p-2">{{$task->indicator->indicatorable->parent->name ?? ''}}</td>
                                        <td class="text-center border p-2">{{$task->goal ?? ''}} </td>
                                        <td class="text-center border p-2"> {{$task->indicator->indicatorUnit->name ?? ''}}</td>
                                        <td class="text-center border p-2">{{ $task->getTotalBudget($transaction) ?? '' }}</td>
                                        <td class="text-center border p-2">{{ $task->getBalanceAs() ?? '' }}</td>
                                        {{--                                @foreach($periods as $period)--}}
                                        {{--                                    <th class="text-center border p-2 bold-h4">{{ $task->goals->whereBetween('period', [date('Y-m-d', strtotime($period)) ,date('Y-m-d', strtotime($period. "+1 month")) ])->first()->goal ?? '-'}}</th>--}}
                                        {{--                                @endforeach--}}
                                        {{--                                @foreach($periods as $period)--}}
                                        {{--                                    <th class="text-center border p-2 bold-h4">{{ $task->goals->whereBetween('period', [date('Y-m-d', strtotime($period)) ,date('Y-m-d', strtotime($period. "+1 month")) ])->first()->progress ?? '-'}}</th>--}}
                                        {{--                                @endforeach--}}
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @else
                <x-empty-content>
                    <x-slot name="title">
                        No existen {{trans_choice('general.activities',2)}}
                    </x-slot>
                </x-empty-content>
            @endif
        </div>
    </div>

@endsection

