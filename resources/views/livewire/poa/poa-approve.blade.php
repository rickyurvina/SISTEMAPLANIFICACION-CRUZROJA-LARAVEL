<div>
    <div wire:ignore.self class="modal fade fade" id="approve-modal-poa" tabindex="-1" style="display: none;">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                @if($poa)
                    <div class="modal-content">
                        <div class="modal-header">
                            @if($poa->approved===true)
                                <h5 class="modal-title h4"><i
                                            class="fas fa-check-circle text-success"></i>Aprobado por {{$poa->approvedBy->getFullName()}}
                                    el {{$poa->approved_date->format('j F, Y')}}
                                </h5>
                            @else
                                <h5 class="modal-title h4"><i
                                            class="fas fa-check-circle text-success"></i> {{ trans('general.poa_approve')  }} {{trans('general.poa')}} @if($poa)
                                        {{$poa->name.' - '.$poa->year}}
                                    @endif
                                </h5>
                            @endif
                            <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="border: 1px solid #e5e5e5; overflow: auto; padding: 10px;">
                                <p>El plan operativo anual detalla las acciones que permiten alcanzar los objetivos institucionales, el mismo debe ser aprobado por
                                    Asamblea Nacional o Provincial según corresponda .
                                    Por favor cargar él acta de la asamblea en la cual se dio aprobación del POA.
                                </p>
                            </div>
                            @if(!$poa->approved)
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="terms" wire:model="terms">
                                    <label class="custom-control-label" for="terms">He leído y estoy de acuerdo con los Téminos y Condiciones</label>
                                </div>
                            @endif

                            @if($poa)
                                <div class="d-flex flex-wrap">
                                    <div class="mt-2 w-100">
                                        <livewire:components.files :modelId="$poa->id"
                                                                   model="{{\App\Models\Poa\Poa::class}}"
                                                                   folder="approvals"/>
                                    </div>
                                    <div class="mt-2 w-100">
                                        <x-label-section>{{ trans('general.comments') }}</x-label-section>
                                        <livewire:components.comments :modelId="$poa->id"
                                                                      class="{{\App\Models\Poa\Poa::class}}"
                                                                      :key="time().$poa->id"
                                                                      identifier="approvals"/>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if($terms && !$poa->approved)
                            <div class="modal-footer justify-content-center">
                                <button class="btn btn-success" wire:click="submit">
                                    <i class="fas fa-save pr-2"></i> {{ trans('general.poa_approve') }}
                                </button>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>