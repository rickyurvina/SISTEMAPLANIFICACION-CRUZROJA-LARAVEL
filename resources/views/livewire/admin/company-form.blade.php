<div class="tab-pane fade show active" id="information" role="tabpanel">
    <div class="card">
        <form wire:submit.prevent="submit"  method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-6 required">
                        <label class="form-label" for="name">{{ trans('general.name') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-user"></i>
                                    </span>
                            </div>
                            <input type="text" wire:model.defer="name" class="form-control bg-transparent @error('name') is-invalid @enderror"
                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.name')]) }}">
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        </div>
                    </div>

                    <div class="form-group col-6 required">
                        <label class="form-label" for="identification">{{ trans('general.ruc') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                            </div>
                            <input type="text" wire:model.defer="identification" class="form-control bg-transparent @error('identification') is-invalid @enderror"
                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.ruc')]) }}">
                            <div class="invalid-feedback">{{ $errors->first('identification') }}</div>
                        </div>
                    </div>

                    <div class="form-group col-6">
                        <label class="form-label" for="phone">{{ trans('general.phone') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-phone-alt"></i>
                                    </span>
                            </div>
                            <input type="text" wire:model.defer="phone" class="form-control bg-transparent @error('phone') is-invalid @enderror"
                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.phone')]) }}">
                            <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                        </div>
                    </div>

                    <div class="form-group col-6">
                        <label class="form-label" for="fax">{{ trans('general.fax') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-fax"></i>
                                    </span>
                            </div>
                            <input type="text" wire:model.defer="fax" class="form-control bg-transparent @error('fax') is-invalid @enderror"
                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.fax')]) }}">
                            <div class="invalid-feedback">{{ $errors->first('fax') }}</div>
                        </div>
                    </div>

                    <div class="form-group col-6 required">
                        <label class="form-label" for="institutionType">{{ trans('general.type') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-building"></i>
                                    </span>
                            </div>
                            <select wire:model="level"
                                    class="custom-select bg-transparent @error('level') is-invalid @enderror">
                                <option value=""
                                        selected>{{ trans('general.form.select.field', ['field' => trans('general.type')]) }}</option>
                                @foreach($levels as $level)
                                    <option value="{{ $level }}">{{ trans('general.level').' '.$level }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">{{ $errors->first('level') }}</div>
                        </div>
                    </div>

                    <div class="form-group col-6 required">
                        <label class="form-label" for="parent">{{ trans('general.parent_institution') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-hands-helping"></i>
                                    </span>
                            </div>
                            <select wire:model.defer="parent"
                                    class="custom-select bg-transparent @error('parent') is-invalid @enderror">
                                <option selected>{{ trans('general.form.select.field', ['field' => trans('general.parent_institution')]) }}</option>
                                @foreach($list_parents as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">{{ $errors->first('parent') }}</div>
                        </div>
                    </div>

                    <div class="form-group col-6">
                        <label class="form-label" for="webSite">{{ trans('general.website') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-globe-americas"></i>
                                    </span>
                            </div>
                            <input type="text" wire:model.defer="webSite" class="form-control bg-transparent @error('webSite') is-invalid @enderror"
                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.website')]) }}">
                            <div class="invalid-feedback">{{ $errors->first('webSite') }}</div>
                        </div>
                    </div>

                    <div class="form-group col-6">
                        <label class="form-label" for="photo">{{ trans('general.file') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-upload"></i>
                                    </span>
                            </div>
                            <input type="file" wire:mode="photo" class="form-control bg-transparent @error('file') is-invalid @enderror"
                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.file')]) }}">
                            <div class="invalid-feedback">{{ $errors->first('photo') }}</div>
                        </div>
                    </div>

                    <div class="form-group col-12">
                        <label class="form-label" for="description">{{ trans('general.description') }}</label>
                        <textarea wire:model="description" rows="3" class="form-control bg-transparent @error('description') is-invalid @enderror">
                            </textarea>
                        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                    </div>

                </div>
            </div>

            <div class="card-footer text-center">
                <div class="row">
                    <div class="col-12">
                         <a href="{{ route('companies.index') }}" class="btn btn-outline-secondary mr-1">
                            <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                        </a>
                        <button class="btn btn-primary" >
                            <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>