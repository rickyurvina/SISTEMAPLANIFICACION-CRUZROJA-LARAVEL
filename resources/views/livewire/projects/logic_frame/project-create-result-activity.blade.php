<div wire:ignore.self class="modal fade in" id="project-create-result-activity" tabindex="-1" role="dialog"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary color-white">
                <h5 class="modal-title h4">{{ __('general.poa_create_activity_title') }}</h5>
                <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column w-80">
                    <label class="form-label required">{{ trans_choice('general.result', 1) }}</label>
                    <div class="btn-group">
                        <button class="btn btn-outline-secondary dropdown-toggle"
                                type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="white-space: nowrap;
                                                                                      overflow: hidden;
                                                                                      text-overflow: ellipsis;">
                            @if($resultId != null)
                                {{ $resultName }}
                            @else
                                {{ trans('general.select') }}
                            @endif
                        </button>
                        <div class="dropdown-menu" style="right: 0; left: 0; height: 300px !important; overflow: scroll">
                            @foreach($results as $result)
                                <div class="dropdown-item" wire:click="$set('resultId', '{{ $result['id'] }}')"
                                     style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">
                                    <span style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">
                                        {{ $result['text'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="invalid-feedback d-block">
                        @error($resultId) {{ $errors->first($resultId) }} @enderror
                    </div>
                </div>
                <div class="row mt-2">

                    <x-form.modal.text id="code" label="{{ __('general.code') }}" required="required"
                                       class="form-group col-12"
                                       placeholder="{{ __('general.form.enter', ['field' => __('general.code')]) }}">
                    </x-form.modal.text>
                    <x-form.modal.text id="text" label="{{ __('general.name') }}" required="required"
                                       class="form-group col-12"
                                       placeholder="{{ __('general.form.enter', ['field' => __('general.name')]) }}">
                    </x-form.modal.text>
                    <x-form.modal.textarea id="description"
                                           label="{{ __('general.description') }}"
                                           class="form-group col-12"
                    >
                    </x-form.modal.textarea>
                    <x-form.modal.select id="owner_id"
                                         label="{{ __('general.responsible') }}"
                                         class="form-group col-8">
                        <option value="">{{ __('general.form.select.field', ['field' => __('general.responsible')]) }}</option>
                        @foreach($usersArray as $item)
                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                        @endforeach
                    </x-form.modal.select>
                    <div class="form-group col-sm-4 col-md-4 col-lg-4">
                        <label class="form-label" for="type_of_aggregation">{{ trans('indicators.indicator.type_of_aggregation') }}</label>
                        <div class="btn-group w-100">
                            <button class="btn btn-outline-secondary dropdown-toggle text-left"
                                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if($typeOfAggregation != null)
                                    <i class="fas fa-{{ trans('indicators.indicator.TYPE_AGGREGATION_ICON_' . $typeOfAggregation) }}"></i>
                                    {{ trans('indicators.indicator.TYPE_AGGREGATION_' . $typeOfAggregation) }}
                                @else
                                    {{ trans('general.select') }}
                                @endif
                            </button>

                            <div class="dropdown-menu w-100">
                                <div class="dropdown-item d-flex align-items-center justify-content-between"
                                     wire:click="$set('typeOfAggregation', 'sum')">
                                                    <span><i class="fas fa-{{ trans('indicators.indicator.TYPE_AGGREGATION_ICON_sum') }}"></i>
                                                        {{ trans('indicators.indicator.TYPE_AGGREGATION_sum') }}</span>
                                    @if($typeOfAggregation == 'sum')
                                        <i class="fas fa-check text-success"></i>
                                    @endif
                                </div>
                                <div class="dropdown-item d-flex align-items-center justify-content-between"
                                     wire:click="$set('typeOfAggregation', 'ave')">
                                                    <span><i class="fas fa-{{ trans('indicators.indicator.TYPE_AGGREGATION_ICON_ave') }}"></i>
                                                        {{ trans('indicators.indicator.TYPE_AGGREGATION_ave') }}</span>
                                    @if($typeOfAggregation == 'ave')
                                        <i class="fas fa-check text-success"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <x-form.modal.footer wirecancelevent="resetForm" wiresaveevent="submitActivity"></x-form.modal.footer>
            </div>
        </div>
    </div>
</div>
