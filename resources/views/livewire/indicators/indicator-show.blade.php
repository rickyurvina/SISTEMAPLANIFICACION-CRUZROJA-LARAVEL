<div class="modal-dialog modal-dialog-center modal-xl">
    <div class="modal-content">
        <div class="modal-content">
            <div class="modal-header bg-primary color-white">
                <h5 class="modal-title h4">{{ trans('indicators.indicator.show_indicator') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            @if(isset($indicator))
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-2"><h5><strong>{{ trans('general.name') }}</strong></h5></dt>
                                <dd class="col-sm-4">
                                    {{ $indicator->name }}
                                </dd>
                                <dt class="col-sm-2"><h5><strong>{{ trans('general.code') }}</strong></h5></dt>
                                <dd class="col-sm-4">
                                    {{ $indicator->code }}
                                </dd>
                                <dt class="col-sm-2"><h5><strong>{{ trans('general.start_date') }}</strong></h5></dt>
                                <dd class="col-sm-4">
                                    {{ $indicator->start_date }}
                                </dd>

                                <dt class="col-sm-2"><h5><strong>{{ trans('general.end_date') }}</strong></h5></dt>
                                <dd class="col-sm-4">
                                    {{ $indicator->end_date }}
                                </dd>

                                <dt class="col-sm-2"><h5><strong>{{ trans('general.type') }}</strong></h5></dt>
                                <dd class="col-sm-4">
                                    {{ $indicator->type=='Manual'? trans('indicators.indicator.manual') :'' }}{{ $indicator->type=='Homologated'? trans('indicators.indicator.homologate'):'' }} {{ $indicator->type=='Grouped'? trans('indicators.indicator.grouped'):'' }}
                                </dd>
                                <dt class="col-sm-2"><h5><strong>{{ trans('indicators.indicator.results') }}</strong></h5></dt>
                                <dd class="col-sm-4">
                                    {{ $indicator->results }}
                                </dd>
                                <dt class="col-sm-2"><h5><strong>{{ trans('indicators.indicator.type_of_aggregation') }}</strong></h5></dt>
                                <dd class="col-sm-4">
                                    {{ $indicator->getTypeAggregation() }}
                                </dd>

                                <dt class="col-sm-2"><h5><strong>{{ trans('indicators.indicator.unit_of_measurement') }}</strong></h5></dt>
                                <dd class="col-sm-4">
                                    {{ $indicator->indicatorUnit->name }}
                                </dd>

                                <dt class="col-sm-2"><h5><strong>{{ trans('general.responsible') }}</strong></h5></dt>
                                <dd class="col-sm-4">
                                    {{ $indicator->user->name }}
                                </dd>


                                <dt class="col-sm-2"><h5><strong>{{trans('indicators.indicator.frequency_update') }}</strong></h5></dt>
                                <dd class="col-sm-4">
                                    {{$indicator->getFrequency()}}
                                </dd>

                                @if(count($this->indicator->indicatorParents)>0)

                                    <dt class="col-sm-2"><h5><strong>{{trans('indicators.indicator.total_actual_value') }}</strong></h5></dt>
                                    <dd class="col-sm-4">
                                        {{ $indicator->total_actual_value}}
                                    </dd>

                                    <dt class="col-sm-2"><h5><strong>{{trans('indicators.indicator.total_goal_value') }}</strong></h5></dt>
                                    <dd class="col-sm-4">
                                        {{$indicator->total_goal_value}}
                                    </dd>

                                    <dt class="col-sm-2"><h5><strong>{{trans('indicators.indicator.child_indicators') }}</strong></h5></dt>
                                    <dd class="col-sm-4">
                                        <ul>
                                            @foreach($indicator->indicatorParents as $child)
                                                <li>
                                                    {{$child->indicator->name}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </dd>

                                @else
                                    <dt class="col-sm-2"><h5><strong>{{ trans('general.source') }}</strong></h5></dt>
                                    <dd class="col-sm-4">
                                        {{ $indicator->sourceIndicator->name ?? null }}
                                    </dd>

                                    <dt class="col-sm-2"><h5><strong>{{ trans('indicators.indicator.base_line') }}</strong></h5></dt>
                                    <dd class="col-sm-4">
                                        {{ $indicator->base_line }}
                                    </dd>

                                    <dt class="col-sm-2"><h5><strong>{{ trans('indicators.indicator.baseline_year') }}</strong></h5></dt>
                                    <dd class="col-sm-4">
                                        {{ $indicator->baseline_year }}
                                    </dd>

                                    <dt class="col-sm-2"><h5><strong>{{ trans('indicators.indicator.final_goal') }}</strong></h5></dt>
                                    <dd class="col-sm-4">
                                        {{ $indicator->goalsRegister() }}
                                    </dd>

                                    <dt class="col-sm-2"><h5><strong>{{ trans('indicators.indicator.total_sum_advance') }}</strong></h5></dt>
                                    <dd class="col-sm-4">
                                        {{ $indicator->progressIndicator() }}
                                    </dd>

                                    <dt class="col-sm-2"><h5><strong>{{trans('indicators.indicator.state_indicator') }}</strong></h5></dt>
                                    <dd class="col-sm-4">
                                        <span class="form-label badge {{$indicator->getStateIndicator()[0]?? null}}  badge-pill">{{$indicator->getStateIndicator()[1]?? null}}</span>
                                    </dd>

                                    <div class="col-sm-8 text-center">

                                        <table id="dt-basic-example" class="table table-bordered  table-striped w-100 dataTable no-footer dtr-inline" role="grid"
                                               aria-describedby="dt-basic-example_info" style="width: 300px">
                                            <thead>
                                            <tr>
                                                <th class="sorting text-center" tabindex="0" aria-controls="dt-basic-example" rowspan="1" colspan="5" style="width: 111px">
                                                    <h3>{{trans('indicators.indicator.threshold_details')}}</h3></th>
                                            </tr>
                                            <tr role="row">
                                                <th class="sorting text-center" tabindex="0" aria-controls="dt-basic-example" rowspan="1" colspan="1" style="width: 111px">
                                                    <span class="">{{trans('indicators.indicator.state')}}</span></th>
                                                <th class="sorting text-center" tabindex="0" aria-controls="dt-basic-example" rowspan="1" colspan="1"
                                                    style="width: 111px">{{trans('indicators.indicator.minimum')}}</th>
                                                <th class="sorting text-center" tabindex="0" aria-controls="dt-basic-example" rowspan="1" colspan="1"
                                                    style="width: 111px">{{trans('indicators.indicator.maximum')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <tr id="1" role="row" class="add">
                                                <td class="dtr-control text-center">
                                                    <span class="d-inline-block rounded-circle mr-2 bg-warning bg-warning" style="width: 15px; height: 15px"></span>
                                                </td>
                                                <td class="dtr-control text-center">
                                                    <small>{{$minAW}}</small>
                                                </td>
                                                <td class="dtr-control text-center">
                                                    <small>{{$maxAW}}</small>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="indicator-chart-"  style="height: 350px; width: 100%">
                                    </div>
                                    <div id="chartdata-"></div>
                                @endif

                            </dl>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <h2>{{trans('general.indicator_state')}}</h2>
                </div>
                <div id="chartdivIndicatorGrouped" class="w-100 height-lg" wire:ignore.self></div>
            @endif
        </div>
    </div>
</div>

@push('page_script')
    <script>
        // end am4core.ready()
        $('#indicator-show-modal').on('show.bs.modal', function (e) {
            window.addEventListener('updateChartData1', event => {
                // alert("hola")
                let chart_ = am4core.create("indicator-chart-", am4charts.XYChart);
                chart_.data = event.detail.data;

                // Create axes
                var categoryAxis = chart_.xAxes.push(new am4charts.CategoryAxis());
                categoryAxis.renderer.labels.template.rotation = 90;
                categoryAxis.dataFields.category = "frequency";
                categoryAxis.title.text = "Frecuencia";
                categoryAxis.renderer.minGridDistance = 1;
                // categoryAxis.renderer.grid.template.location = 1.5;
                // categoryAxis.renderer.grid.template.location = 0.5;

                let valueAxis = chart_.yAxes.push(new am4charts.ValueAxis());
                valueAxis.title.text = "Unidad de medida";

                // Create series
                var series = chart_.series.push(new am4charts.LineSeries());
                series.dataFields.valueY = "value";
                series.dataFields.categoryX = "frequency";
                series.name = "Meta";
                series.tooltipText = "{name}: [bold]{valueY}[/]";
                series.strokeWidth = 3;
                series.strokeDasharray = "5,4";
                series.stroke = am4core.color("#9d00ff");
                let circleBullet = series.bullets.push(new am4charts.CircleBullet());
                circleBullet.circle.fill = am4core.color("#fff");
                circleBullet.circle.stroke = am4core.color("#9d00ff");
                circleBullet.circle.strokeWidth = 3;
                series.tooltip.pointerOrientation = "vertical";

                var series1 = chart_.series.push(new am4charts.LineSeries());
                series1.dataFields.valueY = "actual";
                series1.dataFields.categoryX = "frequency";
                series1.name = "Actual";
                series1.tooltipText = "{name}: [bold]{valueY}[/]";
                series1.strokeWidth = 3;
                series1.bullets.push(new am4charts.CircleBullet());
                let circleBullet1 = series1.bullets.push(new am4charts.CircleBullet());
                circleBullet1.circle.fill = am4core.color("#fff");
                circleBullet1.propertyFields.stroke = "color";
                circleBullet1.circle.strokeWidth = 3;

                chart_.legend = new am4charts.Legend();

                // Add cursor
                chart_.cursor = new am4charts.XYCursor();

                chart_.events.on("datavalidated", function (ev) {
                    chart_.exporting.dataFields = {
                        "frequency": "",
                        "value": "Meta",
                        "actual": "Actual",
                        "progress": "%",
                    }
                    chart_.exporting.adapter.add("data", function (data) {
                        for (var i = 0; i < data.data.length; i++) {
                            data.data[i].progress += "%";
                        }
                        return data;
                    });

                    chart_.exporting.getHTML("html", {
                        addColumnNames: true,
                        pivot: true,
                        emptyAs: "",
                        tableClass: "table table-sm m-0"
                    }, false).then(function (html) {
                        var div = document.getElementById("chartdata-");
                        div.innerHTML = html;
                    });
                });

                // A button to toggle the data table
                var button = chart_.createChild(am4core.SwitchButton);
                button.align = "right";
                button.leftLabel.text = "Ver Datos";
                button.isActive = false;

                // Set toggling of data table
                button.events.on("toggled", function (ev) {
                    var div = document.getElementById("chartdata-");
                    if (button.isActive) {
                        div.style.display = "block";
                    } else {
                        div.style.display = "none";
                    }
                });
            });
            window.addEventListener('updateChartData2', event => {
                am4core.useTheme(am4themes_animated);
                var chartMin = 0;
                var chartMax = 100;
                data = {
                    score: event.detail.data[0]['score'],
                    gradingData: [
                        {
                            color: "#ee1f25",
                            lowScore: 0,
                            highScore: event.detail.data[0]['min']
                        },
                        {
                            color: "#F39C12",
                            lowScore: event.detail.data[0]['min'],
                            highScore: event.detail.data[0]['max']
                        },
                        {
                            color: "#0f9747",
                            lowScore: event.detail.data[0]['max'],
                            highScore: 100
                        }
                    ]
                };

                /**
                 Grading Lookup
                 */
                function lookUpGrade(lookupScore, grades) {
                    // Only change code below this line
                    for (var i = 0; i < grades.length; i++) {
                        if (
                            grades[i].lowScore < lookupScore &&
                            grades[i].highScore >= lookupScore
                        ) {
                            return grades[i];
                        }
                    }
                    return null;
                }

//
                var chart = am4core.create("chartdivIndicatorGrouped", am4charts.GaugeChart);
                chart.hiddenState.properties.opacity = 0;
                chart.fontSize = 11;
                chart.innerRadius = am4core.percent(80);
                chart.resizable = true;
                /**
                 * Normal axis
                 */
                var axis = chart.xAxes.push(new am4charts.ValueAxis());
                axis.min = chartMin;
                axis.max = chartMax;
                axis.strictMinMax = true;
                axis.renderer.radius = am4core.percent(80);
                axis.renderer.inside = true;
                axis.renderer.line.strokeOpacity = 0.1;
                axis.renderer.ticks.template.disabled = false;
                axis.renderer.ticks.template.strokeOpacity = 1;
                axis.renderer.ticks.template.strokeWidth = 0.5;
                axis.renderer.ticks.template.length = 5;
                axis.renderer.grid.template.disabled = true;
                axis.renderer.labels.template.radius = am4core.percent(15);
                axis.renderer.labels.template.fontSize = "0.9em";
                /**
                 * Axis for ranges
                 */
                var axis2 = chart.xAxes.push(new am4charts.ValueAxis());
                axis2.min = chartMin;
                axis2.max = chartMax;
                axis2.strictMinMax = true;
                axis2.renderer.labels.template.disabled = true;
                axis2.renderer.ticks.template.disabled = true;
                axis2.renderer.grid.template.disabled = false;
                axis2.renderer.grid.template.opacity = 0.5;
                axis2.renderer.labels.template.bent = true;
                axis2.renderer.labels.template.fill = am4core.color("#000");
                axis2.renderer.labels.template.fontWeight = "bold";
                axis2.renderer.labels.template.fillOpacity = 0.3;
                /**
                 Ranges
                 */
                for (let grading of data.gradingData) {
                    var range = axis2.axisRanges.create();
                    range.axisFill.fill = am4core.color(grading.color);
                    range.axisFill.fillOpacity = 0.8;
                    range.axisFill.zIndex = -1;
                    range.value = grading.lowScore > chartMin ? grading.lowScore : chartMin;
                    range.endValue = grading.highScore < chartMax ? grading.highScore : chartMax;
                    range.grid.strokeOpacity = 0;
                    range.stroke = am4core.color(grading.color).lighten(-0.1);
                    range.label.inside = true;
                    // range.label.text = grading.title.toUpperCase();
                    range.label.inside = true;
                    range.label.location = 0.5;
                    range.label.inside = true;
                    range.label.radius = am4core.percent(10);
                    range.label.paddingBottom = -5; // ~half font size
                    range.label.fontSize = "0.9em";
                }

                var matchingGrade = lookUpGrade(data.score, data.gradingData);

                /**
                 * Label 1
                 */

                var label = chart.radarContainer.createChild(am4core.Label);
                label.isMeasured = false;
                label.fontSize = "6em";
                label.x = am4core.percent(50);
                label.paddingBottom = 15;
                label.horizontalCenter = "middle";
                label.verticalCenter = "bottom";
//label.dataItem = data;
                label.text = data.score.toFixed(2);
//label.text = "{score}";
                label.fill = am4core.color(matchingGrade.color);

                /**
                 * Label 2
                 */

                var label2 = chart.radarContainer.createChild(am4core.Label);
                label2.isMeasured = false;
                label2.fontSize = "2em";
                label2.horizontalCenter = "middle";
                label2.verticalCenter = "bottom";
                // label2.text = matchingGrade.title.toUpperCase();
                label2.fill = am4core.color(matchingGrade.color);


                /**
                 * Hand
                 */

                var hand = chart.hands.push(new am4charts.ClockHand());
                hand.axis = axis2;
                hand.innerRadius = am4core.percent(55);
                hand.startWidth = 8;
                hand.pin.disabled = true;
                hand.value = data.score;
                hand.fill = am4core.color("#444");
                hand.stroke = am4core.color("#000");

                hand.events.on("positionchanged", function () {
                    label.text = axis2.positionToValue(hand.currentPosition).toFixed(1);
                    var value2 = axis.positionToValue(hand.currentPosition);
                    var matchingGrade = lookUpGrade(axis.positionToValue(hand.currentPosition), data.gradingData);
                    // label2.text = matchingGrade.title.toUpperCase();
                    label2.fill = am4core.color(matchingGrade.color);
                    label2.stroke = am4core.color(matchingGrade.color);
                    label.fill = am4core.color(matchingGrade.color);
                })

                // setInterval(function() {
                //     var value = chartMin + Math.random() * (chartMax - chartMin);
                //     hand.showValue(value, 1000, am4core.ease.cubicOut);
                // }, 2000);

            })
        })
    </script>
@endpush
