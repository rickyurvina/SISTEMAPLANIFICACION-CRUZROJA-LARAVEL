<div class="project-line subheader-block d-lg-flex align-items-center">
    <div class="d-flex align-items-center p-2 mr-6">
        <div class="d-flex align-items-center">
            <h2>{{strlen($project->name)>10? substr($project->name,0,10).'...':$project->name}}</h2>
            <div id="circularMenu1" class="circular-menu circular-menu-left" style="z-index: 99">
                <a class="floating-btn"
                   onclick="document.getElementById('circularMenu1').classList.toggle('active');">
                    <i class="fa fa-bars"></i>
                </a>
                <menu class="items-wrapper">
                    @can('project-view-files'||'manage-files')
                        <a href="{{ route('projects.files', $project->id) }}"
                           class="menu-item fal fa-paperclip" data-toggle="tooltip"
                           data-original-title="Ver Archivos"></a>
                    @endcan

                    @can('project-view-events'||'project-manage-events')
                        <a href="{{ route('projects.events', $project->id) }}"
                           class="menu-item fal fa-line-height" data-toggle="tooltip"
                           data-original-title="Ver Sucesos"></a>
                    @endcan

                    @can('project-view-reports')
                        <a href="{{ route('projects.reportsIndex', $project->id) }}"
                           class="menu-item fal fa-table" data-toggle="tooltip"
                           data-original-title="Reportes"></a>
                    @endcan

                    @can('project-view-learnedLessons'||'project-manage-learnedLessons')
                        <a href="{{ route('projects.lessons_learned', $project->id) }}"
                           class="menu-item fal fa-book-open" data-toggle="tooltip"
                           data-original-title="Lecciones Aprendidas"></a>
                    @endcan

                    @can('project-view-validations'||'project-manage-validations')
                        <a href="{{ route('projects.validations', $project->id) }}"
                           class="menu-item fal fa-check-circle" data-toggle="tooltip"
                           data-original-title="Validaciones"></a>
                    @endcan

                    @can('project-view-reschedulings'||'project-manage-reschedulings')
                        <a href="{{ route('projects.reschedulings', $project->id) }}"
                           class="menu-item fal fa-clock" data-toggle="tooltip"
                           data-original-title="Reprogramaciones"></a>
                    @endcan

                    @can('project-view-evaluations'||'project-manage-evaluations')
                        <a href="{{ route('projects.evaluations', $project->id) }}"
                           class="menu-item fal fa-book-medical" data-toggle="tooltip"
                           data-original-title="Evaluaciones"></a>
                    @endcan

                    @can('project-view-administrativeTasks'||'project-manage-administrativeTasks')
                        <a href="{{ route('projects.administrativeTasks', $project->id) }}"
                           class="menu-item far fa-address-card" data-toggle="tooltip"
                           data-original-title="Actividades Administrativas"></a>
                    @endcan
                </menu>
            </div>
        </div>
    </div>
</div>