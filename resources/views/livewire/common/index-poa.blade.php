<div>
    <div class="panel-container show" style="margin-top: -2%;">
        <div class="panel-content">
            <div class="row" style="height: 3rem">
                <div class="frame-wrap">
                    <div class="demo demo-h-spacing">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info" style="background-color: #0046AD">  {{trans('common.filters')}} <i class="fal fa-filter"></i></button>
                            <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" style="background-color: #0046AD" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only"></span>
                            </button>

                            <div wire:ignore.self class="dropdown-menu dropdown-xl" id="dropdown-filter" style="width: 100rem !important;">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h3 class="dropdown-item">  {{trans('common.time')}}</h3>
                                        <div class="dropdown-divider"></div>
                                        <div class="dropdown-item">
                                            <div class="panel-container show">
                                                <div class="panel-content">
                                                    <div class="frame-wrap">
                                                        <div class="demo">
                                                            <ul class="donate-now">
                                                                <li>
                                                                    <input type="radio" id="a25" name="selectedPeriod" value="last-month" wire:model.defer="selectedPeriod"/>
                                                                    <label for="a25"> {{ strlen("Último mes")>14?substr("Último mes",0,15)."...": "Último mes"  }}</label>
                                                                </li>
                                                                @if(date("m")>=4)
                                                                    <li>
                                                                        <input type="radio" id="a50" name="selectedPeriod" value="quarterly" wire:model.defer="selectedPeriod"/>
                                                                        <label for="a50"> {{ strlen("Último trimestre")>14?substr("Último trimestre",0,15)."...": "Último trimestre"  }}</label>
                                                                    </li>
                                                                @endif
                                                                @if(date("m")>=7)
                                                                    <li>
                                                                        <input type="radio" id="a75" name="selectedPeriod" value="semester" wire:model.defer="selectedPeriod"/>
                                                                        <label for="a75"> {{ strlen("Último semestre")>14?substr("Último semestre",0,15)."...": "Último semestre"  }}</label>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="panel-content dropdown-item">
                                            <div class="form-group">
                                                <label class="form-label" for="single-default">
                                                    {{trans('common.list_of_months')}}
                                                </label>
                                                <select class="select2 form-control w-100" id="single-default" name="selectedMonth"
                                                        wire:model.defer="selectedMonth" {{$selectedPeriod!=null?'disabled':''}}>
                                                    <optgroup label="Meses">
                                                        @foreach($months as $index=> $month)
                                                        <option value="{{$index}}">{{$month}}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <h3 class="dropdown-item" href="javascript:void(0)">  {{trans('common.provinces')}}</h3>
                                        <div class="dropdown-divider"></div>
                                        @foreach($this->listOfProvinces as $province)
                                            <ul class="donate-now">
                                                <li>
                                                    <input type="radio" id="a25-{{$province['id']}}" name="selectedProvince" value="{{$province['id']}}"
                                                           wire:model.lazy="selectedProvince"/>
                                                    <label for="a25-{{$province['id']}}">{{ strlen($province['country'])>13?substr($province['country'],0,13)."...": $province['country']  }}</label>
                                                </li>
                                            </ul>
                                        @endforeach
                                    </div>

                                    <div class="col-md-3">
                                        <h3 class="dropdown-item" href="javascript:void(0)">  {{trans('common.cantones')}}</h3>
                                        <div class="dropdown-divider"></div>
                                        @if(!is_null($selectedProvince))
                                            @foreach($listOfCantones as $canton)
                                                <ul class="donate-now">
                                                    <li>
                                                        <input type="radio" id="a358-{{$canton->id}}" name="selectedCanton" value="{{$canton->id}}"
                                                               wire:model.defer="selectedCanton"/>
                                                        <label for="a358-{{$canton->id}}"> {{ strlen($canton->name)>13?substr($canton->name,0,13)."...": $canton->name  }}</label>
                                                    </li>
                                                </ul>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <h3 class="dropdown-item" href="javascript:void(0)">  {{trans('common.programs')}}</h3>
                                        <div class="dropdown-divider"></div>
                                        @foreach($programsGrouped as $program)
                                            <ul class="donate-now">
                                                <li>
                                                    <input type="radio" id="a3589-{{$program['id']}}" name="selectedProgram" value="{{$program['name']}}"
                                                           wire:model.defer="selectedProgram"/>
                                                    <label for="a3589-{{$program['id']}}">{{ strlen($program['name'])>13?substr($program['name'],0,13)."...": $program['name']  }}</label>
                                                </li>
                                            </ul>
                                        @endforeach
                                        <div class="dropdown-divider"></div>
                                        <div class="dropdown-item">
                                            <button type="button" class="btn btn-lg btn-block btn-outline-info waves-effect waves-themed" style="margin-top: 7%;"
                                                    wire:click="filter()"><span class="fal fa-filter mr-1"></span> {{trans('common.filter')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-left: 1%;">
                    <button type="button" class="btn btn-light" style="background-color: #D52B1E; color: white;"
                            onClick="window.location.reload();">  {{trans('common.clean_filters')}}</button>
                </div>
                @if(count($filtersSelected)>0)
                    @foreach($filtersSelected as $f)
                        <div class="demo-v-spacing" style="margin-left: 1%;">
                            <div class="alert alert-primary alert-dismissible fade show" role="alert"
                                 style="padding: 0.5rem 1.25rem !important;color: dimgray; background-color: #f3f1f5; border-color: #d6d3da;    padding-right: 3.7rem !important; ">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="padding: 0.5rem 1.25rem !important;"
                                        wire:click="cleanFilter('{{ $f['type'] }}')">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <strong>{{$f['name']}}</strong>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="d-flex overflow-auto">
                <ul class="nav nav-tabs-clean color-fusion-50 font-weight-bolder flex-nowrap">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#js_change_pill_justified-1">{{trans('common.poa')}}</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#js_change_pill_justified-2">  {{trans('common.missional')}}</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#js_change_pill_justified-3">{{trans('common.develop')}}</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active mt-1" id="js_change_pill_justified-1" role="tabpanel">
                    @include('common.home.poa')
                </div>
                <div class="tab-pane fade" id="js_change_pill_justified-2" role="tabpanel">
                    <div class="text-right w-100">
                        <a wire:click="exportPdf()" class="btn btn-outline-primary btn-xs shadow-0"><i class="fas fa-file-pdf"></i> Exportar</a>
                    </div>
                    @include('common.home.missional')
                </div>
                <div class="tab-pane fade" id="js_change_pill_justified-3" role="tabpanel">
                    @include('common.home.development')
                </div>
            </div>
        </div>
    </div>
</div>
<div wire:ignore>
    <livewire:common.show-filter-by-period/>
</div>

@push('page_script')
    <script src="https://cdn.amcharts.com/lib/4/themes/material.js"></script>
    <script>

        Livewire.on('toggleShowModal', () => $('#modalInfo').modal('toggle'));

        Livewire.on('toggleDropDownFilter', () => $("#dropdown-filter").removeClass("show"));
        am4core.ready(function () {
            am4core.useTheme(am4themes_animated);
            var chart = am4core.create("chartdivEjecucionPoa", am4charts.GaugeChart);
            chart.innerRadius = am4core.percent(82);

            var axis = chart.xAxes.push(new am4charts.ValueAxis());
            axis.min = 0;
            axis.max = 100;
            axis.strictMinMax = true;
            axis.renderer.radius = am4core.percent(80);
            axis.renderer.inside = true;
            axis.renderer.line.strokeOpacity = 1;
            axis.renderer.ticks.template.disabled = false
            axis.renderer.ticks.template.strokeOpacity = 1;
            axis.renderer.ticks.template.length = 10;
            axis.renderer.grid.template.disabled = true;
            axis.renderer.labels.template.radius = 40;
            axis.renderer.labels.template.adapter.add("text", function (text) {
                return text + "%";
            })

            var colorSet = new am4core.ColorSet();

            var axis2 = chart.xAxes.push(new am4charts.ValueAxis());
            axis2.min = 0;
            axis2.max = 100;
            axis2.strictMinMax = true;
            axis2.renderer.labels.template.disabled = true;
            axis2.renderer.ticks.template.disabled = true;
            axis2.renderer.grid.template.disabled = true;

            var range0 = axis2.axisRanges.create();
            range0.value = 0;
            range0.endValue = 40;
            range0.axisFill.fillOpacity = 1;
            range0.axisFill.fill = "#D52B1E";

            var range1 = axis2.axisRanges.create();
            range1.value = 40;
            range1.endValue = 100;
            range1.axisFill.fillOpacity = 1;
            range1.axisFill.fill = "#FFFFFF";

            var label = chart.radarContainer.createChild(am4core.Label);
            label.isMeasured = false;
            label.fontSize = 20;
            label.x = am4core.percent(80);
            label.y = am4core.percent(100);
            label.horizontalCenter = "middle";
            label.verticalCenter = "bottom";

            var hand = chart.hands.push(new am4charts.ClockHand());
            hand.axis = axis2;
            hand.innerRadius = am4core.percent(20);
            hand.startWidth = 10;
            hand.pin.disabled = true;
            hand.value = {{number_format($ejecuccionGeneral,2)}};

            hand.events.on("propertychanged", function (ev) {
                range0.endValue = ev.target.value;
                range1.value = ev.target.value;
                label.text = axis2.positionToValue(hand.currentPosition).toFixed(1) + "%";
                axis2.invalidate();
            });
        });//ejecuccion general
        am4core.ready(function () {

            am4core.useTheme(am4themes_animated);
            var chart = am4core.create("chartdivPorProvincias", am4charts.XYChart);
            chart.scrollbarX = new am4core.Scrollbar();
            chart.data =@json($listOfProvinces);

            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "country";
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.renderer.minGridDistance = 30;
            categoryAxis.renderer.labels.template.horizontalCenter = "right";
            categoryAxis.renderer.labels.template.verticalCenter = "middle";
            categoryAxis.renderer.labels.template.rotation = 315;
            categoryAxis.tooltip.disabled = true;
            categoryAxis.renderer.minHeight = 70;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.renderer.minWidth = 50;
            valueAxis.min = 0;
            valueAxis.max = 110;
            // Create series
            var series = chart.series.push(new am4charts.ColumnSeries());
            series.sequencedInterpolation = true;
            series.dataFields.valueY = "visits";
            series.dataFields.categoryX = "country";
            series.dataFields.categoryY = "id_country";
            series.tooltipText = "[{categoryX}: bold]{valueY}[/]" + "%";
            series.columns.template.strokeWidth = 0;
            series.tooltip.pointerOrientation = "vertical";
            series.columns.template.column.fillOpacity = 0.8;
            series.columns.template.maxWidth = 70;
            series.columns.template.events.on("hit", function (ev) {
                var name = ev.target.column.dataItem.categories.categoryY;
                window.livewire.emitTo('common.show-filter-by-period', 'openModal', {name: name});
            }, this);

            var title = chart.titles.create();
            title.text = "Ejecución por juntas provinciales";
            title.fontSize = 18;
            title.paddingBottom = -10;

            var labelBullet = series.bullets.push(new am4charts.LabelBullet());
            labelBullet.label.verticalCenter = "bottom";
            labelBullet.label.dy = -10;
            labelBullet.label.text = "{values.valueY.workingValue.formatNumber('#.0')}" + "%";

            // on hover, make corner radiuses bigger
            var hoverState = series.columns.template.column.states.create("hover");
            hoverState.properties.cornerRadiusTopLeft = 0;
            hoverState.properties.cornerRadiusTopRight = 0;
            hoverState.properties.fillOpacity = 1;

            series.columns.template.adapter.add("fill", function (fill, target) {
                return "#0046AD"
            });

            // Cursor
            chart.cursor = new am4charts.XYCursor();

        }); // chart div por provincias
        am4core.ready(function () {
            am4core.useTheme(am4themes_material);
            am4core.useTheme(am4themes_animated);

            var chart = am4core.create("chartPersonalAlcanzado", am4charts.XYChart);
            chart.hiddenState.properties.opacity = 1;

            chart.paddingRight = 40;
            chart.data = [{
                "name": "Total",
                "steps": {{$totalHombres+$totalMujeres}},
                "color": '#D52B1E',
                "href": "{{ asset_cdn("/img/man_women.png") }}"
            }, {
                "name": "Mujeres",
                "steps": {{$totalMujeres??0}},
                "color": '#0046AD',
                "href": "{{ asset_cdn("/img/women.png") }}"
            }, {
                "name": "Hombres",
                "steps": {{$totalHombres??0}},
                "color": "#0046AD",
                "href": "{{ asset_cdn("/img/men.png") }}"
            }];


            var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "name";
            categoryAxis.renderer.grid.template.strokeOpacity = 0;
            categoryAxis.renderer.minGridDistance = 5;
            categoryAxis.renderer.labels.template.dx = -30;
            categoryAxis.renderer.minWidth = 80;
            categoryAxis.renderer.tooltip.dx = -30;

            var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
            valueAxis.renderer.inside = true;
            valueAxis.renderer.labels.template.fillOpacity = 0.9;
            valueAxis.renderer.grid.template.strokeOpacity = 0.2;
            valueAxis.min = 0;
            valueAxis.max = 100;
            valueAxis.cursorTooltipEnabled = false;
            valueAxis.renderer.baseGrid.strokeOpacity = 0;
            valueAxis.renderer.labels.template.dy = 20;

            function createGrid(value) {
                var range = valueAxis.axisRanges.create();
                range.value = value;
                range.label.text = "{value}";
            }

            createGrid(0);
            createGrid(25);
            createGrid(50);
            createGrid(75);
            createGrid(100);

            var series = chart.series.push(new am4charts.ColumnSeries);
            series.dataFields.valueX = "steps";
            series.dataFields.categoryY = "name";
            series.tooltipText = "{valueX.value}" + "%";
            series.tooltip.pointerOrientation = "vertical";
            series.columns.template.propertyFields.fill = "color";
            series.tooltip.dy = -30;
            series.columnsContainer.zIndex = 100;

            var labelBullet = series.bullets.push(new am4charts.LabelBullet());
            labelBullet.label.horizontalCenter = "end";
            labelBullet.label.dx = 30;
            labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.0as')}" + "%";

            var columnTemplate = series.columns.template;
            columnTemplate.height = am4core.percent(50);
            columnTemplate.maxHeight = 35;
            columnTemplate.column.cornerRadius(60, 60, 60, 60);
            columnTemplate.strokeOpacity = 0;

            series.heatRules.push({target: columnTemplate, property: "fill", dataField: "valueX", min: am4core.color("#e5dc36"), max: am4core.color("#5faa46")});
            series.mainContainer.mask = undefined;

            var cursor = new am4charts.XYCursor();
            chart.cursor = cursor;
            cursor.lineX.disabled = true;
            cursor.lineY.disabled = true;
            cursor.behavior = "none";

            var bullet = columnTemplate.createChild(am4charts.CircleBullet);
            bullet.circle.radius = 15;
            bullet.valign = "middle";
            bullet.align = "left";
            bullet.isMeasured = true;
            bullet.interactionsEnabled = false;
            bullet.horizontalCenter = "right";
            bullet.interactionsEnabled = false;

            var hoverState = bullet.states.create("hover");
            var outlineCircle = bullet.createChild(am4core.Circle);
            outlineCircle.adapter.add("radius", function (radius, target) {
                var circleBullet = target.parent;
                return circleBullet.circle.pixelRadius + 10;
            })

            var image = bullet.createChild(am4core.Image);
            image.width = 30;
            image.height = 30;
            image.horizontalCenter = "middle";
            image.verticalCenter = "middle";
            image.propertyFields.href = "href";

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
                        hs.properties.dx = dataItem.column.pixelWidth;
                        bullet.isHover = true;

                        previousBullet = bullet;
                    }
                }
            })
        });//personas alcanzadas
        am4core.ready(function () {
            am4core.useTheme(am4themes_material);
            am4core.useTheme(am4themes_animated);

            var chart = am4core.create("chartPersonalCapacitado", am4charts.XYChart);
            chart.hiddenState.properties.opacity = 1;

            chart.paddingRight = 40;

            chart.data = [{
                "name": "Total",
                "steps": {{$totalHombresCapacitados+$totalMujeresCapacitados}},
                "color": '#D52B1E',
                "href": "{{ asset_cdn("/img/man_women.png") }}"
            }, {
                "name": "Mujeres",
                "steps": {{$totalMujeresCapacitados}},
                "color": '#0046AD',
                "href": "{{ asset_cdn("/img/women.png") }}"
            }, {
                "name": "Hombres",
                "steps": {{$totalHombresCapacitados}},
                "color": "#0046AD",
                "href": "{{ asset_cdn("/img/men.png") }}"
            }];

            var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "name";
            categoryAxis.renderer.grid.template.strokeOpacity = 0;
            categoryAxis.renderer.minGridDistance = 3;
            categoryAxis.renderer.labels.template.dx = -30;
            categoryAxis.renderer.minWidth = 80;
            categoryAxis.renderer.tooltip.dx = -30;

            var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
            valueAxis.renderer.inside = true;
            valueAxis.renderer.labels.template.fillOpacity = 0.9;
            valueAxis.renderer.grid.template.strokeOpacity = 0.2;
            valueAxis.min = 0;
            valueAxis.max = 100;
            valueAxis.cursorTooltipEnabled = false;
            valueAxis.renderer.baseGrid.strokeOpacity = 0;
            valueAxis.renderer.labels.template.dy = 20;

            function createGrid(value) {
                var range = valueAxis.axisRanges.create();
                range.value = value;
                range.label.text = "{value}";
            }

            createGrid(0);
            createGrid(25);
            createGrid(50);
            createGrid(75);
            createGrid(100);

            var series = chart.series.push(new am4charts.ColumnSeries);
            series.dataFields.valueX = "steps";
            series.dataFields.categoryY = "name";
            series.tooltipText = "{valueX.value}";
            series.tooltip.pointerOrientation = "vertical";
            series.columns.template.propertyFields.fill = "color";
            series.tooltip.dy = -30;
            series.columnsContainer.zIndex = 100;

            var labelBullet = series.bullets.push(new am4charts.LabelBullet());
            labelBullet.label.horizontalCenter = "end";
            labelBullet.label.dx = 30;
            labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.0as')}" + "%";

            var columnTemplate = series.columns.template;
            columnTemplate.height = am4core.percent(50);
            columnTemplate.maxHeight = 35;
            columnTemplate.column.cornerRadius(60, 60, 60, 60);
            columnTemplate.strokeOpacity = 0;

            series.heatRules.push({target: columnTemplate, property: "fill", dataField: "valueX", min: am4core.color("#e5dc36"), max: am4core.color("#5faa46")});
            series.mainContainer.mask = undefined;

            var cursor = new am4charts.XYCursor();
            chart.cursor = cursor;
            cursor.lineX.disabled = true;
            cursor.lineY.disabled = true;
            cursor.behavior = "none";

            var bullet = columnTemplate.createChild(am4charts.CircleBullet);
            bullet.circle.radius = 15;
            bullet.valign = "middle";
            bullet.align = "left";
            bullet.isMeasured = true;
            bullet.interactionsEnabled = false;
            bullet.horizontalCenter = "right";
            bullet.interactionsEnabled = false;

            var hoverState = bullet.states.create("hover");
            var outlineCircle = bullet.createChild(am4core.Circle);
            outlineCircle.adapter.add("radius", function (radius, target) {
                var circleBullet = target.parent;
                return circleBullet.circle.pixelRadius + 10;
            })

            var image = bullet.createChild(am4core.Image);
            image.width = 30;
            image.height = 30;
            image.horizontalCenter = "middle";
            image.verticalCenter = "middle";
            image.propertyFields.href = "href";

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
                        hs.properties.dx = dataItem.column.pixelWidth;
                        bullet.isHover = true;

                        previousBullet = bullet;
                    }
                }
            })
        });//personas capacitadas
        am4core.ready(function () {

            am4core.useTheme(am4themes_animated);
            var chart = am4core.create("chartPersonalAlcanzadoPrograma", am4charts.XYChart);
            chart.padding(5, 5, 5, 5);

            var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.dataFields.category = "name";
            categoryAxis.renderer.minGridDistance = 1;
            categoryAxis.renderer.inversed = true;
            categoryAxis.renderer.grid.template.disabled = true;

            var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
            valueAxis.min = 0;

            function createGrid(value) {
                var range = valueAxis.axisRanges.create();
                range.value = value;
                range.label.text = "{value}";
            }

            createGrid(0);
            createGrid(25);
            createGrid(50);
            createGrid(75);
            createGrid(100);

            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.categoryY = "name";
            series.dataFields.valueX = "progress";
            series.dataFields.categoryX = "id";
            series.tooltipText = "{valueX.value}"
            series.columns.template.strokeOpacity = 0;
            series.columns.template.column.cornerRadiusBottomRight = 5;
            series.columns.template.column.cornerRadiusTopRight = 5;
            series.columns.template.propertyFields.fill = "color";
            series.columns.template.propertyFields.stroke = "color";
            series.columns.template.maxHeight = 40;
            series.columns.template.events.on("hit", function (ev) {
                var name = ev.target.column.dataItem.categories.categoryX;
                window.livewire.emitTo('common.show-filter-by-period', 'openModalPeopleReached', {name: name});
            }, this);

            var labelBullet = series.bullets.push(new am4charts.LabelBullet())
            labelBullet.label.horizontalCenter = "left";
            labelBullet.label.dx = 10;
            labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.0as')}" + "%";
            labelBullet.locationX = 1;
            labelBullet.label.fill = am4core.color("#eee");
            categoryAxis.sortBySeries = series;
            chart.data =@json($groups);
        });//personas alcanzadas por programa
        am4core.ready(function () {

            am4core.useTheme(am4themes_animated);
            var chart = am4core.create("chartPersonalHumanitarioCapacitado", am4charts.XYChart);
            chart.padding(5, 5, 5, 5);

            var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.dataFields.category = "name";
            categoryAxis.renderer.minGridDistance = 1;
            categoryAxis.renderer.inversed = true;
            categoryAxis.renderer.grid.template.disabled = true;

            var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
            valueAxis.min = 0;

            function createGrid(value) {
                var range = valueAxis.axisRanges.create();
                range.value = value;
                range.label.text = "{value}";
            }

            createGrid(0);
            createGrid(25);
            createGrid(50);
            createGrid(75);
            createGrid(100);

            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.categoryY = "name";
            series.dataFields.categoryX = "id";
            series.dataFields.valueX = "progress";
            series.tooltipText = "{valueX.value}"
            series.columns.template.strokeOpacity = 0;
            series.columns.template.column.cornerRadiusBottomRight = 5;
            series.columns.template.column.cornerRadiusTopRight = 5;
            series.columns.template.propertyFields.fill = "color";
            series.columns.template.propertyFields.stroke = "color";
            series.columns.template.maxHeight = 40;
            series.columns.template.events.on("hit", function (ev) {
                var name = ev.target.column.dataItem.categories.categoryX;
                window.livewire.emitTo('common.show-filter-by-period', 'openModalPeopleCapacitado', {name: name});
            }, this);

            var labelBullet = series.bullets.push(new am4charts.LabelBullet())
            labelBullet.label.horizontalCenter = "left";
            labelBullet.label.dx = 10;
            labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.0as')}" + "%";
            labelBullet.locationX = 1;
            labelBullet.label.fill = am4core.color("#eee");

            categoryAxis.sortBySeries = series;
            chart.data =@json($groups2);

        });//personas capacitadas por porgrama
        am4core.ready(function () {

            am4core.useTheme(am4themes_animated);
            var chart = am4core.create("chartCalificacionServicio", am4charts.XYChart);
            chart.padding(5, 5, 5, 5);

            var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.dataFields.category = "name";
            categoryAxis.renderer.minGridDistance = 1;
            categoryAxis.renderer.inversed = true;
            categoryAxis.renderer.grid.template.disabled = true;

            var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
            valueAxis.min = 0;

            function createGrid(value) {
                var range = valueAxis.axisRanges.create();
                range.value = value;
                range.label.text = "{value}";
            }

            createGrid(0);
            createGrid(25);
            createGrid(50);
            createGrid(75);
            createGrid(100);

            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.categoryY = "name";
            series.dataFields.categoryX = "id";
            series.dataFields.valueX = "progress";
            series.tooltipText = "{valueX.value}"
            series.columns.template.strokeOpacity = 0;
            series.columns.template.column.cornerRadiusBottomRight = 5;
            series.columns.template.column.cornerRadiusTopRight = 5;
            series.columns.template.propertyFields.fill = "color";
            series.columns.template.propertyFields.stroke = "color";
            series.columns.template.maxHeight = 40;
            series.columns.template.events.on("hit", function (ev) {
                var name = ev.target.column.dataItem.categories.categoryX;
                window.livewire.emitTo('common.show-filter-by-period', 'openModalService', {name: name});
            }, this);
            var labelBullet = series.bullets.push(new am4charts.LabelBullet())
            labelBullet.label.horizontalCenter = "left";
            labelBullet.label.dx = 10;
            labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.0as')}" + "%";
            labelBullet.locationX = 1;
            labelBullet.label.fill = am4core.color("#eee");
            categoryAxis.sortBySeries = series;
            chart.data =@json($groups3);

        });//calificacion servicio
        am4core.ready(function () {

            am4core.useTheme(am4themes_animated);
            var chart = am4core.create("chartProductosArea", am4charts.XYChart);
            chart.padding(40, 40, 40, 40);

            var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.dataFields.category = "name";
            categoryAxis.renderer.minGridDistance = 1;
            categoryAxis.renderer.inversed = true;
            categoryAxis.renderer.grid.template.disabled = true;

            var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
            valueAxis.min = 0;
            valueAxis.max = 100;

            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.categoryY = "name";
            series.dataFields.categoryX = "id";
            series.dataFields.valueX = "progress";
            series.tooltipText = "{valueX.value}"
            series.columns.template.strokeOpacity = 0;
            series.columns.template.propertyFields.fill = "color";
            series.columns.template.maxHeight = 40;
            series.columns.template.events.on("hit", function (ev) {
                var name = ev.target.column.dataItem.categories.categoryX;
                window.livewire.emitTo('common.show-filter-by-period', 'openModalDoc', {name: name});
            }, this);

            var title = chart.titles.create();
            title.text = "Productos por área";
            title.fontSize = 18;
            title.paddingBottom = 10;

            var labelBullet = series.bullets.push(new am4charts.LabelBullet())
            labelBullet.label.horizontalCenter = "left";
            labelBullet.label.dx = 10;
            labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.0as')}%";
            labelBullet.locationX = 1;
            labelBullet.label.fill = am4core.color("#eee");
            categoryAxis.sortBySeries = series;
            chart.data =@json($groups4)

        });//productos por area

        window.addEventListener('updateChartData-', event => {
            am4core.ready(function () {
                am4core.useTheme(am4themes_animated);
                var chart = am4core.create("chartdivEjecucionPoa", am4charts.GaugeChart);
                chart.innerRadius = am4core.percent(82);
                var axis = chart.xAxes.push(new am4charts.ValueAxis());
                axis.min = 0;
                axis.max = 100;
                axis.strictMinMax = true;
                axis.renderer.radius = am4core.percent(80);
                axis.renderer.inside = true;
                axis.renderer.line.strokeOpacity = 1;
                axis.renderer.ticks.template.disabled = false
                axis.renderer.ticks.template.strokeOpacity = 1;
                axis.renderer.ticks.template.length = 10;
                axis.renderer.grid.template.disabled = true;
                axis.renderer.labels.template.radius = 40;
                axis.renderer.labels.template.adapter.add("text", function (text) {
                    return text + "%";
                })

                var colorSet = new am4core.ColorSet();

                var axis2 = chart.xAxes.push(new am4charts.ValueAxis());
                axis2.min = 0;
                axis2.max = 100;
                axis2.strictMinMax = true;
                axis2.renderer.labels.template.disabled = true;
                axis2.renderer.ticks.template.disabled = true;
                axis2.renderer.grid.template.disabled = true;

                var range0 = axis2.axisRanges.create();
                range0.value = 0;
                range0.endValue = 40;
                range0.axisFill.fillOpacity = 1;
                range0.axisFill.fill = "#D52B1E";

                var range1 = axis2.axisRanges.create();
                range1.value = 40;
                range1.endValue = 100;
                range1.axisFill.fillOpacity = 1;
                range1.axisFill.fill = "#FFFFFF";


                var label = chart.radarContainer.createChild(am4core.Label);
                label.isMeasured = false;
                label.fontSize = 20;
                label.x = am4core.percent(80);
                label.y = am4core.percent(100);
                label.horizontalCenter = "middle";
                label.verticalCenter = "bottom";
                label.text = "20%";

                var hand = chart.hands.push(new am4charts.ClockHand());
                hand.axis = axis2;
                hand.innerRadius = am4core.percent(20);
                hand.startWidth = 10;
                hand.pin.disabled = true;
                hand.value = event.detail.ejecucionGeneral;


                hand.events.on("propertychanged", function (ev) {
                    range0.endValue = ev.target.value;
                    range1.value = ev.target.value;
                    label.text = axis2.positionToValue(hand.currentPosition).toFixed(1) + "%";
                    axis2.invalidate();
                });
            });//ejecuccion general
            am4core.ready(function () {

                am4core.useTheme(am4themes_material);
                am4core.useTheme(am4themes_animated);
                var chart = am4core.create("chartdivPorProvincias", am4charts.XYChart);
                chart.scrollbarX = new am4core.Scrollbar();
                chart.data = event.detail.listOfProvinces;

                var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "country";
                categoryAxis.renderer.grid.template.location = 0;
                categoryAxis.renderer.minGridDistance = 30;
                categoryAxis.renderer.labels.template.horizontalCenter = "right";
                categoryAxis.renderer.labels.template.verticalCenter = "middle";
                categoryAxis.renderer.labels.template.rotation = 315;
                categoryAxis.tooltip.disabled = true;
                categoryAxis.renderer.minHeight = 110;

                var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis.renderer.minWidth = 50;

// Create series
                var series = chart.series.push(new am4charts.ColumnSeries());
                series.sequencedInterpolation = true;
                series.dataFields.valueY = "visits";
                series.dataFields.categoryX = "country";
                series.dataFields.categoryY = "id_country";
                series.tooltipText = "[{categoryX}: bold]{valueY}[/]" + "%";
                series.columns.template.strokeWidth = 0;
                series.tooltip.pointerOrientation = "vertical";
                series.columns.template.column.fillOpacity = 0.8;
                series.columns.template.maxWidth = 70;

                series.columns.template.events.on("hit", function (ev) {
                    var name = ev.target.column.dataItem.categories.categoryY;
                    window.livewire.emitTo('common.show-filter-by-period', 'openModal', {name: name});
                }, this);

                var title = chart.titles.create();
                title.text = "Ejecucción por juntas provinciales";
                title.fontSize = 18;
                title.paddingBottom = -10;

                var labelBullet = series.bullets.push(new am4charts.LabelBullet());
                labelBullet.label.verticalCenter = "bottom";
                labelBullet.label.dy = -10;
                labelBullet.label.text = "{values.valueY.workingValue.formatNumber('#.0')}" + "%";

// on hover, make corner radiuses bigger
                var hoverState = series.columns.template.column.states.create("hover");
                hoverState.properties.cornerRadiusTopLeft = 0;
                hoverState.properties.cornerRadiusTopRight = 0;
                hoverState.properties.fillOpacity = 1;

                series.columns.template.adapter.add("fill", function (fill, target) {
                    return "#0046AD"
                });

// Cursor
                chart.cursor = new am4charts.XYCursor();

            }); // chart div por provincias
            am4core.ready(function () {

                am4core.useTheme(am4themes_animated);
                var test = event.detail.test;
                var selectedProvince = event.detail.selectedProvince;
                if (!test && selectedProvince != null) {
                    var chart = am4core.create("chartdivPorJuntas", am4charts.XYChart);
                    chart.data = event.detail.ejecutadoJuntasArr;
                    // Create axes
                    var yAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                    yAxis.dataFields.category = "canton";
                    yAxis.renderer.grid.template.location = 0;
                    yAxis.renderer.labels.template.fontSize = 10;
                    yAxis.renderer.minGridDistance = 10;
                    yAxis.renderer.cellStartLocation = 0.1;
                    yAxis.renderer.cellEndLocation = 0.8;


                    var title = chart.titles.create();
                    title.text = "Ejecucción por juntas cantonales";
                    title.fontSize = 18;
                    title.paddingBottom = 10;

                    var xAxis = chart.xAxes.push(new am4charts.ValueAxis());
                    xAxis.max = 100;
                    xAxis.min = 0;

                    var series = chart.series.push(new am4charts.ColumnSeries());
                    series.dataFields.valueX = "percentage";
                    series.dataFields.categoryY = "canton";
                    series.columns.template.tooltipText = "{categoryY}: [bold]{valueX}[/]" + "%";
                    series.columns.template.strokeWidth = 0;
                    series.columns.template.maxHeight = 70;

                    let listOfProvinces = [];
                    listOfProvinces = event.detail.listOfProvinces;
                    listOfProvinces.forEach(function (element) {

                    })

                    if (test) {
                        series.columns.template.adapter.add("fill", function (fill, target) {
                            if (target.dataItem) {
                                switch (target.dataItem.dataContext.province) {
                                    @foreach($listOfProvinces as $index => $p)
                                    case "{{$p['country']}}":
                                        return "{{$p['color']}}";
                                        break;
                                        @endforeach
                                }
                            }
                            return fill;
                        });
                    } else {
                        series.columns.template.adapter.add("fill", function (fill, target) {
                            if (target.dataItem) {
                                return "#D52B1E";
                            }
                            return fill;
                        });
                    }

                    var axisBreaks = {};
                    var legendData = [];

                    var labelBullet = series.bullets.push(new am4charts.LabelBullet())
                    labelBullet.label.horizontalCenter = "end";
                    labelBullet.label.dx = 10;
                    labelBullet.label.fontSize = 15
                    labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.0as')}" + "%";
                    labelBullet.locationX = 1;
                    labelBullet.label.fill = am4core.color("#eee");

// Add ranges
                    function addRange(label, start, end, color) {
                        var range = yAxis.axisRanges.create();
                        range.category = start;
                        range.endCategory = end;
                        range.label.text = label;
                        range.label.disabled = false;
                        range.label.fill = color;
                        range.label.location = 0;
                        range.label.dx = -130;
                        range.label.dy = 12;
                        range.label.fontWeight = "bold";
                        range.label.fontSize = 12;
                        range.label.horizontalCenter = "left"
                        range.label.inside = false;

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


                    if (test) {
                        @foreach($listOfProvinces as $index => $p)

                        addRange("{{$p['country']}}", "{{$p['menor']??""}}", "{{$p['mayor']}}", "{{$p['color']}}");
                        @endforeach
                    }


                    chart.cursor = new am4charts.XYCursor();
                    var legend = new am4charts.Legend();
                    legend.position = "right";
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
                                if (dataItem.dataContext.province == name) {
                                    dataItem.hide(1000, 500);
                                }
                            })
                            series.dataItems.each(function (dataItem) {
                                if (dataItem.dataContext.province == name) {
                                    dataItem.hide(1000, 0, 0, ["valueX"]);
                                }
                            })
                        } else {
                            axisBreak.animate({property: "breakSize", to: 1}, 1000, am4core.ease.cubicOut);
                            yAxis.dataItems.each(function (dataItem) {
                                if (dataItem.dataContext.province == name) {
                                    dataItem.show(1000);
                                }
                            })

                            series.dataItems.each(function (dataItem) {
                                if (dataItem.dataContext.province == name) {
                                    dataItem.show(1000, 0, ["valueX"]);
                                }
                            })
                        }
                    })
                }

            });//div por juntas
            am4core.ready(function () {
                am4core.useTheme(am4themes_material);
                am4core.useTheme(am4themes_animated);

                var chart = am4core.create("chartPersonalAlcanzado", am4charts.XYChart);
                chart.hiddenState.properties.opacity = 1;
                chart.paddingRight = 40;
                let hombres_ = event.detail.totalHombres;
                let mujeres_ = event.detail.totalMujeres;
                let total_ = parseFloat(hombres_) + parseFloat(mujeres_);
                chart.data = [{
                    "name": "Total",
                    "steps": parseFloat(total_),
                    "color": '#D52B1E',
                    "href": "{{ asset_cdn("/img/man_women.png") }}"
                }, {
                    "name": "Mujeres",
                    "steps": parseFloat(mujeres_),
                    "color": '#0046AD',
                    "href": "{{ asset_cdn("/img/women.png") }}"
                }, {
                    "name": "Hombres",
                    "steps": parseFloat(hombres_),
                    "color": "#0046AD",
                    "href": "{{ asset_cdn("/img/men.png") }}"
                }];
                var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "name";
                categoryAxis.renderer.grid.template.strokeOpacity = 0;
                categoryAxis.renderer.minGridDistance = 5;
                categoryAxis.renderer.labels.template.dx = -30;
                categoryAxis.renderer.minWidth = 80;
                categoryAxis.renderer.tooltip.dx = -30;

                var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
                valueAxis.renderer.inside = true;
                valueAxis.renderer.labels.template.fillOpacity = 0.9;
                valueAxis.renderer.grid.template.strokeOpacity = 0.2;
                valueAxis.min = 0;
                valueAxis.max = 100;
                valueAxis.cursorTooltipEnabled = false;
                valueAxis.renderer.baseGrid.strokeOpacity = 0;
                valueAxis.renderer.labels.template.dy = 20;

                function createGrid(value) {
                    var range = valueAxis.axisRanges.create();
                    range.value = value;
                    range.label.text = "{value}";
                }

                createGrid(0);
                createGrid(25);
                createGrid(50);
                createGrid(75);
                createGrid(100);

                var series = chart.series.push(new am4charts.ColumnSeries);
                series.dataFields.valueX = "steps";
                series.dataFields.categoryY = "name";
                series.tooltipText = "{valueX.value}" + "%";
                series.tooltip.pointerOrientation = "vertical";
                series.columns.template.propertyFields.fill = "color";
                series.tooltip.dy = -30;
                series.columnsContainer.zIndex = 100;

                var labelBullet = series.bullets.push(new am4charts.LabelBullet());
                labelBullet.label.horizontalCenter = "end";
                labelBullet.label.dx = 30;
                labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.0as')}" + "%";

                var columnTemplate = series.columns.template;
                columnTemplate.height = am4core.percent(50);
                columnTemplate.maxHeight = 35;
                columnTemplate.column.cornerRadius(60, 60, 60, 60);
                columnTemplate.strokeOpacity = 0;

                series.heatRules.push({target: columnTemplate, property: "fill", dataField: "valueX", min: am4core.color("#e5dc36"), max: am4core.color("#5faa46")});
                series.mainContainer.mask = undefined;

                var cursor = new am4charts.XYCursor();
                chart.cursor = cursor;
                cursor.lineX.disabled = true;
                cursor.lineY.disabled = true;
                cursor.behavior = "none";

                var bullet = columnTemplate.createChild(am4charts.CircleBullet);
                bullet.circle.radius = 15;
                bullet.valign = "middle";
                bullet.align = "left";
                bullet.isMeasured = true;
                bullet.interactionsEnabled = false;
                bullet.horizontalCenter = "right";
                bullet.interactionsEnabled = false;

                var hoverState = bullet.states.create("hover");
                var outlineCircle = bullet.createChild(am4core.Circle);
                outlineCircle.adapter.add("radius", function (radius, target) {
                    var circleBullet = target.parent;
                    return circleBullet.circle.pixelRadius + 10;
                })

                var image = bullet.createChild(am4core.Image);
                image.width = 30;
                image.height = 30;
                image.horizontalCenter = "middle";
                image.verticalCenter = "middle";
                image.propertyFields.href = "href";

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
                            hs.properties.dx = dataItem.column.pixelWidth;
                            bullet.isHover = true;

                            previousBullet = bullet;
                        }
                    }
                })
            });//personas alcanzadas
            am4core.ready(function () {
                am4core.useTheme(am4themes_material);
                am4core.useTheme(am4themes_animated);

                var chart = am4core.create("chartPersonalCapacitado", am4charts.XYChart);
                chart.hiddenState.properties.opacity = 1;
                chart.paddingRight = 40;
                let hombres = event.detail.totalHombresCapacitados;
                let mujeres = event.detail.totalMujeresCapacitados;
                let total = parseFloat(hombres) + parseFloat(mujeres);

                chart.data = [{
                    "name": "Total",
                    "steps": parseFloat(total),
                    "color": '#D52B1E',
                    "href": "{{ asset_cdn("/img/man_women.png") }}"
                }, {
                    "name": "Mujeres",
                    "steps": parseFloat(mujeres),
                    "color": '#0046AD',
                    "href": "{{ asset_cdn("/img/women.png") }}"
                }, {
                    "name": "Hombres",
                    "steps": parseFloat(hombres),
                    "color": "#0046AD",
                    "href": "{{ asset_cdn("/img/men.png") }}"
                }];

                var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "name";
                categoryAxis.renderer.grid.template.strokeOpacity = 0;
                categoryAxis.renderer.minGridDistance = 3;
                categoryAxis.renderer.labels.template.dx = -30;
                categoryAxis.renderer.minWidth = 80;
                categoryAxis.renderer.tooltip.dx = -30;

                var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
                valueAxis.renderer.inside = true;
                valueAxis.renderer.labels.template.fillOpacity = 0.9;
                valueAxis.renderer.grid.template.strokeOpacity = 0.2;
                valueAxis.min = 0;
                valueAxis.max = 100;
                valueAxis.cursorTooltipEnabled = false;
                valueAxis.renderer.baseGrid.strokeOpacity = 0;
                valueAxis.renderer.labels.template.dy = 20;

                function createGrid(value) {
                    var range = valueAxis.axisRanges.create();
                    range.value = value;
                    range.label.text = "{value}";
                }

                createGrid(0);
                createGrid(25);
                createGrid(50);
                createGrid(75);
                createGrid(100);

                var series = chart.series.push(new am4charts.ColumnSeries);
                series.dataFields.valueX = "steps";
                series.dataFields.categoryY = "name";
                series.tooltipText = "{valueX.value}";
                series.tooltip.pointerOrientation = "vertical";
                series.columns.template.propertyFields.fill = "color";
                series.tooltip.dy = -30;
                series.columnsContainer.zIndex = 100;

                var labelBullet = series.bullets.push(new am4charts.LabelBullet());
                labelBullet.label.horizontalCenter = "end";
                labelBullet.label.dx = 30;
                labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.0as')}" + "%";

                var columnTemplate = series.columns.template;
                columnTemplate.height = am4core.percent(50);
                columnTemplate.maxHeight = 35;
                columnTemplate.column.cornerRadius(60, 60, 60, 60);
                columnTemplate.strokeOpacity = 0;

                series.heatRules.push({target: columnTemplate, property: "fill", dataField: "valueX", min: am4core.color("#e5dc36"), max: am4core.color("#5faa46")});
                series.mainContainer.mask = undefined;

                var cursor = new am4charts.XYCursor();
                chart.cursor = cursor;
                cursor.lineX.disabled = true;
                cursor.lineY.disabled = true;
                cursor.behavior = "none";

                var bullet = columnTemplate.createChild(am4charts.CircleBullet);
                bullet.circle.radius = 15;
                bullet.valign = "middle";
                bullet.align = "left";
                bullet.isMeasured = true;
                bullet.interactionsEnabled = false;
                bullet.horizontalCenter = "right";
                bullet.interactionsEnabled = false;

                var hoverState = bullet.states.create("hover");
                var outlineCircle = bullet.createChild(am4core.Circle);
                outlineCircle.adapter.add("radius", function (radius, target) {
                    var circleBullet = target.parent;
                    return circleBullet.circle.pixelRadius + 10;
                })

                var image = bullet.createChild(am4core.Image);
                image.width = 30;
                image.height = 30;
                image.horizontalCenter = "middle";
                image.verticalCenter = "middle";
                image.propertyFields.href = "href";

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
                            hs.properties.dx = dataItem.column.pixelWidth;
                            bullet.isHover = true;

                            previousBullet = bullet;
                        }
                    }
                })
            });//personas capacitadas
            am4core.ready(function () {

                am4core.useTheme(am4themes_animated);
                var chart = am4core.create("chartPersonalAlcanzadoPrograma", am4charts.XYChart);
                chart.padding(5, 5, 5, 5);

                var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                categoryAxis.renderer.grid.template.location = 0;
                categoryAxis.dataFields.category = "name";
                categoryAxis.renderer.minGridDistance = 1;
                categoryAxis.renderer.inversed = true;
                categoryAxis.renderer.grid.template.disabled = true;

                var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
                valueAxis.min = 0;

                function createGrid(value) {
                    var range = valueAxis.axisRanges.create();
                    range.value = value;
                    range.label.text = "{value}";
                }

                createGrid(0);
                createGrid(25);
                createGrid(50);
                createGrid(75);
                createGrid(100);

                var series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.categoryY = "name";
                series.dataFields.categoryX = "id";
                series.dataFields.valueX = "progress";
                series.tooltipText = "{valueX.value}"
                series.columns.template.strokeOpacity = 0;
                series.columns.template.column.cornerRadiusBottomRight = 5;
                series.columns.template.column.cornerRadiusTopRight = 5;
                series.columns.template.propertyFields.fill = "color";
                series.columns.template.propertyFields.stroke = "color";
                series.columns.template.maxHeight = 40;
                series.columns.template.events.on("hit", function (ev) {
                    var name = ev.target.column.dataItem.categories.categoryX;
                    window.livewire.emitTo('common.show-filter-by-period', 'openModalPeopleReached', {name: name});
                }, this);

                var labelBullet = series.bullets.push(new am4charts.LabelBullet())
                labelBullet.label.horizontalCenter = "left";
                labelBullet.label.dx = 10;
                labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.0as')}" + "%";
                labelBullet.locationX = 1;
                labelBullet.label.fill = am4core.color("#eee");
                categoryAxis.sortBySeries = series;
                chart.data = event.detail.groups;

            });//personas alcanzadas por programa
            am4core.ready(function () {

                am4core.useTheme(am4themes_animated);
                var chart = am4core.create("chartPersonalHumanitarioCapacitado", am4charts.XYChart);
                chart.padding(5, 5, 5, 5);

                var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                categoryAxis.renderer.grid.template.location = 0;
                categoryAxis.dataFields.category = "name";
                categoryAxis.renderer.minGridDistance = 1;
                categoryAxis.renderer.inversed = true;
                categoryAxis.renderer.grid.template.disabled = true;

                var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
                valueAxis.min = 0;

                function createGrid(value) {
                    var range = valueAxis.axisRanges.create();
                    range.value = value;
                    range.label.text = "{value}";
                }

                createGrid(0);
                createGrid(25);
                createGrid(50);
                createGrid(75);
                createGrid(100);

                var series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.categoryY = "name";
                series.dataFields.categoryX = "id";
                series.dataFields.valueX = "progress";
                series.tooltipText = "{valueX.value}"
                series.columns.template.strokeOpacity = 0;
                series.columns.template.column.cornerRadiusBottomRight = 5;
                series.columns.template.column.cornerRadiusTopRight = 5;
                series.columns.template.propertyFields.fill = "color";
                series.columns.template.propertyFields.stroke = "color";
                series.columns.template.maxHeight = 40;
                series.columns.template.events.on("hit", function (ev) {
                    var name = ev.target.column.dataItem.categories.categoryX;
                    window.livewire.emitTo('common.show-filter-by-period', 'openModalPeopleCapacitado', {name: name});
                }, this);

                var labelBullet = series.bullets.push(new am4charts.LabelBullet())
                labelBullet.label.horizontalCenter = "left";
                labelBullet.label.dx = 10;
                labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.0as')}" + "%";
                labelBullet.locationX = 1;
                labelBullet.label.fill = am4core.color("#eee");

                categoryAxis.sortBySeries = series;
                chart.data = event.detail.groups2;

            });//personas capacitadas por porgrama
            am4core.ready(function () {

                am4core.useTheme(am4themes_animated);
                var chart = am4core.create("chartCalificacionServicio", am4charts.XYChart);
                chart.padding(5, 5, 5, 5);

                var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                categoryAxis.renderer.grid.template.location = 0;
                categoryAxis.dataFields.category = "name";
                categoryAxis.renderer.minGridDistance = 1;
                categoryAxis.renderer.inversed = true;
                categoryAxis.renderer.grid.template.disabled = true;

                var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
                valueAxis.min = 0;

                function createGrid(value) {
                    var range = valueAxis.axisRanges.create();
                    range.value = value;
                    range.label.text = "{value}";
                }

                createGrid(0);
                createGrid(25);
                createGrid(50);
                createGrid(75);
                createGrid(100);

                var series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.categoryY = "name";
                series.dataFields.categoryX = "id";
                series.dataFields.valueX = "progress";
                series.tooltipText = "{valueX.value}"
                series.columns.template.strokeOpacity = 0;
                series.columns.template.column.cornerRadiusBottomRight = 5;
                series.columns.template.column.cornerRadiusTopRight = 5;
                series.columns.template.propertyFields.fill = "color";
                series.columns.template.propertyFields.stroke = "color";
                series.columns.template.maxHeight = 40;
                series.columns.template.events.on("hit", function (ev) {
                    var name = ev.target.column.dataItem.categories.categoryX;
                    window.livewire.emitTo('common.show-filter-by-period', 'openModalService', {name: name});
                }, this);

                var labelBullet = series.bullets.push(new am4charts.LabelBullet())
                labelBullet.label.horizontalCenter = "left";
                labelBullet.label.dx = 10;
                labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.0as')}" + "%";
                labelBullet.locationX = 1;
                labelBullet.label.fill = am4core.color("#eee");
                categoryAxis.sortBySeries = series;
                chart.data = event.detail.groups3;

            });//calificacion servicio
            am4core.ready(function () {

                am4core.useTheme(am4themes_animated);
                var chart = am4core.create("chartProductosArea", am4charts.XYChart);
                chart.padding(40, 40, 40, 40);

                var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                categoryAxis.renderer.grid.template.location = 0;
                categoryAxis.dataFields.category = "name";
                categoryAxis.renderer.minGridDistance = 1;
                categoryAxis.renderer.inversed = true;
                categoryAxis.renderer.grid.template.disabled = true;

                var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
                valueAxis.min = 0;
                valueAxis.max = 100;

                var series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.categoryY = "name";
                series.dataFields.categoryX = "id";
                series.dataFields.valueX = "progress";
                series.tooltipText = "{valueX.value}"
                series.columns.template.strokeOpacity = 0;
                series.columns.template.propertyFields.fill = "color";
                series.columns.template.maxHeight = 40;
                series.columns.template.events.on("hit", function (ev) {
                    var name = ev.target.column.dataItem.categories.categoryX;
                    window.livewire.emitTo('common.show-filter-by-period', 'openModalDoc', {name: name});
                }, this);
                var title = chart.titles.create();
                title.text = "Productos por área";
                title.fontSize = 18;
                title.paddingBottom = 10;

                var labelBullet = series.bullets.push(new am4charts.LabelBullet())
                labelBullet.label.horizontalCenter = "left";
                labelBullet.label.dx = 10;
                labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.0as')}%";
                labelBullet.locationX = 1;
                labelBullet.label.fill = am4core.color("#eee");
                categoryAxis.sortBySeries = series;
                chart.data = event.detail.groups4;
            });//productos por area
        });
    </script>
@endpush

