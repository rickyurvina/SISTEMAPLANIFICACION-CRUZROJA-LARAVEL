@extends('layouts.admin')

@section('title', trans('general.reports'))

@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0 mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('projects.reports') }}">
                Informes
            </a>
        </li>

        <li class="breadcrumb-item active"> Seguimiento de Cartera</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <x-label-section> Seguimiento de Cartera</x-label-section>
        <div class="card m-3">
            <h4 class="bold-h4 m-2">Nombre Corto del Proyecto</h4>
            <h5 class="p-2">
                {{--                {{$project->name}}--}}
            </h5>
            <table class="border p-2 m-3">
                <tr>
                    <th class="text-center bold-h4 border" style="background-color: #DDEBF7">Presupuesto</th>
                    <th class="text-center bold-h4 border" style="background-color: #DDEBF7">Valor Ejecutado</th>
                    <th class="text-center bold-h4 border" style="background-color: #DDEBF7">Saldo sin Ejecutar</th>
                    <th class="border text-center bold-h4 p-2">Donante</th>
                    <th class="border text-center bold-h4 p-2">Fecha de Inicio</th>
                    <th class="border text-center bold-h4 p-2">Fecha de Fin</th>
                </tr>
                <tr class="border">
                    <td class="text-center border">
                        {{--                        {{$project->getTotalBudgetEncodedProject()}}--}}
                    </td>
                    <td class="text-center border">
                        {{--                        {{$project->getTotalBudgetAsProject()}}--}}
                    </td>
                    <td class="text-center border">
                        {{--                        {{$project->getTotalBudgetWithOutExecutionProject()}}--}}
                    </td>
                    <td>
                        <select name="founders" class="custom-select" id="funders">
                            <option value="">Financiadores</option>
                            {{--                            @foreach($project->funders as $funder)--}}
                            {{--                                <option value="{{ $funder->id }}">{{ $funder->name }}</option>--}}
                            {{--                            @endforeach--}}
                        </select>
                    </td>
                    <td class="border text-center p-2">
                        {{--                        {{$project->end_date->format('d-m-Y') ?? ''}}--}}
                    </td>
                    <td class="border text-center p-2">
                        {{--                        {{$project->start_date->format('d-m-Y') ?? ''}}--}}
                    </td>
                </tr>
                <tr>
                    <td class="border p-2" colspan="3">
                        <div class="demo-v-spacing">
                            <div class="progress">
                                {{--                                <div class="progress-bar bg-secondary" role="progressbar" style="width: {{$project->getPhysicProgress()}}%"--}}
                                {{--                                     aria-valuenow="{{$project->getPhysicProgress()}}" aria-valuemin="0" aria-valuemax="100">{{$project->getPhysicProgress()}}% Avance Técnico--}}
                                {{--                                </div>--}}
                            </div>
                            <div class="progress">
                                {{--                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{$project->getProgressTimeUpDate()}}%"--}}
                                {{--                                     aria-valuenow="{{$project->getProgressTimeUpDate()}}" aria-valuemin="0" aria-valuemax="100">{{$project->getProgressTimeUpDate()}}% Avance--}}
                                {{--                                    Tiempo--}}
                                {{--                                </div>--}}
                            </div>
                            <div class="progress">
                                {{--                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$project->getPercentageBudget()}}%"--}}
                                {{--                                     aria-valuenow="{{$project->getPercentageBudget()}}" aria-valuemin="0" aria-valuemax="100">{{$project->getPercentageBudget()}}% Avance--}}
                                {{--                                    Presupuesto--}}
                                {{--                                </div>--}}
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">Fecha de Corte: {{$now->format('d-m-Y')}}</td>
                    <td colspan="3" class="text-center">Suma Beneficiarios:
                        {{--                        {{$project->getTotalBeneficiaries()}}--}}
                    </td>
                </tr>
            </table>
        </div>
        <div>
            <div class="row">
                <div class="col-12">
                    <div class="text-center p-2">
                        <x-label-section>Ejecuciòn Mujeres / Hombres</x-label-section>
                    </div>
                    <div class="mt-2 p-2">
                        <div id="WomenMenChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_script')

    <script>
        am4core.ready(function () {
            am4core.useTheme(am4themes_animated);

            var chart = am4core.create("WomenMenChart", am4charts.XYChart);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            chart.paddingBottom = 30;

            chart.data = [{
                "name": "Women",
                "steps": 688
            }, {
                "name": "Men",
                "steps": 11561
            }];

            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "name";
            categoryAxis.renderer.grid.template.strokeOpacity = 0;
            categoryAxis.renderer.minGridDistance = 10;
            categoryAxis.renderer.labels.template.dy = 35;
            categoryAxis.renderer.tooltip.dy = 35;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.renderer.inside = true;
            valueAxis.renderer.labels.template.fillOpacity = 0.8;
            valueAxis.renderer.grid.template.strokeOpacity = 0;
            valueAxis.min = 0;
            valueAxis.cursorTooltipEnabled = false;
            valueAxis.renderer.baseGrid.strokeOpacity = 0;

            var series = chart.series.push(new am4charts.ColumnSeries);
            series.dataFields.valueY = "steps";
            series.dataFields.categoryX = "name";
            series.tooltipText = "{valueY.value}";
            series.tooltip.pointerOrientation = "vertical";
            series.tooltip.dy = -6;
            series.columnsContainer.zIndex = 100;

            var columnTemplate = series.columns.template;
            columnTemplate.width = am4core.percent(50);
            columnTemplate.maxWidth = 66;
            columnTemplate.column.cornerRadius(60, 60, 10, 10);
            columnTemplate.strokeOpacity = 0;

            series.heatRules.push({target: columnTemplate, property: "fill", dataField: "valueY", min: am4core.color("#FF66CC"), max: am4core.color("#7080F6")});
            series.mainContainer.mask = undefined;

            var cursor = new am4charts.XYCursor();
            chart.cursor = cursor;
            cursor.lineX.disabled = true;
            cursor.lineY.disabled = true;
            cursor.behavior = "none";

            var bullet = columnTemplate.createChild(am4charts.CircleBullet);
            bullet.circle.radius = 30;
            bullet.valign = "bottom";
            bullet.align = "center";
            bullet.isMeasured = true;
            bullet.mouseEnabled = false;
            bullet.verticalCenter = "bottom";

            var hoverState = bullet.states.create("hover");
            var outlineCircle = bullet.createChild(am4core.Circle);
            outlineCircle.adapter.add("radius", function (radius, target) {
                var circleBullet = target.parent;
                return circleBullet.circle.pixelRadius + 10;
            })

            var image = bullet.createChild(am4core.Image);
            image.width = 60;
            image.height = 60;
            image.horizontalCenter = "middle";
            image.verticalCenter = "middle";

            image.adapter.add("href", function (href, target) {
                var dataItem = target.dataItem;
                if (dataItem) {
                    return "{{ url('/'). '/img/' }}" + dataItem.categoryX.toLowerCase() + ".png";
                }
            })

            image.adapter.add("mask", function (mask, target) {
                var circleBullet = target.parent;
                return circleBullet.circle;
            })

            var previousBullet;
            chart.cursor.events.on("cursorpositionchanged", function (event) {
                var dataItem = series.tooltipDataItem;

                if (dataItem.column) {
                    var bullet = dataItem.column.children.getIndex(1);

                    if (previousBullet && previousBullet != bullet) {
                        previousBullet.isHover = false;
                    }

                    if (previousBullet != bullet) {

                        var hs = bullet.states.getKey("hover");
                        hs.properties.dy = -bullet.parent.pixelHeight + 30;
                        bullet.isHover = true;

                        previousBullet = bullet;
                    }
                }
            })
        });//ejecuccion general

    </script>
@endpush
