<div id="score-historical" style="height: 300px;"></div>

@push('page_script')
    <script>

        am4core.ready(function () {
            let chart_score_historical = am4core.create("score-historical", am4charts.XYChart);

            chart_score_historical.data = @json($historicalScore);
            chart_score_historical.hideCredits = true;

            // Create axes
            let categoryAxis = chart_score_historical.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "period_id";
            categoryAxis.renderer.minGridDistance = 30;
            categoryAxis.renderer.grid.template.stroke = am4core.color("#aaaaac");
            categoryAxis.renderer.grid.template.strokeWidth = 1.5;
            categoryAxis.renderer.grid.template.strokeDasharray = "5,3"
            categoryAxis.renderer.grid.template.strokeOpacity = .1;
            categoryAxis.renderer.labels.template.adapter.add("html", function(html, target) {
                if(target.dataItem && target.dataItem.dataContext) {
                    return `<span>` + target.dataItem.dataContext.frequency + `</span>` + `<br>` + target.dataItem.dataContext.year;
                }
            });

            let valueAxis = chart_score_historical.yAxes.push(new am4charts.ValueAxis());
            valueAxis.min = 0;
            valueAxis.max = 100;
            valueAxis.renderer.minGridDistance = 30;
            valueAxis.renderer.grid.template.stroke = am4core.color("#aaaaac");
            valueAxis.renderer.grid.template.strokeWidth = 1.5;
            valueAxis.renderer.grid.template.strokeDasharray = "5,3";
            valueAxis.renderer.grid.template.strokeOpacity = .1;

            function createGrid(value) {
                let range = valueAxis.axisRanges.create();
                range.value = value;
                range.label.text = "{value}";
            }

            createGrid(0);
            createGrid(20);
            createGrid(40);
            createGrid(60);
            createGrid(80);
            createGrid(100);

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
                categoryAxis.renderer.labels.template.adapter.add("html", function(html, target) {
                    if(target.dataItem && target.dataItem.dataContext) {
                        return `<span>` + target.dataItem.dataContext.frequency + `</span>` + `<br>` + target.dataItem.dataContext.year;
                    }
                });

                let valueAxis = chart_score_historical.yAxes.push(new am4charts.ValueAxis());
                valueAxis.min = 0;
                valueAxis.max = 100;
                valueAxis.renderer.minGridDistance = 30;
                valueAxis.renderer.grid.template.stroke = am4core.color("#aaaaac");
                valueAxis.renderer.grid.template.strokeWidth = 1.5;
                valueAxis.renderer.grid.template.strokeDasharray = "5,3";
                valueAxis.renderer.grid.template.strokeOpacity = .1;

                function createGrid(value) {
                    let range = valueAxis.axisRanges.create();
                    range.value = value;
                    range.label.text = "{value}";
                }

                createGrid(0);
                createGrid(20);
                createGrid(40);
                createGrid(60);
                createGrid(80);
                createGrid(100);

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

    </script>
@endpush