<div>
    <div wire:ignore.self class="modal fade" id="project-edit-acquisition" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 70rem;">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">{{ trans('general.edit') }}  {{__('general.acquisition')}}</h5>
                    <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="panel-content">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item" wire:ignore.self>
                                <a class="nav-link active" data-toggle="tab" href="#general" role="tab" aria-selected="false">
                                    <i class="fal fa-user text-primary"></i>
                                    <span class="hidden-sm-down ml-1">{{trans('general.prj_acquisitions_create_title')}}</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content border border-top-0 p-3">
                            <div class="tab-pane fade show active" id="general" role="tabpanel" wire:ignore.self>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12 required" wire:ignore>
                                            <label class="form-label" for="select2">
                                                {{ trans('general.prj_acquisitions_item_description') }}
                                            </label>
                                            <select class="form-control @error('acquisitionEditProductId') is-invalid @enderror" id="select2edit">
                                            </select>
                                            @error('acquisitionEditProductId')
                                            <div class="invalid-feedback">{{ $errors->first('acquisitionEditProductId') }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-12 required">
                                            <label class="form-label" for="information_type">{{ trans('general.prj_acquisitions_description') }}</label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <input type="text" wire:model.defer="acquisitionEditDescription"
                                                       class="form-control bg-transparent @error('acquisitionEditDescription') is-invalid @enderror"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.prj_acquisitions_description')]) }}">
                                                <div class="invalid-feedback">{{ $errors->first('acquisitionEditDescription') }}</div>
                                            </div>
                                        </div>


                                        <div class="form-group col-3 required">
                                            <label class="form-label" for="interest_level">{{ trans('general.prj_acquisitions_unit') }}</label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <select wire:model.defer="acquisitionEditUnit"
                                                        class="custom-select bg-transparent @error('acquisitionEditUnit') is-invalid @enderror">
                                                    <option value="">{{ trans('general.form.select.field', ['field' => trans('general.prj_acquisitions_unit')]) }}</option>
                                                    @foreach($unitsEdit as $item)
                                                        <option value="{{ $item->id }}">{{ $item->description }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">{{ $errors->first('acquisitionEditUnit') }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group col-3 required">
                                            <label class="form-label" for="information_type">{{ trans('general.prj_acquisitions_quantity') }}</label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <input type="text" wire:model.defer="acquisitionEditQuantity"
                                                       class="form-control bg-transparent @error('acquisitionEditQuantity') is-invalid @enderror"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.prj_acquisitions_quantity')]) }}">
                                                <div class="invalid-feedback">{{ $errors->first('acquisitionEditQuantity') }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group col-3 required">
                                            <label class="form-label" for="information_type">{{ trans('general.prj_acquisitions_price') }}</label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <input type="text" wire:model.defer="acquisitionEditPrice"
                                                       class="form-control bg-transparent @error('acquisitionEditPrice') is-invalid @enderror"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.prj_acquisitions_price')]) }}">
                                                <div class="invalid-feedback">{{ $errors->first('acquisitionEditPrice') }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group col-3 required">
                                            <label class="form-label" for="interest_level">{{ trans('general.prj_acquisitions_mode') }}</label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <select wire:model.defer="acquisitionEditMode"
                                                        class="custom-select bg-transparent @error('acquisitionEditMode') is-invalid @enderror">
                                                    <option value="">{{ trans('general.form.select.field', ['field' => trans('general.prj_acquisitions_mode')]) }}</option>
                                                    @foreach($typesEdit as $item)
                                                        <option value="{{ $item->id }}">{{ $item->description }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">{{ $errors->first('acquisitionEditMode') }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group col-3">
                                            <label class="form-label" for="date_required_information">{{ trans('general.prj_acquisitions_date') }}</label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <input type="date" wire:model.defer="acquisitionEditDate"
                                                       class="form-control bg-transparent @error('acquisitionEditDate') is-invalid @enderror"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.prj_acquisitions_date')]) }}">
                                                <div class="invalid-feedback">{{ $errors->first('acquisitionEditDate') }}</div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="col-12">
                                <a class="btn btn-outline-secondary mr-1" wire:click="closeModal">
                                    <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                                </a>
                                <button wire:click="updateAcquisition" class="btn btn-primary">
                                    <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('page_script')
    <script>
        $(document).ready(function () {
            $('#select2edit').select2({
                dropdownParent: $("#project-edit-acquisition"),
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
            @this.set('acquisitionEditProductId', $(this).val());
                Livewire.emit('productEditChange');
            });
        });

        window.addEventListener('loadProduct', event => {
            let data = {
                id: event.detail.id,
                text: event.detail.description
            };

            $("#select2edit").empty();
            let newOption = new Option(data.text, data.id, false, false);
            $('#select2edit').append(newOption);
        });
    </script>
@endpush