<div id="objective-score" style="height: 250px;"></div>

@push('page_script')
    <script>
        am4core.ready(function () {
            let chart = am4core.create("objective-score", am4charts.XYChart);

            chart.data = @json($objectiveScore);

            // Create axes
            let categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "name";
            categoryAxis.renderer.inversed = true;
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.renderer.minGridDistance = 10;
            categoryAxis.renderer.cellStartLocation = 0.3;
            categoryAxis.renderer.cellEndLocation = 0.7;


            let valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
            valueAxis.title.text = "Score";
            valueAxis.renderer.opposite = true;
            valueAxis.min = 0;
            valueAxis.max = 10;
            valueAxis.renderer.grid.template.disabled = true;
            valueAxis.renderer.labels.template.disabled = true;


            function createGrid(value) {
                let range = valueAxis.axisRanges.create();
                range.value = value;
                range.label.text = "{value}";
            }

            createGrid(0);
            createGrid(2);
            createGrid(4);
            createGrid(6);
            createGrid(8);
            createGrid(10);

            // Create series
            let series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.valueX = 'value';
            series.dataFields.categoryY = "name";
            series.clustered = false;
            series.columns.template.strokeOpacity = 0;
            series.columns.template.tooltipText = "{name}: {valueX.value}";

            series.columns.template.adapter.add("fill", function(fill, target) {
                if (target.dataItem && (target.dataItem.valueX < 3.33)) {
                    return am4core.color("#ee1f25");
                }

                if (target.dataItem && (target.dataItem.valueX >= 6.67)) {
                    return am4core.color("#0f9747");
                }
                else {
                    return '#fdae19';
                }
            });

        });
    </script>
@endpush