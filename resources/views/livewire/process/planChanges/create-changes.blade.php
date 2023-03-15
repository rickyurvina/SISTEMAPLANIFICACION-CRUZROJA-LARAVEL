<div wire:ignore.self class="modal fade in" id="plan-create-changes" tabindex="-1" role="dialog"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary color-white">
                <h5 class="modal-title h4">{{ __('general.poa_create_change_title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-2">
                    <x-form.modal.text id="code" label="{{ __('general.code') }}" required="required"
                                       class="form-group col-6 required"
                                       placeholder="{{ __('general.form.enter', ['field' => __('general.code')]) }}">
                    </x-form.modal.text>
                    <x-form.modal.date id="date" label="{{ __('general.date') }}" required="required"
                                       class="form-group col-6 required"
                                       placeholder="{{ __('general.form.enter', ['field' => __('general.date')]) }}">
                    </x-form.modal.date>


                    <x-form.modal.textarea id="description"
                                           label="{{ __('general.description') }}"
                                           class="form-group col-12 required">
                    </x-form.modal.textarea>

                    <x-form.modal.textarea id="objective"
                                           label="{{ __('general.objective') }}"
                                           class="form-group col-12 required">
                    </x-form.modal.textarea>
                    <x-form.modal.textarea id="consequence"
                                           label="{{ __('general.consequence') }}"
                                           class="form-group col-12 required">
                    </x-form.modal.textarea>
                </div>
            </div>
            <div class="justify-content-center">
                <x-form.modal.footer wirecancelevent="resetForm" wiresaveevent="save"></x-form.modal.footer>
            </div>
        </div>
    </div>
</div>
