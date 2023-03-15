<div wire:ignore.self class="modal fade" id="add_catalog_activity_modal" tabindex="-1" role="dialog" aria-hidden="true"
     style="height: 100%;">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div wire:ignore class="modal-header bg-primary text-white">
                <h5 class="modal-title">{{ trans('general.add_new') }}</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="far fa-times"></i></span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-6 required">
                        <label class="form-label" for="code">{{ trans('poa.code') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-right-0">
                                    <i class="fas fa-code"></i>
                                </span>
                            </div>
                            <input type="text" wire:model.defer="code"
                                   class="form-control bg-transparent @error('code') is-invalid @enderror"
                                   placeholder="{{ trans('general.form.enter', ['field' => trans('poa.code')]) }}"/>
                            <div class="invalid-feedback">{{ $errors->first('code') }}</div>
                        </div>
                    </div>
                    <div class="form-group col-6 required">
                        <label class="form-label" for="name">{{ trans('general.names') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                    <i class="fas fa-book"></i>
                                                </span>
                            </div>
                            <input type="text" wire:model.defer="name"
                                   class="form-control bg-transparent @error('name') is-invalid @enderror"
                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.names')]) }}"/>
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label class="form-label" for="cost">{{ trans('poa.cost') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                    <i class="fas fa-money-bill"></i>
                                                </span>
                            </div>
                            <input type="number" wire:model.defer="cost"
                                   class="form-control bg-transparent @error('cost') is-invalid @enderror"
                                   placeholder="{{ trans('general.form.enter', ['field' => trans('poa.cost')]) }}"/>
                            <div class="invalid-feedback">{{ $errors->first('cost') }}</div>
                        </div>
                    </div>
                    <div class="form-group col-6 required">
                        <label class="form-label required"
                               for="radio-group-1">{{ __('general.poa_activity_impact') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="impact1" name="impact" value="1" class="custom-control-input"
                                               wire:model.defer="impact">
                                        <label class="custom-control-label"
                                               for="impact1">{{ __('general.poa_activity_category_low') }}</label>
                                    </div>
                                </div>
                                <div class="input-group-text">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="impact2" name="impact" value="2" class="custom-control-input"
                                               wire:model.defer="impact">
                                        <label class="custom-control-label"
                                               for="impact2">{{ __('general.poa_activity_category_medium') }}</label>
                                    </div>
                                </div>
                                <div class="input-group-text">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="impact3" name="impact" value="3" class="custom-control-input"
                                               wire:model.defer="impact">
                                        <label class="custom-control-label"
                                               for="impact3">{{ __('general.poa_activity_category_high') }}</label>
                                    </div>
                                </div>
                            </div>
                            @error('impact') <span class="text-danger error ml-2">{{ $message }}</span>@enderror
                        </div>

                        <label class="form-label required"
                               for="radio-group-1">{{ __('general.poa_activity_complexity') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="complexity1" name="complexity" value="1" class="custom-control-input"
                                               wire:model.defer="complexity">
                                        <label class="custom-control-label"
                                               for="complexity1">{{ __('general.poa_activity_category_low') }}</label>
                                    </div>
                                </div>
                                <div class="input-group-text">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="complexity2" name="complexity" value="2" class="custom-control-input"
                                               wire:model.defer="complexity">
                                        <label class="custom-control-label"
                                               for="complexity2">{{ __('general.poa_activity_category_medium') }}</label>
                                    </div>
                                </div>
                                <div class="input-group-text">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="complexity3" name="complexity" value="3" class="custom-control-input"
                                               wire:model.defer="complexity">
                                        <label class="custom-control-label"
                                               for="complexity3">{{ __('general.poa_activity_category_high') }}</label>
                                    </div>
                                </div>
                            </div>
                            @error('complexity') <span class="text-danger error ml-2">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-secondary" wire:click="closeModal"><i
                            class="fas fa-times"></i> {{ trans('general.cancel') }}</button>
                <button class="btn btn-primary" wire:click="submit">
                    <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                </button>
            </div>
        </div>
    </div>
</div>
@push('page_script')
    <script>
        document.addEventListener('livewire:load', function (event) {
        @this.on('refreshDropdown', function () {
            let companies = [];
            $.each(@this.existingCompanies, function (key, company) {
                companies.push({
                    text: company.name,
                    id: company.id,
                    selected: company.selected
                });
            });
            $('#companies')
                .empty()
                .select2({
                    dropdownParent: $("#add_catalog_activity_modal"),
                    placeholder: "{{ trans('general.select') }}",
                    data: companies
                }).on('change', function (e) {
            @this.set('companySelect', $(this).val());
            });
        });
        });

        $('#defaultIndeterminate').prop('indeterminate', true)

        var toggleCheckbox = function () {
            $('#js-checkbox-toggle').toggleText('Change to CIRCLE', 'Change back to default');
            $('.frame-wrap .custom-checkbox').toggleClass('custom-checkbox-circle');
        }

        var toggleRadio = function () {
            $('#js-radio-toggle').toggleText('Change to ROUNDED', 'Change back to default');
            $('.frame-wrap .custom-radio').toggleClass('custom-radio-rounded');
        }

    </script>
@endpush