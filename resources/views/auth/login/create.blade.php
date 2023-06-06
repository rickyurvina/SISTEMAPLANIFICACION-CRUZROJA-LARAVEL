@extends('layouts.home')

@section('content')
    <div class="container-fluid d-flex justify-content-center position-absolute start-25" style="top: 38%">
        <a href="{{ route('azure.login') }}" class="btn btn-secondary btn-custom-color btn-round px-5 py-3 mb-3 fs-3" height="128">
            Acceder
        </a>
    </div>
@endsection
