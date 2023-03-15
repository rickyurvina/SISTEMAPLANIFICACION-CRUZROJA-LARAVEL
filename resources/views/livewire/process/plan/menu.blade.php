@can('view-process-information-process')
    <div class=" mt-1">
        <a href="{{ route('process.showInformation', [$process->id, $page]) }}"
           class="btn {{ $subMenu == 'showInformation' ? 'btn-success':' btn-info' }} mr-2">
                        <span
                                data-placement="top" title="Información del Proceso"
                                data-original-title="Información del Proceso">
                          <i class="fas fa-eye mr-1 "></i>  Información del Proceso </span>
        </a>
    </div>
@endcan

@can('view-activities-process-process'||'manage-activities-process-process')
    <div class=" mt-1">
        <a href="{{ route('process.showActivities',[$process->id, $page]) }}"
           class="btn  {{ $subMenu == 'showActivities' ? 'btn-success':' btn-info' }} mr-2">
                <span
                        data-placement="top" title="Actividades"
                        data-original-title="Actividades">
                     <i class="fas fa-arrow-alt-from-top  mr-1"></i>Actividades</span>
        </a>
    </div>
@endcan

@can('view-indicators-process'||'manage-indicators-process')
    <div class=" mt-1">
        <a href="{{ route('process.showIndicators', [$process->id, $page]) }}"
           class="btn {{ $subMenu == 'showIndicators' ? 'btn-success':' btn-info' }} mr-2">
                        <span
                                data-placement="top" title="Indicadores"
                                data-original-title="Indicadores">
                    <i class="fas fa-arrow-alt-square-up  mr-1"></i>{{trans_choice('general.indicators',2)}}</span>
        </a>
    </div>
@endcan

@can('view-risks-process-process'||'manage-risks-process-process')
    <div class=" mt-1">
        <a href="{{ route('process.showRisks', [$process->id, $page]) }}"
           class="btn  {{ $subMenu == 'showRisks' ? 'btn-success':' btn-info' }} mr-2">
                        <span
                                data-placement="top" title="Gestión de Riesgos"
                                data-original-title="Gestión de Riesgos">
                          <i class="fas fa-engine-warning  mr-1"></i>Gestión de Riesgos</span>
        </a>
    </div>
@endcan

@can('view-changes-process'||'manage-changes-process')
    <div class=" mt-1">
        <a href="{{ route('process.showPlanChanges', [$process->id, $page]) }}"
           class="btn  {{ $subMenu == 'showPlanChanges' ? 'btn-success':' btn-info' }} mr-2">
                        <span
                                data-placement="top" title="Planificación de Cambios"
                                data-original-title="Planificación de Cambios">
                    <i class="fas fa-calendar-check  mr-1"></i>Planificación de Cambios</span>
        </a>
    </div>
@endcan

@can('view-files-process-process'||'manage-files-process-process')
    <div class=" mt-1">
        <a href="{{ route('process.showFiles', [$process->id, $page]) }}"
           class="btn  {{ $subMenu == 'showFiles' ? 'btn-success':' btn-info' }} mr-2">
                        <span
                                data-placement="top" title="Indicadores"
                                data-original-title="Indicadores">
                    <i class="fas fa-paperclip  mr-1"></i>Archivos</span>
        </a>
    </div>
@endcan


