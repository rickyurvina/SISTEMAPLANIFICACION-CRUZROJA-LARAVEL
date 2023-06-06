<div wire:ignore.self class="modal fade in" id="project-create-specific-objective" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary color-white">
                <h4 class="modal-title">
                    Crear Objetivo Específico
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <form wire:submit.prevent="submit" method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <x-form.modal.text id="code" label="{{ __('general.code') }}" class="form-group col-sm-4" required="required"
                                           placeholder="{{ trans('general.form.enter', ['field' => trans('general.code')]) }}">
                        </x-form.modal.text>

                        <x-form.modal.text id="name" label="{{ __('general.name') }}" class="form-group col-sm-12" required="required"
                                           placeholder="{{ trans('general.form.enter', ['field' => trans('general.name')]) }}">
                        </x-form.modal.text>

                        <div class="form-group col-12">
                            <label class="form-label"
                                   for="description">{{ trans('general.description') }}</label>
                            <textarea class="form-control  bg-transparent  @error('description') is-invalid @enderror"
                                       id="description" name="description" rows="3"
                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.description')]) }}"
                                       wire:model.defer="description"></textarea>
                            <div class="invalid-feedback">{{ $errors->first('description',':message') }} </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <x-form.modal.footer></x-form.modal.footer>
                </div>
            </form>
        </div>
    </div>
</div>
