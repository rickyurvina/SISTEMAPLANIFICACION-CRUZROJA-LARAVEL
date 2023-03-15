@extends('layouts.admin')

@section('title', trans('general.title.show', ['type' => trans_choice('general.perspectives', 1)]))

@section('subheader-title')
    <i class="fal fa-plus text-primary"></i> {{ trans('general.title.show', ['type' => trans_choice('general.perspectives', 1)]) }}
    - {{ $perspective->name }}
@endsection

@section('content')
    <div class="card">
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
                        <input type="text" class="form-control border-left-0 bg-transparent pl-0" disabled value="{{$perspective->name }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <div class="row">
                <div class="col-12">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mr-1">
                        <i class="fas fa-times"></i> {{ trans('general.go_back') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection