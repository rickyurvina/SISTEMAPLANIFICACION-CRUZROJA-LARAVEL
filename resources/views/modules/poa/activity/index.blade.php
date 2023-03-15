@extends('layouts.admin')

@section('title', __('poa.activities_poa'))

@push('css')
    <style>
        .subheader {
            margin-bottom: 8px !important;
        }
    </style>
@endpush

@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0">
        <li class="breadcrumb-item">
            <a href="{{ route('poa.poas') }}">
                {{ trans('poa.list_poas') }}
            </a>
        </li>
        <li class="breadcrumb-item active">{{ $poa->name }}</li>
    </ol>
@endsection

@section('subheader')
    <div class="d-flex flex-wrap w-100">
        <div class="w-25">
            <h1 class="subheader-title">
                {{ $poa->year }} - {{ __('poa.activities_poa') }}
            </h1>
        </div>
        <div class="w-15 ml-auto">
            <a href="{{route('poa.rescheduling', $poa->id)}}" class="btn btn-sm btn-outline-light">
                <span class="btn btn-sm mr-2">
                  <i class="fal fa-clock mr-1 "></i>  {{trans('general.rescheduling')}}
                </span>
            </a>
        </div>
        <div class="ml-auto w-auto">
            <livewire:poa.status.poa-status :poa="$poa"/>
        </div>
    </div>
@endsection

@section('content')

    @if($poa->status instanceof \App\States\Poa\InProgress)
        <livewire:poa.activity.poa-activity :idPoa="$poa->id"/>
        <div wire:ignore>
            <livewire:poa.activity.poa-create-activity :poaId="$poa->id"/>
        </div>
        <livewire:poa.assigns.poa-assign-weights/>
        <livewire:poa.assigns.poa-assign-goals/>
    @else
        <livewire:poa.activity.poa-show-activity :idPoa="$poa->id"/>
    @endif
@endsection

@push('page_script')
    <script>
        Livewire.on('toggleModalCreateActivity', () => $('#poa-create-activity-modal').modal('toggle'));
        Livewire.on('toggleAssignWeight', () => $('#poa-assign-weights').modal('toggle'));
        $('#poa-create-activity-modal').on('show.bs.modal', function (e) {
            let programId = $(e.relatedTarget).data('program-id');
            //Livewire event trigger
            Livewire.emit('loadIndicators', programId);
        });

        $('#poa-assign-weights').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let programId = $(e.relatedTarget).data('program-id');
            //Livewire event trigger
            Livewire.emit('loadPrograms', programId);
        });

        $('#poa-assign-goals').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let programId = $(e.relatedTarget).data('program-id');
            //Livewire event trigger
            Livewire.emit('loadProgram', programId);
        });
    </script>
@endpush