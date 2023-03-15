@extends('modules.projectInternal.project')


@section('title', 'Informe')


@section('project-page')

    <ol class="breadcrumb bg-transparent pl-2 pr-0 mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('projects.reportsIndex', $project->id) }}">
                Informes del Proyecto
            </a>
        </li>

        <li class="breadcrumb-item active"> INFORME POR SECTORES</li>
    </ol>

    <div style="display: grid !important;" class="p-2">
        <div class="w-100 p-2">
            <x-label-section> INFORME POR SECTORES</x-label-section>
        </div>
        <h4 class="bold-h4">{{$project->name}}</h4>
        <h4 class="bold-h4">Objetivo General:</h4> {!! $project->general_objective ?? ''!!}
        <table>
            <tr>
                <th class="border bold-h4 text-center p-2">Beneficiario Alcanzados</th>
                <th class="border bold-h4 text-center p-2">Ejecución física</th>
                <th class="border bold-h4 text-center p-2">Tiempo transcurrido</th>
                <th class="border bold-h4 text-center p-2">Ejecución Presupuestaria</th>
            </tr>
            <tr>
                <td class="border text-center p-2">{{$project->getPercentageBeneficiaries()}}%</td>
                <td class="border text-center p-2">{{$project->getPhysicProgress()}}%</td>
                <td class="border text-center p-2">{{$project->getProgressTimeUpDate()}}%</td>
                <td class="border text-center p-2">{{$project->getPercentageBudget()}}%</td>
            </tr>
            <tr>
                <td class="border text-center p-2" colspan="2">Personas Meta: {{$project->getTotalGoalBeneficiaries()}}</td>
                <td class="border text-center p-2" colspan="3">Personas Alcanzadas: {{$project->getTotalBeneficiaries()}}</td>
            </tr>
        </table>
        <table>
            <th class="bold-h4 border text-center p-2" colspan="8">Ejecución Presupuestaria</th>
            <tr>
                <th class="border bold-h4 text-center p-2">Sector</th>
                <th class="border bold-h4 text-center p-2">Presupuesto Meta</th>
                <th class="border bold-h4 text-center p-2">Presupuesto Financiado</th>
                <th class="border bold-h4 text-center p-2">%</th>
                <th class="border bold-h4 text-center p-2">Ejecución Efectivo</th>
                <th class="border bold-h4 text-center p-2">%</th>
                <th class="border bold-h4 text-center p-2">Comprometido</th>
                <th class="border bold-h4 text-center p-2">%</th>
            </tr>

            @foreach($programs as $program)
                <tr>
                    <td class="border text-center p-2">{{$program['sector'] ?? ''}}</td>
                    <td class="border text-center p-2">$45698</td>
                    <td class="border text-center p-2">$45698</td>
                    <td class="border text-center p-2">45%</td>
                    <td class="border text-center p-2">$45698</td>
                    <td class="border text-center p-2">45%</td>
                    <td class="border text-center p-2">$45698</td>
                    <td class="border text-center p-2">45%</td>
                </tr>
            @endforeach

        </table>
        <div class="mt-3 p-2">
            <div class="m-2">
                <x-label-section>Presupuesto Meta VS Presupuesto Financiado</x-label-section>
            </div>
            <div>
                <div id="budgetChart"></div>
            </div>
        </div>
    </div>
    <script src="//cdn.amcharts.com/lib/4/core.js"></script>
    <script src="//cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="//cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="//cdn.amcharts.com/lib/4/themes/kelly.js"></script>

@endsection

@push('page_script')

    <script>
        am4core.useTheme(am4themes_animated);
        am4core.useTheme(am4themes_kelly);

        // Create chart instance
        var chart = am4core.create("budgetChart", am4charts.XYChart3D);

        // Add data
        chart.data = [
                @foreach($programs as $program)
            {
                "sector": "{{$program['sector']}}",
                "budget": "{{$program['budget']}}",
                "value": "{{$program['value']}}",
            },
            @endforeach
        ];

        // Create axes
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "sector";
        categoryAxis.title.text = "Sectores";

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Presupuesto Meta";

        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries3D());
        series.dataFields.valueY = "budget";
        series.dataFields.categoryX = "sector";
        series.name = "value";
        series.tooltipText = "{name}: [bold]{valueY}[/]";

        var series2 = chart.series.push(new am4charts.ColumnSeries3D());
        series2.dataFields.valueY = "budget";
        series2.dataFields.categoryX = "sector";
        series2.name = "Value";
        series2.tooltipText = "{name}: [bold]{valueY}[/]";

        // Add cursor
        chart.cursor = new am4charts.XYCursor();
    </script>
@endpush