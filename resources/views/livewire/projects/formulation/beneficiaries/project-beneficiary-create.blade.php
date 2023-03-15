<div wire:ignore.self class="modal fade" id="add_beneficiary_modal" tabindex="-1" role="dialog" aria-hidden="true"
     style="height: 100%;">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div wire:ignore class="modal-header bg-primary text-white">
                <h5 class="modal-title">{{ trans('general.create')}} {{__('general.beneficiaries')}} <x-tooltip-help message="Ayuda para el nombre"> </x-tooltip-help></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="far fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <h6><b>{{ trans('general.create')}} {{__('general.beneficiaries')}}</b></h6>

                <div class="form-row">

                    <x-form.inputs.select id="projectType"
                                          wire:model.defer="projectType"
                                          label="{{ trans('general.type') }}"
                                          class="form-group col-6 required">
                        <option value="">--Seleccione--</option>
                        @foreach($beneficiary_types as $item)
                            <option value="{{ $item->id }}" {{ $projectType == $item->id ? 'selected' : ''}}>{{ $item->description }}</option>
                        @endforeach
                    </x-form.inputs.select>

                    <x-form.modal.text id="projectAmount"
                                       label="{{ trans('general.project-amount') }}"
                                       required="required" class="form-group col-6"
                                       placeholder="{{ __('general.form.enter', ['field' => __('general.project-amount')]) }}">
                    </x-form.modal.text>

                </div>

            </div>
            <div class="justify-content-center">
                <div class="card-footer text-center">
                    <div class="row">
                        <div class="col-12">
                            <a class="btn btn-outline-secondary mr-1" wire:click="closeModal">
                                <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                            </a>
                            <button wire:click="submit" class="btn btn-primary">
                                <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>