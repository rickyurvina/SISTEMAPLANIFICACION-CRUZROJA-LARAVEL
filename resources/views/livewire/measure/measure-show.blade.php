<div>
    <div
            x-data="{
                show: @entangle('show')
            }"
            x-init="$watch('show', value => {
            if (value) {
                $('#measure-show-modal').modal('show')
            } else {
                $('#measure-show-modal').modal('hide');
            }
        })"
            x-on:keydown.escape.window="show = false"
            x-on:close.stop="show = false"
    >

        <div wire:ignore.self class="modal fade" id="measure-show-modal" tabindex="-1" role="dialog" aria-hidden="true"
             data-backdrop="static" data-keyboard="false" style="min-height: 50vh !important; height: auto">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    @if($measure)
                        <div class="modal-header">
                            <h5 class="modal-title h4"><i class="fas fa-plus-circle text-success"></i> {{ trans('indicators.indicator.show_indicator')}}
                                Periodo: {{$period->start_date->format('F j, Y')}}</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                            </button>
                        </div>
                        <div class="flex-grow-1 w-100 p-3" style="overflow: hidden auto" x-data="{ tab: 'details' }" x-cloak="">
                            <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" :class="{ 'active': tab === 'details' }" x-on:click.prevent="tab = 'details'" href="#" role="tab">Detalles</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" :class="{ 'active': tab === 'indicator' }" x-on:click.prevent="tab = 'indicator'" href="#" role="tab">Reporte de
                                        Indicador</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane pt-2 fade" :class="{ 'active show': tab === 'details' }">
                                    <dl class="row">
                                        <dt class="col-sm-2"><h5><strong>{{ trans('general.name') }}</strong></h5></dt>
                                        <dd class="col-sm-4">
                                            {{ $measure->name }}
                                        </dd>
                                        @if($score)
                                            <dt class="col-sm-2"><h5><strong>{{ trans('general.score') }}</strong></h5></dt>
                                            <dd class="col-sm-4" style="color: {{ $measure->score($periodId)['dataUsed'][0]['color']}}">
                                                {{ $score['dataUsed'][0]['score']  }}
                                            </dd>
                                        @endif
                                        <dt class="col-sm-2"><h5><strong>{{ trans('general.code') }}</strong></h5></dt>
                                        <dd class="col-sm-4">
                                            {{ $measure->code }}
                                        </dd>
                                        <dt class="col-sm-2"><h5><strong>{{ trans('general.start_date') }}</strong></h5></dt>
                                        <dd class="col-sm-4">
                                            {{ $measure->calendar->periods->first()->start_date->format('F j, Y')}}
                                        </dd>

                                        <dt class="col-sm-2"><h5><strong>{{ trans('general.end_date') }}</strong></h5></dt>
                                        <dd class="col-sm-4">
                                            {{ $measure->calendar->periods->last()->end_date->format('F j, Y') }}
                                        </dd>

                                        <dt class="col-sm-2"><h5><strong>{{ trans('general.type') }}</strong></h5></dt>
                                        <dd class="col-sm-4">
                                            {{ $measure->type }}
                                        </dd>

                                        <dt class="col-sm-2"><h5><strong>{{ trans('indicators.indicator.results') }}</strong></h5></dt>
                                        <dd class="col-sm-4">
                                            {{ $measure->description }}
                                        </dd>
                                        <dt class="col-sm-2"><h5><strong>{{ trans('indicators.indicator.type_of_aggregation') }}</strong></h5></dt>
                                        <dd class="col-sm-4">
                                            {{ $measure->aggregation_type }}
                                        </dd>

                                        <dt class="col-sm-2"><h5><strong>{{ trans('indicators.indicator.unit_of_measurement') }}</strong></h5></dt>
                                        <dd class="col-sm-4">
                                            {{ $measure->unit->name }}
                                        </dd>

                                        <dt class="col-sm-2"><h5><strong>{{ trans('general.responsible') }}</strong></h5></dt>
                                        <dd class="col-sm-4">
                                            {{ $measure->responsible->name }}
                                        </dd>

                                        <dt class="col-sm-2"><h5><strong>{{trans('indicators.indicator.frequency_update') }}</strong></h5></dt>
                                        <dd class="col-sm-4">
                                            {{$measure->calendar->name}}
                                        </dd>

                                        <dt class="col-sm-2"><h5><strong>{{ trans('indicators.indicator.base_line') }}</strong></h5></dt>
                                        <dd class="col-sm-4">
                                            {{ $measure->base_line }}
                                        </dd>

                                        <dt class="col-sm-2"><h5><strong>{{ trans('indicators.indicator.baseline_year') }}</strong></h5></dt>
                                        <dd class="col-sm-4">
                                            {{ $measure->baseline_year }}
                                        </dd>

                                        <dt class="col-sm-2"><h5><strong>Pertenece a:</strong></h5></dt>
                                        <dd class="col-sm-4">
                                            {{ $measure->indicatorable->name }}
                                        </dd>
                                    </dl>
                                    <div id="score-historical" style="height: 300px;"></div>
                                </div>
                                <div class="tab-pane pt-2 fade" :class="{ 'active show': tab === 'indicator' }">
                                    <livewire:measure.report :periodId="$periodId" :model="$measure"/>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@push('page_script')
    <script>
        $('#measure-show-modal').on('show.bs.modal', function (e) {
            am4core.ready(function () {
                let chart_score_historical = am4core.create("score-historical", am4charts.XYChart);

                chart_score_historical.data = @json($scores);
                chart_score_historical.hideCredits = true;

                // Create axes
                let categoryAxis = chart_score_historical.xAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "period_id";
                categoryAxis.renderer.minGridDistance = 30;
                categoryAxis.renderer.grid.template.stroke = am4core.color("#aaaaac");
                categoryAxis.renderer.grid.template.strokeWidth = 1.5;
                categoryAxis.renderer.grid.template.strokeDasharray = "5,3"
                categoryAxis.renderer.grid.template.strokeOpacity = .1;
                categoryAxis.renderer.labels.template.adapter.add("html", function (html, target) {
                    if (target.dataItem && target.dataItem.dataContext) {
                        return `<span>` + target.dataItem.dataContext.frequency + `</span>` + `<br>` + target.dataItem.dataContext.year;
                    }
                });

                let valueAxis = chart_score_historical.yAxes.push(new am4charts.ValueAxis());
                valueAxis.renderer.minGridDistance = 30;
                valueAxis.renderer.grid.template.stroke = am4core.color("#aaaaac");
                valueAxis.renderer.grid.template.strokeWidth = 1.5;
                valueAxis.renderer.grid.template.strokeDasharray = "5,3";
                valueAxis.renderer.grid.template.strokeOpacity = .1;

                // Create series
                let series = chart_score_historical.series.push(new am4charts.LineSeries());
                series.dataFields.valueY = "value";
                series.dataFields.categoryX = "period_id";
                series.name = "Score";
                series.tooltipText = "{name}: [bold]{valueY}[/]";
                series.strokeWidth = 3;
                series.stroke = am4core.color("#d2d3d5");
                let circleBullet = series.bullets.push(new am4charts.CircleBullet());
                circleBullet.circle.fill = am4core.color("#fff");
                circleBullet.propertyFields.stroke = "color";
                circleBullet.circle.strokeWidth = 5;
                series.tooltip.pointerOrientation = "vertical";

                $("g[aria-labelledby]").hide();
            });
            window.addEventListener('updateData', event => {
                am4core.ready(function () {
                    let chart_score_historical = am4core.create("score-historical", am4charts.XYChart);

                    chart_score_historical.data = event.detail.historicalScore;
                    chart_score_historical.hideCredits = true;

                    // Create axes
                    let categoryAxis = chart_score_historical.xAxes.push(new am4charts.CategoryAxis());
                    categoryAxis.dataFields.category = "period_id";
                    categoryAxis.renderer.minGridDistance = 30;
                    categoryAxis.renderer.grid.template.stroke = am4core.color("#aaaaac");
                    categoryAxis.renderer.grid.template.strokeWidth = 1.5;
                    categoryAxis.renderer.grid.template.strokeDasharray = "5,3"
                    categoryAxis.renderer.grid.template.strokeOpacity = .1;
                    categoryAxis.renderer.labels.template.adapter.add("html", function (html, target) {
                        if (target.dataItem && target.dataItem.dataContext) {
                            return `<span>` + target.dataItem.dataContext.frequency + `</span>` + `<br>` + target.dataItem.dataContext.year;
                        }
                    });

                    let valueAxis = chart_score_historical.yAxes.push(new am4charts.ValueAxis());
                    valueAxis.renderer.minGridDistance = 30;
                    valueAxis.renderer.grid.template.stroke = am4core.color("#aaaaac");
                    valueAxis.renderer.grid.template.strokeWidth = 1.5;
                    valueAxis.renderer.grid.template.strokeDasharray = "5,3";
                    valueAxis.renderer.grid.template.strokeOpacity = .1;

                    // Create series
                    let series = chart_score_historical.series.push(new am4charts.LineSeries());
                    series.dataFields.valueY = "value";
                    series.dataFields.categoryX = "period_id";
                    series.name = "Score";
                    series.tooltipText = "{name}: [bold]{valueY}[/]";
                    series.strokeWidth = 3;
                    series.stroke = am4core.color("#d2d3d5");
                    let circleBullet = series.bullets.push(new am4charts.CircleBullet());
                    circleBullet.circle.fill = am4core.color("#fff");
                    circleBullet.propertyFields.stroke = "color";
                    circleBullet.circle.strokeWidth = 5;
                    series.tooltip.pointerOrientation = "vertical";

                    $("g[aria-labelledby]").hide();
                });
            });
        })
    </script>
@endpush