@extends('modules.projectInternal.project')

@section('project-page')
    <div class="container-fluid">
        <div class="d-flex flex-row-reverse">
            <div>
                <a href="javascript:void(0);" data-toggle="modal" data-target="#project-create-stakeholder" data-project-id="{{$project->id}}"
                   class="btn btn-success btn-sm mb-2 mr-2 ml-auto">
                    <span class="fas fa-plus mr-1"></span> &nbsp;{{ trans('general.add_new') }}
                </a>
            </div>
            <div>
                <x-tooltip-help message="{{$messages->where('code','actores_clave')->first()->description}}"></x-tooltip-help>
            </div>
        </div>
        <div class="card w-100">
            @if($stakeholders->count()>0)
                <div class="row">
                    <div class="col-12">
                        <x-search route="{{ route('projects.stakeholder',$project) }}"/>
                        <div class="table-responsive">
                            <table class="table  m-0">
                                <thead class="bg-primary-50">
                                <tr>
                                    <th class="d-none">@sortablelink('id', trans('general.id'))</th>
                                    <th> {{trans('general.assigned_to')}}</th>
                                    <th>@sortablelink('priority', trans('general.priority'))</th>
                                    <th> {{trans('general.interest_level')}}</th>
                                    <th> {{trans('general.influence_level')}}</th>
                                    <th>@sortablelink('strategy', trans('general.strategy'))</th>
                                    <th class="text-center color-primary-500">{{ trans('general.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($stakeholders as $item)
                                    <tr>
                                        <td class="d-none"></td>
                                        <td>
                                            {{ $item->interested->getFullName()??'' }}
                                        </td>
                                        <td>
                                            @switch($item->priority)
                                                @case(\App\Models\Projects\Stakeholders\ProjectStakeholder::URGENT)
                                                <span style="color: red">
                                    <i class='red fa fa-bell w-10 text-center'></i> {{ trans('general.labels.priority_' . $item->priority) }}
                                </span>
                                                @break
                                                @case(\App\Models\Projects\Stakeholders\ProjectStakeholder::IMPORTANT)
                                                <span style="color: red">
                                    <i class='red fa fa-exclamation w-10 text-center'></i> {{ trans('general.labels.priority_' . $item->priority) }}
                                </span>
                                                @break
                                                @case(\App\Models\Projects\Stakeholders\ProjectStakeholder::HALF)
                                                <span style="color: green">
                          <i class='green fa fa-minus w-10 text-center'></i> {{ trans('general.labels.priority_' . $item->priority) }}
                                </span>
                                                @break
                                                @case(\App\Models\Projects\Stakeholders\ProjectStakeholder::LOW)
                                                <span style="color: blue">
                                    <i class='color-blue fa fa-long-arrow-down w-10 text-center'></i> {{ trans('general.labels.priority_' . $item->priority) }}
                                </span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td>{{ $item->interest_level }}</td>
                                        <td>{{ $item->influence_level }}</td>
                                        <td>{{ $item->strategy }}</td>
                                        <td class="text-center">
                                            <a href="javascript:void(0);" aria-expanded="false"
                                               data-toggle="modal"
                                               data-target="#project-create-stakeholder"
                                               data-project-id="{{$project->id}}"
                                               data-item-id="{{ $item->id }}">
                                                <i class="fas fa-edit mr-1 text-info"
                                                   data-toggle="tooltip" data-placement="top" title=""
                                                   data-original-title="Editar"></i></a>
                                            <x-delete-link-icon
                                                    action="{{ route('project.deleteStakeholder', ['id' => $item->id]) }}"
                                                    id="{{ $item->id }}">
                                            </x-delete-link-icon>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <x-pagination :items="$stakeholders"/>

                    </div>
                    <div class="col-6" style="display: none">
                        <div id="chartdivStakeholders" style="height: 400px; width: 100%"></div>
                    </div>
                </div>

            @else
                <x-empty-content>
                    <x-slot name="title">
                        {{trans('general.stakeholders')}}
                    </x-slot>
                </x-empty-content>

            @endif
        </div>
        <div>
            <livewire:projects.stakeholders.project-create-stakeholder :id="$project->id"/>
        </div>

    </div>


@endsection
@push('page_script')
    <script>
        $('#project-create-stakeholder').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let projectId = $(e.relatedTarget).data('project-id');
            let item = $(e.relatedTarget).data('item-id');
            //Livewire event trigger
            Livewire.emit('open', projectId, item);
        });

        Livewire.on('toggleProjectCreateStakeholder', () => $('#project-create-stakeholder').modal('toggle'));
        am4core.ready(function () {
            // Themes begin
            am4core.useTheme(am4themes_animated);
// Themes end

            var chart = am4core.create("chartdivStakeholders", am4charts.XYChart);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            chart.maskBullets = false;

            var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            var yAxis = chart.yAxes.push(new am4charts.CategoryAxis());

            xAxis.dataFields.category = "x";
            yAxis.dataFields.category = "y";

            xAxis.renderer.grid.template.disabled = true;
            xAxis.renderer.minGridDistance = 40;

            yAxis.renderer.grid.template.disabled = true;
            yAxis.renderer.inversed = true;
            yAxis.renderer.minGridDistance = 30;

            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.categoryX = "x";
            series.dataFields.categoryY = "y";
            series.dataFields.value = "value";
            series.sequencedInterpolation = true;
            series.defaultState.transitionDuration = 3000;

// Set up column appearance
            var column = series.columns.template;
            column.strokeWidth = 2;
            column.strokeOpacity = 1;
            column.stroke = am4core.color("#000000");
            column.tooltipText = "{result},: {value.workingValue.formatNumber('#.')}";
            column.width = am4core.percent(90);
            column.height = am4core.percent(90);
            column.column.cornerRadius(6, 6, 6, 6);
            column.propertyFields.fill = "color2";

// Set up bullet appearance
            var bullet1 = series.bullets.push(new am4charts.CircleBullet());
//bullet1.circle.propertyFields.radius = "value";
            bullet1.circle.fill = am4core.color("#000");
            bullet1.circle.strokeWidth = 0;
            bullet1.circle.fillOpacity = 0.7;
            bullet1.interactionsEnabled = false;

            var bullet2 = series.bullets.push(new am4charts.LabelBullet());
            bullet2.label.text = "{value}";
            bullet2.label.fill = am4core.color("#fff");
            bullet2.zIndex = 1;
            bullet2.fontSize = 15;
            bullet2.interactionsEnabled = false;

            chart.data = @json($data)

            var baseWidth = Math.min(chart.plotContainer.maxWidth, chart.plotContainer.maxHeight);
            var maxRadius = baseWidth / Math.sqrt(chart.data.length) / 2 - 10; // 2 is jast a margin
            series.heatRules.push({min: 40, max: maxRadius, property: "radius", target: bullet1.circle});


            chart.plotContainer.events.on("maxsizechanged", function () {
                var side = Math.min(chart.plotContainer.maxWidth, chart.plotContainer.maxHeight);
                bullet1.circle.clones.each(function (clone) {
                    clone.scale = side / baseWidth;
                })
            })
        });//ejecuccion general

    </script>
@endpush