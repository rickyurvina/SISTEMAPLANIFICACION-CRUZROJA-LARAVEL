@extends('modules.project.project')

@push('stylesheet')
    <link rel="stylesheet" type="text/css" media="screen, print" href="{{ asset_cdn("vendor/dhtmlx/gantt/dhtmlxgantt.css?v=7.1.3") }}">
    <link rel="stylesheet" type="text/css" media="screen, print" href="{{ asset_cdn("vendor/dhtmlx/common/controls_styles.css?v=7.1.5")}}">
    <style>
        #myCover {
            width: 100%;
            height: 100%;
        }

        #gantt_here {
            height: 100%;
            width: 100%;
        }


        .owner-label {
            width: 20px;
            height: 20px;
            line-height: 20px;
            font-size: 12px;
            display: inline-block;
            border: 1px solid #cccccc;
            border-radius: 25px;
            background: #e6e6e6;
            color: #6f6f6f;
            margin: 0 3px;
            font-weight: bold;
        }

        .gantt_cal_chosen select {
            width: 400px;
        }

        .gantt-dropdown {
            position: absolute;
            top: 0;
            right: 0;
            width: 20px;
            height: 100%;
            z-index: 2;
            border-left: 1px solid #cecece

        }

        .gantt-dropdown:hover {
            background: rgba(0, 0, 0, 0.1);
        }

        #gantt_dropdown {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 25px;
            position: absolute;
            display: none;
            border: 1px solid #cecece;
            background: #fff;
            padding: 10px;
            z-index: 10;
            top: 215px !important;
        }

        #gantt_dropdown input {
            margin: 0 5px;
        }

        #gantt_dropdown label {
            display: inline-block;
            width: 100%;
            min-width: 120px;
            height: 25px;
        }


        .resource-controls label {
            margin: 0 10px;
            vertical-align: bottom;
            display: inline-block;
            color: #3e3e3e;
            padding: 2px;
            transition: box-shadow 0.2s;
        }

        .resource-controls label:hover {
            box-shadow: 0 2px rgba(84, 147, 255, 0.42);
        }

        .resource-controls input {
            vertical-align: top;
        }


        .resource_marker div {
            width: 28px;
            height: 28px;
            line-height: 29px;
            display: inline-block;
            border-radius: 15px;
            color: #FFF;
            margin: 3px;
        }

        .resource_marker.workday_ok div {
            background: #51c185;
        }

        .resource_marker.workday_over div {
            background: #ff8686;
        }

        .owner-label {
            width: 20px;
            height: 20px;
            line-height: 20px;
            font-size: 12px;
            display: inline-block;
            border: 1px solid #cccccc;
            border-radius: 25px;
            background: #e6e6e6;
            color: #6f6f6f;
            margin: 0 3px;
            font-weight: bold;
        }
    </style>
@endpush

@push('vendor_js')
    <script src="{{ asset_cdn("vendor/dhtmlx/gantt/dhtmlxgantt.js?v=7.1.3") }}"></script>
    <script src="{{ asset_cdn("vendor/dhtmlx/common/resource_project_assignments.js?v=7.1.5") }}"></script>
    <script src="{{ asset_cdn("vendor/dhtmlx/common/resource_project_multiple_owners.js?v=7.1.5") }}"></script>
@endpush

@section('project-page')
    <div class="panel-1" style="display: contents">

        <div id="myCover">
            <div class="d-flex align-items-center mb-1">
                <div class="w-25 mr-auto">
                    @foreach($project->subsidiaries as $item)
                        <a type="button" href="{{route('projects.activities', [$project->id, $item->company->id])}}"
                           class="btn btn-sm btn-outline-secondary waves-effect waves-themed {{$company==$item->company->id ? 'active':''}}">
                            {{$item->company->name}}
                        </a>
                    @endforeach
                </div>
                <div class="w-25 ml-auto">
                    <input id="gantt_zoom" type="text" value="">
                </div>
            </div>

            <div class="gantt_control">
                <button id="toggle_fullscreen" onclick="gantt.ext.fullscreen.toggle();">Pantalla completa</button>
                <button onclick="updateCriticalPath(this)">Ver ruta crítica</button>
                <button type="button" data-toggle="modal" data-target="#project-activities-weight" data-id="{{ $project->id }}">
                    {{ __('general.weight') }} {{ trans_choice('general.result', 2) }}
                </button>
                <button type="button" data-toggle="modal" data-target="#project-activities-wbs" data-id="{{ $project->id }}">
                    WBS
                </button>
            </div>

            <div id="gantt_here" style='width:100%;height: 100%' class="gantt_skin_terrace"></div>
            <div id="gantt_dropdown">
                <h2>Dropdown here</h2>
            </div>
            <div wire:ignore>
                <livewire:projects.activities.project-show-activity-weight :project="$project"/>
            </div>
            <div wire:ignore>
                <livewire:projects.activities.project-show-activities-wbs :projectId="$project->id"/>
            </div>
            <div wire:ignore>
                <livewire:projects.activities.project-register-advance-activity/>
            </div>
        </div>
    </div>
@endsection


@push('page_script')
    <script>
        Livewire.on('toggleRegisterAdvanceActivity', () => $('#register-advance-activity').modal('toggle'));
        Livewire.on('closeModalResultsWeight', () => $('#project-activities-weight').modal('toggle'));

        function updateCriticalPath(toggle) {
            toggle.enabled = !toggle.enabled;
            if (toggle.enabled) {
                toggle.innerHTML = "Ocultar ruta crítica";
                gantt.config.highlight_critical_path = true;
            } else {
                toggle.innerHTML = "Ver ruta crítica";
                gantt.config.highlight_critical_path = false;
            }
            gantt.render();
        }

        function getDropdownNode() {
            return document.querySelector("#gantt_dropdown");
        }

        Livewire.on('toggleShowModal', () => $('#show-activity-task').modal('toggle'));
        $(() => {
            let labels = ['Horas', 'Días', 'Semanas', 'Meses', 'Cuartos', 'Años'];
            let values = ['hour', 'day', 'week', 'month', 'quarter', 'year'];
            $('#gantt_zoom').ionRangeSlider(
                {
                    skin: 'round',
                    prefix: 'Zoom: ',
                    grid: true,
                    grid_num: 0,
                    hide_min_max: true,
                    values: [0, 1, 2, 3, 4, 5],
                    prettify: function (n) {
                        return labels[n];
                    },
                    onFinish: function (data) {
                        gantt.ext.zoom.setLevel(values[data.from]);
                    }
                }
            );

            gantt.i18n.setLocale("es");
            gantt.config.date_format = "%Y-%m-%d %H:%i";
            gantt.config.date_grid = "%d/%m/%Y %H:%i";
            gantt.config.grid_width = 700;
            gantt.config.order_branch = true;
            gantt.config.autosize = "y";

            // Critical path
            gantt.plugins({
                critical_path: true,
                auto_scheduling: true,
                marker: true,
                tooltip: true,
                fullscreen: true,
                grouping: true,
            });

            gantt.config.highlight_critical_path = true;
            gantt.config.auto_scheduling = true;

            gantt.config.work_time = true;
            gantt.config.skip_off_time = true;

            gantt.config.fit_tasks = true;
            gantt.config.duration_unit = 'hour';
            gantt.config.duration_step = 1;
            gantt.config.row_height = 40;
            gantt.config.root_id = "root";
            gantt.config.types.button = "button";

            gantt.config.root_task_id = "";
            gantt.config.task_scroll_offset = 120;

            gantt.config.scales = [
                {unit: "month", step: 1, format: "%F, %Y"},
                {unit: "day", step: 1, format: "%d %M"}
            ];

            gantt.config.resource_property = "owner";
            gantt.config.open_tree_initially = true;
            gantt.config.scale_height = 50;

            var resourceMode = "hours";

            gantt.$resourcesStore = gantt.createDatastore({
                name: gantt.config.resource_store,
                type: "treeDatastore",
                initItem: function (item) {
                    item.parent = item.parent || gantt.config.root_id;
                    item[gantt.config.resource_property] = item.parent;
                    item.open = true;
                    return item;
                }
            });

            gantt.$resourcesStore.attachEvent("onAfterSelect", function (id) {
                gantt.refreshData();
            });

            let formatter = gantt.ext.formatters.durationFormatter({
                enter: "hour",
                store: "hour",
                short: true,
                format: "auto",
                labels: {
                    minute: {
                        full: "minuto",
                        plural: "minutos",
                        short: "min"
                    },
                    hour: {
                        full: "hora",
                        plural: "horas",
                        short: "h"
                    },
                    day: {
                        full: "día",
                        plural: "días",
                        short: "d"
                    },
                    week: {
                        full: "semana",
                        plural: "semanas",
                        short: "wk"
                    },
                    month: {
                        full: "mes",
                        plural: "meses",
                        short: "m"
                    },
                    year: {
                        full: "año",
                        plural: "años",
                        short: "y"
                    }
                }
            });
            let linksFormatter = gantt.ext.formatters.linkFormatter({durationFormatter: formatter});

            gantt.serverList("user", [

                {
                    key: 0, label: "N/A"
                },
                    @foreach($users as $user)
                {
                    key: {{$user->id}}, label: "{{$user->name}}"
                },
                @endforeach
            ]);

            gantt.serverList("usuario", [

                {
                    key: 0, label: "N/A"
                },
                    @foreach($users as $user)
                {
                    key: {{$user->id}}, label: "{{$user->name}}"
                },
                @endforeach
            ]);

            gantt.serverList("company", [

                {
                    key: 0, label: "N/A"
                },
                    @foreach($companies as $item)
                {
                    key: {{$item->id}}, label: "{{$item->name}}"
                },
                @endforeach
            ]);

            let editors = {
                text: {type: "text", map_to: "text"},
                start_date: {type: "date", map_to: "start_date"},
                end_date: {type: "date", map_to: "end_date"},
                progress: {type: "number", map_to: "progress"},
                duration: {type: "duration", map_to: "duration", min: 0, max: 100, formatter: formatter},
                predecessors: {type: "predecessor", map_to: "auto"},
                owner: {type: "select", height: 22, options: gantt.serverList("user"), map_to: "owner"},
                owner_id: {type: "select", height: 22, options: gantt.serverList("usuario"), map_to: "owner_id"},
                company: {type: "select", height: 22, options: gantt.serverList("company"), map_to: "company_id"},
            };

            gantt.addMarker({
                start_date: gantt.date.date_part(new Date()),
                css: "today",
                text: "Hoy",
                title: "Hoy"
            });

            let getWBSCodeOriginal = gantt.getWBSCode;
            gantt.getWBSCode = function (task) {
                const wbs = getWBSCodeOriginal.apply(this, arguments);
                if (!wbs) {
                    return '';
                }
                let resultWBS = wbs.substring(wbs.indexOf(".") + 1);

                if (task.$level === 0) {
                    return '';
                }
                return resultWBS;
            };

            let originalCreateTask = gantt.createTask;
            gantt.createTask = function () {
                const task = arguments[0];

                if (task && task.type === gantt.config.types.milestone) {
                    task.duration = 0;
                }
                let taskId = originalCreateTask.apply(this, arguments);
                gantt.unselectTask();

                return taskId;
            };

            const formatTaskName = function (e) {
                return e ? e.replace(/</g, "&lt;").replace(/>/g, "&gt;") : e
            }

            function byId(list, id) {
                for (var i = 0; i < list.length; i++) {
                    if (list[i].key == id)
                        return list[i].label || "";
                }
                return "";
            }


            gantt.config.columns = [
                {
                    name: "wbs",
                    label: "wbs",
                    resize: true,
                    width: 45,
                    min_width: 45,
                    max_width: 45,
                    template: function (e) {
                        return e.type !== gantt.config.types.button ? gantt.getWBSCode(e) : '';
                    }
                },
                {
                    name: "text",
                    label: "Nombre",
                    resize: true,
                    tree: true,
                    min_width: 50,
                    width: 300,
                    editor: editors.text,
                    template: function (e) {
                        if (e.type === gantt.config.types.button) {
                            return "<div class='btn-control'>" +
                                "       <div class='buttons d-flex align-items-center'>" +
                                "           <i class='fas fa-plus-circle mr-1'></i>" +
                                "           <span class='button add_task' data-action='add-task'>Actividad</span>" +
                                "           <span class='button add_task' data-action='add-milestone'>Hito</span>" +
                                "           <span class='button' data-action='add-activity'>Resultado</span>" +
                                "       </div>" +
                                "   </div>" +
                                "<input type='text' class='crate_task_input'>";
                        }
                        return formatTaskName(e.text).trim()
                    },
                    onrender: function (e, node) {
                        if (e.type === gantt.config.types.button)
                            node.classList.add('text_cell');
                    }
                },
                {
                    name: "start_date",
                    label: "Fecha de inicio",
                    resize: true,
                    align: "center",
                    min_width: 90,
                    width: 130,
                    editor: editors.start_date,
                    template: function (e) {
                        return e.type === gantt.config.types.button ? "" : e.start_date
                    },
                    onrender: function (e, node) {
                        if (e.type === gantt.config.types.button)
                            node.remove();
                    }
                },
                {
                    name: "company_id",
                    label: "Junta",
                    width: 80,
                    align: "center",
                    editor: editors.company,
                    template: function (item) {
                        return byId(gantt.serverList('company'), item.company_id)
                    }
                },
                {
                    name: "owner_id",
                    align: "center",
                    width: 80,
                    editor: editors.owner_id,
                    label: "Responsable",
                    template: function (task) {
                        return byId(gantt.serverList('usuario'), task.owner_id)
                    }
                },
                {
                    name: "duration",
                    label: "Duración",
                    resize: true,
                    align: "right",
                    editor: editors.duration,
                    template: function (e) {
                        if (e.type === gantt.config.types.button || e.type === gantt.config.types.milestone)
                            return "";
                        return formatter.format(e.duration);
                    },
                    onrender: function (e, node) {
                        if (e.type === gantt.config.types.button)
                            node.remove();
                    }
                },
                {
                    name: "progress",
                    label: "Progreso",
                    resize: true,
                    align: "center",
                    editor: editors.progress,
                    template: function (e) {
                        if (e.progress >= 1)
                            return "100%";
                        if (e.progress === 0)
                            return "0%";
                        return e.type === gantt.config.types.button ? "" : Math.round(e.progress * 100).toFixed(0) + '%'
                    },
                    onrender: function (e, node) {
                        if (e.type === gantt.config.types.button)
                            node.remove();
                    }
                },
                {
                    name: "predecessors",
                    label: "Predecesor",
                    width: 80,
                    align: "left",
                    editor: editors.predecessors,
                    resize: true,
                    template: function (task) {
                        let links = task.$target;
                        let labels = [];
                        for (let i = 0; i < links.length; i++) {
                            let link = gantt.getLink(links[i]);
                            labels.push(linksFormatter.format(link));
                        }
                        return labels.join(", ")
                    }
                },
                {
                    name: "owner", align: "center", width: 75, label: "Usuarios Asignados", template: function (task) {
                        if (task.type === gantt.config.types.project) {
                            return "";
                        }
                        let store = gantt.getDatastore("resource");
                        let assignments = task[gantt.config.resource_property];

                        if (!assignments || !assignments.length) {
                            return "Sin Asignar";
                        }
                        if (assignments.length === 1) {
                            return store.getItem(assignments[0].resource_id).text;
                        }
                        let result = "";
                        assignments.forEach(function (assignment) {
                            let owner = store.getItem(assignment.resource_id);
                            if (!owner)
                                return;
                            result += "<div class='owner-label' title='" + owner.text + "'>" + owner.text.substr(0, 1) + "</div>";
                        });
                        return result;
                    }, resize: true
                },
            ];

            function getResourceAssignments(resourceId) {
                var assignments;
                var store = gantt.getDatastore(gantt.config.resource_store);
                var resource = store.getItem(resourceId);

                if (resource.$level === 0) {
                    assignments = [];
                    store.getChildren(resourceId).forEach(function (childId) {
                        assignments = assignments.concat(gantt.getResourceAssignments(childId));
                    });
                } else if (resource.$level === 1) {
                    assignments = gantt.getResourceAssignments(resourceId);
                } else {
                    assignments = gantt.getResourceAssignments(resource.$resource_id, resource.$task_id);
                }
                return assignments;
            }

            var resourceConfig = {
                columns: [
                    {
                        name: "name", label: "Name", tree: true, template: function (e) {
                            console.log('llego aqui');
                            return e.text;
                        }
                    }
                ]
            };

            gantt.templates.resource_cell_class = function (start_date, end_date, resource, tasks) {
                var css = [];
                css.push("resource_marker");
                if (tasks.length <= 1) {
                    css.push("workday_ok");
                } else {
                    css.push("workday_over");
                }
                return css.join(" ");
            };

            gantt.templates.resource_cell_value = function (start_date, end_date, resource, tasks) {
                var result = 0;
                tasks.forEach(function (item) {
                    var assignments = gantt.getResourceAssignments(resource.id, item.id);
                    assignments.forEach(function (assignment) {
                        var task = gantt.getTask(assignment.task_id);
                        result += assignment.value * 1;
                    });
                });
                if (result % 1) {
                    result = Math.round(result * 10) / 10;
                }
                return "<div>" + result + "</div>";
            };

            gantt.locale.labels.section_resources = "Owners";
            gantt.config.lightbox.sections = [
                {name: "description", height: 38, map_to: "text", type: "textarea", focus: true},
                {name: "resources", type: "resources", map_to: "owner", options: gantt.serverList("user"), default_value: 8},
                {name: "owner_id", type: "select", map_to: "owner_id", options: gantt.serverList("usuario")},
                {name: "time", type: "duration", map_to: "auto"}
            ];

            gantt.config.resource_store = "resource";
            gantt.config.resource_property = "owner";
            gantt.config.order_branch = true;
            gantt.config.open_tree_initially = true;


            gantt.config.layout = {
                css: "gantt_container",
                rows: [
                    {
                        gravity: 2,
                        cols: [
                            {view: "grid", group: "grids", scrollY: "scrollVer"},
                            {resizer: true, width: 1},
                            {view: "timeline", scrollX: "scrollHor", scrollY: "scrollVer"},
                            {view: "scrollbar", id: "scrollVer", group: "vertical"}
                        ]
                    },
                    {resizer: true, width: 1},
                    {view: "scrollbar", id: "scrollHor"}
                ]
            };

            gantt.$resourcesStore.attachEvent("onParse", function () {
                var people = [];
                gantt.$resourcesStore.eachItem(function (res) {
                    if (!gantt.$resourcesStore.hasChild(res.id)) {
                        var copy = gantt.copy(res);
                        copy.key = res.id;
                        copy.label = res.text;
                        people.push(copy);
                    }
                });
                gantt.updateCollection("user", people);
            });

            gantt.$resourcesStore.parse([
                {id: '', text: "Sin Asignar", parent: null},
                    @foreach($users as $user)
                {
                    id: '{{$user->id}}', text: "{{$user->name}}", label: "{{$user->name}}", parent: null, unit: "hours/day"
                },
                @endforeach
            ]);

            //* END MULTIPLE RESOURCES **/

            var allColumns = gantt.config.columns;

            //  Scales
            let zoomConfig = {
                levels: [
                    {
                        name: "hour",
                        scale_height: 38,
                        min_column_width: 20,
                        min_duration: 30,
                        scales: [
                            {unit: "day", step: 1, format: "%d %M"},
                            {unit: "hour", step: 1, format: "%H"}
                        ]
                    },
                    {
                        name: "day",
                        scale_height: 38,
                        min_column_width: 26,
                        scales: [
                            {unit: "month", step: 1, format: "%F %Y"},
                            {
                                unit: "day", step: 1, format: "%d", css: function (e) {
                                    return (e.getDay() === 0 || e.getDay() === 6) ? "" : " weekend";
                                }
                            }
                        ]
                    },
                    {
                        name: "week",
                        scale_height: 38,
                        min_column_width: 70,
                        min_duration: 30,
                        scales: [
                            {unit: "month", step: 1, date: "%F %Y"},
                            {
                                unit: "week", step: 1, index: 1,
                                template: function (e) {
                                    let t = e.getDay(), n = new Date(e.valueOf());
                                    n.setDate(e.getDate() + (4 - t));
                                    let i = n.getFullYear()
                                        , a = Math.round((n.getTime() - new Date(i, 0, 1).getTime()) / 864e5)
                                        , r = 1 + Math.floor(a / 7)
                                        , o = e.getDate()
                                        , s = e;
                                    s.setDate(s.getDate() + 6);
                                    let l = s.getDate();
                                    return '<span title="Fecha Inicio y fin de la semana">' + o + "-" + l + '</span>&nbsp;<span title="Número de la semana">' +
                                        '(' + r + ")</span>"
                                }
                            }
                        ]
                    },
                    {
                        name: "month",
                        scale_height: 38,
                        step: 1,
                        min_column_width: 65,
                        scales: [
                            {unit: "year", step: 1, format: "%Y"},
                            {unit: "month", step: 1, format: "%M"}
                        ]
                    },
                    {
                        name: "quarter",
                        scale_height: 38,
                        min_column_width: 45,
                        scales: [
                            {
                                unit: "quarter",
                                step: 1,
                                format: function (e) {
                                    return "Cuarto " + " " + Math.ceil((e.getMonth() + 1) / 3) + ", " + e.getFullYear()
                                }
                            }, {
                                unit: "month",
                                step: 1,
                                format: "%M"
                            }
                        ]
                    },
                    {
                        name: "year",
                        scale_height: 38,
                        min_column_width: 45,
                        scales: [
                            {unit: "year", step: 1, format: "%Y"}
                        ]
                    }
                ]
            };

            gantt.ext.zoom.init(zoomConfig);
            gantt.ext.zoom.setLevel("hour");

            gantt.templates.task_class = function (start, end, task) {
                if (task.type === gantt.config.types.project && task.id === gantt.config.root_task_id)
                    return "project_estimate";

                if (task.type === gantt.config.types.project)
                    return "hide_project_progress_drag";
                if (task.progress > 0.5) {
                    return "";
                } else {
                    return "important";
                }
            };

            //critical path
            gantt.templates.timeline_cell_class = function (task, date) {
                if (date.getDay() === 0 || date.getDay() === 6)
                    return "weekend";
                if (!gantt.isWorkTime({date: date, task: task}))
                    return "week_end";
                return "";
            };

            // Open/close sign
            gantt.templates.grid_open = function (item) {
                return "<div class='gantt_tree_icon gantt_" +
                    (item.$open ? "close" : "open") + "'><i class='fas fa-caret-" + (item.$open ? "down" : "right") + "'></i></div>";
            };

            gantt.templates.rightside_text = function (start, end, task) {
                if (task.type === gantt.config.types.milestone) {
                    return task.text;
                }
                return "";
            };

            gantt.attachEvent("onTaskDblClick", function (id, e) {
                // window.livewire.emitTo('projects.activities.project-show-activity-task', 'openModal', {id: id});
                window.livewire.emitTo('projects.activities.project-register-advance-activity', 'openAdvance', {id: id, isGantt: true});
                // let task = gantt.getTask(id);
                // return task.type !== gantt.config.types.button;
            });

            gantt.attachEvent("onTaskClick", function (id, e) {
                let button = e.target.closest("[data-action]")
                let task = gantt.getTask(id);
                if (button && task.type === gantt.config.types.button) {
                    let action = button.getAttribute("data-action");
                    switch (action) {
                        case "add-task":
                            createInputTask(e, task, gantt.config.types.task)
                            break;
                        case "add-milestone":
                            createInputTask(e, task, gantt.config.types.milestone);
                            break;
                        case "add-activity":
                            addNew(gantt.config.types.project, task.parent)
                            break;
                    }
                    return false;
                }
                return true;
            });

            gantt.attachEvent("onTaskOpened", (function (e) {
                let task = gantt.getTask(e);
                task.open = 1;
                gantt.updateTask(e, task);
            }));

            gantt.attachEvent("onTaskClosed", (function (e) {
                let task = gantt.getTask(e);
                task.open = 0;
                gantt.updateTask(e, task);
            }));

            //prevent moving to another sub-branch:
            gantt.attachEvent("onBeforeTaskMove", function (id, parent, tindex) {
                let task = gantt.getTask(id);
                return task.parent === parent;

            });

            gantt.ext.inlineEditors.attachEvent("onSave", function (state) {
                let col = state.columnName;
                if (gantt.autoSchedule && (col === "start_date" || col === "end_date" || col === "duration")) {
                    gantt.autoSchedule();
                }
            });

            // Prevent inline edit for some column and task types
            gantt.ext.inlineEditors.attachEvent("onBeforeEditStart", function (state) {
                let task = gantt.getTask(state.id);
                let col = state.columnName;
                if (task.type === gantt.config.types.button || (task.type === gantt.config.types.project && task.id === gantt.config.root_task_id))
                    return false;

                if (col === 'duration' && task.type === gantt.config.types.milestone)
                    return false;

                return !(col === 'progress' && task.type === gantt.config.types.project);

            });

            gantt.ext.inlineEditors.attachEvent("onEditStart", function (state) {
                if (state.columnName === "progress") {
                    let task = gantt.getTask(state.id);
                    let element = document.querySelector("input[name='progress']")
                    element.value = Math.round(element.value * 100).toFixed(0);
                }
            });

            gantt.ext.inlineEditors.attachEvent("onBeforeSave", function (state) {
                if (state.columnName === "progress")
                    state.newValue /= 100;
                return true;
            });

            // automatically change the scale while dragging a task
            gantt.attachEvent("onTaskDrag", function (id, mode, task, original) {
                let state = gantt.getState();
                let minDate = state.min_date,
                    maxDate = state.max_date;

                let scaleStep = gantt.date.add(new Date(), state.scale_step, state.scale_unit) - new Date();

                let showDate,
                    repaint = false;
                if (mode === "resize" || mode === "move") {
                    if (Math.abs(task.start_date - minDate) < scaleStep) {
                        showDate = task.start_date;
                        repaint = true;

                    } else if (Math.abs(task.end_date - maxDate) < scaleStep) {
                        showDate = task.end_date;
                        repaint = true;
                    }

                    if (repaint) {
                        gantt.render();
                        gantt.showDate(showDate);
                    }
                }
            });


            gantt.init("gantt_here");

            @if(!is_null($company))
            gantt.load("/projects/{{ $project->id }}/gantt/data/{{$company}}");
            let dp = gantt.dataProcessor("/projects/{{ $project->id }}/gantt");

            @else

            gantt.load("/projects/{{ $project->id }}/gantt/data");
            let dp = gantt.dataProcessor("/projects/{{ $project->id }}/gantt");

            @endif


            dp.init(gantt);
            dp.setTransactionMode({
                mode: "REST",
                payload: {
                    _token: "{{ csrf_token() }}"
                }
            }, true);

            dp.attachEvent("onBeforeDataSending", function (id, state, data) {
                return !(!state.length || data.type === gantt.config.types.button);
            });

            dp.attachEvent("onAfterUpdate", function (id, action, tid, response) {
                let a = {};

                let method = null;

                if (response['method'] != null) {

                    method = response['method'];

                }

                if ("inserted" === action && (a = gantt.isTaskExists(tid) && gantt.getTask(tid)) && a.type === gantt.config.types.project && method == null) {

                    afterCreateNewActivity(tid);

                }
            });

            // recalculate progress of summary tasks when the progress of subtasks changes
            (function dynamicProgress() {

                function calculateSummaryProgress(task) {
                    if (task.type !== gantt.config.types.project)
                        return task.progress;
                    let totalToDo = 0;
                    let totalDone = 0;
                    gantt.eachTask(function (child) {
                        if (child.type !== gantt.config.types.project) {
                            totalToDo += child.duration;
                            totalDone += (child.progress || 0) * child.duration;
                        }
                    }, task.id);
                    if (!totalToDo) return 0;
                    else return totalDone / totalToDo;
                }

                function refreshSummaryProgress(id, submit) {
                    if (!gantt.isTaskExists(id))
                        return;

                    let task = gantt.getTask(id);
                    task.progress = calculateSummaryProgress(task);

                    if (!submit) {
                        gantt.refreshTask(id);
                    } else {
                        gantt.updateTask(id);
                    }

                    if (!submit && gantt.getParent(id) !== gantt.config.root_id) {
                        refreshSummaryProgress(gantt.getParent(id), submit);
                    }
                }

                gantt.attachEvent("onParse", function () {
                    gantt.eachTask(function (task) {
                        if (task.parent === gantt.config.root_id)
                            gantt.config.root_task_id = task.id;
                        task.progress = calculateSummaryProgress(task);
                        addCustomButtonInParent(task);
                    });
                });

                gantt.attachEvent("onAfterTaskUpdate", function (id) {
                    refreshSummaryProgress(gantt.getParent(id), true);
                });

                gantt.attachEvent("onTaskDrag", function (id) {
                    refreshSummaryProgress(gantt.getParent(id), false);
                });
                gantt.attachEvent("onAfterTaskAdd", function (id) {
                    refreshSummaryProgress(gantt.getParent(id), true);
                });


                (function () {
                    let idParentBeforeDeleteTask = 0;
                    gantt.attachEvent("onBeforeTaskDelete", function (id) {
                        idParentBeforeDeleteTask = gantt.getParent(id);
                    });
                    gantt.attachEvent("onAfterTaskDelete", function () {
                        refreshSummaryProgress(idParentBeforeDeleteTask, true);
                    });
                })();
            })();

            const addCustomButtonInParent = function (task) {
                if (task.parent !== gantt.config.root_id && task.type === gantt.config.types.project) {
                    gantt.addTask({
                        unscheduled: !0,
                        auto_scheduling: !1,
                        type: gantt.config.types.button,
                        gantt_id: task.gantt_id,
                        sortorder: 1e4
                    }, task.id)
                }
            }

            const createInputTask = function (e, task, type) {
                document.querySelectorAll('.gantt_row').forEach(el => el.classList.remove('active'))
                e.target.closest(".gantt_row").classList.add('active');
                let input = e.target.closest(".gantt_tree_content").querySelector('input');
                input.focus();
                input.addEventListener("blur", function (event) {
                    input.closest(".gantt_row").classList.remove('active');
                }, true);
                input.addEventListener("keydown", function (event) {
                    if (event.keyCode === 13) {
                        event.preventDefault();
                        addNew(type, task.parent, input.value)
                        document.querySelectorAll('.gantt_row').forEach(el => el.classList.remove('active'));
                        input.value = '';
                    }
                });
            };

            const addNew = function (type, tid, text) {
                let i = {};
                i.type = type;
                i.text = text && text.trim() || 'Nueva Actividad';
                i.type === gantt.config.types.project ? (i.text = 'Nuevo Resultado', i.open = 1) : '';
                i.type === gantt.config.types.milestone && (i.text = text && text.trim() || 'Nuevo Hito');
                i.start_date = gantt.date.date_part(new Date());
                i.duration = 1;

                let order = calculateSortOrderForTask(type, tid);
                i.sortorder = order.sortorder;
                gantt.addTask(i, i.type === gantt.config.types.project ? gantt.config.root_task_id : tid, order.index);
            }

            const afterCreateNewActivity = function (tid) {
                addNew(gantt.config.types.task, tid);
                addCustomButtonInParent(gantt.getTask(tid));
                gantt.open(tid);
            }

            const calculateSortOrderForTask = function (type, tid) {
                let t = gantt.getTask(tid);
                if (gantt.config.types.project === type) {
                    return {
                        index: gantt.getTaskIndex(tid) + 1,
                        sortorder: t && t.sortorder + 1 || 1
                    }
                }
                let children = _.filter(_.map(gantt.getChildren(tid), (function (e) {
                        return gantt.getTask(e)
                    }
                )), (function (e) {
                        return "button" !== e.type
                    }
                ));
                return {
                    index: children && children.length || 0,
                    sortorder: children && children.length ? +children[children.length - 1].sortorder + 1 : 1
                }
            };

            if (!window.ganttModules) {
                window.ganttModules = {};
            }

            //tooltip
            gantt.attachEvent("onGanttReady", function () {
                var tooltips = gantt.ext.tooltips;
                tooltips.tooltip.setViewport(gantt.$task_data);
                var radios = [].slice.call(gantt.$container.querySelectorAll("input[type='radio']"));
                radios.forEach(function (r) {
                    gantt.event(r, "change", function (e) {
                        var radios = [].slice.call(gantt.$container.querySelectorAll("input[type='radio']"));
                        radios.forEach(function (r) {
                            r.parentNode.className = r.parentNode.className.replace("active", "");
                        });

                        if (this.checked) {
                            resourceMode = this.value;
                            this.parentNode.className += " active";
                            gantt.getDatastore(gantt.config.resource_store).refresh();
                        }
                    });
                });
            });
            gantt.ext.fullscreen.getFullscreenElement = function () {
                return document.getElementById("myCover");
            }

            gantt.templates.progress_text = function (start, end, task) {
                return "<span style='text-align:left;'>" + Math.round(task.progress * 100) + "% </span>";
            };

            //dropdown menu

            gantt.$showDropdown = function (node) {
                var position = node.getBoundingClientRect();
                var dropDown = getDropdownNode();
                dropDown.style.top = position.bottom + "px";
                dropDown.style.left = position.left + "px";
                dropDown.style.display = "block";
                populateColumnsDropdown(dropDown);

                dropDown.onchange = function () {
                    var selection = getColumnsSelection(dropDown);
                    gantt.config.columns = createColumnsConfig(selection);
                    gantt.render();
                }

                dropDown.keep = true;
                setTimeout(function () {
                    dropDown.keep = false;
                })
            }
            gantt.$hideDropdown = function () {
                var dropDown = getDropdownNode();
                dropDown.style.display = "none";

            }

            window.addEventListener("click", function (event) {
                if (!event.target.closest("#gantt_dropdown") && !getDropdownNode().keep) {
                    gantt.$hideDropdown();
                }
            });

            function populateColumnsDropdown(node) {
                var visibleColumns = {};
                gantt.config.columns.forEach(function (col) {
                    visibleColumns[col.name] = true;
                });

                var lines = [];
                allColumns.forEach(function (col) {
                    var checked = visibleColumns[col.name] ? "checked" : "";
                    lines.push("<label><input type='checkbox' name='" + col.name + "' " + checked + ">" + col.label + "</label>");
                });
                node.innerHTML = lines.join("<br>");
            }

            function getColumnsSelection(node) {
                var selectedColumns = node.querySelectorAll(":checked");
                var checkedColumns = {};
                selectedColumns.forEach(function (node) {
                    checkedColumns[node.name] = true;
                });
                return checkedColumns;
            }

            function createColumnsConfig(selectedColumns) {
                var newColumns = [];

                allColumns.forEach(function (column) {
                    if (selectedColumns[column.name]) {
                        newColumns.push(column);
                    }
                });

                newColumns.push(controlsColumn);
                return newColumns;
            }

            var colHeader = '<div class="gantt_grid_head_cell gantt_grid_head_add" onclick="gantt.createTask()"></div><div class="gantt-dropdown" onclick="gantt.$showDropdown(this)">&#9660;</div>';

            var controlsColumn = {
                name: "buttons", label: colHeader, width: 75, template: function (task) {
                    return (
                        ''
                    );
                }
            }

            gantt.config.columns = createColumnsConfig({
                wbs: true,
                text: true,
                progress: true,
                start_date: true,
                company_id: true,
                end_date: true,
                duration: true,
                owner: true,
                owner_id: true,
            })
            ganttModules.grid_struct = (function (gantt) {
                gantt.config.font_width_ratio = 7;
                gantt.templates.leftside_text = function leftSideTextTemplate(start, end, task) {
                    if (getTaskFitValue(task) === "left") {
                        return task.text;
                    }
                    return "";
                };
                gantt.templates.rightside_text = function rightSideTextTemplate(start, end, task) {
                    if (getTaskFitValue(task) === "right") {
                        return task.text;
                    }
                    return "";
                };
                gantt.templates.task_text = function taskTextTemplate(start, end, task) {
                    if (getTaskFitValue(task) === "center") {
                        return task.text;
                    }
                    return "";
                };

                function getTaskFitValue(task) {
                    let taskStartPos = gantt.posFromDate(task.start_date),
                        taskEndPos = gantt.posFromDate(task.end_date);

                    let width = taskEndPos - taskStartPos;
                    let textWidth = (task.text || "").length * gantt.config.font_width_ratio;

                    if (width < textWidth) {
                        let ganttLastDate = gantt.getState().max_date;
                        let ganttEndPos = gantt.posFromDate(ganttLastDate);
                        if (ganttEndPos - taskEndPos < textWidth) {
                            return "left"
                        } else {
                            return "right"
                        }
                    } else {
                        return "center";
                    }
                }
            })(gantt);

        });

    </script>
@endpush



