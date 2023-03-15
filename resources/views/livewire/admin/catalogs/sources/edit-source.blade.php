<div>
    <div class="modal fade" id="update-source" tabindex="-1" aria-hidden="true" style="display: none;" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary color-white">
                    <h5 class="modal-title h4">{{ trans('general.edit').' '.trans_choice('general.source', 1)  }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="far fa-times color-white"></i></span>
                    </button>
                </div>
                @if($source)
                    <div class="modal-body">
                        <div class="row">
                            <x-form.modal.text id="name" label="{{ __('general.name') }}" required="required"
                                               class="form-group col-6 required"
                                               placeholder="{{ __('general.form.enter', ['field' => __('general.name')]) }}">
                            </x-form.modal.text>
                            <x-form.modal.text id="institution" label="{{ __('general.institution') }}" required="required"
                                               class="form-group col-6 required"
                                               placeholder="{{ __('general.form.enter', ['field' => __('general.institution')]) }}">
                            </x-form.modal.text>
                            <x-form.modal.textarea id="description"
                                                   label="{{ __('general.description') }}"
                                                   class="form-group mt-1 col-6">
                            </x-form.modal.textarea>

                            <x-form.modal.select id="type"
                                                 label="{{ trans('general.type') }}"
                                                 class="col-6 form-group required">
                                <option value="">{{trans('general.choose')}}  {{ trans('general.type') }}</option>
                                <option value="{{\App\Models\Indicators\Sources\IndicatorSource::TYPE_SURVEY}}" {{ old("type") == \App\Models\Indicators\Sources\IndicatorSource::TYPE_SURVEY ? "selected":"" }}>{{trans('indicators.indicator.TYPE_'.\App\Models\Indicators\Sources\IndicatorSource::TYPE_SURVEY) }}</option>
                                <option value="{{\App\Models\Indicators\Sources\IndicatorSource::TYPE_ADMINISTRATIVE_RECORD}}" {{ old("type") == \App\Models\Indicators\Sources\IndicatorSource::TYPE_ADMINISTRATIVE_RECORD ? "selected":"" }}>{{ trans('indicators.indicator.TYPE_'.\App\Models\Indicators\Sources\IndicatorSource::TYPE_ADMINISTRATIVE_RECORD) }}</option>
                                <option value="{{\App\Models\Indicators\Sources\IndicatorSource::TYPE_TRANSACTIONAL}}" {{ old("type") == \App\Models\Indicators\Sources\IndicatorSource::TYPE_TRANSACTIONAL ? "selected":"" }}>{{trans('indicators.indicator.TYPE_'.\App\Models\Indicators\Sources\IndicatorSource::TYPE_TRANSACTIONAL) }}</option>
                            </x-form.modal.select>
                        </div>
                        <div class="justify-content-center">
                            <x-form.modal.footer wiresaveevent="save"></x-form.modal.footer>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>