<div>
    <div wire:ignore.self class="modal fade" id="poa-piat-activity-rescheduling" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 70rem;">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Solicitar Reprogramación</h5>
                    <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <form wire:submit.prevent="create()" method="post" autocomplete="off">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-12 required">
                                <label class="form-label"
                                       for="description">{{ trans('general.description') }}</label>
                                <textarea wire:model.defer="description" rows="3"
                                          class="form-control bg-transparent @error('description') is-invalid @enderror">
                        </textarea>
                                <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="justify-content-center">
                        <x-form.modal.footer></x-form.modal.footer>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
