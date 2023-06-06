<div>
    <div wire:ignore.self class="modal fade" id="add_piat_modal" tabindex="-1" role="dialog" aria-hidden="true"
         style="height: 100%;">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div wire:ignore class="modal-header bg-primary text-white">
                    <h5 class="modal-title">{{ trans('general.add_new') }}</h5>
                    <button type="button" data-dismiss="modal" class="close text-white" aria-label="Close">
                        <span aria-hidden="true"><i class="far fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="panel-content">
                        @if ($newPoaActivityPiatId == null)
                            <form wire:submit.prevent="submit()" method="post" autocomplete="off">
                                <div class="d-flex flex-wrap align-items-center justify-content-between w-100">
                                    <div class="form-group w-50 pr-1 mb-0">
                                        <label class="form-label fw-700 required"
                                               for="name">{{ trans('poa.piat_matrix_create_placeholder_name') }}</label>
                                        <input type="text"
                                               class="form-control bg-transparent @error('name') is-invalid @enderror"
                                               placeholder="{{ trans('poa.piat_matrix_create_placeholder_name') }}"
                                               wire:model.defer="name">
                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('name') }}</div>
                                    </div>
                                    <div class="form-group w-50 pr-1 mb-0">
                                        <label class="form-label fw-700"
                                               for="place">{{ trans('poa.piat_matrix_create_placeholder_place') }}</label>
                                        <input type="text" wire:model.defer="place" class="form-control "
                                               placeholder="{{ trans('poa.piat_matrix_create_placeholder_place') }}"/>
                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('place') }}</div>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap align-items-center justify-content-between w-100 mt-2">
                                    <div class="form-group w-25 mb-0 pr-1">
                                        <label class="form-label fw-700 required"
                                               for="date">{{ trans('poa.piat_matrix_create_placeholder_date') }}</label>
                                        <input type="date" wire:model.defer="date"
                                               class="form-control bg-transparent @error('date') is-invalid @enderror"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('poa.piat_matrix_create_placeholder_date')]) }}"/>
                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('date') }}</div>
                                    </div>
                                    <div class="form-group w-25 mb-0 pr-1">
                                        <label class="form-label fw-700 required"
                                               for="date">{{ trans('poa.piat_matrix_create_placeholder_end_date') }}</label>
                                        <input type="date" wire:model.defer="endDate"
                                               class="form-control bg-transparent @error('endDate') is-invalid @enderror"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('poa.piat_matrix_create_placeholder_endDate')]) }}"/>
                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('endDate') }}</div>
                                    </div>
                                    <div class="form-group w-25 pr-1 required mb-0">
                                        <label class="form-label fw-700 timepicker"
                                               for="initTime">{{ trans('poa.piat_matrix_create_placeholder_initial_time') }}</label>
                                        <input type="time" wire:model.defer="initTime"
                                               class="form-control bg-transparent @error('initTime') is-invalid @enderror"
                                               placeholder="{{ trans('poa.piat_matrix_create_placeholder_initial_time') }}"/>
                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('initTime') }}</div>
                                    </div>
                                    <div class="form-group w-25 mb-0">
                                        <label class="form-label fw-700 timepicker required"
                                               for="endTime">{{ trans('poa.piat_matrix_create_placeholder_end_time') }}</label>
                                        <input type="time" wire:model.defer="endTime"
                                               class="form-control bg-transparent @error('endTime') is-invalid @enderror"
                                               placeholder="{{ trans('poa.piat_matrix_create_placeholder_end_time') }}"/>
                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('endTime') }}</div>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap align-items-center justify-content-between mt-2">
                                    <div class="form-group w-33 required mb-0">
                                        <label class="form-label fw-700"
                                               for="province">{{ trans('poa.piat_matrix_create_placeholder_province') }}</label>
                                        <select wire:model="province"
                                                class="custom-select bg-transparent @error('province') is-invalid @enderror"
                                                id="province">
                                            <option value="" selected>
                                                {{ trans('poa.piat_matrix_create_placeholder_province') }}
                                            </option>
                                            @foreach ($provinces as $item)
                                                <option value="{{ $item->id }}">{{ $item->description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('province') }}</div>
                                    </div>
                                    <div class="form-group w-33 mb-0">
                                        <label class="form-label fw-700 required"
                                               for="canton">{{ trans('poa.piat_matrix_create_placeholder_canton') }}</label>
                                        <select wire:model="canton"
                                                class="custom-select bg-transparent @error('canton') is-invalid @enderror">
                                            <option value="" selected>
                                                {{ trans('poa.piat_matrix_create_placeholder_canton') }}
                                            </option>
                                            @foreach ($cantons as $item)
                                                <option value="{{ $item->id }}">{{ $item->description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('canton') }}</div>
                                    </div>
                                    <div class="form-group w-33 mb-0">
                                        <label class="form-label fw-700 required"
                                               for="parish">{{ trans('poa.piat_matrix_create_placeholder_parish') }}</label>
                                        <select wire:model="parish"
                                                class="custom-select bg-transparent @error('parish') is-invalid @enderror">
                                            <option value="" selected>
                                                {{ trans('poa.piat_matrix_create_placeholder_parish') }}
                                            </option>
                                            @foreach ($parishes as $item)
                                                <option value="{{ $item->id }}">{{ $item->description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">{{ $errors->first('parish') }}</div>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap align-items-center w-100 mt-2">
                                    <div class="form-group w-25 mb-0 pr-1">
                                        <label class="form-label fw-700"
                                               for="maleBenef">{{ trans('poa.piat_matrix_create_placeholder_benef_male') }}</label>
                                        <input type="number" min="0" wire:model.defer="maleBenef" class="form-control"
                                               placeholder="Cantidad de beneficiarios hombres"/>
                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('maleBenef') }}</div>
                                    </div>
                                    <div class="form-group w-25 mr-4 mb-0">
                                        <label class="form-label fw-700"
                                               for="femaleBenef">{{ trans('poa.piat_matrix_create_placeholder_benef_female') }}</label>
                                        <input type="number" min="0" wire:model.defer="femaleBenef" class="form-control"
                                               placeholder="Cantidad de beneficiarios mujeres"/>
                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('femaleBenef') }}</div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-label">Selecionar fuente de responsables y personal asignado</label>
                                        <div class="custom-control custom-radio mb-2" wire:click="$set('sourceUsers',true)">
                                            <input type="radio" class="custom-control-input" id="usersSivol" name="radio-stacked" checked="">
                                            <label class="custom-control-label" for="usersSivol">Escoger personal de SIVOL</label>
                                        </div>
                                        <div class="custom-control custom-radio" wire:click="$set('sourceUsers',false)">
                                            <input type="radio" class="custom-control-input" id="usersSystem" name="radio-stacked">
                                            <label class="custom-control-label" for="usersSystem">Esoger personal del sistema</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap align-items-center justify-content-between w-100 mr-2 mt-2">
                                    <div class="form-group w-50 pr-1">
                                        <label class="form-label fw-700"
                                               for="goal">{{ trans('poa.piat_matrix_create_placeholder_goals') }}</label>
                                        <textarea wire:model.defer="goal" class="form-control"
                                                  placeholder="{{ trans('poa.piat_matrix_create_placeholder_goals') }}"></textarea>
                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('goal') }}</div>
                                    </div>
                                    @if($sourceUsers==true)
                                        <div class="form-group w-50 pr-1">
                                            <div class="alert alert-primary alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">
                                                    <i class="fal fa-times"></i>
                                                </span>
                                                </button>
                                                <div class="d-flex flex-start w-100">
                                                    <div class="mr-2 hidden-md-down">
                                                    <span class="icon-stack icon-stack-lg">
                                                        <i class="base base-6 icon-stack-3x opacity-100 color-primary-500"></i>
                                                        <i class="base base-10 icon-stack-2x opacity-100 color-primary-300 fa-flip-vertical"></i>
                                                        <i class="fal fa-info icon-stack-1x opacity-100 color-white"></i>
                                                    </span>
                                                    </div>
                                                    <div class="d-flex flex-fill">
                                                        <div class="flex-fill">
                                                            <p class="h6">Personal de SIVOL</p>
                                                            <p>Cuando complete la información de la nueva matriz podra hacer una solicitud a SIVOL con la cantidad requerida de
                                                                voluntarios.</p>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="form-group w-50 p-2">
                                            <div class="d-flex w-100">
                                                <div class="position-relative w-100" x-data="{ open: false }">
                                                    <button class="btn btn-outline-secondary dropdown-toggle-custom w-100  @if(count($usersSelect) > 0) filtered @endif"
                                                            x-on:click="open = ! open"
                                                            type="button">
                                                        <span class="spinner-border spinner-border-sm" wire:loading></span>
                                                        @if(count($usersSelect) > 0)
                                                            <span class="badge bg-white ml-2">
                                                              Cantidad de usuarios seleccionados {{' - '.count($usersSelect)}}
                                                          </span>
                                                        @else
                                                            {{trans_choice('general.users',1)}}
                                                        @endif
                                                    </button>
                                                    <div class="dropdown mb-2 w-100" x-on:click.outside="open = false" x-show="open"
                                                         style="will-change: top, left;top: 37px;left: 0;">
                                                        <div class="p-3 hidden-child" wire:loading.class.remove="hidden-child"
                                                             wire:target="usersSelect">
                                                            <div class="d-flex justify-content-center">
                                                                <div class="spinner-border">
                                                                    <span class="sr-only"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div wire:loading.class="hidden-child">
                                                            <div style="max-height: 300px; overflow-y: auto" class="w-100">
                                                                @if(empty($users))
                                                                    <div class="dropdown-item" x-cloak
                                                                         @click="open = false">
                                                                        <span>{{ trans_choice('general.users',1) }}</span>
                                                                    </div>
                                                                @endif
                                                                @foreach($users as $index => $item)
                                                                    <div class="dropdown-item cursor-pointer"
                                                                         wire:key="{{time().$index}}">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="i-user-{{ $item->id }}"
                                                                                   wire:model="usersSelect"
                                                                                   value="{{ $item->id }}">
                                                                            <label class="custom-control-label"
                                                                                   for="i-user-{{ $item->id }}">{{ $item->name  }}</label>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                                @if(count($usersSelect) > 0 )
                                                                    <div class="dropdown-divider"></div>
                                                                    <div class="dropdown-item">
                                                                        <span wire:click="$set('usersSelect', [])"
                                                                              class="cursor-pointer">{{ trans('general.delete_selection') }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <x-form.modal.footer data-dismiss="modal"></x-form.modal.footer>
                                </div>
                            </form>
                        @endif
                        @if ($newPoaActivityPiatId != null)
                            @if($sourceUsers==true)
                                <div class="card p-2">
                                    <div class="d-flex flex-wrap w-100">
                                        <div class="mr-4">
                                            <x-label-section>
                                                {{ trans('poa.request_sisvol') }}
                                            </x-label-section>
                                        </div>
                                        @if($showAddRequestSivol==false)
                                            <div>
                                                <button wire:click="$set('showAddRequestSivol',true)"
                                                        class="btn btn-sm btn-success waves-effect waves-themed mr-auto">
                                                    {{trans('general.new')}}
                                                </button>
                                            </div>
                                        @else
                                            <div>
                                                <button wire:click="$set('showAddRequestSivol',false)"
                                                        class="btn btn-sm btn-info waves-effect waves-themed mr-auto">
                                                    {{trans('general.close')}}
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="section-divider"></div>
                                    <div class="row">
                                        @if($responseRequest)
                                            <div class="col-12 p-2">
                                                <div class="panel-tag">
                                                    {{$responseRequest}}
                                                </div>
                                            </div>
                                        @endif
                                        @if($poaPiatRequestSivol->count()>0)
                                            <div class="w-100 pl-2">
                                                <div class="table-responsive">
                                                    <table class="table table-light table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th class="w-20">{{ __('general.description') }}</th>
                                                            <th class="w-20">{{ __('general.status') }}</th>
                                                            <th class="w-20">{{ __('general.number_request') }}</th>
                                                            <th class="w-20">{{ __('general.number_activated') }}</th>
                                                            <th class="w-20">{{ __('general.response') }}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @forelse($poaPiatRequestSivol as $index => $item)
                                                            <tr wire:key="{{time().$index.$item['id']}}" wire:ignore>
                                                                <td>
                                                                    {{$item->description}}
                                                                </td>
                                                                <td>
                                                                    {{$item->status}}
                                                                </td>
                                                                <td>
                                                                    {{$item->number_request}}
                                                                </td>
                                                                <td>
                                                                    {{$item->number_activated}}
                                                                </td>
                                                                <td>
                                                                    {{$item->response}}
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="7">
                                                                    <div class="d-flex align-items-center justify-content-center">
                                                            <span class="color-fusion-500 fs-3x py-3"><i
                                                                        class="fas fa-exclamation-triangle color-warning-900"></i>
                                                                No se encontraron actividades</span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endif
                                        @if($showAddRequestSivol==true)
                                            <div class="col-4">
                                                <div class="d-flex flex-wrap align-items-center w-100 mt-2">
                                                    <div class="form-group w-100">
                                                        <label class="form-label fw-700"
                                                               for="numberRequestVol">{{ trans('poa.piat_request_vol') }}</label>
                                                        <input type="number" min="0" wire:model.defer="numberRequestVol" class="form-control"
                                                               placeholder="Cantidad de vlontarios hombres"/>
                                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('numberRequestVol') }}</div>
                                                    </div>
                                                    <div class="form-group w-100">
                                                        <button wire:click="requestVol"
                                                                class="btn btn-sm btn-success waves-effect waves-themed w-100">
                                                            <span class="fal fa-shield-check mr-1"></span>
                                                            {{trans('general.request')}}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="alert alert-primary">
                                                    <div class="d-flex flex-start w-100">
                                                        <div class="mr-2 hidden-md-down">
                                                            <img src="{{ asset_cdn('img/logo_sivol2.png') }}" class="width-10">
                                                        </div>
                                                        <div class="d-flex flex-fill">
                                                            <div class="flex-fill">
                                                                <span class="h5">Solciitud de activación de voluntarios para la actividad</span>
                                                                <br> Al dar click en solicitar, se enviará una solicitud de activación de la cantidad voluntarios necesarios
                                                                para la
                                                                actividad.
                                                                <code>Verificar que el # ingresado sea correcto,</code> Una vez la solicitud haya sido aceptada desde SIVOL
                                                                se
                                                                mostrara
                                                                el listado de voluntarios asignadors.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-12" wire:loading wire:target="requestVol">
                                            <div class="frame-wrap">
                                                <div class="border p-3">
                                                    <div class="d-flex align-items-center">
                                                        <strong>Procesando solicitud...</strong>
                                                        <div class="spinner-border ml-auto color-success-700" role="status" aria-hidden="true"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <hr>
                            <form wire:submit.prevent="submitPlan()" method="post" autocomplete="off">
                                <div class="d-flex flex-wrap w-100">
                                    <div class="mr-auto">
                                        <div>MATRIZ: {{ $newPoaActivityPiatName }}</div>
                                        <div></div>
                                        <div class="section-divider"></div>
                                        <x-label-section>{{ trans('poa.piat_matrix_activity_plan') }}</x-label-section>
                                    </div>
                                    <div class="ml-auto">
                                        <button wire:click="terminate()" type="button" class="btn btn-danger btn-sm">
                                            <span aria-hidden="true">Terminar</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="section-divider"></div>
                                <div class="d-flex flex-wrap align-items-center justify-content-between w-65">
                                    <div class="form-group w-50 mb-0 pr-1">
                                        <label class="form-label fw-700 required"
                                               for="task">{{ trans('poa.piat_matrix_create_placeholder_task') }}</label>
                                        <input type="text" class="form-control"
                                               placeholder="{{ trans('poa.piat_matrix_create_placeholder_task') }}"
                                               wire:model.defer="task">
                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('task') }}</div>
                                    </div>
                                    @if($sourceUsers==false)
                                        <div class="form-group w-50">
                                            <label class="form-label fw-700"
                                                   for="responsable">{{ trans('poa.piat_matrix_create_placeholder_responsable') }}</label>
                                            <select wire:model.defer="responsable" class="custom-select bg-transparent">
                                                <option value="" selected>
                                                    {{ trans('poa.piat_matrix_create_placeholder_responsable') }}
                                                </option>
                                                @foreach ($poaPiatResponsibles as $item)
                                                    @if($item->user_id)
                                                        <option value="{{ $item->id }}">{{ $item->user->name }}</option>
                                                    @else
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback" style="display: block;">{{ $errors->first('responsable') }}</div>
                                        </div>
                                    @endif
                                </div>
                                <div class="d-flex flex-wrap align-items-center justify-content-between w-100">
                                    <div class="form-group w-25 mb-0">
                                        <label class="form-label fw-700 required"
                                               for="planDate">{{ trans('poa.piat_matrix_create_placeholder_date') }}</label>
                                        <input type="date" wire:model.defer="planDate" class="form-control"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('poa.piat_matrix_create_placeholder_date')]) }}"/>
                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('planDate') }}</div>
                                    </div>

                                    <div class="form-group w-25 mb-0">
                                        <label class="form-label fw-700 required"
                                               for="planEndDate">{{ trans('poa.piat_matrix_create_placeholder_end_date') }}</label>
                                        <input type="date" wire:model.defer="planEndDate" class="form-control"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('poa.piat_matrix_create_placeholder_end_date')]) }}"/>
                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('planEndDate') }}</div>
                                    </div>
                                    <div class="form-group w-25 mb-0">
                                        <label class="form-label fw-700 timepicker required"
                                               for="planInitTime">{{ trans('poa.piat_matrix_create_placeholder_initial_time') }}</label>
                                        <input type="time" wire:model.defer="planInitTime" class="form-control"
                                               placeholder="{{ trans('poa.piat_matrix_create_placeholder_initial_time') }}"/>
                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('planInitTime') }}</div>
                                    </div>
                                    <div class="form-group w-25">
                                        <label class="form-label fw-700 timepicker required"
                                               for="planEndTime">{{ trans('poa.piat_matrix_create_placeholder_end_time') }}</label>
                                        <input type="time" wire:model.defer="planEndTime" class="form-control"
                                               placeholder="{{ trans('poa.piat_matrix_create_placeholder_end_time') }}"/>
                                        <div class="invalid-feedback" style="display: block;">{{$errors->first('planEndTime') }}</div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <div class="card-footer text-muted py-2 text-center">
                                        <a wire:click="resetPlanForm()" href="javascript:void(0);" class="btn btn-outline-secondary mr-1">
                                            <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                            @if (count($piatPlan) > 0)
                                <div class="card-body pt-0">
                                    <div class="frame-wrap">
                                        <table class="table m-0">
                                            <thead>
                                            <tr>
                                                <th>{{ __('poa.piat_matrix_create_placeholder_task') }}</th>
                                                <th>{{ __('poa.piat_matrix_create_placeholder_date') }}</th>
                                                <th>{{ __('poa.piat_matrix_create_placeholder_end_date') }}</th>
                                                <th>{{ __('poa.piat_matrix_create_placeholder_initial_time') }}</th>
                                                <th>{{ __('poa.piat_matrix_create_placeholder_end_time') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($piatPlan as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex float-left">
                                                            <span
                                                                    class="color-item shadow-hover-5 mr-2 cursor-default"></span>
                                                            <span>{{ $item['task'] }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex float-left">
                                                            <span
                                                                    class="color-item shadow-hover-5 mr-2 cursor-default"></span>
                                                            <span>{{ $item['date'] }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex float-left">
                                                            <span
                                                                    class="color-item shadow-hover-5 mr-2 cursor-default"></span>
                                                            <span>{{ $item['end_date'] }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex float-left">
                                                            <span
                                                                    class="color-item shadow-hover-5 mr-2 cursor-default"></span>
                                                            <span>{{ $item['initial_time'] }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex float-left">
                                                            <span
                                                                    class="color-item shadow-hover-5 mr-2 cursor-default"></span>
                                                            <span>{{ $item['end_time'] }}</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <span class="color-fusion-500 fs-3x py-3"><i
                                                                        class="fas fa-exclamation-triangle color-warning-900"></i>
                                                                No se encontraron actividades</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                            <form wire:submit.prevent="submitRequirements()" method="post" autocomplete="off">
                                <div class="section-divider"></div>
                                <x-label-section>{{ trans('poa.piat_matrix_activity_requirement') }}</x-label-section>
                                <div class="section-divider"></div>

                                <div class="d-flex flex-wrap align-items-center w-100">
                                    <div class="form-group w-33 pr-1 mb-0">
                                        <label class="form-label fw-700 required"
                                               for="quantity">{{ trans('poa.piat_matrix_create_placeholder_quantity') }}</label>
                                        <input type="number" min="1" class="form-control"
                                               placeholder="{{ trans('poa.piat_matrix_create_placeholder_quantity') }}"
                                               wire:model="quantity">
                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('quantity') }}</div>
                                    </div>
                                    <div class="form-group w-33 pr-1 mb-0">
                                        <label class="form-label fw-700 required"
                                               for="approxCost">{{ trans('poa.piat_matrix_create_placeholder_cost') }}</label>
                                        <input type="number" min="1" class="form-control"
                                               placeholder="{{ trans('poa.piat_matrix_create_placeholder_cost') }}"
                                               wire:model="approxCost">
                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('approxCost') }}</div>
                                    </div>
                                    @if($sourceUsers==false)
                                        <div class="form-group w-33">
                                            <label class="form-label fw-700"
                                                   for="reqResponsable">{{ trans('poa.piat_matrix_create_placeholder_responsable') }}</label>
                                            <select wire:model="reqResponsable" class="custom-select bg-transparent">
                                                <option value="" selected>
                                                    {{ trans('poa.piat_matrix_create_placeholder_responsable') }}
                                                </option>
                                                @foreach ($poaPiatResponsibles as $item)
                                                    @if($item->user_id)
                                                        <option value="{{ $item->id }}">{{ $item->user->name }}</option>
                                                    @else
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback" style="display: block;">{{ $errors->first('reqResponsable') }}</div>
                                        </div>
                                    @endif
                                </div>
                                <div class="d-flex flex-wrap align-items-center justify-content-between w-100 mr-2">
                                    <div class="form-group w-100 pr-1 mb-0">
                                        <label class="form-label fw-700 required"
                                               for="description">{{ trans('poa.piat_matrix_create_placeholder_description') }}</label>
                                        <input type="text" class="form-control"
                                               placeholder="{{ trans('poa.piat_matrix_create_placeholder_description') }}"
                                               wire:model="description">
                                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('description') }}</div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <div class="card-footer text-muted py-2 text-center">
                                        <a wire:click="resetRequirementsForm()" href="javascript:void(0);" class="btn btn-outline-secondary mr-1">
                                            <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                            @if (count($piatReq) > 0)
                                <div class="card-body pt-0">
                                    <div class="frame-wrap">
                                        <table class="table m-0">
                                            <thead>
                                            <tr>
                                                <th>{{ __('poa.piat_matrix_create_placeholder_description') }}</th>
                                                <th>{{ __('poa.piat_matrix_create_placeholder_quantity') }}</th>
                                                <th>{{ __('poa.piat_matrix_create_placeholder_cost') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($piatReq as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex float-left">
                                                            <span
                                                                    class="color-item shadow-hover-5 mr-2 cursor-default"></span>
                                                            <span>{{ $item['description'] }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex float-left">
                                                            <span
                                                                    class="color-item shadow-hover-5 mr-2 cursor-default"></span>
                                                            <span>{{ $item['quantity'] }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex float-left">
                                                            <span
                                                                    class="color-item shadow-hover-5 mr-2 cursor-default"></span>
                                                            <span>{{ $item['approximate_cost'] }}</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <span class="color-fusion-500 fs-3x py-3"><i
                                                                        class="fas fa-exclamation-triangle color-warning-900"></i>
                                                                No se encontraron requerimientos</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
