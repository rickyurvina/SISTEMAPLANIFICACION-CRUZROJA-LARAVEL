@if(session('company_id')===$project->company_id || in_array(session('company_id'),$project->subsidiaries->pluck('company_id')->toArray()))
    <div class="frame-wrap mb-3">
        <div class="d-flex d-flex-row">
            @if($project->phase instanceof \App\States\Project\StartUp)
                @can('project-manage-indexCard')
                    <a href="{{ route('projects.showIndex', $project->id) }}">
                                    <span class="btn btn-sm {{ $page == 'act' ? 'btn-success':' btn-info' }} mr-2"
                                          data-placement="top" title="Ficha"
                                          data-original-title="Ficha">
                                      <i class="fas fa-eye mr-1 "></i>  Ficha</span>
                    </a>
                @endcan
            @endif

            @if($project->phase instanceof \App\States\Project\Planning)
                @can('project-manage-governance')
                    <a href="{{ route('projects.team', $project->id) }}">
                      <span class="btn btn-sm {{ $page == 'team' ? 'btn-success':' btn-info' }} mr-2"
                            data-placement="top" title="{{trans('general.governance')}}"
                            data-original-title="{{trans('general.governance')}}">
                          <i class="fas fa-ball-pile mr-1"></i>  {{trans_choice('general.governance',0)}}</span>
                    </a>
                @endcan
            @endif
            @can('project-manage-logicFrame')
                <a href="{{ route('projects.logic-frame', $project->id) }}">
                                    <span class="btn btn-sm {{ $page == 'logic_frame' ? 'btn-success':' btn-info' }} mr-2"
                                          data-placement="top" title="{{trans('general.logic_frame')}}"
                                          data-original-title="{{trans('general.logic_frame')}}">
                                    <i class="fas fa-file-archive mr-1"></i>        {{substr(trans('general.logic_frame'),0,25) }}</span>
                </a>
            @endcan
            @can('project-manage-stakeholders')

                <a href="{{ route('projects.stakeholder', $project->id) }}">
                                   <span class="btn btn-sm {{ $page == 'stakeholders' ? 'btn-success':' btn-info' }} mr-2"
                                         data-placement="top" title="{{trans('general.stakeholders')}}"
                                         data-original-title="{{trans('general.stakeholders')}}"
                                   > <i class="fas fa-poll-people mr-1"></i>{{substr(trans('general.stakeholders'),0,25) }}</span>
                </a>
            @endcan
            @can('project-manage-risks')
                <a href="{{ route('projects.risks', $project->id) }}">
                                    <span class="btn btn-sm {{ $page == 'risks' ? 'btn-success':' btn-info' }} mr-2"
                                    ><i class="fas fa-engine-warning mr-1"></i> Riesgos</span>
                </a>
            @endcan
            @if($project->phase instanceof \App\States\Project\StartUp)
                @can('project-manage-formulatedDocument')
                    <a href="{{ route('projects.doc', $project->id) }}">
                                     <span class="btn btn-sm {{ $page == 'formulated_document' ? 'btn-success':' btn-info' }} mr-2"
                                           data-placement="top" title="Documento Formulado"
                                           data-original-title="Documento Formulado"
                                     > <i class="fas fa-file mr-1"></i>Documento Formulado</span>
                    </a>
                @endcan
                @can('project-manage-referentialBudget')
                    <a href="{{ route('projects.showReferentialBudget', $project->id) }}">
                                   <span class="btn btn-sm {{ $page == 'budget' ? 'btn-success':' btn-info' }} mr-2"
                                         data-placement="top" title="Presupuesto"
                                         data-original-title="Presupuesto"
                                   > <i class="fas fa-dollar-sign mr-1"></i>Presupuesto Referencial</span>
                    </a>
                @endcan
            @endif

            @if(!($project->phase instanceof \App\States\Project\StartUp))
                @can('project-manage-timetable')
                    <a href="{{ route('projects.activities', $project->id) }}">
                                    <span class="btn btn-sm {{ $page == 'activities' ? 'btn-success':' btn-info' }} mr-2"
                                          data-placement="top" title="{{trans('general.activities')}}"
                                          data-original-title="{{trans('general.activities')}}">
                                   <i class="fas fa-calendar mr-1"></i> Cronograma
                                    </span>
                    </a>
                @endcan

                @can('project-manage-calendar')
                    <a href="{{ route('projects.calendar', $project->id) }}">
                                    <span class="btn btn-sm {{ $page == 'calendar' ? 'btn-success':' btn-info' }} mr-2"
                                          data-placement="top" title="Calendario"
                                          data-original-title="Calendario">
                                   <i class="fas fa-calendar mr-1"></i> Calendario
                                    </span>
                    </a>
                @endcan
                @can('project-manage-activities')
                    <a href="{{ route('projects.activities_results', $project) }}">
                                    <span class="btn btn-sm {{ $page == 'activities_results' ? 'btn-success':' btn-info' }} mr-2"
                                          data-placement="top" title="{{trans_choice('general.activities',2)}}"
                                          data-original-title="{{trans_choice('general.activities',2)}}">
                                    <i class="fas fa-arrow-alt-from-top mr-1"></i>{{trans_choice('general.activities',2) }}
                                    </span>
                    </a>
                @endcan

                <a href="{{ route('projects.budgetDocumentReport', $project) }}">
                           <span class="btn btn-sm {{ $page == 'budget' ? 'btn-success':' btn-info' }} mr-2"
                                 data-placement="top" title="Presupuesto"
                                 data-original-title="Presupuesto"
                           > <i class="fas fa-dollar-sign mr-1"></i>Presupuesto</span>
                </a>
                @can('project-manage-acquisitions')
                    <a href="{{ route('projects.acquisitions', $project->id) }}">
                                    <span class="btn btn-sm {{ $page == 'acquisitions' ? 'btn-success':' btn-info' }} mr-2"
                                          data-placement="top" title="{{trans('general.acquisitions')}}"
                                          data-original-title="{{trans('general.acquisitions')}}">
                                      <i class="fas fa-bags-shopping mr-1"></i>  Adquisiciones</span>
                    </a>
                @endcan
                @can('project-manage-communication')
                    <a href="{{route('projects.communication', $project)}}">
                                    <span class="btn btn-sm {{ $page == 'communications' ? 'btn-success':' btn-info' }} mr-2"
                                          data-placement="top" title="{{trans('general.communication')}}"
                                          data-original-title="{{trans('general.communication')}}">
                                    <i class="fas fa-ballot mr-1"></i>    Comunicación
                                    </span>
                    </a>
                @endcan

            @endif
            @can('project-view-summary')
                <a href="{{ route('projects.showSummary', $project->id) }}">
                                    <span class="btn btn-sm {{ $page == 'summary' ? 'btn-success':' btn-info' }} mr-2"
                                          data-placement="top"
                                          title="Resumen de la Fase"
                                          data-original-title="Resumen de la Fase"
                                    > <i class="fas fa-folder-open mr-1"></i>Resumen</span>
                </a>
            @endcan
        </div>
    </div>
@endif
