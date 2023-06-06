@extends('layouts.home')

@section('content')
    <div class="container-fluid d-flex flex-wrap justify-content-center position-absolute start-25" style="top: 35%">
{{--            @if(in_array('ERP.Read', $user->roles))--}}
                <a href="http://erp.laverix.com.ec/" rel="noopener noreferrer">
                    <img src="{{ asset("/img/logo_administration.png")}}" height="128" alt="">
                </a>
{{--            @endif--}}
{{--            @if(in_array('Planning.Read', $user->roles))--}}
                <a href="http://cre.test/poa/poas">
                    <img src="{{ asset("/img/logo_planification.png")}}" height="128" alt="">
                </a>
{{--            @endif--}}
    </div>
@endsection
