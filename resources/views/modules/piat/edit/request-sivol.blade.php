@if($responsibles->count()==0 && !$is_terminated)
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
    <hr>
@endif