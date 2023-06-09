<div>
    <div class="d-flex mb-3">
        <div class="input-group bg-white shadow-inset-2 w-25 mr-2">
            <input type="text" class="form-control border-right-0 bg-transparent pr-0"
                   placeholder="{{ trans('general.filter') . ' ' . trans_choice('general.result', 2) }} ..."
                   wire:model="search">
            <div class="input-group-append">
                <span class="input-group-text bg-transparent border-left-0">
                    <i class="fal fa-search"></i>
                </span>
            </div>
        </div>

        @if(count($objectives) > 0)
            <div class="btn-group">
                <button class="btn btn-outline-secondary dropdown-toggle @if(count($selectedObjectives) > 0) filtered @endif"
                        type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ trans('general.objectives_name') }}
                    @if(count($selectedObjectives) > 0)
                        <span class="badge bg-white ml-2">{{ count($selectedObjectives) }}</span>
                    @endif
                </button>
                <div class="dropdown-menu">
                    @foreach($objectives as $objective)
                        <div class="dropdown-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="i-program-{{ $objective['id'] }}" wire:model="selectedObjectives"
                                       value="{{ $objective['id'] }}">
                                <label class="custom-control-label"
                                       for="i-program-{{ $objective['id'] }}">{{ strlen($objective['name'])>10? substr($objective['name'], 0,10).'...': $objective['name']  }}</label>
                            </div>
                        </div>
                    @endforeach
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-item">
                        <span wire:click="$set('selectedObjectives', [])">{{ trans('general.delete_selection') }}</span>
                    </div>
                    <div class="dropdown-item">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="showProgramPanel" checked="" wire:model="showProgramPanel">
                            <label class="custom-control-label" for="showProgramPanel">{{ trans('general.show_panel_objectives') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(count($selectedObjectives) > 0 || $search != '')
            <a class="btn btn-outline-default ml-2" wire:click="clearFilters()">{{ trans('common.clean_filters') }}</a>
        @endif
        <button type="button" class="btn btn-success border-0 shadow-0 ml-2" data-toggle="modal"
                data-target="#project-create-specific-objective">{{ trans('general.create') }} {{trans('general.objectives_name')}} </button>
        <x-tooltip-help message="{{$messages->where('code','objetivo_especifico')->first()->description}}"></x-tooltip-help>
    </div>
    <div class="d-flex align-items-start">
        @if($showProgramPanel)
            <div class="panel w-25 mr-3">
                <div class="panel-hdr">
                    <h2>
                        {{ trans('general.objectives_name') }}
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
                            @foreach($objectives as $index => $objective)
                                <div class="card mb-1">
                                    <div class="card-header">
                                        <a href="javascript:void(0);" class="card-title py-2 collapsed" data-toggle="collapse"
                                           data-target="#accordion-p-{{ $objective['id'] }}"
                                           aria-expanded="false">
                                            <span class="color-item shadow-hover-5 mr-2 cursor-default" style="background-color: {{ $objective['color'] }}; "></span>
                                            <span class="w-65" style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">
                                               {{ $objective['name'] }}
                                            </span>
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
                                    <div id="accordion-p-{{ $objective['id'] }}" class="collapse">
                                        <div class="card-body">
                                            <div class="d-flex flex-column">
                                                <div class="dropdown-item cursor-pointer" style="border-radius: 4px"  data-toggle="modal"
                                                     data-target="#project-create-specific-objective"
                                                     data-objective-id="{{ $objective['id'] }}">
                                                    <i class="fas fa-edit mr-2"></i> {{ trans('general.edit') . ' ' . trans_choice('general.objectives_name', 1) }}
                                                </div>
                                                <div class="dropdown-item cursor-pointer" style="border-radius: 4px" data-toggle="modal"
                                                     data-target="#project-create-results"
                                                     data-objective-id="{{ $objective['id'] }}">
                                                    <i class="fas fa-plus-circle mr-2"></i> {{ trans('general.create') . ' ' . trans_choice('general.result', 1) }}
                                                    <x-tooltip-help message="{{$messages->where('code','resultados')->first()->description}}"></x-tooltip-help>
                                                </div>
                                                @if($objective->results->count()<1)
                                                    <div class="dropdown-item cursor-pointer" style="border-radius: 4px" data-toggle="modal"
                                                         wire:click="$emit('triggerDeleteObjective', '{{ $objective->id }}')">
                                                        <i class="fal fa-trash-alt mr-2"></i> {{  trans_choice('general.delete', 1) }}
                                                    </div>
                                                @endif
                                                <h6 class="m-0 text-muted">{{ __('general.color') }}</h6>
                                                <livewire:components.color-palette :modelId="$objective['id']" :key="time().$loop->index"
                                                                                   class="App\Models\Projects\Objectives\ProjectObjectives" field="color"/>
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
        <div class="w-75">
            <div class="table-responsive">
                <table class="table table-light table-hover">
                    <thead>
                    <tr>
                        <th class="w-10 table-th">{{__('general.code')}}</th>
                        <th class="w-auto table-th">{{__('general.name')}}</th>
                        <th class="w-10 table-th">{{__('general.services')}}</th>
                        <th class="w-10 table-th"><a href="#">{{ trans('general.actions') }} </a></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($results as $item)
                        <tr class="tr-hover" wire:loading.class.delay="opacity-50">
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="color-item shadow-hover-5 mr-2 cursor-default" style="background-color: {{ $item->color }}"></span>
                                    <span>
                                        {{$item->code }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{$item->text }}
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center">
                                    <span>
                                   {{$item->services->count()??'0'}}
                                    </span>
                                    <button class="border-0 bg-transparent"
                                            data-toggle="modal" data-target="#project-create-services"
                                            data-result-id="{{  $item->id }}"
                                    ><i class="fas fa-plus-circle mr-1 text-info" data-placement="top" title="Añadir Servicios"
                                        data-original-title="Añadir Servicios"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center">
                                    @if($item->childs->count()<1)
                                        <button class="border-0 bg-transparent" wire:click="$emit('triggerDelete', '{{ $item->id }}')"
                                        ><i class="fas fa-trash mr-1 text-danger"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="d-flex align-items-center justify-content-center">
                                            <span class="color-fusion-500 fs-3x py-3"><i
                                                        class="fas fa-exclamation-triangle color-warning-900"></i> No se encontraron resultados</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>
            <x-pagination :items="$results"/>
        </div>
    </div>
</div>

@push('page_script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('div.dropdown-item, .color-item').on('click', function () {
                $(".open-drop").dropdown("hide");
            });

        @this.on('triggerDelete', id => {
            Swal.fire({
                title: '{{ trans('messages.warning.sure') }}',
                text: '{{ trans('messages.warning.delete') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--danger)',
                confirmButtonText: '<i class="fas fa-trash"></i> {{ trans('general.yes') . ', ' . trans('general.delete') }}',
                cancelButtonText: '<i class="fas fa-times"></i> {{ trans('general.no') . ', ' . trans('general.cancel') }}'
            }).then((result) => {
                //if user clicks on delete
                if (result.value) {
                    // calling destroy method to delete
                @this.call('deleteResult', id);
                }
            });
        });

        @this.on('triggerDeleteActivity', id => {
            Swal.fire({
                title: '{{ trans('messages.warning.sure') }}',
                text: '{{ trans('messages.warning.delete') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--danger)',
                confirmButtonText: '<i class="fas fa-trash"></i> {{ trans('general.yes') . ', ' . trans('general.delete') }}',
                cancelButtonText: '<i class="fas fa-times"></i> {{ trans('general.no') . ', ' . trans('general.cancel') }}'
            }).then((result) => {
                //if user clicks on delete
                if (result.value) {
                    // calling destroy method to delete
                @this.call('deleteActivity', id);
                }
            });
        });

        @this.on('triggerDeleteObjective', id => {
            Swal.fire({
                title: '{{ trans('messages.warning.sure') }}',
                text: '{{ trans('messages.warning.delete') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--danger)',
                confirmButtonText: '<i class="fas fa-trash"></i> {{ trans('general.yes') . ', ' . trans('general.delete') }}',
                cancelButtonText: '<i class="fas fa-times"></i> {{ trans('general.no') . ', ' . trans('general.cancel') }}'
            }).then((result) => {
                //if user clicks on delete
                if (result.value) {
                    // calling destroy method to delete
                @this.call('deleteObjective', id);
                }
            });
        });
        });
    </script>

@endpush
