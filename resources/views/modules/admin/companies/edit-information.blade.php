<div class="tab-pane fade show active" id="information" role="tabpanel">
    <div class="card">
        <form action="{{ route('companies.update', $company) }}" method="post">
            @csrf
            @method('PUT')
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
                            <input type="text" id="name"
                                   name="name"
                                   value="{{ $company->name }}"
                                   class="form-control bg-transparent @error('name') is-invalid @enderror"
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
                            <input type="text" id="identification"
                                   name="identification"
                                   value="{{ $company->identification }}"
                                   class="form-control bg-transparent @error('identification') is-invalid @enderror"
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
                            <input type="text" id="phone" name="phone"
                                   value="{{ $company->phone }}"
                                   class="form-control bg-transparent @error('phone') is-invalid @enderror"
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
                            <input type="text" id="fax" name="fax"
                                   value="{{ $company->fax }}"
                                   class="form-control bg-transparent @error('fax') is-invalid @enderror"
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
                            <select id="level"
                                    name="level"
                                    class="custom-select bg-transparent @error('institution') is-invalid @enderror">
                                @foreach($levels as $institutionType)
                                    @if($company->level ==  $institutionType)
                                        <option value="{{ $institutionType }}" selected>
                                            {{ trans('general.level').' '.$institutionType }}
                                        </option>
                                    @else
                                        <option value="{{ $institutionType }}">
                                            {{ trans('general.level').' '.$institutionType }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="invalid-feedback">{{ $errors->first('level') }}</div>
                        </div>
                    </div>

                    <div class="form-group col-6">
                        @if($company->level > 1)
                            <label class="form-label" for="parent">{{ trans('general.parent_institution') }}</label>
                            <div class="input-group bg-white shadow-inset-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-hands-helping"></i>
                                    </span>
                                </div>
                                <select class="custom-select" id="parent" name="parent">
                                    <option selected
                                            value="0">{{ trans('general.form.select.field', ['field' => trans('general.parent_institution')]) }}</option>
                                    @foreach($list_parents as $parent)
                                        @if($company->parent_id == $parent)
                                            <option value="{{ $parent->id }}" selected>{{ $parent->name }}</option>
                                        @else
                                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">{{ $errors->first('parent') }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="form-group col-6">
                        <label class="form-label" for="webSite">{{ trans('general.website') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-globe-americas"></i>
                                    </span>
                            </div>
                            <input type="text" id="webSite" name="webSite"
                                   value="{{ $company->web_site }}"
                                   class="form-control bg-transparent @error('webSite') is-invalid @enderror"
                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.website')]) }} https://www.cruzroja.org.ec">
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
                            <input type="file" id="photo" name="photo"
                                   class="form-control bg-transparent @error('file') is-invalid @enderror"
                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.file')]) }}">
                            <div class="invalid-feedback">{{ $errors->first('photo') }}</div>
                        </div>
                    </div>

                    <div class="form-group col-12">
                        <label class="form-label" for="description">{{ trans('general.description') }}</label>
                        <textarea id="description" name="description"
                                  rows="3"
                                  class="form-control bg-transparent @error('description') is-invalid @enderror">{{ $company->description }}</textarea>
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
                        <button class="btn btn-warning">
                            <i class="fas fa-save pr-2"></i> {{ trans('general.update') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>