<div>
    <div wire:ignore class="modal fade modal-fullscreen example-modal-fullscreen show" id="project-activities-wbs" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">WBS de {{$project->name}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="chartdiv"  style="width: 100%; height: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('page_script')

{{--    <script>--}}
{{--        var root = am5.Root.new("chartdiv");--}}

{{--        root.setThemes([--}}
{{--            am5themes_Animated.new(root)--}}
{{--        ]);--}}

{{--        var container = root.container.children.push(--}}
{{--            am5.Container.new(root, {--}}
{{--                width: am5.percent(100),--}}
{{--                height: am5.percent(100),--}}
{{--                layout: root.verticalLayout--}}
{{--            })--}}
{{--        );--}}

{{--        // var series = container.children.push(--}}
{{--        //     am5hierarchy.ForceDirected.new(root, {--}}
{{--        //         downDepth: 1,--}}
{{--        //         initialDepth: 1,--}}
{{--        //         topDepth: 0,--}}
{{--        //         valueField: "value",--}}
{{--        //         categoryField: "name",--}}
{{--        //         childDataField: "children",--}}
{{--        //         minRadius: 30--}}
{{--        //     })--}}
{{--        // );--}}
{{--        var series = container.children.push(am5hierarchy.Tree.new(root, {--}}
{{--            singleBranchOnly: false,--}}
{{--            downDepth: 1,--}}
{{--            initialDepth: 10,--}}
{{--            topDepth:0,--}}
{{--            valueField: "value",--}}
{{--            categoryField: "name",--}}
{{--            childDataField: "children"--}}
{{--        }));--}}
{{--        series.labels.template.setAll({--}}
{{--            fill: am5.color(0x000000),--}}
{{--        });--}}

{{--        // Hide circles--}}
{{--        series.circles.template.set("forceHidden", true);--}}
{{--        series.outerCircles.template.set("forceHidden", true);--}}

{{--        // Add an icon to node--}}
{{--        // series.nodes.template.setup = function(target) {--}}
{{--        //     var icon = target.children.push(am5.Picture.new(root, {--}}
{{--        //         width: 150,--}}
{{--        //         height: 70,--}}
{{--        //         centerX: am5.percent(50),--}}
{{--        //         centerY: am5.percent(50),--}}
{{--        //         src: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAYFBMVEVksvT///9dr/TJ4fu32PlYrfNbr/Nst/a62vl4vPfE4P293PnR5/3E4PuDwfdWrPP5/P7u9v7R5/rZ7PyUyPeLxfecy/fi8P3Z6v30+P2t1Pd8vvem0fedzPZ5u/XX6vvOjnNzAAAEF0lEQVR4nO3d6XaqMBSG4SQaKIIIAjI53P9dngBqy2RtKwe/zX67+vOsk2clTHZJhKSemHsAk8dC/FiIHwvxYyF+LMSPhfixED8W4veEMI+2RZz4VaXTZN8SI1n626yxf1tnt7v+v/Ug/CSO48PpWKzdVRr8VRhuT47WyvRwPP+3ajjKqn+1SNz098Lww38v2lDGWbrhr4RRIt5dd0uLeHwix4T7s0bxValdefmRMPKReE3aH57HIWF+ePujbyhlnfLnhCuY46+bEt4TwuCo5x7oH9LH3gWyKwz9x1fid0/53StHR5jaqCv0lrLTR8II3VdlRePCy9yDe1H7MWE098helboMC8O5B/a6VDokDBwKB+E1OxwQxtiXiXZW0he6yBf6frroClNCS7RORx1hSU0o7LZwSw54X6eNMB/9SAm58IvwSOk8eksdPoX53IOZJiu8CwuKU2gm8XgXzj2UqVLBVbiidyJtUuur0J97JJPlNMKQ5lFYVT1jGKFLdZE25xojBPz09+nOlZDQg28/FRrhhdZjUzu1MsKC8CIV1skIE8pC4RuhM/cgpi0wP6SzjJDu9b5qZ4SUT6XmST8UwW7uQUyaEYbE5zBdgDClLVTZAoQRcaG3AGFG+rbUPFwIj4XYLUC4FWQ/LG2yNtTncBFC4qtUuWJD+wlYfYgteSHPIXjLmEPi59K1IPy3tSoW4rcI4ZqF2LEQPxbix0L8WIgfC/FjIX4sxI+F+LEQPxbix0L8WIgfC/FjIX4sxI+F+LEQPxbix0L8WIgfC/FjIX4sxI+F+LEQPxbix0L8WIgfC/FbhPCDvJD+t/NYCN4ihPS/j89C8BYh5Dd/gGeE9N+iRP9NWCwEj75wAe9NXIKQ+htal/CWXfpC+m+7pi+k/9b5nPjeCOkCdn8IaF8Pd/kSdmEhuQXpPRUIWc49iEmzpZAHygeiSoyQ9CtarcIISd/UWJkRkj7V2Hm1wyPhA9EchpXQo7tM1aYWEt5brtrVudotl+wyrRZpLYyo3nxr77Zr9XnuoUyUfd+Xm+i5Rrl3IdGdOu3gU0jyY2FdT+FVSHJf57P8KiT4qanet4TySG0SVSzbQnInm+Y081UYzT2k16Yy2RVKl9KhqAvZF8oTnUPxfhC2hXT2IFelHBYGRK6KlpOPCGVQUiC2gW0hiXsbVQbygRD/aVjFbWBPKMG/naDXXVBPKFMb16hE1vP0hTI4WaDG3godEZo7OB/x/kY7/QkcE0q5gVuq2t4MU0aExugoHKTS9moMMiqUMosFBNIMMvHGGQ+EUuar2NLvjVRaJZvwEeKh0BRkRWmUdfp9ug3IOWYDp88fCRtmmEZZtt97q/fI2++zLErD73DPC6FjIX4sxI+F+LEQPxbix0L8WIgfC/H7B/6VSB+1jcIsAAAAAElFTkSuQmCC"--}}
{{--        //     }))--}}
{{--        // }--}}
{{--        // var root = am5.Root.new("chartdiv");--}}
{{--        //--}}
{{--        // root.setThemes([--}}
{{--        //     am5themes_Animated.new(root)--}}
{{--        // ]);--}}
{{--        //--}}
{{--        // // Create wrapper container--}}
{{--        // var container = root.container.children.push(am5.Container.new(root, {--}}
{{--        //     width: am5.percent(100),--}}
{{--        //     height: am5.percent(100),--}}
{{--        //     layout: root.verticalLayout--}}
{{--        // }));--}}
{{--        //--}}
{{--        // // Create series--}}
{{--        // // https://www.amcharts.com/docs/v5/charts/hierarchy/#Adding--}}
{{--        // var series = container.children.push(am5hierarchy.Tree.new(root, {--}}
{{--        //     singleBranchOnly: false,--}}
{{--        //     downDepth: 1,--}}
{{--        //     initialDepth: 10,--}}
{{--        //     valueField: "value",--}}
{{--        //     categoryField: "name",--}}
{{--        //     childDataField: "children"--}}
{{--        // }));--}}
{{--        //--}}
{{--        // series.circles.template.setAll({--}}
{{--        //     radius: 30--}}
{{--        // });--}}
{{--        //--}}
{{--        // series.outerCircles.template.setAll({--}}
{{--        //     radius: 30--}}
{{--        // });--}}

{{--        // Generate and set data--}}
{{--        // https://www.amcharts.com/docs/v5/charts/hierarchy/#Setting_data--}}
{{--        var maxLevels = 3;--}}
{{--        var maxNodes = 3;--}}
{{--        var maxValue = 100;--}}
{{--        var data = @json($data)--}}

{{--        series.data.setAll([data]);--}}
{{--        series.set("selectedDataItem", series.dataItems[0]);--}}

{{--        series.appear(1000, 100);--}}
{{--    </script>--}}
@endpush