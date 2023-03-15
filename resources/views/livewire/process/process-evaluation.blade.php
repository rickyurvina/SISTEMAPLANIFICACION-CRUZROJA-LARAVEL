<div>
    <div class="row p-4">
        <div class="d-flex flex-wrap w-100">
            <div class="d-flex flex-column w-30">
                <x-label-section>{{ trans('general.performance') }} Eje Y</x-label-section>
                <div class="text-left">
                    <input type="text" wire:model="performance" readonly
                           class="form-control-sm form-control-plaintext">
                </div>
            </div>
            <div class="d-flex flex-column w-40">
                <x-label-section>{{ trans('general.importance') }} Eje X</x-label-section>
                <div class="text-left">
                    <input type="text" wire:model="importance" readonly
                           class="form-control-sm form-control-plaintext">
                </div>
            </div>
            <div class="d-flex ml-auto flex-column w-30">
                <x-label-section>{{ trans('general.evaluation_result') }}</x-label-section>
                <div class="text-left">
                    @if($color)
                        <span>
                            @if($color==\App\Models\Process\Process::COLOR_REENGINEERING)
                                <span class="font-weight-bold"
                                      style="color:{{\App\Models\Process\Process::COLOR_PROCESS_EVALUATION[$color][2]}} ">{{trans('general.COMATOUS_PROCESS')}}</span>
                            @endif
                                <div class="font-weight-bold"
                                     style="color:{{\App\Models\Process\Process::COLOR_PROCESS_EVALUATION[$color][2]}} "> {{trans(\App\Models\Process\Process::COLOR_PROCESS_EVALUATION[$color][0])}}</div>
                            {{trans(\App\Models\Process\Process::COLOR_PROCESS_EVALUATION[$color][1])}}
                        </span>
                    @else
                        -
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self>
        <div id="chartEvaluation" style="width: 100% !important; height: 400px !important;font-size: medium !important;">
        </div>
        <div class="card mt-2">
            <div class="table-responsive">
                <table class="table  m-0">
                    <thead class="bg-primary-50">
                    <tr>
                        <th class="text-center" colspan="3">Descripción de Escalas</th>
                    </tr>
                    <tr>
                        <th class="w-5 text-center">#</th>
                        <th class="text-center w-20">{{ trans('general.process_importance_scale') }}</th>

                        <th class="text-center w-auto">{{ trans('general.process_performance_scale') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($scalesX)
                        @for($i=0; $i<5;$i++)
                            <tr>
                                <td class="text-center">{{$i+1}}</td>
                                <td class="text-center">{{$scalesX[$i]}}</td>
                                <td class="text-center">{{$scalesY[$i]}}</td>
                            </tr>
                        @endfor
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@push('page_script')
    <script>
        am4core.ready(function () {

            // Apply chart themes
            am4core.useTheme(am4themes_animated);

            let chart = am4core.create("chartEvaluation", am4charts.XYChart);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            chart.maskBullets = true;

            let xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            let yAxis = chart.yAxes.push(new am4charts.CategoryAxis());

            xAxis.dataFields.category = "x";
            yAxis.dataFields.category = "y";

            xAxis.renderer.grid.template.disabled = true;
            xAxis.renderer.minGridDistance = 40;

            yAxis.renderer.grid.template.disabled = true;
            yAxis.renderer.inversed = true;
            yAxis.renderer.minGridDistance = 30;
            yAxis.renderer.labels.template.wrap = true;
            yAxis.renderer.labels.template.maxWidth = 180;


            let series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.categoryX = "x";
            series.dataFields.categoryY = "y";
            series.dataFields.value = "evaluation_result";
            series.sequencedInterpolation = true;
            series.defaultState.transitionDuration = 3000;

            let column = series.columns.template;
            column.strokeWidth = 2;
            column.strokeOpacity = 1;
            column.stroke = am4core.color("#FFFFFF");
            column.tooltipText = "Evaluación: {evaluation_result} \n Desempeño : {performance} \n Importancia: {importance}";
            series.tooltip.getFillFromObject = false;
            series.tooltip.background.fill = am4core.color("#FFFFFF");
            series.tooltip.label.fill = am4core.color("#000");
            column.width = am4core.percent(100);
            column.height = am4core.percent(100);
            column.column.cornerRadius(6, 6, 6, 6);
            column.propertyFields.fill = "color";

            // Set up bullet appearance
            var bullet1 = series.bullets.push(new am4charts.CircleBullet());
            bullet1.circle.propertyFields.radius = 'radius';
            bullet1.circle.fill = am4core.color("#000");
            bullet1.circle.strokeWidth = 0;
            bullet1.circle.fillOpacity = 0.7;
            bullet1.interactionsEnabled = false;
            series.columns.template.cursorOverStyle = am4core.MouseCursorStyle.pointer;

            series.columns.template.events.on("hit", function (ev) {
                let data = ev.target.column.dataItem.dataContext;
                window.livewire.emitTo('process.process-evaluation', 'updateStatus', {data: data});
            }, this);

            chart.data = @json($data);

        });
        window.addEventListener('updateChartDataEvaluation', event => {
            am4core.ready(function () {

                // Apply chart themes
                am4core.useTheme(am4themes_animated);

                let chart = am4core.create("chartEvaluation", am4charts.XYChart);
                chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

                chart.maskBullets = true;

                let xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                let yAxis = chart.yAxes.push(new am4charts.CategoryAxis());

                xAxis.dataFields.category = "x";
                yAxis.dataFields.category = "y";

                xAxis.renderer.grid.template.disabled = true;
                xAxis.renderer.minGridDistance = 40;

                yAxis.renderer.grid.template.disabled = true;
                yAxis.renderer.inversed = true;
                yAxis.renderer.minGridDistance = 30;
                yAxis.renderer.labels.template.wrap = true;
                yAxis.renderer.labels.template.maxWidth = 180;


                let series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.categoryX = "x";
                series.dataFields.categoryY = "y";
                series.dataFields.value = "evaluation_result";
                series.sequencedInterpolation = true;
                series.defaultState.transitionDuration = 3000;

                let column = series.columns.template;
                column.strokeWidth = 2;
                column.strokeOpacity = 1;
                column.stroke = am4core.color("#FFFFFF");
                column.tooltipText = "Evaluación: {evaluation_result} \n Desempeño : {performance} \n Importancia {importance}";
                series.tooltip.getFillFromObject = false;
                series.tooltip.background.fill = am4core.color("#FFFFFF");
                series.tooltip.label.fill = am4core.color("#000");
                column.width = am4core.percent(100);
                column.height = am4core.percent(100);
                column.column.cornerRadius(6, 6, 6, 6);
                column.propertyFields.fill = "color";

                // Set up bullet appearance
                var bullet1 = series.bullets.push(new am4charts.CircleBullet());
                bullet1.circle.propertyFields.radius = 'radius';
                bullet1.circle.fill = am4core.color("#000");
                bullet1.circle.strokeWidth = 0;
                bullet1.circle.fillOpacity = 0.7;
                bullet1.interactionsEnabled = false;
                series.columns.template.cursorOverStyle = am4core.MouseCursorStyle.pointer;

                series.columns.template.events.on("hit", function (ev) {
                    let data = ev.target.column.dataItem.dataContext;
                    window.livewire.emitTo('process.process-evaluation', 'updateStatus', {data: data});
                }, this);

                chart.data = event.detail.data;
                {{--                chart.data = @json($data);--}}

            });
        })
    </script>
@endpush