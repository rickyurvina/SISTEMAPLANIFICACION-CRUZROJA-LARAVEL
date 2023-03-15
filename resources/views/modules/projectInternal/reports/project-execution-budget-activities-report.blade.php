@extends('modules.projectInternal.project')

@section('title', 'Informe de ejecución y presupuesto de actividades')


@section('project-page')
    <ol class="breadcrumb bg-transparent pl-2 pr-0 mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('projects.reportsIndex', $project->id) }}">
                Informes del Proyecto
            </a>
        </li>
        <li class="breadcrumb-item active"> INFORME DE EJECUCIÓN Y PRESUPUESTO DE ACTIVIDADES</li>
    </ol>
    <div class="container-fluid">
        <div class="w-100 p-2">
            <x-label-section> INFORME DE EJECUCIÓN Y PRESUPUESTO DE ACTIVIDADES</x-label-section>
        </div>
        <div class="flex-grow-1 w-100" style="overflow: hidden auto">
            <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tab-activities" role="tab" aria-selected="true">EJECUCIÓN
                        DE ACTIVIDADES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-budget" role="tab" aria-selected="false">EJECUCIÓN
                        DE PRESUPUESTO</a>
                </li>
            </ul>
            @if($project->objectives)
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="tab-activities" role="tabpanel">
                        <div class="pl-2 w-100">
                            <table class="border p-2 p-2 m-4 w-100">
                                <tr style="background-color: #B2B2B2;color:#fffffd">
                                    <th class="border p-2 w-50 text-center bold-h4">RESULTADO</th>
                                    <th class="border p-2 text-center bold-h4">META</th>
                                    <th class="border p-2 text-center bold-h4">EJECUTADO</th>
                                    <th class="border p-2 text-center bold-h4">AVANCE</th>
                                </tr>
                                <tr>
                                @foreach($project->objectives as $objective)
                                    @foreach($objective->results as $result)
                                        <tr>
                                            <td class="border p-2 text-center">{{$result->text}}</td>
                                            <td class="border p-2 text-center">{{$result->goal}}</td>
                                            <td class="border p-2 text-center">{{$result->advance}}</td>
                                            <td class="border">
                                                <div class="progress">
                                                    <div class="progress-bar bg-info bg-info-gradient"
                                                         role="progressbar"
                                                         style="width: {{$result->getProgressPhysic()}}%"
                                                         aria-valuenow="{{$result->getProgressPhysic()}}"
                                                         aria-valuemin="0"
                                                         aria-valuemax="100">{{$result->getProgressPhysic()}}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                <tr style="background-color: #B2B2B2;color:#fffffd">
                                    <th class="border p-2 w-50 text-center bold-h4">ACTIVIDAD</th>
                                    <th class="border p-2 text-center bold-h4">META</th>
                                    <th class="border p-2 text-center bold-h4">EJECUTADO</th>
                                    <th class="border p-2 text-center bold-h4">AVANCE</th>
                                </tr>
                                @foreach($project->tasks->where('type','task') as $task)
                                    <tr>
                                        <td class="border p-2 text-center">{{$task->text}}</td>
                                        <td class="border p-2 text-center">{{$task->goal}}</td>
                                        <td class="border p-2 text-center">{{$task->advance}}</td>
                                        <td class="border">
                                            <div class="progress">
                                                <div class="progress-bar bg-info bg-info-gradient" role="progressbar"
                                                     style="width: {{$task->getProgressPhysic()}}%"
                                                     aria-valuenow="{{$task->getProgressPhysic()}}" aria-valuemin="0"
                                                     aria-valuemax="100">{{$task->getProgressPhysic()}}%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-budget" role="tabpanel">
                        <div class="pl-2">
                            <table class="border p-2 p-2 m-4 w-100">
                                <th style="background-color: #B2B2B2; color:#fffffd"
                                    class="text-center border p-2 text-center bold-h4" colspan="4">EJECUCIÓN PRESUPUESTO
                                    POR ACTIVIDAD
                                </th>
                                <tr style="background-color: #B2B2B2;color:#fffffd">
                                    <th class="border p-2 w-50 text-center bold-h4">CÓDIGO ACTIVIDAD</th>
                                    <th class="border p-2 text-center bold-h4">PLANIFICADO</th>
                                    <th class="border p-2 text-center bold-h4">EJECUTADO</th>
                                    <th class="border p-2 text-center bold-h4">AVANCE</th>
                                </tr>
                                @foreach($project->tasks->where('type','task') as $task)
                                    <tr>
                                        <td class="border p-2 text-center">{{$task->text}}</td>
                                        <td>{{ $task->getBalanceEncodedApproved() }}</td>
                                        <td>{{ $task->getBalanceAs() }}</td>
                                        <td class="border p-2 text-center">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped bg-info"
                                                     role="progressbar" style="width: {{$task->getPercentageBudget()}}%"
                                                     aria-valuenow="{{$task->getPercentageBudget()}}" aria-valuemin="0"
                                                     aria-valuemax="100">{{$task->getPercentageBudget()}}%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
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

