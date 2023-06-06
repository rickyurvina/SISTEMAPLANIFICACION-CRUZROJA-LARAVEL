<div wire:ignore.self class="modal fade" id="add_contact_modal" tabindex="-1" role="dialog" aria-hidden="true" style="height: 100%;">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div wire:ignore.self class="modal-header bg-primary text-white">
                <h5 class="modal-title">{{ trans('general.add_new_contact') }}</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="far fa-times"></i></span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-6 required">
                        <label class="form-label" for="name">{{ trans('general.names') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-right-0">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <input type="text" wire:model.defer="name"
                                   class="form-control bg-transparent @error('name') is-invalid @enderror"
                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.name')]) }}">
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        </div>
                    </div>

                    <div class="form-group col-6 required">
                        <label class="form-label" for="email">{{ trans('general.email') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-right-0">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                            <input type="email" wire:model.defer="email"
                                   class="form-control bg-transparent @error('email') is-invalid @enderror"
                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.email')]) }}">
                            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                        </div>
                    </div>

                    <div class="form-group col-6 required">
                        <label class="form-label"
                               for="phone">{{ trans('general.personal_phone') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-right-0">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                            <input type="text" wire:model.defer="phone"
                                   class="form-control bg-transparent @error('phone') is-invalid @enderror"
                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.personal_phone')]) }}">
                            <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                        </div>
                    </div>

                    <div class="form-group col-12">
                        <label class="form-label"
                               for="personalNotes">{{ trans('general.personal_notes') }}</label>
                        <textarea wire:model.defer="personalNotes" rows="3"
                                  class="form-control bg-transparent @error('personalNotes') is-invalid @enderror">
                                            </textarea>
                        <div class="invalid-feedback">{{ $errors->first('personalNotes') }}</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i
                            class="fas fa-times"></i> {{ trans('general.cancel') }}</button>
                <button class="btn btn-primary" wire:click="submit">
                    <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                </button>
            </div>
        </div>
    </div>
</div>