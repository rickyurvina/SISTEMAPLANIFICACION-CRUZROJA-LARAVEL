<div class="pl-2 mt-2">
    <div class="d-flex align-items-start">
        @if($showProgramPanel)
            <div class="panel w-30 mr-3">
                <div class="panel-hdr">
                    <h2>
                        {{ trans_choice('general.result',2) }}
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-toggle="tooltip" data-offset="0,10" data-original-title="{{ trans('general.close') }}"
                                wire:click="$set('showProgramPanel', false)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="accordion accordion-outline accordion-clean" id="accordion-progrms">
                            @foreach($results as $index => $result)
                                <div class="card mb-1">
                                    <div class="card-header">
                                        <a href="javascript:void(0);" class="card-title py-2 collapsed" data-toggle="collapse"
                                           data-target="#accordion-p-{{ $result->id }}"
                                           aria-expanded="false">
                                            <span class="color-item shadow-hover-5 mr-2" style="background-color: {{ $result['color'] }}"></span>
                                            {{$result->text}}
                                            <span class="ml-auto">
                                                                        <span class="collapsed-reveal">
                                                                            <i class="fal fa-minus fs-xl"></i>
                                                                        </span>
                                                                        <span class="collapsed-hidden">
                                                                            <i class="fal fa-plus fs-xl"></i>
                                                                        </span>
                                                                    </span>
                                        </a>
                                    </div>
                                    <div id="accordion-p-{{ $result->id }}" class="collapse">
                                        <div class="card-body">
                                            <div class="d-flex flex-column">
                                                <div class="dropdown-item cursor-pointer" style="border-radius: 4px">
                                                    <div class="dropdown-cell-wrapper show-child-on-hover cursor-pointer dropdown dropdown-table show-hidden-child-on-hover mr-2 dropdown-logic-frame"
                                                         data-toggle="dropdown">
                                                        <div class="dropdown-option-wrapper">
                                                            <div class="mr-2">
                                                                <i class="fas fa-plus-circle"></i>
                                                            </div>
                                                            <div class="option-names">
                                                                                    <span class="">
                                                                                        <span class="bg-gray-50" dir="auto">
                                                                                            <span>{{ $result->indicators->count()>1?  $result->indicators->count().'-Indicadores':$result->indicators->count().'-Indicador'}}</span>
                                                                                        </span>
                                                                                    </span>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown-menu fadeindown  m-0 dropdown-menu-side show-child-on-hover pr-4">
                                                            @foreach($result->indicators as $indicator)
                                                                <div class="dropdown-item justify-content-between cursor-default"
                                                                     wire:key="{{ 'r.i.' . $loop->index }}">
                                                                    <div class="col-md-9 cursor-pointer">
                                                                        <i class="fal fa-chart-line mr-2"></i>
                                                                        <span class="text-component" dir="auto">
                                                                                               <span>{{ strlen( $indicator->name)>25? substr( $indicator->name,0,25).'...': $indicator->name }}</span>
                                                                                             </span>
                                                                    </div>
                                                                    <div class="col-md-1 cursor-pointer"
                                                                         wire:click="$emit('triggerAdvance','{{ $indicator->id }}')">
                                                                        <span class="color-success-700"><i class="far fa-calendar-alt"></i></span>
                                                                    </div>
                                                                    <div class="col-md-1 cursor-pointer"
                                                                         wire:click="$emit('triggerEdit', '{{ $indicator->id }}')">
                                                                        <span class="color-warning-700"><i class="fas fa-pencil-alt"></i></span>
                                                                    </div>
                                                                    <div class="col-md-1 cursor-pointer"
                                                                         wire:click="$emit('triggerDeleteIndicator', '{{ $indicator->id }}')">
                                                                        <span class="color-danger-700"><i class="fas fa-trash-alt"></i></span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            <div class="dropdown-item m-2 d-flex active mt-4"
                                                                 wire:click="$emit('show', 'App\\Models\\Projects\\Activities\\Task', '{{ $result->id }}')">
                                                                <i class="fal fa-plus mr-2"></i>
                                                                <span class="text-component" dir="auto">
                                                                                        <span>Agregar Indicador</span>
                                                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($result->childs()->count()<1)
                                                    <div class="dropdown-item cursor-pointer" style="border-radius: 4px" data-toggle="modal"
                                                         wire:click="$emit('triggerDeleteResult', '{{ $result->id }}')">
                                                        <i class="fal fa-trash-alt mr-2"></i> {{  trans_choice('general.delete', 1) }}
                                                    </div>
                                                @endif
                                                <h6 class="m-0 text-muted">{{ __('general.color') }}</h6>
                                                <livewire:components.color-palette :modelId="$result->id" :key="time().$loop->index"
                                                                                   class="\App\Models\Projects\Activities\Task" field="color"/>
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
        <div class="w-100">
            <div class="table-responsive">
                <table class="table table-light table-hover">
                    <thead>
                    <tr>
                        <th class="w-10 table-th">{{__('general.code')}}</th>
                        <th class="w-20 table-th">{{__('general.name')}}</th>
                        <th class="w-20 table-th">{{__('general.responsable')}}</th>
                        <th class="w-20 table-th">Sede Ejecutora</th>
                        <th class="w-10 table-th"><a href="#">{{ trans('general.actions') }} </a></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($activities as $item)
                        <tr class="tr-hover" wire:loading.class.delay="opacity-50">
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="color-item shadow-hover-5 mr-2 cursor-default" style="background-color: {{ $item->color }}"></span>
                                    {{$item->code }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{$item->text }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($item->responsible)
                                        {{$item->responsible->getFullName() }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{$item->company->name}}
                                </div>
                            </td>
                            <td>
                                <div class="frame-wrap">
                                    <div class="d-flex justify-content-start">
                                        <div class="p-2">
                                            @if($poa)
                                                <a href="javascript:void(0);" aria-expanded="false"
                                                   wire:click="$emit('registerAdvance', '{{ $item->id }}')">
                                                    <i class="fas fa-edit mr-1 text-info"
                                                       data-toggle="tooltip" data-placement="top" title=""
                                                       data-original-title="Detalles Actividad"></i>
                                                </a>
                                            @endif
                                        </div>
                                        <div class="p-2">
                                            <a href="{{route('internal.piat_index',$item)}}">
                                                <i class="fas fa-house mr-1 text-info"
                                                   data-toggle="tooltip" data-placement="top" title=""
                                                   data-original-title="Matrices Piat"></i>
                                            </a>
                                        </div>
                                        <div class="p-2">
                                            @if($item->indicators->count() < 1)
                                                <button class="border-0 bg-transparent"
                                                        wire:click="$emit('triggerDeleteResult', '{{ $item->id }}')" data-toggle="tooltip"
                                                        data-placement="top" title="Eliminar"
                                                        data-original-title="Eliminar"><i class="fas fa-trash mr-1 text-danger"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="d-flex align-items-center justify-content-center">
                                                    <span class="color-fusion-500 fs-3x py-3"><i
                                                                class="fas fa-exclamation-triangle color-warning-900"></i> No se encontraron actividades</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <x-pagination :items="$activities"/>
        </div>
    </div>
</div>
