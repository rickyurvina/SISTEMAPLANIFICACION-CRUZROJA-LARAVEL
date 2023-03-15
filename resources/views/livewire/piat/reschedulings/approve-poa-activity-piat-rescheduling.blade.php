<div>
    <div wire:ignore.self class="modal fade" id="approve-poa-activity-piat-rescheduling" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 70rem;">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Aprobar Reprogramación</h5>
                    <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                @if($activity)
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <x-label-section>Razón de la Reprogramación</x-label-section>
                                <p class="mt-1">
                                    {{$description}}
                                </p>
                            </div>
                            <div class="form-group col-6">
                                <x-label-section>Usuario que solicita</x-label-section>
                                <div class="d-flex">
                                    <div class="" @if($rescheduling->applicant) data-toggle="tooltip" data-placement="top"
                                         title="{{ $rescheduling->applicant->getFullName() }}" data-original-title="{{ $rescheduling->applicant->getFullName() }}" @endif>
                                        <div class="dropdown-item">
                                                            <span class="mr-2">
                                                                <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle width-1">
                                                            </span>
                                            <span class="pt-1">{{ $rescheduling->applicant->getFullName() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                @endif
                <div class="justify-content-center">
                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="col-12">
                                <a class="btn btn-outline-secondary mr-1" wire:click="resetForm" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                                </a>
                                <button wire:click="approve" class="btn btn-primary">
                                    <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
