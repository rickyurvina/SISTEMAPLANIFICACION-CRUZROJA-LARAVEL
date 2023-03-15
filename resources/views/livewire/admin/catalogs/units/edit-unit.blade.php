<div>
    <div wire:ignore.self class="modal fade in" id="update-unit" data-backdrop="static" data-keyboard="false" tabindex="-1"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary color-white">
                    <h5 class="modal-title h4">{{ trans('general.update').' '.trans_choice('general.sources', 2)  }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="far fa-times color-white"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($unit)
                        <div class="row">
                            <x-form.modal.text id="name" label="{{ __('general.name') }}" required="required"
                                               class="form-group col-6 required"
                                               placeholder="{{ __('general.form.enter', ['field' => __('general.name')]) }}">
                            </x-form.modal.text>
                            <x-form.modal.text id="abbreviation" label="{{ __('general.abbreviation') }}" required="required"
                                               class="form-group col-6 required"
                                               placeholder="{{ __('general.form.enter', ['field' => __('general.abbreviation')]) }}">
                            </x-form.modal.text>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="is_for_people" name="is_for_people" wire:model="is_for_people">
                                <label class="custom-control-label" for="is_for_people">Indicador de Personas</label>
                            </div>
                        </div>
                        <br>
                        <div class="justify-content-center">
                            <x-form.modal.footer wirecancelevent="resetForm" wiresaveevent="save"></x-form.modal.footer>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>