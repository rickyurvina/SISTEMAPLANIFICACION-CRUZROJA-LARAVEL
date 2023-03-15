<div wire:ignore.self class="modal fade in" id="create-non-conformity" tabindex="-1" role="dialog"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary color-white">
                <h5 class="modal-title h4">{{ trans('general.create')}} {{trans('general.nonconformity')}}</h5>
                <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-2">

                    <x-form.modal.text id="code" label="{{ __('general.code') }}" required="required"
                                       class="form-group col-4 required"
                                       placeholder="{{ __('general.form.enter', ['field' => __('general.code')]) }}">
                    </x-form.modal.text>

                    <x-form.modal.text id="number" label="{{ __('general.number') }}" required="required"
                                       class="form-group col-4 required"
                                       placeholder="{{ __('general.form.enter', ['field' => __('general.number')]) }}">
                    </x-form.modal.text>

                    <x-form.modal.select id="type"
                                         label="{{ __('general.type') }}"
                                         class="form-group col-4 required">
                        <option value="">{{ __('general.form.select.field', ['field' => __('general.type')]) }}</option>
                        @foreach(\App\Models\Process\NonConformities::TYPES as $item)
                              <option value="{{$item}}">{{$item}}</option>
                         @endforeach
                    </x-form.modal.select>

                    <x-form.modal.textarea id="description"
                                           label="{{ __('general.description') }}"
                                           class="form-group col-12 required"
                    >
                    </x-form.modal.textarea>

                    <x-form.modal.textarea id="evidence"
                                           label="{{ __('general.evidence') }}"
                                           class="form-group col-12 required"
                    >
                    </x-form.modal.textarea>

                    <div class="form-group col-12 w-100">
                        <livewire:components.list-view title="{{ __('general.causes') }} {{__('general.root')}}"
                                                       event="causesAdded"
                        />
                    </div>

                </div>
            </div>
            <div class="justify-content-center">
                <x-form.modal.footer wirecancelevent="resetForm" wiresaveevent="save"></x-form.modal.footer>
            </div>
        </div>
    </div>
</div>
