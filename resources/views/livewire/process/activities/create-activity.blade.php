<div wire:ignore.self class="modal fade in" id="plan-create-activity" tabindex="-1" role="dialog"
     aria-hidden="true" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary color-white">
                <h5 class="modal-title h4">{{ __('general.poa_create_activity_title') }}</h5>
                <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-2">

                    <x-form.modal.text id="code" label="{{ __('general.code') }}" required="required"
                                       class="form-group col-6 required"
                                       placeholder="{{ __('general.form.enter', ['field' => __('general.code')]) }}">
                    </x-form.modal.text>
                    <x-form.modal.text id="name" label="{{ __('general.name') }}" required="required"
                                       class="form-group col-6 required"
                                       placeholder="{{ __('general.form.enter', ['field' => __('general.name')]) }}">
                    </x-form.modal.text>
                    <x-form.modal.textarea id="expected_result"
                                           label="{{ __('general.expected_result') }}"
                                           class="form-group col-12 required"
                    >
                    </x-form.modal.textarea>
                    <x-form.modal.select id="generated_service_id"
                                         label="{{ __('general.generated_service') }}"
                                         class="form-group col-12">
                        <option value="">{{ __('general.form.select.field', ['field' => __('general.generated_service')]) }}</option>
                        @foreach($generated_services as $index=>$item)
                            <option value="{{$item->id}}">{{ $item->name }}</option>
                        @endforeach
                    </x-form.modal.select>
                    <x-form.modal.textarea id="specifications"
                                           label="{{ __('general.specs') }}"
                                           class="form-group col-12"
                    >
                    </x-form.modal.textarea>
                    <x-form.modal.textarea id="cares"
                                           label="{{ __('general.cares') }}"
                                           class="form-group col-12"
                    >
                    </x-form.modal.textarea>
                    <x-form.modal.textarea id="procedures"
                                           label="{{ __('general.procedures') }}"
                                           class="form-group col-12"
                    >
                    </x-form.modal.textarea>
                    <x-form.modal.textarea id="equipment"
                                           label="{{ __('general.equipment') }}"
                                           class="form-group col-12"
                    >
                    </x-form.modal.textarea>
                    <x-form.modal.textarea id="supplies"
                                           label="{{ __('general.supplies') }}"
                                           class="form-group col-12"
                    >
                    </x-form.modal.textarea>

                </div>
            </div>
            <div class="justify-content-center">
                <x-form.modal.footer wirecancelevent="resetForm" wiresaveevent="submitActivity"></x-form.modal.footer>
            </div>
        </div>
    </div>
</div>
