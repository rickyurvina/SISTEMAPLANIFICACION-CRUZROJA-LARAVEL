<div wire:ignore.self class="modal fade" id="add_public_purchases_modal" tabindex="-1" role="dialog" aria-hidden="true"
     style="height: 100%;">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div wire:ignore class="modal-header bg-primary text-white">
                <h5 class="modal-title">{{ trans('general.create') }} {{__('general.public_purchases')}}</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="far fa-times"></i></span>
                </button>
            </div>

            <div class="modal-body">

                <div class="panel-content">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#general" role="tab" aria-selected="true"
                               wire:ignore.self>
                                <i class="fal fa-user text-primary"></i>
                                <span class="hidden-sm-down ml-1">Información General</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content border border-top-0 p-3">
                        <div class="card tab-pane fade show active" id="general" role="tabpanel" wire:ignore.self>
                            <div class="card-body">
                                <div class="row">

                                    <x-form.modal.text type="text" id="code" wire:model.defer="code"
                                                       label="{{ trans('general.code') }}"
                                                       class="form-group col-6" required="required"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.code')]) }}"/>


                                    <x-form.modal.text type="text" id="name" wire:model.defer="name"
                                                       label="{{ trans('general.name') }}"
                                                       class="form-group col-6" required="required"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.name')]) }}"/>


                                    <x-form.modal.text type="text" id="description" wire:model.defer="description"
                                                       label="{{ trans('general.description') }}"
                                                       class="form-group col-6"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.description')]) }}"/>

                                    <x-form.modal.text type="text" id="unitPrice" wire:model.defer="unitPrice"
                                                       label="{{ trans('general.unit_price') }}"
                                                       class="form-group col-6"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.unit_price')]) }}"/>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="justify-content-center">
                <div class="card-footer text-center">
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-outline-secondary" wire:click="closeModal"><i
                                        class="fas fa-times"></i> {{ trans('general.cancel') }}</button>
                            <button class="btn btn-primary" wire:click="submit">
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
    <script src="{{ asset_cdn("/vendor/inputmask/dist/jquery.inputmask.js") }}"></script>
    <script>
        $(document).ready(function () {
            $(":input").inputmask();
        });
    </script>
@endpush
