@if($showProgramPanel)
    <div class="panel w-25">
        <div class="panel-hdr">
            <h2>
                {{ trans('general.objectives_name') }}
            </h2>
            <div class="panel-toolbar">

                <button class="btn btn-panel" data-toggle="tooltip" data-offset="0,10"
                        data-original-title="{{ trans('general.close') }}"
                        wire:click="$set('showProgramPanel', false)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <div class="accordion accordion-outline accordion-clean"
                     id="accordion-progrms">
                    @foreach($project->objectives as $index => $objective)
                        <div class="card mb-1">
                            <div class="card-header">
                                        <span href="javascript:void(0);" class="card-title py-2 collapsed w-90"
                                              data-toggle="collapse"
                                              data-target="#accordion-p-{{ $objective['id'] }}"
                                              aria-expanded="false">
                                            <span class="color-item shadow-hover-5 mr-2 cursor-default"
                                                  style="background-color: {{ $objective['color'] }};">
                                            </span>
                                            <span wire:ignore wire:key="{{time().$objective->code}}" class="w-75">
                                                 <livewire:components.input-text :modelId="$objective['id']"
                                                                                 class="\App\Models\Projects\Objectives\ProjectObjectives"
                                                                                 field="name"
                                                                                 :rules="'required|max:255|min:3'"
                                                                                 defaultValue="{{ $objective['name'] }}"
                                                                                 :key="time().$objective['id']"/>
                                                        </span>

                                                        <span class="ml-auto">
                                                            <span class="collapsed-reveal">
                                                                <i class="fal fa-minus fs-xl"></i>
                                                            </span>
                                                            <span class="collapsed-hidden">
                                                                <i class="fal fa-plus fs-xl"></i>
                                                            </span>
                                                        </span>
                                                    </span>
                            </div>
                            <div id="accordion-p-{{ $objective['id'] }}" class="collapse">
                                <div class="card-body">
                                    <div class="d-flex flex-column">
                                        <div class="dropdown-item cursor-pointer"
                                             style="border-radius: 4px" data-toggle="modal"
                                             data-target="#project-activities-weight"
                                             data-objective-id="{{ $objective['id'] }}">
                                            <i class="fas fa-weight mr-2"></i>     {{ __('general.weight') }} {{ trans_choice('general.result', 2) }}
                                        </div>
                                        <div class="dropdown-item cursor-pointer"
                                             style="border-radius: 4px" data-toggle="modal"
                                             data-target="#project-create-results"
                                             data-objective-id="{{ $objective['id'] }}">
                                            <i class="fas fa-plus-circle mr-2"></i> {{ trans('general.create') . ' ' . trans_choice('general.result', 1) }}
                                        </div>

                                        <div class="dropdown-item cursor-pointer"
                                             style="border-radius: 4px">
                                            <div class="dropdown-cell-wrapper show-child-on-hover cursor-pointer dropdown dropdown-table show-hidden-child-on-hover mr-2 dropdown-logic-frame"
                                                 data-toggle="dropdown">
                                                <div class="dropdown-option-wrapper" style="padding: 0 !important;">
                                                    <div class="mr-2">
                                                        <i class="fas fa-plus-circle"></i>
                                                    </div>
                                                    <div class="option-names">
                                                        <span class="">
                                                            <span class="bg-gray-50" dir="auto">
                                                                <span>{{ $objective->indicators->count()>1?  $objective->indicators->count().'-Indicadores':$objective->indicators->count().'-Indicador'}}</span>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="dropdown-menu fadeindown  m-0 dropdown-menu-side show-child-on-hover pr-4">
                                                    @foreach($objective->indicators as $indicator)
                                                        <div class="dropdown-item justify-content-between cursor-default"
                                                             wire:key="{{ 'r.i.' . $loop->index }}">
                                                            <div class="col-md-9 cursor-pointer">
                                                                <i class="fal fa-chart-line mr-2"></i>
                                                                <span class="text-component"
                                                                      dir="auto">
                                                                                               <span>{{ strlen( $indicator->name)>25? substr( $indicator->name,0,25).'...': $indicator->name }}</span>
                                                                                             </span>
                                                            </div>
                                                            <div class="col-md-1 cursor-pointer"
                                                                 wire:click="$emit('triggerAdvance','{{ $indicator->id }}')">
                                                                                            <span class="color-success-700"><i
                                                                                                        class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <div class="col-md-1 cursor-pointer"
                                                                 wire:click="$emit('triggerEdit', '{{ $indicator->id }}')">
                                                                                            <span class="color-warning-700"><i
                                                                                                        class="fas fa-pencil-alt"></i></span>
                                                            </div>
                                                            <div class="col-md-1 cursor-pointer"
                                                                 wire:click="$emit('triggerDeleteIndicator', '{{ $indicator->id }}')">
                                                                                            <span class="color-danger-700"><i
                                                                                                        class="fas fa-trash-alt"></i></span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <div class="dropdown-item m-2 d-flex active mt-4"
                                                         wire:click="$emit('show', 'App\\Models\\Projects\\Objectives\\ProjectObjectives', '{{ $objective->id }}')">
                                                        <i class="fal fa-plus mr-2"></i>
                                                        <span class="text-component"
                                                              dir="auto">
                                                                            <span>Agregar Indicador</span>
                                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if($objective->results->count()<1)
                                            <div class="dropdown-item cursor-pointer"
                                                 style="border-radius: 4px"
                                                 data-toggle="modal"
                                                 wire:click="$emit('triggerDeleteObjective', '{{ $objective->id }}')">
                                                <i class="fal fa-trash-alt mr-2"></i> {{  trans_choice('general.delete', 1) }}
                                            </div>
                                        @endif
                                        <h6 class="m-0 text-muted">{{ __('general.color') }}</h6>
                                        <livewire:components.color-palette
                                                :modelId="$objective['id']"
                                                :key="time().$loop->index"
                                                class="App\Models\Projects\Objectives\ProjectObjectives"
                                                field="color"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endif