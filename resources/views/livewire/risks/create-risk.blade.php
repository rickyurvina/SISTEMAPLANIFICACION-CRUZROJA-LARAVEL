<div class="ml-auto"
        x-data="{ show: @entangle('show')}"
        x-init="$watch('show', value => { if (value) { $('#create-risk-modal').modal('show') } else { $('#create-risk-modal').modal('hide'); } })"
        x-on:keydown.escape.window="show = false"
        x-on:close.stop="show = false"
>
    <button type="button" class="btn btn-success border-0 shadow-0" x-on:click="show = true">
      {{ trans('general.create_risk') }}
    </button>
    <div class="modal fade" id="create-risk-modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
         aria-hidden="true" style="display: none;" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary color-white">
                    <h5 class="modal-title h4">{{ trans('general.create').' '.trans_choice('general.risks', 1)  }}</h5>
                    <button type="button" class="close" aria-label="Close" x-on:click="show = false">
                        <span aria-hidden="true"><i class="far fa-times color-white"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <x-form.modal.text id="name"
                                               label="{{ trans('general.name') }}"
                                               required="required" class="form-group col-12 required"
                                               placeholder="{{ __('general.form.enter', ['field' => __('general.name')]) }}">
                            </x-form.modal.text>
                            <x-form.modal.textarea id="description"
                                                   label="{{ __('general.description') }}"
                                                   class="form-group col-12 required">
                            </x-form.modal.textarea>
                            @if($classifications)
                                <x-form.modal.select id="classification" label="{{ trans('general.classification') }}"
                                                     class="form-group col-12 required">
                                    <option
                                            value="">{{ trans('general.form.select.field', ['field' => trans('general.classification')]) }}</option>
                                    @foreach($classifications as $item)
                                        <option
                                                value="{{ $item->id }}" {{ (collect(old('classifications'))->contains($item->id)) ? 'selected':'' }}>{{ $item->name }}</option>
                                    @endforeach
                                </x-form.modal.select>
                            @endif
                            <x-form.modal.text id="identification_date"
                                               type="date"
                                               label="{{ trans('general.identification_date') }}"
                                              class="form-group col-4"
                                               placeholder="{{ __('general.form.enter', ['field' => __('general.identification_date')]) }}">
                            </x-form.modal.text>
                            <x-form.modal.text id="incidence_date"
                                               type="date"
                                               label="{{ trans('general.incidence_date') }}"
                                               class="form-group col-4"
                                               placeholder="{{ __('general.form.enter', ['field' => __('general.incidence_date')]) }}">
                            </x-form.modal.text>
                            <x-form.modal.text id="closing_date"
                                               type="date"
                                               label="{{ trans('general.closing_date') }}"
                                             class="form-group col-4"
                                               placeholder="{{ __('general.form.enter', ['field' => __('general.closing_date')]) }}">
                            </x-form.modal.text>
                            <x-form.modal.text id="cost"
                                               type="number"
                                               label="{{ trans('general.cost') }}"
                                             class="form-group col-6"
                                               placeholder="{{ __('general.form.enter', ['field' => __('general.cost')]) }}">
                            </x-form.modal.text>
                            <x-form.modal.text id="cause"
                                               type="text"
                                               label="{{ trans('general.cause') }}"
                                          class="form-group col-6"
                                               placeholder="{{ __('general.form.enter', ['field' => __('general.cause')]) }}">
                            </x-form.modal.text>
                        </div>
                    </div>
                    <div class="justify-content-center">
                        <x-form.modal.footer wirecancelevent="resetForm" wiresaveevent="store"></x-form.modal.footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>