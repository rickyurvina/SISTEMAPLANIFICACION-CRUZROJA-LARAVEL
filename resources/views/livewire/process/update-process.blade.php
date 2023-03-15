<div>
    <div class="modal fade" id="update-process-modal" tabindex="-1" aria-hidden="true" style="display: none;" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary color-white">
                    <h5 class="modal-title h4">{{ trans('general.edit').' '.trans_choice('general.module_process', 1)  }}</h5>
                    <button type="button" class="close" aria-label="Close" wire:click="closeModal()">
                        <span aria-hidden="true"><i class="far fa-times color-white"></i></span>
                    </button>
                </div>
                @if($process)
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

                            <x-form.modal.selectwd id="owner_id"
                                                   label="{{ trans('general.process_owner') }}"
                                                   class="col-6 form-group required">
                                <option value="">{{ trans('general.form.select.field', ['field' => trans('general.process_owner')]) }}</option>
                                @foreach($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->getFullName() }}</option>
                                @endforeach
                            </x-form.modal.selectwd>

                            <x-form.modal.textarea id="description"
                                                   label="{{ __('general.description') }}"
                                                   class="form-group col-6">
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
                            <div class="card-footer text-center">
                                <div class="row">
                                    <div class="col-12">
                                        <a class="btn btn-outline-secondary mr-1" wire:click="closeModal">
                                            <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                                        </a>
                                        <button wire:click="save" class="btn btn-primary">
                                            <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                @endif
            </div>
        </div>
    </div>
</div>