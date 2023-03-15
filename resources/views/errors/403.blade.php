@extends('layouts.error')

@section('title', trans('errors.title.403'))

@section('content')
    <div class="h-alt-hf d-flex flex-column align-items-center justify-content-center text-center">
        <h1 class="page-error color-warning-300">
            {{trans('errors.common.permission_denied')}}
            <small class="fw-500">
                {{trans('errors.common.dear_user')}},</br>
                {{ trans('errors.message.403') }}
            </small>
        </h1>
        <button type="button" class="btn btn-outline-secondary waves-effect waves-themed" onclick="history.back()" >
            {{ trans('general.return') }}
        </button>
    </div>
@endsection