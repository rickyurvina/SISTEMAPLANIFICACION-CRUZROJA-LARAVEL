<div wire:ignore.self class="modal fade in" id="plan-create-activity" tabindex="-1" role="dialog"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary color-white">
                <h5 class="modal-title h4">{{ __('general.activity') }}</h5>
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
                    <x-form.modal.text id="name" label="{{ __('general.name') }}" required="required"
                                       class="form-group col-6 required"
                                       placeholder="{{ __('general.form.enter', ['field' => __('general.name')]) }}">
                    </x-form.modal.text>
                    <x-form.modal.date id="start_date" label="{{ __('general.start_date') }}" required="required"
                                       class="form-group col-6 required"
                                       placeholder="{{ __('general.form.enter', ['field' => __('general.start_date')]) }}">
                    </x-form.modal.date>
                    <x-form.modal.date id="end_date" label="{{ __('general.end_date') }}" required="required"
                                       class="form-group col-6 required"
                                       placeholder="{{ __('general.form.enter', ['field' => __('general.end_date')]) }}">
                    </x-form.modal.date>
                    <x-form.modal.select id="user_id"
                                         label="{{ __('general.responsible') }}"
                                         class="form-group col-6 required">
                        <option value="">{{ __('general.form.select.field', ['field' => __('general.user')]) }}</option>
                        @foreach($users as $item)
                            <option value="{{ $item->id }}">{{ $item->getFullName() }}</option>
                        @endforeach
                    </x-form.modal.select>

                    <x-form.modal.textarea id="description"
                                           label="{{ __('general.description') }}"
                                           class="form-group col-6 required">
                    </x-form.modal.textarea>
                </div>
            </div>
            <div class="justify-content-center">
                <x-form.modal.footer wirecancelevent="cancelForm" wiresaveevent="save"></x-form.modal.footer>
            </div>
        </div>
    </div>
</div>
