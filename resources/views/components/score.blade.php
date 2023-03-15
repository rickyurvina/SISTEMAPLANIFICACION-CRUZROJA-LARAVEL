@props(['id', 'score' => 0, 'difScoreValue' => '', 'difScoreColor' => '', 'title' => '', 'beforePeriod' => '', 'hasData' => false])

<div class="card">
    <div class="card-header bg-transparent fw-700">
        DESEMPEÑO
        <div class="spinner-border spinner-border-sm ml-3" role="status" wire:loading>
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="card-body">
        @if($score)
            <div class="d-flex justify-content-end">
                @if($hasData)
                    <span class="badge fs-4x text-white mr-6"
                          data-toggle="popover"
                          data-trigger="hover" data-placement="top"
                          data-content="Diferencia con {{ $beforePeriod }}"
                          style="background-color: {{ $difScoreColor }}; z-index: 9999">
                        {{ $difScoreValue }}
                    </span>
                @endif
            </div>
        @else
            <div class="d-flex justify-content-center">
                <span class="badge badge-dark fs-2x mb-3">Aún no actualizado</span>
            </div>
        @endif
        <div id="score-chart" style="height: 265px;position: relative; top: -30px"></div>
    </div>
</div>

@push('page_script')
    <script>
        am4core.ready(function () {

            // create chart
            let chart = am4core.create("score-chart", am4charts.GaugeChart);
            chart.responsive.enabled = true;

            /**
             * Axis for ranges
             */
            let axis2 = chart.xAxes.push(new am4charts.ValueAxis());
            axis2.min = 0;
            axis2.max = 100;
            axis2.renderer.innerRadius = am4core.percent(96);

            axis2.strictMinMax = true;
            axis2.renderer.labels.template.disabled = true;
            axis2.renderer.ticks.template.disabled = true;
            axis2.renderer.grid.template.disabled = true;

            /**
             Ranges
             */
            let range = axis2.axisRanges.create();
            range.axisFill.fill = am4core.color('#f25131');
            range.axisFill.fillOpacity = 1;
            range.axisFill.zIndex = -1;
            range.value = 0;
            range.endValue = 33.33;
            range.grid.strokeOpacity = 0;

            let range1 = axis2.axisRanges.create();
            range1.axisFill.fill = am4core.color('#fbcc3b');
            range1.axisFill.fillOpacity = 1;
            range1.axisFill.zIndex = -1;
            range1.value = 33.33;
            range1.endValue = 66.67;
            range1.grid.strokeOpacity = 0;


            let range2 = axis2.axisRanges.create();
            range2.axisFill.fill = am4core.color('#96cd00');
            range2.axisFill.fillOpacity = 1;
            range2.axisFill.zIndex = -1;
            range2.value = 66.67;
            range2.endValue = 100;
            range2.grid.strokeOpacity = 0;

            let axis = chart.xAxes.push(new am4charts.ValueAxis());
            axis.min = 0;
            axis.max = 100;
            axis.strictMinMax = true;
            axis.renderer.inside = true;

            axis.renderer.innerRadius = am4core.percent(50);
            axis.renderer.radius = am4core.percent(94);
            axis.renderer.labels.template.disabled = true;
            axis.renderer.ticks.template.disabled = true;
            axis.renderer.grid.template.disabled = true;

            @if($score)
            let range4 = axis.axisRanges.create();
            range4.axisFill.fill = am4core.color('#eff3f7');
            range4.axisFill.fillOpacity = 1;
            range4.axisFill.zIndex = -1;
            range4.value = 0;
            range4.endValue = 33.33;
            range4.grid.strokeOpacity = 0;

            let range5 = axis.axisRanges.create();
            range5.axisFill.fill = am4core.color('#fbcc3b');
            range5.axisFill.fillOpacity = 1;
            range5.axisFill.zIndex = -1;
            range5.value = 33.33;
            range5.endValue = 66.67;
            range5.grid.strokeOpacity = 0;

            let range6 = axis.axisRanges.create();
            range6.axisFill.fill = am4core.color('#eff3f7');
            range6.axisFill.fillOpacity = 1;
            range6.axisFill.zIndex = -1;
            range6.value = 66.67;
            range6.endValue = 100;
            range6.grid.strokeOpacity = 0;

            /**
             * Hand
             */
            let hand = chart.hands.push(new am4charts.ClockHand());
            hand.axis = axis;
            hand.innerRadius = am4core.percent(10);
            hand.startWidth = 12;
            hand.pin.radius = 14;
            hand.pin.strokeOpacity = 0;
            hand.value = {{ $score != '' ? $score:'' }};
            hand.fill = am4core.color("#444");
            hand.strokeOpacity = 0;

            let centerLabel = chart.chartContainer.createChild(am4core.Label);
            centerLabel.isMeasured = false;
            centerLabel.textAlign = "middle";
            centerLabel.text = "[font-size:25px; #000000; bold;]{{ $score }}\n[font-size:15px; #8b98a6; bold]SCORE";
            centerLabel.y = am4core.percent(82);
            centerLabel.x = am4core.percent(41);
            @else
            let range10 = axis.axisRanges.create();
            range10.axisFill.fill = am4core.color('#eff3f7');
            range10.axisFill.fillOpacity = 1;
            range10.axisFill.zIndex = -1;
            range10.value = 0;
            range10.endValue = 100;
            range10.grid.strokeOpacity = 0;
            @endif
        });
        window.addEventListener('updateData', event => {

            am4core.ready(function () {

                    // create chart
                    let chart = am4core.create("score-chart", am4charts.GaugeChart);
                    chart.responsive.enabled = true;

                    /**
                     * Axis for ranges
                     */
                    let axis2 = chart.xAxes.push(new am4charts.ValueAxis());
                    axis2.min = 0;
                    axis2.max = 100;
                    axis2.renderer.innerRadius = am4core.percent(96);

                    axis2.strictMinMax = true;
                    axis2.renderer.labels.template.disabled = true;
                    axis2.renderer.ticks.template.disabled = true;
                    axis2.renderer.grid.template.disabled = true;

                    /**
                     Ranges
                     */
                    let range = axis2.axisRanges.create();
                    range.axisFill.fill = am4core.color('#f25131');
                    range.axisFill.fillOpacity = 1;
                    range.axisFill.zIndex = -1;
                    range.value = 0;
                    range.endValue = 33.33;
                    range.grid.strokeOpacity = 0;

                    let range1 = axis2.axisRanges.create();
                    range1.axisFill.fill = am4core.color('#fbcc3b');
                    range1.axisFill.fillOpacity = 1;
                    range1.axisFill.zIndex = -1;
                    range1.value = 33.33;
                    range1.endValue = 66.67;
                    range1.grid.strokeOpacity = 0;


                    let range2 = axis2.axisRanges.create();
                    range2.axisFill.fill = am4core.color('#96cd00');
                    range2.axisFill.fillOpacity = 1;
                    range2.axisFill.zIndex = -1;
                    range2.value = 66.67;
                    range2.endValue = 100;
                    range2.grid.strokeOpacity = 0;

                    let axis = chart.xAxes.push(new am4charts.ValueAxis());
                    axis.min = 0;
                    axis.max = 100;
                    axis.strictMinMax = true;
                    axis.renderer.inside = true;

                    axis.renderer.innerRadius = am4core.percent(50);
                    axis.renderer.radius = am4core.percent(94);
                    axis.renderer.labels.template.disabled = true;
                    axis.renderer.ticks.template.disabled = true;
                    axis.renderer.grid.template.disabled = true;

                    if (event.detail.score) {
                        let range4 = axis.axisRanges.create();
                        range4.axisFill.fill = am4core.color('#eff3f7');
                        range4.axisFill.fillOpacity = 1;
                        range4.axisFill.zIndex = -1;
                        range4.value = 0;
                        range4.endValue = 33.33;
                        range4.grid.strokeOpacity = 0;

                        let range5 = axis.axisRanges.create();
                        range5.axisFill.fill = am4core.color('#fbcc3b');
                        range5.axisFill.fillOpacity = 1;
                        range5.axisFill.zIndex = -1;
                        range5.value = 33.33;
                        range5.endValue = 66.67;
                        range5.grid.strokeOpacity = 0;

                        let range6 = axis.axisRanges.create();
                        range6.axisFill.fill = am4core.color('#eff3f7');
                        range6.axisFill.fillOpacity = 1;
                        range6.axisFill.zIndex = -1;
                        range6.value = 66.67;
                        range6.endValue = 100;
                        range6.grid.strokeOpacity = 0;

                        /**
                         * Hand
                         */
                        let hand = chart.hands.push(new am4charts.ClockHand());
                        hand.axis = axis;
                        hand.innerRadius = am4core.percent(10);
                        hand.startWidth = 12;
                        hand.pin.radius = 14;
                        hand.pin.strokeOpacity = 0;
                        hand.value = event.detail.score;
                        hand.fill = am4core.color("#444");
                        hand.strokeOpacity = 0;

                        let centerLabel = chart.chartContainer.createChild(am4core.Label);
                        centerLabel.isMeasured = false;
                        centerLabel.textAlign = "middle";
                        centerLabel.text = "[font-size:25px; #000000; bold;]" + event.detail.score + "\n[font-size:15px; #8b98a6; bold]SCORE";
                        centerLabel.y = am4core.percent(82);
                        centerLabel.x = am4core.percent(41);
                    } else {
                        let range10 = axis.axisRanges.create();
                        range10.axisFill.fill = am4core.color('#eff3f7');
                        range10.axisFill.fillOpacity = 1;
                        range10.axisFill.zIndex = -1;
                        range10.value = 0;
                        range10.endValue = 100;
                        range10.grid.strokeOpacity = 0;
                    }
                }
            );

        });
    </script>
@endpush