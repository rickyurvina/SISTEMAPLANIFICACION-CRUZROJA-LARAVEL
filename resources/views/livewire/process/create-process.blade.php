<div>
    <div wire:ignore.self class="modal fade in" id="create-process-modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary color-white">
                    <h5 class="modal-title h4">{{ trans('general.create').' '.trans_choice('general.module_process', 1)  }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="far fa-times color-white"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <x-form.modal.text id="code" label="{{ __('general.code') }}" required="required"
                                           class="form-group col-6 required"
                                           placeholder="{{ __('general.form.enter', ['field' => __('general.code')]) }}">
                        </x-form.modal.text>

                        <x-form.modal.text id="name" label="{{ __('general.name') }}" required="required"
                                           class="form-group col-6 required"
                                           placeholder="{{ __('general.form.enter', ['field' => __('general.name')]) }}">
                        </x-form.modal.text>

                        <x-form.modal.select id="type"
                                             label="{{ trans('general.type') }}"
                                             class="col-6 form-group required">
                            <option value="">{{ trans('general.form.select.field', ['field' => trans('general.type')]) }}</option>
                            @foreach($types as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </x-form.modal.select>

                        <x-form.modal.select id="ownerId"
                                             label="{{ trans('general.process_owner') }}"
                                             class="col-6 form-group required">
                            <option value="">{{ trans('general.form.select.field', ['field' => trans('general.process_owner')]) }}</option>
                            @if($users)
                                @foreach($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->getFullName() }}</option>
                                @endforeach
                            @endif
                        </x-form.modal.select>
                        <x-form.modal.textarea id="description"
                                               label="{{ __('general.description') }}"
                                               class="form-group mt-1 col-6">
                        </x-form.modal.textarea>
                        <x-form.modal.textarea id="attributions"
                                               label="{{ __('general.attributions') }}"
                                               class="form-group mt-1 col-6">
                        </x-form.modal.textarea>
                        <x-form.modal.select id="services"
                                             label="{{ trans('general.client_type') }}"
                                             class="col-6 form-group">
                            <option value="">{{ trans('general.form.select.field', ['field' => trans('general.client_type')]) }}</option>
                            @foreach(\App\Models\Process\Process::TYPES_CLIENTS as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </x-form.modal.select>

                        <x-form.modal.text id="cycle_time" type="number"  label="{{ __('general.cycle_time') }}"
                                           class="form-group col-6"
                                           placeholder="{{ __('general.form.enter', ['field' => __('general.cycle_time')]) }}">
                        </x-form.modal.text>
                        <x-form.modal.text id="people_number" type="number" label="{{ __('general.people_number') }}"
                                           class="form-group col-6"
                                           placeholder="{{ __('general.form.enter', ['field' => __('general.people_number')]) }}">
                        </x-form.modal.text>
                        <x-form.modal.textarea id="product_services"
                                               label="{{ __('general.product_services') }}"
                                               class="form-group mt-1 col-6">
                        </x-form.modal.textarea>

                    </div>
                    <br>
                    <div class="justify-content-center">
                        <x-form.modal.footer wirecancelevent="resetForm" wiresaveevent="save"></x-form.modal.footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>