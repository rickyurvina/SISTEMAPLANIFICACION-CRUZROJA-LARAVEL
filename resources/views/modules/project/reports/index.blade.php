@extends('layouts.admin')

@section('title', trans('general.reports'))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-table text-primary"></i> {{ trans('general.reports') }}
    </h1>
@endsection

@section('content')
    <div class="row">
        @foreach($cardReports as $cardReport)
            <div class="col-sm-3 mb-2">
                <div class="card">
                    <a href="{{ route($cardReport['ruta']) }}">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">{{ $cardReport['titulo'] }}</h5>
                            <p class="card-text">{{$cardReport['descripcion']}}</p>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
