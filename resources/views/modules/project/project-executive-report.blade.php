@extends('modules.project.project')

@section('title', 'Informe Ejecutivo')

@section('project-page')
    <div class="container-fluid">

        <ol class="breadcrumb bg-transparent pl-2 pr-0 mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('projects.reportsIndex', $project->id) }}">
                    Informes del Proyecto
                </a>
            </li>

            <li class="breadcrumb-item active"> Informe Ejecutivo</li>
        </ol>
        <x-label-section> {{trans('general.executive_report')}}</x-label-section>

        <div style="display: grid !important;">
            <h2 style="padding: 4px" class="ml-auto">{{trans('general.cutoff_date')}}: {{$now->format('d-m-Y')}}</h2>
            <table class="border ex-e-table m-4">
                <thead class="border header">
                <tr class="border ">
                    <th colspan="6" class="border  text-center header"><h4 class="bold-h4">{{trans_choice('general.GENERAL_INFORMATION',2)}}
                            DEL PROYECTO</h4></th>
                </tr>
                </thead>
                <tr class="border ">
                    <th class="border p-2"
                        style="width: 25%"><h4 class="bold-h4">{{trans_choice('general.name',2)}}:</h4>
                    </th>
                    <th colspan="5" class="border p-2">{{ $project->name }}</th>
                </tr>
                <tr>
                <tr class="border ">
                    <th colspan="1" class="border p-2"><h4 class="bold-h4">{{trans_choice('general.objective_general',2)}}:</h4></th>
                    <th colspan="5" class="border p-2">{!! $project->general_objective ?? ''!!}  </th>

                </tr>
                <tr class="border ">
                    <th colspan="1" class="border p-2"><h4 class="bold-h4">{{trans('general.lines_action')}}:</h4></th>
                    <th colspan="5" class="border p-2">
                        @foreach($lineActions as $item)
                            <ul>
                                <li>{{ $item['name']}}</li>
                            </ul>
                        @endforeach
                    </th>
                </tr>
                <tr class="border p-4">
                    <th class="border p-2"
                        style="width: 25%"><h4 class="bold-h4">{{trans_choice('general.start_date',2)}}:</h4>
                    </th>
                    <td style="width:10%" class="p-2">{{$project->start_date ? $project->start_date->format('d-m-Y') : ''}}</td>
                    <th class="border p-2"
                        style="width: 10%"><h4 class="bold-h4">{{trans_choice('general.end_date',2)}}:</h4>
                    </th>
                    <td style="width: 5%" class="p-2">{{$project->end_date ? $project->end_date->format('d-m-Y') : ''}}</td>
                    <th class="border text-center p-2"
                        style="width: 10%"><h4 class="bold-h4">{{trans_choice('general.duration',2)}}:</h4>
                    </th>
                    <td style="width: 20%;" class="p-2">{{$project->getDifferenceStartEndDatesMonths() ?? ''}} Meses</td>
                </tr>
                <tr class="border">
                    <th colspan="1" class="border p-2"
                        style="width: 25%"><h4 class="bold-h4">{{trans('general.location')}}:</h4>
                    </th>
                    <td colspan="2" class="text-center p-2">{{$project->location ? $project->location->description : '' }} </td>
                    <th colspan="1" class="border p-2"
                        style="width: 20%"><h4 class="bold-h4">{{trans_choice('general.departments',2)}}:</h4>
                    </th>
                    <td colspan="2" class="p-2">
                        @foreach($project->areas as $area)
                            <ul>
                                <li>{{$area->department ? $area->department->name : ''}}</li>
                            </ul>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th colspan="1" class="border p-2"
                        style="width: 20%"><h4 class="bold-h4">{{trans('general.amount')}}:</h4>
                    </th>
                    <td colspan="2" class="text-center p-2">{{$project->getTotalBudgetProject()}} </td>
                    <th colspan="1" class="border p-2"
                        style="width: 20%"><h4 class="bold-h4">{{trans('general.type')}} {{__('general.of_project')}}:</h4>
                    </th>
                    <td colspan="2" class="text-center p-2">{{trans('general.'.$project->type)}} </td>
                </tr>
            </table>
            <table class="border ex-e-table m-4">
                <thead class="border header">
                <tr class="border ">
                    <th colspan="6" class="border  text-center header"><h4 class="bold-h4">{{__('general.ADVANCE')}}</h4></th>
                </tr>
                </thead>
                <tr>
                    <th class="text-center p-2"><span style="color: red"> <i class="fa fa-bullseye fa-5x"></i></span></th>
                    <th class="text-center p-2"><span style="color: red"><i class="fa fa-badge-dollar fa-5x"></i></span></th>
                    <th class="text-center p-2"><span style="color: red"> <i class="fa fa-calendar-check fa-5x"></i></span></th>
                </tr>
                <tr>
                    <th class="text-center p-2 font-weight-bold">{{__('general.physic_execution')}}</th>
                    <th class="text-center p-2 font-weight-bold">{{__('general.budget_execution')}}</th>
                    <th class="text-center p-2 font-weight-bold">{{__('general.calendar_execution')}}</th>
                </tr>
                <tr>
                    <td class="text-center p-2" style="color: red">{{$projectProgress}}%</td>
                    <td class="text-center p-2" style="color: red">{{  $project->getPercentageBudget()  }}%</td>
                    <td class="text-center p-2" style="color: red">{{$project->getProgressTimeUpDate()}}%</td>
                </tr>
            </table>
            <table class="border ex-e-table m-4">
                <thead class="border header">
                <tr class="border ">
                    <th colspan="6" class="border  text-center header"><h4 class="bold-h4">{{__('general.RESULTS')}}</h4></th>
                </tr>
                </thead>
                <tr>
                    <th></th>
                    <th class="text-center font-weight-bolder w-55">{{{trans_choice('general.result',1)}}}</th>
                    <th class="text-center font-weight-bolder w-15">{{{trans('general.executed')}}}</th>
                    <th class="text-center font-weight-bolder w-15">{{{trans('general.goal')}}}</th>
                    <th class="text-center font-weight-bolder w-15">{{{trans('general.percentage')}}}</th>
                </tr>
                @foreach($project->objectives as $objective)
                    @foreach($objective->results as $result)
                        <tr class="text-center">
                            <td class="text-center" style="color: #0a70bd">
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-flag fa-stack-1x fa-inverse"></i>
                            </span>
                            </td>
                            <td class="text-center">{{$result->text ?? '-'}}</td>
                            <td class="text-center">{{$result->advance ?? 0}}</td>
                            <td class="text-center">{{$result->goal ?? 0}}</td>
                            <td class="text-center">{{$result->progress}}%</td>
                        </tr>
                    @endforeach
                @endforeach
            </table>
            <br>
            <table class="border ex-e-table m-4">
                <thead class="border header">
                <tr class="border ">
                    <th colspan="6" class="border  text-center header"><h4 class="bold-h4">{{__('general.OBJECTIVES')}}</h4></th>
                </tr>
                </thead>
                @foreach($project->objectives as $objective)
                    @foreach($objective->results as $result)
{{--                            @foreach($result->services as $service)--}}
                                @if($loop->first)
                                    <tr class="border ">
                                        <th colspan="6" class="border  text-center" style="background-color: #7d8bc9 "><h4 class="bold-h4">{{$objective->name}}: {{$result->service ? $result->service->name : ''}}
                                                <i style="color:red" class="fa fa-caret-right fa-1x"></i></h4></th>
                                    </tr>
                                @endif
                                <tr>
                                    <th class="w-10"></th>
                                    <th class="w-30"></th>
                                    <th class="text-center w-10" style="color: red">{{trans('general.goal')}}</th>
                                    <th class="text-center w-20" style="color: red">{{trans('general.executed')}}</th>
                                    <th class="text-center w-20"><i style="color:red" class="fa fa-caret-down fa-2x"></i></th>
                                </tr>
                                <tr>
                                    <td class="text-center" style="color: #0a70bd"><i class="fa fa-shield fa-2x"></i></td>
                                    <td class="text-center">{{$result->text ?? '-'}}</td>
                                    <td class="text-center">{{$result->goal ?? 0}}</td>
                                    <td class="text-center">{{$result->advance ?? 0}}</td>
                                    <td class="text-center" style="color: red">{{$objective->result->progress ?? 0}}%</td>
                                </tr>
                            @endforeach
                    @endforeach
{{--                @endforeach--}}
            </table>
            <br>
        </div>
    </div>
@endsection