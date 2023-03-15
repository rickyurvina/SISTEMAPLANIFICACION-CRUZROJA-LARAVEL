<div>
    <div class="d-flex flex-wrap">
        <x-label-detail><small class="badge badge-info">Solicitudes Abiertas </small></x-label-detail>
        <x-content-detail><small class="badge badge-info">{{$data[0]['abiertas']}} </small></x-content-detail>
    </div>
    <div class="d-flex flex-wrap">
        <x-label-detail><small class="badge badge-success">Solicitudes Aprobadas </small></x-label-detail>
        <x-content-detail><small class="badge badge-success">{{$data[0]['aprobadas']}}</small></x-content-detail>
    </div>
    <div class="d-flex flex-wrap">
        <x-label-detail><small class="badge badge-danger">Solicitudes Rechazadas </small></x-label-detail>
        <x-content-detail><small class="badge badge-danger">{{$data[0]['rechazadas']}} </small></x-content-detail>
    </div>
    <x-label-section>Solicitar Cambios de Metas</x-label-section>
    <div class="section-divider"></div>
    <div class="d-flex flex-wrap mt-1">
        <x-label-section>Solicitudes Realizadas</x-label-section>

        <div class="ml-auto mr-3">
            <a href="javascript:void(0);" class="color-black" wire:click="$set('showAddRequest', true)">
                <i class="fal fa-plus fa-1x"></i>
            </a>
        </div>
    </div>
    @if($showAddRequest)
        <form wire:submit.prevent="submitRequest()" method="post" autocomplete="off">
            <div class="modal-body">
                <div class="row">
                    @foreach($goals as $item)
                        <div class="d-flex flex-wrap align-items-center justify-content-between w-25">
                            <div class="form-group w-50">
                                <label class="form-label fw-700" for="goals.{{ $loop->index }}.goal">{{ $item['monthName'] }}</label>
                                <input type="text" id="goals.{{ $loop->index }}.goal" class="form-control" placeholder="Ejecutado" value="{{$item['goal']}}"
                                       wire:model="goals.{{$loop->index}}.goal" readonly="readonly">
                                <span class="help-block">
                                           Valor actual.
                                        </span>
                            </div>
                            <div class="form-group w-50">
                                <input type="number" step="0.01" min="0" id="goals.{{ $loop->index }}.request" class="form-control" placeholder="Valor Solicitado"
                                       wire:model="goals.{{$loop->index}}.request">
                                <span class="help-block">
                                             Solicitud.
                                        </span>
                            </div>
                        </div>
                    @endforeach

                    <x-form.modal.textarea id="goalRequestJustificationForm" label="{{ __('general.poa_request_justification') }}"
                                           class="form-group col-12">
                    </x-form.modal.textarea>

                    <div class="form-group col-12 pl-6 pt-4">
                        <x-fileupload
                                wire:model.defer="files"
                                allowRevert
                                allowRemove
                                allowFileSizeValidation
                                maxFileSize="4mb">
                        </x-fileupload>
                        <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('files',':message') }} </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <x-form.modal.footer wirecancelevent="resetForm">
                    </x-form.modal.footer>
                </div>
            </div>
        </form>
    @else
        @foreach($listRequests as $index => $request)
            <div class="d-flex flex-wrap mt-2" wire:key="{{time().$index}}">
                <i class="fal fa-bring-forward color-info-600 mr-2 ml-2 mt-2"></i>
                <div class="fs-1x color-info-600 mr-2">
                    <x-label-detail>
                         <span data-toggle="modal" data-target="#edit-request-modal" data-request-id="{{ $request->first()->id }}">
                                <a class="mr-2" href="javascript:void(0);">
                                    Solicitud #{{$request->first()->request_number}}
                                </a>
                            </span>
                    </x-label-detail>
                </div>
                <div class="fs-1x mr-2">
                    <x-label-detail># Cambios {{$request->count()}}</x-label-detail>
                </div>
                <div class="fs-1x  mr-2">
                    <x-content-detail>
                        <div class=" d-flex flex-wrap">
                            <span class="fw-600">  Usuario que solicita:</span>
                            <span class="color-primary-600"> {{$request->first()->requestUser->getFullName()}}</span>
                        </div>
                    </x-content-detail>

                </div>
                <div class="d-flex">
                    <x-content-detail>
                        <span class="badge badge- {{ \App\Models\Poa\PoaIndicatorGoalChangeRequest::STATUS_BG[$request->first()->status] }} badge-pill">{{ $request->first()->status }}</span>
                    </x-content-detail>
                </div>
            </div>
        @endforeach
    @endif
    @if($showAddRequest===false && $listRequests->count()==0)
        <div wire:key="{{time().'request'}}">
            <x-empty-content>
                <x-slot name="img">
                    <i class="fas fa-cloud-upload-alt" style="color: #2582fd;"></i>
                </x-slot>
                <x-slot name="title">
                    {{ trans('general.poa_request') }}
                </x-slot>
                <x-slot name="info">
                    {{ trans('messages.info.empty_attachment') }}
                </x-slot>

                <div class="d-flex flex-column">
                    <a href="#" wire:click="$set('showAddRequest', true)">
                        <i class="fal fa-plus fa-1x">{{ trans('general.add_request') }}</i>
                    </a>
                </div>
            </x-empty-content>
        </div>
    @endif
    <div wire:ignore>
        <livewire:poa.requests.poa-goal-change-request/>
    </div>
</div>
@push('page_script')
    <script>
        Livewire.on('toggleModalGoalChangeRequest', () => $('#edit-request-modal').modal('toggle'));

        $('#edit-request-modal').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let requestId = $(e.relatedTarget).data('request-id');
            //Livewire event trigger
            Livewire.emit('requestGoalChangeEdit', requestId, true);
        });
    </script>
@endpush