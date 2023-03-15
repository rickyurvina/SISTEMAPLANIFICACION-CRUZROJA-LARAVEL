@extends('modules.projectInternal.project')


@section('title', 'Informe Ejecutivo')


@section('project-page')
    <h1 class="subheader-title p-2">
        <i class="fal fa-table text-primary"></i> {{trans('general.executive_report')}}
    </h1>
    <div class="card">
        <h2 style="padding: 4px">{{trans('general.cutoff_date')}}: {{$now->format('d-m-Y')}}</h2>
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
                <th colspan="5" class="border p-2">{{ $project->name ?? '' }}</th>
            </tr>
            <tr>
            <tr class="border ">
                <th colspan="1" class="border p-2"><h4 class="bold-h4">{{trans_choice('general.objective_general',2)}}:</h4></th>
                <th colspan="5" class="border p-2">{!! $project->general_objective ?? ''!!}  </th>

            </tr>
            <tr class="border ">
                <th colspan="1" class="border p-2"><h4 class="bold-h4">{{trans_choice('general.programs',2)}}:</h4></th>
                <th colspan="5" class="border p-2">
                    @foreach($programs as $program)
                        <ul>
                            <li>{{ $program['name']}}</li>
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
                    style="width: 25%"><h4 class="bold-h4">{{trans('general.project_leader')}}:</h4>
                </th>
                <td colspan="2" class="text-center p-2">{{$project->responsible->name?? ''}}</td>
                <th colspan="1" class="border p-2"
                    style="width: 20%"><h4 class="bold-h4">{{trans_choice('general.departments',2)}}:</h4>
                </th>
                <td colspan="2" class="p-2">
                    @foreach($project->areas as $area)
                        <ul>
                            <li>{{$area->department->name ?? ''}}</li>
                        </ul>
                    @endforeach
                </td>
            </tr>
        </table>
        {{--            OBJETIVOS ESPECIFICOS --}}
        <table class="border ex-e-table m-4">
            <thead class="border header">
            <tr class="border p-2">
                <th colspan="6" class="border text-center"><h4 class="bold-h4">{{trans_choice('general.specific_objective',2)}}</h4></th>
            </tr>
            </thead>
            @foreach($project->objectives as $objective)
                <tr class="border">
                    <td style="padding: 4px" class="p-2">{{$objective->name ?? ''}}</td>
                </tr>
            @endforeach
        </table>
        <table class="border ex-e-table m-4">
            <thead class="border  header2">
            <tr class="border ">
                <th colspan="7" class="border  text-center"><h4 class="bold-h4">{{trans('general.INDICATORS')}}</h4></th>
            </tr>
            </thead>
            <tr class="border text-center" class="header2">
                <th class="borde text-center"><h4 class="bold-h4">{{trans('general.NAME')}}</h4></th>
                <th class="border text-center"><h4 class="bold-h4">{{trans('general.base_line')}}</h4></th>
                <th class="border text-center"><h4 class="bold-h4">{{trans('general.FREQUENCY')}}</h4></th>
                <th class="border text-center"><h4 class="bold-h4">{{trans('general.planned')}}</h4></th>
                <th class="border text-center"><h4 class="bold-h4">{{trans('general.executed')}}</h4></th>
                <th class="border text-center"><h4 class="bold-h4">{{trans('general.PERCENTAGE')}}</h4></th>
                <th class="border text-center"><h4 class="bold-h4">{{trans('general.STATUS')}}</h4></th>
            </tr>
            @foreach($project->objectives as $objective)
                @foreach($objective->results as $result)
                    @foreach($result->indicators as $indicator)
                        <tr class="text-center">
                            <td class="border p-2">{{$indicator->name ?? ''}}</td>
                            <td class="border text-center p-2">{{$indicator->base_line ?? ''}}</td>
                            <td class="border text-center p-2">{{\App\Models\Indicators\Indicator\Indicator::PERIODS[$indicator->frequency] ?? ''}}</td>
                            <td class="border text-center p-2">{{$indicator->total_goal_value ?? 0}} {{$indicator->indicatorUnit->abbreviation ?? ''}}</td>
                            <td class="border text-center p-2">{{$indicator->total_actual_value ?? 0}} {{$indicator->indicatorUnit->abbreviation ?? ''}}</td>
                            <td class="border text-center p-2">
                                <span class="badge {{$indicator->getStateIndicator()[0]}}">{{$indicator->getStateIndicator()[1]}}</span>
                            </td>
                            <td class="border text-center p-2">
                                <span class="badge {{$indicator->getStateIndicator()[0]}}"> </span>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
            @foreach($project->objectives as $objective)
                @foreach($objective->indicators as $indicatorO)
                    <tr class="text-center">
                        <td class="border p-2">{{$indicatorO->name ?? ''}}</td>
                        <td class="border text-center p-2">{{$indicatorO->base_line ?? ''}}</td>
                        <td class="border text-center p-2">{{\App\Models\Indicators\Indicator\Indicator::PERIODS[$indicatorO->frequency] ?? ''}}</td>
                        <td class="border text-center p-2">{{$indicatorO->total_goal_value ?? 0}} {{$indicatorO->indicatorUnit->abbreviation ?? ''}}</td>
                        <td class="border text-center p-2">{{$indicatorO->total_actual_value ?? 0}} {{$indicatorO->indicatorUnit->abbreviation ?? ''}}</td>
                        <td class="border text-center p-2">
                            <span class="badge {{$indicatorO->getStateIndicator()[0]}}">{{$indicatorO->getStateIndicator()[1]}}</span>
                        </td>
                        <td class="border text-center p-2">
                            <span class="badge {{$indicatorO->getStateIndicator()[0]}}"> </span>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </table>
        <table class="border ex-e-table m-4">
            <thead class="border header">
            <tr class="border">
                <th colspan="8" class="border  text-center"><h4 class="bold-h4">{{trans('general.cumulative_budget_advance')}}</h4>
                </th>
            </tr>
            <tr>
                <th style="width: max-content" rowspan="2" colspan="4" class="border  text-center header2"><h4>
                        {{trans('general.ADVANCE')}}</h4>
                </th>
                <th rowspan=2 class="border  text-center header2"><h4 class="bold-h4">{{trans('general.total_amount')}}</h4></th>
                <th colspan="3" class="border  text-center header2"><h4 class="bold-h4">{{trans('general.earned_value')}}</h4></th>
            </tr>
            <tr>
                <th class="border  text-center header2"><h4 class="bold-h4">{{trans('general.encoded')}}</h4></th>
                <th class="border  text-center header2"><h4 class="bold-h4">{{trans('general.earned')}}</h4></th>
                <th class="border  text-center header2"><h4 class="bold-h4">{{trans('general.PERCENTAGE')}}</h4></th>
            </tr>
            </thead>
            <tr>
                <td colspan="4" id="budgetAdvance" style="max-width: 800px; height: 300px"></td>
                <td class="border text-center">{{$project->getTotalBudgetProject()}}</td>
                <td class="border text-center">{{$project->getTotalBudgetEncodedProject()}}</td>
                <td class="border text-center">{{$project->getTotalBudgetAsProject()}}</td>
                <td class="border text-center">{{  $project->getPercentageBudget()  }}%</td>
            </tr>
        </table>
        <table class="border ex-e-table m-4">
            <thead class="border header">
            <tr class="border ">
                <th colspan="7" class="border  text-center"><h4 class="bold-h4">{{trans('general.physical_advance')}}</h4></th>
            </tr>
            </thead>
            <tr>
                <th class="border  text-center" rowspan="3" id="projectAdvance" style="height: 300px; max-width: 800px;"></th>
                <th class="border  text-center" style="width:100%" colspan="4">
                    <table class="ex-e-table" style="min-width: -webkit-fill-available">
                        <thead class="border  bg-primary-50" style="color:#eaeef0">
                        <tr class="border ">
                            <th colspan="6" class="border text-center p-2" style="background-color: #43a047"><h4
                                        class="bold-h4">{{trans('general.executed_task')}}</h4>
                            </th>
                        <tr>
                            <th class="border text-center p-2" style="background-color: #43a047"><h4 class="bold-h4">
                                    {{trans('general.milestone')}}</h4></th>
                            <th class="border text-center p-2" style="background-color: #43a047"><h4 class="bold-h4">
                                    {{trans_choice('general.date',2)}}</h4></th>
                            <th class="border text-center p-2" style="background-color: #43a047"><h4 class="bold-h4">
                                    {{trans_choice('general.responsible',2)}}</h4></th>
                        </tr>
                        </thead>
                        <th>
                            @if($activities->count()>0)
                                @foreach($activities as $activity)
                                    <tr>
                                        @if(($activity->status=='Terminada'||
                                            $activity->status=='En progreso') &&
                                            ($activity->start_date<$now && $now<$activity->end_date) )
                                            <td class="border p-2">{{$activity->text ?? ''}}</td>
                                            <td class="border  text-center p-2">{{$activity->end_date ? $activity->end_date->format('d-m-Y') : ''}}</td>
                                            <td class="border  text-center p-2">{{$activity->responsible->name ?? ''}}</td>
                                        @endif
                                    </tr>
                        @endforeach
                        @else
                            <td colspan=4 class="border text-center p-2">{{trans('general.there_are_no_executed_milestone')}}</td>
                            @endif
                            </th>
                    </table>
                    <br>
                    <table class="ex-e-table" style="min-width: -webkit-fill-available">
                        <thead class="border header" style="background-color: #f4511e">
                        <tr class="border ">
                            <th colspan="6" class="border p-2 text-center"><h4 class="bold-h4">{{trans('general.overdue_task')}}</h4></th>
                        <tr>
                            <th class="border text-center p-2"><h4 class="bold-h4">{{trans('general.milestone')}}</h4></th>
                            <th class="border text-center p-2"><h4 class="bold-h4">{{trans_choice('general.date',2)}}</h4></th>
                            <th class="border text-center p-2"><h4 class="bold-h4">{{trans_choice('general.responsible',2)}}</h4></th>
                        </tr>
                        </thead>
                        <th>
                            @if($activities->count()>0)
                                @foreach($activities as $activity)
                                    <tr>
                                        @if(($activity->status=='Programada'||
                                             $activity->status=='En progreso') &&
                                              $activity->end_date<=$now)
                                            <td class="border p-2">{{$activity->text ?? ''}}</td>
                                            @if($activity->end_date!=null)
                                                <td class="border p-2 text-center">{{$activity->end_date ? $activity->end_date->format('d-m-Y') : ''}}</td>
                                            @else
                                                <td class="border  p-2 text-center">------</td>
                                            @endif
                                            <td class="border p-2 text-center">{{$activity->responsible->name??''}}</td>
                                        @endif
                                    </tr>
                        @endforeach
                        @else
                            <td colspan=4 class="border  text-center">{{trans('general.there_are_no_overdue_milestone')}}</td>
                            @endif
                            </th>
                    </table>
                    <br>
                    <table class="ex-e-table" style="min-width: -webkit-fill-available">
                        <thead class="border header" style="background-color: #ffab40">
                        <tr class="border ">
                            <th colspan="4" class="border p-2 text-center"><h4 class="bold-h4">{{trans('general.upcoming_task')}}</h4></th>
                        <tr>
                            <th class="border p-2 text-center"><h4 class="bold-h4">{{trans('general.milestone')}}</h4></th>
                            <th class="border p-2 text-center"><h4 class="bold-h4">{{trans_choice('general.date',2)}}</h4></th>
                            <th class="border p-2 text-center"><h4 class="bold-h4">{{trans_choice('general.responsible',2)}}</h4></th>
                        </tr>
                        </thead>
                        <th>
                            @if($activities->count()>0)
                                @foreach($activities as $activity)
                                    <tr>
                                        @if(($activity->status=='Programada') &&
                                             $activity->end_date>$now)
                                            <td class="border p-2 text-center">{{$activity->text ?? ''}}</td>
                                            <td class="border p-2 text-center">{{$activity->end_date ? $activity->end_date->format('d-m-Y') : ''}}</td>
                                            <td class="border p-2 text-center">{{$activity->responsible->name ?? ''}}</td>
                                        @endif
                                    </tr>
                        @endforeach
                        @else
                            <td colspan=4 class="border  text-center">{{trans('general.there_are_no_upcoming_milestone')}}</td>
                            @endif
                            </th>
                    </table>
                    <br>
                </th>
            </tr>

        </table>
    </div>

    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/dark.js"></script>

@endsection

@push('page_script')

    <script>
        // Themes begin
        am4core.useTheme(am4themes_animated);
        am4core.useTheme(am4themes_dark);
        // Themes end
        // create chart PRESUPUESTO
        var budgetAdvance = am4core.create("budgetAdvance", am4charts.GaugeChart);
        budgetAdvance.innerRadius = -15;

        var axis = budgetAdvance.xAxes.push(new am4charts.ValueAxis());
        axis.min = 0;
        axis.max = 100;
        axis.strictMinMax = true;
        axis.numberFormatter.numberFormat = "#a";

        let ds = new am4core.DropShadowFilter();
        ds.blur = 10;
        ds.opacity = 0.5;
        axis.filters.push(ds)

        var colorSet = new am4core.ColorSet();

        var gradient = new am4core.LinearGradient();
        gradient.stops.push({color: am4core.color("red")})
        gradient.stops.push({color: am4core.color("yellow")})
        gradient.stops.push({color: am4core.color("green")})

        axis.renderer.line.stroke = gradient;
        axis.renderer.line.strokeWidth = 15;
        axis.renderer.line.strokeLinecap = "round";
        axis.renderer.line.strokeOpacity = 1;

        axis.renderer.grid.template.disabled = true;
        const data = {{$project->getPercentageBudget()}}
        console.log(data)
        var hand = budgetAdvance.hands.push(new am4charts.ClockHand());
        hand.radius = am4core.percent(102);
        hand.startWidth = 16;
        hand.pin.radius = 8;
        hand.parent.zIndex = 100;
        setInterval(function () {
            hand.showValue(data, 1000, am4core.ease.cubicOut);
        }, 2000);
    </script>
    <script>
        am4core.useTheme(am4themes_animated);
        am4core.useTheme(am4themes_dark);
        // create chart AVANCE
        var projectAdvance = am4core.create("projectAdvance", am4charts.GaugeChart);
        projectAdvance.innerRadius = -15;

        var axis = projectAdvance.xAxes.push(new am4charts.ValueAxis());
        axis.min = 0;
        axis.max = 100;
        axis.strictMinMax = true;
        axis.numberFormatter.numberFormat = "#a";

        let dsa = new am4core.DropShadowFilter();
        dsa.blur = 10;
        dsa.opacity = 0.5;
        axis.filters.push(dsa)

        var colorSet = new am4core.ColorSet();

        var gradient = new am4core.LinearGradient();
        gradient.stops.push({color: am4core.color("red")})
        gradient.stops.push({color: am4core.color("yellow")})
        gradient.stops.push({color: am4core.color("green")})

        axis.renderer.line.stroke = gradient;
        axis.renderer.line.strokeWidth = 15;
        axis.renderer.line.strokeLinecap = "round";
        axis.renderer.line.strokeOpacity = 1;

        axis.renderer.grid.template.disabled = true;
        const dataProgress = JSON.parse(`<?php echo $projectProgress; ?>`)
        console.log(dataProgress)
        var handA = projectAdvance.hands.push(new am4charts.ClockHand());
        handA.radius = am4core.percent(102);
        handA.startWidth = 16;
        handA.pin.radius = 8;
        handA.parent.zIndex = 100;
        setInterval(function () {
            handA.showValue(dataProgress, 1000, am4core.ease.cubicOut);
        }, 2000);
    </script>
@endpush