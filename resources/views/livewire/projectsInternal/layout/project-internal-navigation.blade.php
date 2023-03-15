<div class=""
     x-cloak
     x-data="{
        show: @entangle('show').defer,
        phase: @entangle('phase'),
        transition: @entangle('transition')
        }"
     x-init="
            $watch('show', value => {
                if (value) {
                    $('#project-status-change').modal('show');
                } else {
                    $('#project-status-change').modal('hide');
                    phase = false;
                }
            });

"
     x-on:keydown.escape.window="show = false;"
     x-on:close.stop="show = false;"
>
    <div class="frame-wrap m-0">
        <div class="d-flex flex-wrap">
            <div class="w-auto p-2 text-center">
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
                                    <a href="{{ route('projects.filesInternal', $project->id) }}"
                                       class="menu-item fal fa-paperclip" data-toggle="tooltip"
                                       data-original-title="Ver Archivos"></a>
                                    <a href="{{ route('projects.eventsInternal', $project->id) }}"
                                       class="menu-item fal fa-line-height" data-toggle="tooltip"
                                       data-original-title="Ver Sucesos"></a>
                                    <a href="{{ route('projects.reportsIndexInternal', $project->id) }}"
                                       class="menu-item fal fa-table" data-toggle="tooltip"
                                       data-original-title="Reportes"></a>
                                    <a href="{{ route('projects.lessons_learnedInternal', $project->id) }}"
                                       class="menu-item fal fa-book-open" data-toggle="tooltip"
                                       data-original-title="Lecciones Aprendidas"></a>
                                    <a href="{{ route('projects.reschedulingsInternal', $project->id) }}"
                                       class="menu-item fal fa-clock" data-toggle="tooltip"
                                       data-original-title="Reprogramaciones"></a>
                                    <a href="{{ route('projects.evaluationsInternal', $project->id) }}"
                                       class="menu-item fal fa-book-medical" data-toggle="tooltip"
                                       data-original-title="Evaluaciones"></a>
                                    <a href="{{ route('projects.administrativeTasksInternal', $project->id) }}"
                                       class="menu-item far fa-address-card" data-toggle="tooltip"
                                       data-original-title="Actividades Administrativas"></a>
                                </menu>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ol class="breadcrumb breadcrumb-lg breadcrumb-arrow mb-0 p-2">
                <li class="@if($project->phase->isActive(\App\States\Project\Planning::class)) active @endif">
                    <a href="#">
                        <i class="fas fa-pencil-alt"></i>
                        <span class="hidden-md-down">{{ \App\States\Project\Planning::label() }}</span>
                    </a>
                </li>
                <li class="@if($project->phase->isActive(\App\States\Project\Implementation::class)) active @endif">
                    <a href="#" @if($project->phase->isActive(\App\States\Project\Planning::class ))
                    x-on:click="show = true; phase = true; transition='Implementación';" @endif>
                        <i class="fas fa-play"></i>
                        <span class="hidden-md-down">{{ \App\States\Project\Implementation::label() }}</span>
                    </a>
                </li>
                <li class="@if($project->phase->isActive(\App\States\Project\Closing::class)) active @endif">
                    <a href="#"
                       @if($project->phase->isActive(\App\States\Project\Implementation::class )) x-on:click="show = true; phase = true; transition='Cierre';" @endif>
                        <i class="fas fa-window-close"></i>
                        <span class="hidden-md-down">{{ \App\States\Project\Closing::label() }}</span>
                    </a>
                </li>
            </ol>
        </div>
    </div>
    @if(session('company_id')===$project->company_id)
        <div class="frame-wrap mb-3">
            <div class="d-flex d-flex-row">
                @can('manage-indexCard-project')
                    <a href="{{ route('projects.showIndexInternal', $project->id) }}">
                                    <span class="btn btn-sm {{ $page == 'act' ? 'btn-success':' btn-info' }} mr-2"
                                          data-placement="top" title="Ficha"
                                          data-original-title="Ficha">
                                      <i class="fas fa-eye mr-1 "></i>  Ficha</span>
                    </a>
                @endcan

                <a href="{{ route('projects.teamInternal', $project->id) }}">
                                      <span class="btn btn-sm {{ $page == 'team' ? 'btn-success':' btn-info' }} mr-2"
                                            data-placement="top" title="{{trans('general.governance')}}"
                                            data-original-title="{{trans('general.governance')}}">
                                          <i class="fas fa-ball-pile mr-1"></i>  {{trans_choice('general.governance',0)}}</span>
                </a>

                <a href="{{ route('projects.stakeholderInternal', $project->id) }}">
                                                   <span class="btn btn-sm {{ $page == 'stakeholders' ? 'btn-success':' btn-info' }} mr-2"
                                                         data-placement="top" title="{{trans('general.logic_frame')}}"
                                                         data-original-title="{{trans('general.logic_frame')}}"
                                                   > <i class="fas fa-poll-people mr-1"></i>{{substr(trans('general.stakeholders'),0,25) }}</span>
                </a>

                <a href="{{ route('projects.risksInternal', $project->id) }}">
                                                    <span class="btn btn-sm {{ $page == 'risks' ? 'btn-success':' btn-info' }} mr-2"
                                                    ><i class="fas fa-engine-warning mr-1"></i> Riesgos</span>
                </a>
                <a href="{{ route('projects.docInternal', $project->id) }}">
                                                     <span class="btn btn-sm {{ $page == 'formulated_document' ? 'btn-success':' btn-info' }} mr-2"
                                                           data-placement="top" title="Documento Formulado"
                                                           data-original-title="Documento Formulado"
                                                     > <i class="fas fa-file mr-1"></i>Documento Formulado</span>
                </a>

                <a href="{{ route('projects.showReferentialBudgetInternal', $project->id) }}">
                                                   <span class="btn btn-sm {{ $page == 'budget' ? 'btn-success':' btn-info' }} mr-2"
                                                         data-placement="top" title="Presupuesto"
                                                         data-original-title="Presupuesto"
                                                   > <i class="fas fa-dollar-sign mr-1"></i>Presupuesto Referencial</span>
                </a>

                <a href="{{ route('projects.calendarInternal', $project->id) }}">
                                    <span class="btn btn-sm {{ $page == 'calendar' ? 'btn-success':' btn-info' }} mr-2"
                                          data-placement="top" title="Calendario"
                                          data-original-title="Calendario">
                                   <i class="fas fa-calendar mr-1"></i> Calendario
                                    </span>
                </a>

                <a href="{{ route('projects.activities_resultsInternal', $project) }}">
                                                    <span class="btn btn-sm {{ $page == 'activities_results' ? 'btn-success':' btn-info' }} mr-2"
                                                          data-placement="top"
                                                          title="{{trans_choice('general.activities',2)}}"
                                                          data-original-title="{{trans_choice('general.activities',2)}}">
                                                    <i class="fas fa-arrow-alt-from-top mr-1"></i>{{trans_choice('general.activities',2) }}
                                                    </span>
                </a>

                <a href="{{ route('projects.showSummaryInternal', $project->id) }}">
                                    <span class="btn btn-sm {{ $page == 'summary' ? 'btn-success':' btn-info' }} mr-2"
                                          data-placement="top"
                                          title="Resumen de la Fase"
                                          data-original-title="Resumen de la Fase"
                                    > <i class="fas fa-folder-open mr-1"></i>Resumen</span>
                </a>
            </div>
        </div>
    @endif

    <div class="modal fade" id="project-status-change" style="display: none;"
         data-backdrop="static" data-keyboard="false" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <template x-if="phase">
                        <h3 class="modal-title">{{ trans('general.change_phase') }}</h3>
                    </template>
                    <template x-if="!phase">
                        <h3 class="modal-title">{{ trans('general.change_status') }}</h3>
                    </template>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            x-on:click="show = false; transition=null">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <template x-if="phase">
                        <div class="d-flex align-items-center mb-6">

                            <div class="d-flex align-items-center flex-column">
                                <x-label-section>{{ trans('general.from') }}</x-label-section>
                                <span class="badge {{ $project->phase->color() }} fs-2x mr-3">
                          {{ $project->phase->label() }}
                            </span>
                            </div>

                            <span class="mr-3"><i class="fas fa-arrow-right color-success-500 fa-2x"></i></span>

                            <div class="d-flex align-items-center flex-column">
                                <x-label-section>{{ trans('general.to') }}</x-label-section>
                                <span class="badge @if($transition) {{ $project->phase->to($transition)->color() }}   @else     {{ $project->phase->to()->color() }} @endif fs-2x">
                                    @if($transition) {{$transition}}  @else      {{ $project->phase->to()->label() }} @endif
                            </span>
                            </div>
                        </div>
                    </template>
                    <template x-if="!phase">
                        <div class="d-flex align-items-center mb-6">
                            <div class="d-flex align-items-center flex-column">
                                <x-label-section>{{ trans('general.phase') }}</x-label-section>
                                <span class="badge fs-2x mr-3">{{ $project->phase }}:</span>
                            </div>

                            <div class="d-flex align-items-center flex-column">
                                <x-label-section>{{ trans('general.from') }}</x-label-section>
                                <span class="badge {{ $project->status->color() }} fs-2x mr-3">
                                {{ $project->status->label() }}
                            </span>
                            </div>

                            <span class="mr-3"><i class="fas fa-arrow-right color-success-500 fa-2x"></i></span>

                            <div class="d-flex align-items-center flex-column">
                                <x-label-section>{{ trans('general.to') }}</x-label-section>
                                <span class="badge @if($transition) {{ $project->status->to($transition)->color() }}   @else     {{ $project->status->to()->color() }} @endif fs-2x">
                                    @if($transition) {{$transition}}  @else      {{ $project->status->to()->label() }} @endif
                            </span>
                            </div>
                        </div>
                    </template>
                    <x-label-section>{{ trans('general.change_history') }}</x-label-section>

                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-2 content-detail"><span class="fw-700">{{ trans('general.from') }}</span>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-2 content-detail"><span class="fw-700">{{ trans('general.to') }}</span>
                            </div>
                            <div class="col-4 content-detail"><span
                                        class="fw-700">{{ trans('general.updated_by') }}</span></div>
                            <div class="col-3 content-detail"><span class="fw-700">{{ trans('general.date') }}</span>
                            </div>
                        </div>
                        @foreach($project->phaseChanges() as $change)
                            <div class="row mb-2">
                                <div class="col-2">
                                    <span class="badge {{ \App\Models\Projects\Project::statusColor($change->properties->get('old')['phase']) }} mr-3">
                                        {{ $change->properties->get('old')['phase'] }}
                                    </span>
                                </div>
                                <div class="col-1"><i class="fas fa-arrow-right color-success-500"></i></div>
                                <div class="col-2">
                                    <span class="badge {{ \App\Models\Projects\Project::statusColor($change->properties->get('attributes')['phase']) }}">
                                        {{ $change->properties->get('attributes')['phase'] }}
                                    </span>
                                </div>
                                <div class="col-4">
                                    <span class="mr-2">
                                        <img src="{{ asset_cdn('img/user.svg') }}" class="rounded-circle width-1">
                                    </span>
                                    {{ $change->causer->name }}</div>
                                <div class="col-3">{{ company_date($change->created_at) }}</div>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="panel-container show">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary shadow-none" data-dismiss="modal"
                                    x-on:click="show = false; transition=null">{{ trans('general.cancel') }}</button>
                            @if($phase)
                                <button type="button" class="btn btn-success border-0 shadow-none"
                                        wire:click="changePhase">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                                          wire:target="changePhase" wire:loading></span>
                                    {{ trans('general.change') }}
                                </button>
                            @else
                                <button type="button" class="btn btn-success border-0 shadow-none"
                                        wire:click="changeStatus">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                                          wire:target="changeStatus" wire:loading></span>
                                    {{ trans('general.change') }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('page_script')
    <script>
        Livewire.on('closeModalValidations', () => $('#project-status-change').modal('toggle'));
    </script>
@endpush