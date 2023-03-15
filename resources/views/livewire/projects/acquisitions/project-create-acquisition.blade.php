<div wire:ignore.self class="modal fade" id="project-create-acquisition" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 70rem;">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">{{ trans('general.create') }} {{__('general.acquisition')}}</h5>
                <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card-body">
                    @error($acquisitionProductId)
                    <div class="invalid-feedback">{{ $errors->first('acquisitionProductId') }}</div>
                    @enderror
                    <div class="row">
                        <div class="form-group col-12 required" wire:ignore>
                            <label class="form-label" for="select2">
                                {{ trans('general.prj_acquisitions_item_description') }}
                            </label>
                            <select class="form-control @error('acquisitionProductId') is-invalid @enderror" id="select2">
                            </select>
                            <div class="invalid-feedback">{{ $errors->first('acquisitionProductId') }}</div>
                        </div>

                        <div class="form-group col-12 required">
                            <label class="form-label" for="information_type">{{ trans('general.prj_acquisitions_description') }}</label>
                            <div class="input-group bg-white shadow-inset-2">
                                <input type="text" wire:model.defer="acquisitionDescription"
                                       class="form-control bg-transparent @error('acquisitionDescription') is-invalid @enderror"
                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.prj_acquisitions_description')]) }}">
                                <div class="invalid-feedback">{{ $errors->first('acquisitionDescription') }}</div>
                            </div>
                        </div>


                        <div class="form-group col-3 required">
                            <label class="form-label" for="interest_level">{{ trans('general.prj_acquisitions_unit') }}</label>
                            <div class="input-group bg-white shadow-inset-2">
                                <select wire:model.defer="acquisitionUnit"
                                        class="custom-select bg-transparent @error('acquisitionUnit') is-invalid @enderror">
                                    <option value="">{{ trans('general.form.select.field', ['field' => trans('general.prj_acquisitions_unit')]) }}</option>
                                    @foreach($units as $item)
                                        <option value="{{ $item->id }}">{{ $item->description }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">{{ $errors->first('acquisitionUnit') }}</div>
                            </div>
                        </div>

                        <div class="form-group col-3 required">
                            <label class="form-label" for="information_type">{{ trans('general.prj_acquisitions_quantity') }}</label>
                            <div class="input-group bg-white shadow-inset-2">
                                <input type="number" wire:model.defer="acquisitionQuantity"
                                       class="form-control bg-transparent @error('acquisitionQuantity') is-invalid @enderror"
                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.prj_acquisitions_quantity')]) }}">
                                <div class="invalid-feedback">{{ $errors->first('acquisitionQuantity') }}</div>
                            </div>
                        </div>

                        <div class="form-group col-3 required">
                            <label class="form-label" for="information_type">{{ trans('general.prj_acquisitions_price') }}</label>
                            <div class="input-group bg-white shadow-inset-2">
                                <input type="text" wire:model.defer="acquisitionPrice"
                                       class="form-control bg-transparent @error('acquisitionPrice') is-invalid @enderror" value=""
                                       data-inputmask="'alias': 'currency'"
                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.prj_acquisitions_price')]) }}">
                                <div class="invalid-feedback">{{ $errors->first('acquisitionPrice') }}</div>
                            </div>
                        </div>

                        <div class="form-group col-3 required">
                            <label class="form-label" for="interest_level">{{ trans('general.prj_acquisitions_mode') }}</label>
                            <div class="input-group bg-white shadow-inset-2">
                                <select wire:model.defer="acquisitionMode"
                                        class="custom-select bg-transparent @error('acquisitionMode') is-invalid @enderror">
                                    <option value="">{{ trans('general.form.select.field', ['field' => trans('general.prj_acquisitions_mode')]) }}</option>
                                    @foreach($types as $item)
                                        <option value="{{ $item->id }}">{{ $item->description }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">{{ $errors->first('acquisitionMode') }}</div>
                            </div>
                        </div>

                        <div class="form-group col-3 required">
                            <label class="form-label" for="date_required_information">{{ trans('general.prj_acquisitions_date') }}</label>
                            <div class="input-group bg-white shadow-inset-2">
                                <input type="date" wire:model.defer="acquisitionDate"
                                       class="form-control bg-transparent @error('acquisitionDate') is-invalid @enderror"
                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.prj_acquisitions_date')]) }}">
                                <div class="invalid-feedback">{{ $errors->first('acquisitionDate') }}</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="justify-content-center">
                <div class="card-footer text-center">
                    <div class="row">
                        <div class="col-12">
                            <a class="btn btn-outline-secondary mr-1" wire:click="closeModal">
                                <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                            </a>
                            <button wire:click="createAcquisition" class="btn btn-primary">
                                <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('page_script')
    <script>
        document.addEventListener('livewire:load', function (event) {
        @this.on('refreshDropdown', function () {
            $('#select2').select2({
                dropdownParent: $("#project-create-acquisition"),
                placeholder: "{{ trans('general.select').' '.trans('general.prj_acquisitions_item_description') }}",
                ajax: {
                    url: '{{ route('catalog.purchase.search') }}',
                    dataType: 'json',
                    delay: 100,
                    cache: true,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: (data) => {
                        return {
                            results: data
                        };
                    }
                }
            }).on('change', function (e) {
            @this.set('acquisitionProductId', $(this).val());
                Livewire.emit('productChange');
            });
        });
        });
    </script>
@endpush