<div>
    <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Avance por meses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">

                    <div id="chartdivTest" class="w-100 height-lg" wire:ignore.self>
                    </div>
                    <div id="chartdata-1" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('page_script')
    <script>
        $('#modalInfo').on('show.bs.modal', function (e) {
            window.addEventListener('showChart', event => {
                // alert("hola")
                let chart_ = am4core.create("chartdivTest", am4charts.XYChart);
                chart_.data = event.detail.data;

                // Create axes
                var categoryAxis = chart_.xAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "frequency";
                categoryAxis.renderer.minGridDistance = 50;
                categoryAxis.renderer.grid.template.location = 0.5;
                categoryAxis.renderer.labels.template.adapter.add("html", function (html, target) {
                    if (target.dataItem.dataContext) {
                        return `<span style="font-weight: bold;color:` + target.dataItem.dataContext.color + `">` + target.dataItem.dataContext.frequency.replace(/ \(.*/, "") + `<br>
                                <span style="opacity: 0.4;">` + target.dataItem.dataContext.year + `</span></span>`;
                    }
                });

                let valueAxis = chart_.yAxes.push(new am4charts.ValueAxis());

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
                        var div = document.getElementById("chartdata-1");
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
                    var div = document.getElementById("chartdata-1");
                    if (button.isActive) {
                        div.style.display = "block";
                    } else {
                        div.style.display = "none";
                    }
                });
            });
        })
    </script>
@endpush