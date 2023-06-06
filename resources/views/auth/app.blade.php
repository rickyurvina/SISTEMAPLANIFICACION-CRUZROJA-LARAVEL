@extends('layouts.home')

@section('content')
    <div class="container-fluid d-flex flex-wrap justify-content-center position-absolute start-25" style="top: 35%">
        @if($data)
            @if(!is_null($data['roles']))
                @if(in_array('ERP.Read',$data['roles']))
                    <a href="{{ config('app.erp_url') }}" rel="noopener noreferrer">
                        <img src="{{ asset("/img/logo_administration.png")}}" height="128" alt="">
                    </a>
                @endif

                @if(in_array('Planning.Read', $data['roles']))
                    <a href="{{ route('common.verify-azure-user') }}" rel="noopener noreferrer">
                        <img src="{{ asset("/img/logo_planification.png")}}" height="128" alt="">
                    </a>
                @endif
            @else
                <x-empty-content>
                    <x-slot name="img">
                        <i class="fas fa-sad-tear" style="color: #2582fd;"></i>
                    </x-slot>

                    <x-slot name="info">
                        {{ trans('messages.info.no_roles_assigned') }}
                    </x-slot>

                </x-empty-content>
            @endif
        @endif
    </div>
@endsection
