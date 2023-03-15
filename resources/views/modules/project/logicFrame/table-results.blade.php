<div class="w-75 pl-2">
    <div class="table-responsive">
        <table class="table table-light table-hover">
            <thead>
            <tr>
                <th class="w-5 table-th">{{__('general.code')}}</th>
                <th class="w-25 table-th">{{__('general.name')}}</th>
                <th class="w-20 table-th">{{__('general.responsable')}}</th>
                <th class="w-10 table-th">Supuestos</th>
                <th class="w-10 table-th">{{trans('general.weight')}}</th>
                <th class="w-10 table-th">{{trans_choice('general.indicators',2)}}</th>
                <th class="w-10 table-th">{{__('general.services')}}</th>
                <th class="w-10 table-th"><a href="#">{{ trans('general.actions') }} </a>
                </th>
            </tr>
            </thead>
            <tbody>
            @forelse($results as $index => $item)
                <tr class="tr-hover" wire:loading.class.delay="opacity-50" wire:key="{{time().$item->objective->id.$index}}" wire:ignore.self>
                    <td class="w-10">
                        <div class="d-flex align-items-center">
                                                        <span class="color-item shadow-hover-5 mr-2 cursor-default"
                                                              style="background-color: {{ $item->color }}"></span>
                            <div wire:key="{{time().$item->code}}" wire:ignore>
                                <livewire:components.input-inline-edit :modelId="$item->id"
                                                                       class="\App\Models\Projects\Activities\Task"
                                                                       field="code"
                                                                       :rules="'required|max:5|alpha_num|alpha_dash|unique:prj_tasks,code,' . $item->id . ',id,objective_id,' . $item->objective->id. ',type,project'"
                                                                       defaultValue="{{$item->code ?? '' }}"
                                                                       :key="time().$item->id"
                                />
                            </div>
                        </div>
                    </td>
                    <td>
                        <div wire:key="{{time().$item->text}}" style="width: 300px; !important;" wire:ignore>
                            <livewire:components.input-text :modelId="$item->id"
                                                            class="\App\Models\Projects\Activities\Task"
                                                            field="text"
                                                            :rules="'required|max:200|min:5'"
                                                            defaultValue="{{$item->text ?? __('general.add_name') }}"
                                                            :key="time().$item->id"/>
                        </div>
                    </td>
                    <td>
                        <div wire:key="{{time().$item->id.'user'}}" wire:ignore>
                            <livewire:components.dropdown-user :modelId="$item->id"
                                                               modelClass="\App\Models\Projects\Activities\Task"
                                                               field="owner_id"
                                                               :user="$item->responsible"
                                                               :key="time().$item->id"/>
                        </div>
                    </td>
                    <td>
                        <div wire:ignore wire:key="{{time().$item->id}}">
                            <livewire:components.input-text :modelId="$item->id"
                                                            class="\App\Models\Projects\Activities\Task"
                                                            field="assumptions"
                                                            defaultValue="{{$item->assumptions }}"
                                                            :key="time().$item->id"/>

                        </div>
                    </td>
                    <td>
                        {{$item->weight}}
                    </td>
                    <td class="border-right">
                        <div class="cursor-pointer  dropdown-table show-hidden-child-on-hover mr-2 dropdown-logic-frame"
                             data-toggle="dropdown">
                            <div class="dropdown-option-wrapper">
                                <div class="mr-2">
                                                            <span class="bg-gray-50 mr-2">{{ $item->indicators->count() }}    <i
                                                                        class="fas fa-plus-circle text-info"></i></span>
                                </div>
                                <div class="dropdown-menu fadeindown dropdown-xl m-0 dropdown-menu-side show-child-on-hover">
                                    @foreach($item->indicators as $indicator)
                                        <div class="dropdown-item m-2 justify-content-between cursor-default"
                                             wire:key="{{ 'r.i.' . $loop->index }}">
                                            <div class="col-md-9 cursor-pointer">
                                                <i class="fal fa-chart-line mr-2"></i>
                                                <span class="text-component" dir="auto">
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
                                         wire:click="$emit('show', 'App\\Models\\Projects\\Activities\\Task', '{{ $item->id }}')">
                                        <i class="fal fa-plus mr-2"></i>
                                        <span class="text-component" dir="auto">
                                                                        <span>Agregar Indicador</span>
                                                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="text-center">
                        <div class="d-flex align-items-center">
                                                        <span>
                                                            {{$item->services->count()??'0'}}
                                                        </span>
                            <button class="border-0 bg-transparent"
                                    data-toggle="modal"
                                    data-target="#project-create-services"
                                    data-result-id="{{  $item->id }}"
                            ><i class="fas fa-plus-circle mr-1 text-info"
                                data-placement="top" title="Añadir Servicios"
                                data-original-title="Añadir Servicios"></i>
                            </button>

                        </div>
                    </td>
                    <td>
                        @if($item->childs->count()<1)
                            <button class="border-0 bg-transparent"
                                    wire:click="$emit('triggerDelete', '{{ $item->id }}')"
                                    data-toggle="tooltip"
                                    data-placement="top" title="Eliminar"
                                    data-original-title="Eliminar"><i
                                        class="fas fa-trash mr-1 text-danger"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
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
