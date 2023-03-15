@extends('layouts.admin')

@section('title', trans('general.title.create', ['type' => trans_choice('general.department', 1)]))

@section('subheader-title')
    <i class="fal fa-plus text-primary"></i> {{ trans('general.title.create', ['type' => trans_choice('general.department', 1)]) }}
@endsection

@section('content')


    <div class="border px-3 pt-3 pb-0 rounded">

        <x-form action="{{ route('departments.store') }}" method="post">
            <div class="card-body">
                <div class="row">
                    <x-form.inputs.text id="code" label="{{ trans('general.code') }}" class="col-2 required"
                                        value="{{ old('code') }}"
                                        placeholder="{{ trans('general.form.enter', ['field' => trans('general.code')]) }}"/>
                    <div class="form-group col-10 required"></div>
                    <x-form.inputs.text type="text" id="name" label="{{ trans('general.name') }}" class="col-6 required"
                                        value="{{ old('name') }}"
                                        placeholder="{{ trans('general.form.enter', ['field' => trans('general.name')]) }}"/>
                    <x-form.inputs.select2 class="col-6 required" label="{{ trans('general.responsible') }}"
                                           id="responsible" :multiple="false">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->getFullName() }}</option>
                        @endforeach
                    </x-form.inputs.select2>
                    <div class="form-group col-6">
                        <label class="form-label" for="parent_id">{{ trans('general.department') }}</label>
                        <select id="parent_id" name="parent_id"
                                class="custom-select bg-transparent @error('parent_id') is-invalid @enderror">
                            <option value=""
                                    selected>{{ trans('general.form.select.field', ['field' => trans('general.department')]) }}</option>
                            @foreach($departments as $departments)
                                <option value="{{ $departments->id }}">{{ $departments->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">{{ $errors->first('parent_id') }}</div>
                    </div>

                    <div class="form-group col-6">
                        <label class="form-label" for="programs">{{ trans('general.programs') }}</label>
                        <select class="form-control" multiple="multiple" id="select2-dropdown-programs"
                                name="select2-dropdown-programs[]">
                            @foreach($programs as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <x-form.modal.textarea id="description" label="{{ trans('general.description') }}"
                                           class="col-12"
                                           placeholder="{{ trans('general.form.enter', ['field' => trans('general.description')]) }}"/>
                </div>
            </div>
            <div class="card-footer text-center">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mr-1">
                            <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                        </a>
                        <button class="btn btn-success">
                            <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                        </button>
                    </div>
                </div>
            </div>
        </x-form>

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