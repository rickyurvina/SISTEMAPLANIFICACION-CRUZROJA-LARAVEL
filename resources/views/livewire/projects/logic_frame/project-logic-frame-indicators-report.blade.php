<div>
    <div class="row">
        <div class="col-md-12">
            <div id="chartIndicatorsAdvance" style="width: 100%; height: 500px !important;"></div>
        </div>
        <div class="col-md-12">

            <div class="card">
                <h5 class="card-title">{{ trans('general.list_indicators') }}</h5>
                <div class="table-responsive">
                    <table class="table table-hover m-0">
                        <thead class="bg-primary-50">
                        <tr>
                            <th>@sortablelink('code', trans('general.code'))</th>
                            <th>@sortablelink('name', trans('general.name'))</th>
                            <th>@sortablelink('user_id', trans('general.responsible'))</th>
                            <th>@sortablelink('category', trans('general.category'))</th>
                            <th>@sortablelink('state', trans('general.state'))</th>
                            <th>@sortablelink('period_advance', trans('general.period_advance'))</th>
                            <th>@sortablelink('updated_at', trans('general.updated_at'))</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($indicators as $item)
                            <tr>
                                <td><a href="javascript:void(0);" aria-expanded="false"
                                       wire:click="$emitTo('indicators.indicator-show', 'open', {{ $item->id }})">{{ $item->code }}</a>
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->category }}</td>
                                <td>
                                    <span class="form-label badge {{$item->getStateIndicator()[0]?? null}}  badge-pill">{{$item->getStateIndicator()[1]?? null}}%</span>
                                </td>
                                <td>{{ $item->progressIndicator()>0 ?  $item->progressIndicator() : '0.00'}}</td>
                                <td>{{ $item->updated_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('page_script')
    <script>
        window.addEventListener('updateChartDataProjectResults', event => {
            am4core.ready(function () {
                am4core.useTheme(am4themes_animated);
                let chart = am4core.create("chartIndicatorsAdvance", am4charts.XYChart);
                //chart.scrollbarY = new am4core.Scrollbar();

                var title = chart.titles.create();
                title.text = "Avance de Indicadores por Resultado";
                title.fontSize = 18;
                title.paddingBottom = 10;

                // chart.data = JSON.parse(event.detail.data_project_results);
                chart.data =@json($data_project_results);

                let yAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                yAxis.dataFields.category = "indicator";
                yAxis.renderer.grid.template.location = 0;
                yAxis.renderer.labels.template.fontSize = 10;
                yAxis.renderer.minGridDistance = 10;
                yAxis.reverseOrder = true;
                yAxis.tooltip.disabled = true;

                let xAxis = chart.xAxes.push(new am4charts.ValueAxis());
                xAxis.min = 0;
                xAxis.max = 100;
                xAxis.tooltip.disabled = true;
                xAxis.renderer.labels.template.adapter.add("text", function (text) {
                    return text + "%";
                });

                let series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.valueX = "progress";
                series.dataFields.categoryY = "indicator";
                series.columns.template.tooltipText = "Porcentaje de Avance: [bold]{valueX}[/] %";
                series.columns.template.strokeWidth = 0;
                series.columns.template.column.propertyFields.fill = "color";

                var labelBullet = series.bullets.push(new am4charts.LabelBullet());
                labelBullet.label.text = "{progress} %";
                labelBullet.label.fontSize = 20;
                labelBullet.locationX = 0.1;
                labelBullet.label.hideOversized = true;

                chart.cursor = new am4charts.XYCursor();

                let listOfResponsePlans = [];
                listOfResults = event.detail.data_information_project_result;
                {{--listOfResults =  {{ json_encode($data_information_project_result) }};--}}


                series.columns.template.adapter.add("fill", function (fill, target) {
                    if (target.dataItem) {
                        switch (target.dataItem.dataContext.response_plan) {

                            @foreach($data_information_project_result as $index => $p)
                            case "{{$p['result']}}":
                                return "{{$p['color']}}";
                                break;
                                @endforeach
                        }
                    }
                    return fill;
                });

                var axisBreaks = {};
                var legendData = [];

                function addRange(label, start, end, color) {

                    var range = yAxis.axisRanges.create();
                    range.category = start;
                    range.endCategory = end;
                    range.label.text = label;
                    range.label.disabled = false;
                    range.label.fill = color;
                    range.label.location = 0;
                    range.label.dx = -145;
                    range.label.dy = 12;
                    range.label.fontWeight = "bold";
                    range.label.fontSize = 12;
                    range.label.horizontalCenter = "left"
                    range.label.inside = true;

                    range.grid.stroke = am4core.color("#396478");
                    range.grid.strokeOpacity = 1;
                    range.tick.length = 200;
                    range.tick.disabled = false;
                    range.tick.strokeOpacity = 0.6;
                    range.tick.stroke = am4core.color("#396478");
                    range.tick.location = 0;

                    range.locations.category = 1;
                    var axisBreak = yAxis.axisBreaks.create();
                    axisBreak.startCategory = start;
                    axisBreak.endCategory = end;
                    axisBreak.breakSize = 1;
                    axisBreak.fillShape.disabled = true;
                    axisBreak.startLine.disabled = true;
                    axisBreak.endLine.disabled = true;
                    axisBreaks[label] = axisBreak;

                    legendData.push({name: label, fill: color});
                }

                listOfResults.forEach(function (element) {
                    addRange(element['result'], element['mayor'], element['menor'], element['color']);
                })
                {{--@foreach($data_information_project_result as $item)--}}

                {{--addRange({{$item['result']}}, {{$item['mayor']}}, {{$item['menor']}}, {{$item['color']}});--}}

                {{--@endforeach--}}

                let legend = new am4charts.Legend();
                legend.position = "bottom";
                legend.scrollable = true;
                legend.valign = "top";
                legend.reverseOrder = true;

                chart.legend = legend;
                legend.data = legendData;

                legend.itemContainers.template.events.on("toggled", function (event) {
                    var name = event.target.dataItem.dataContext.name;
                    var axisBreak = axisBreaks[name];
                    if (event.target.isActive) {
                        axisBreak.animate({property: "breakSize", to: 0}, 1000, am4core.ease.cubicOut);
                        yAxis.dataItems.each(function (dataItem) {
                            if (dataItem.dataContext.result == name) {
                                dataItem.hide(1000, 500);
                            }
                        })
                        series.dataItems.each(function (dataItem) {
                            if (dataItem.dataContext.result == name) {
                                dataItem.hide(1000, 0, 0, ["valueX"]);
                            }
                        })
                    } else {
                        axisBreak.animate({property: "breakSize", to: 1}, 1000, am4core.ease.cubicOut);
                        yAxis.dataItems.each(function (dataItem) {
                            if (dataItem.dataContext.result == name) {
                                dataItem.show(1000);
                            }
                        })

                        series.dataItems.each(function (dataItem) {
                            if (dataItem.dataContext.result == name) {
                                dataItem.show(1000, 0, ["valueX"]);
                            }
                        })
                    }
                })

            });
        })
    </script>
@endpush
