@extends('layouts.admin')

@section('title', trans('general.title.edit', ['type' => trans_choice('general.department', 1)]))

@section('subheader-title')
    <i class="fal fa-plus text-primary"></i> {{ trans('general.title.edit', ['type' => trans_choice('general.department', 1)]) }}
@endsection

@section('content')


    <div class="border px-3 pt-3 pb-0 rounded">
        <form action="{{ route('departments.update',$department->id) }}" method="POST">
            <input type="hidden" name="_method" value="PUT">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-2 required">
                        <label class="form-label"
                               for="code">{{ trans('general.code').' '.trans('general.department') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-qrcode"></i>
                                    </span>
                            </div>
                            <input type="text" id="code" name="code"
                                   class="form-control bg-transparent @error('code') is-invalid @enderror"
                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.code').' '.trans('general.department')]) }}"
                                   value="{{ $department->code }}">
                            <div class="invalid-feedback">{{ $errors->first('code') }}</div>
                        </div>
                    </div>

                    <div class="form-group col-10 required"></div>

                    <div class="form-group col-6 required">
                        <label class="form-label"
                               for="name">{{ trans('general.name').' '.trans('general.department') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fab fa-amilia"></i>
                                    </span>
                            </div>
                            <input type="text" id="name" name="name"
                                   class="form-control bg-transparent @error('name') is-invalid @enderror"
                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.name').' '.trans('general.department')]) }}"
                                   value="{{ $department->name }}">
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        </div>
                    </div>

                    <x-form.inputs.select2 class="col-6 required" label="{{ trans('general.responsible') }}"
                                           id="responsible" :multiple="false">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->getFullName() }}</option>
                        @endforeach
                    </x-form.inputs.select2>


                    <div class="form-group col-6">
                        <label class="form-label" for="parent_id">{{ trans('general.department') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-right-0">
                                    <i class="fas fa-hands-helping"></i>
                                </span>
                            </div>
                            <select id="parent_id" name="parent_id" value="{{ $department->parent_id }}"
                                    class="custom-select bg-transparent @error('parent_id') is-invalid @enderror">
                                <option
                                    value="">{{ trans('general.form.select.field', ['field' => trans('general.department')]) }}</option>
                                @foreach($departments as $departments)
                                    <option value="{{ $departments->id }}" selected>{{ $departments->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">{{ $errors->first('parent_id') }}</div>
                        </div>
                    </div>

                    <div class="form-group col-6">
                        <label class="form-label" for="programs">{{ trans('general.programs') }}</label>
                        <select class="form-control" multiple="multiple" id="select2-dropdown-programs"
                                name="select2-dropdown-programs[]">
                            @foreach($programs as $item)
                                <option
                                    value="{{ $item->id }}" {{ in_array($item->id, $selected_programs) ? 'selected':'' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-12">
                        <label class="form-label" for="description">{{ trans('general.description') }}</label>
                        <textarea id="description" name="description"
                                  class="form-control @error('description') is-invalid @enderror">{{ $department->description }}</textarea>
                        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                    </div>

                </div>
            </div>

            <div class="card-footer text-center">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mr-1">
                            <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                        </a>
                        <button class="btn btn-outline-warning">
                            <i class="fas fa-save pr-2"></i> {{ trans('general.update') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('page_script')
    <script>
        $(document).ready(function () {
            $('#select2-dropdown-programs').select2({
                placeholder: "{{ trans('general.select').' '.trans('general.programs') }}"
            });
        });
    </script>
@endpush