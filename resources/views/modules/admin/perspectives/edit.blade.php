@extends('layouts.admin')

@section('title', trans('general.title.edit', ['type' => trans_choice('general.perspectives', 1)]))

@push('css')
    <style>
        .subheader {
            margin-bottom: 0 !important;
        }
    </style>
@endpush
@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.catalogs') }}">
                {{trans_choice('general.catalog',2)}}
            </a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{route('perspectives.index')}}">

            {{ trans('general.perspectives')  }}
            </a>
        </li>
        <li class="breadcrumb-item active">{{trans('general.edit')}}     {{ trans('general.perspectives') }}</li>

    </ol>
@endsection

@section('content')
    <div class="card">

        <form action="{{ route('perspectives.update', $perspective->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-6">
                        <label class="form-label" for="name">{{ trans('general.name') }}</label>
                        <div class="input-group bg-white shadow-inset-2">
                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fal fa-sort-numeric-down-alt"></i>
                                    </span>
                            </div>
                            <input type="text" required name="name" id="name" class="form-control border-left-0 bg-transparent pl-0 @error('name') is-invalid @enderror"
                                   value="{{ old('name', $perspective->name) }}" placeholder="{{ trans('general.form.enter', ['field' => trans('general.name')]) }}">
                            <div class="invalid-feedback">{{ $errors->first('name',':message') }} </div>
                        </div>
                    </div>

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
        </form>
    </div>
@endsection