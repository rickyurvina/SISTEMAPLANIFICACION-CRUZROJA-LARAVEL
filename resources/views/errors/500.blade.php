@extends('layouts.error')

@section('title', trans('errors.title.500'))

@section('content')
    <div class="h-alt-hf d-flex flex-column align-items-center justify-content-center text-center">
        <h1 class="page-error color-warning-300">
            {{ trans('errors.header.500') }}
            <small class="fw-500">
                {{ trans('errors.message.500') }}
            </small>
        </h1>
    </div>
@endsection