@extends('layouts.admin')

@section('title', trans('poa.card_reports'))

@section('subheader')
    <style>
        .subheader {
            margin-bottom: 0 !important;
            margin-top: 0 !important;
        }
    </style>
@endsection

@section('content')
    <h1 class="p-2">
        <i class="fal fa-table text-primary"></i> Reportes
    </h1>
    <div class="row p-2">
        @foreach($cardReports as $cardReport)
            <div class="col-sm-3 mb-2">
                <div class="card">
                    <a href="{{route($cardReport['ruta'])}}">
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
