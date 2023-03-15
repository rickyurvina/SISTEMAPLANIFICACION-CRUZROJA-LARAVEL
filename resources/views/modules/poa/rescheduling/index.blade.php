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
            <a href="{{ route('poas.activities.index', ['poa' => $poa->id]) }}" class="btn btn-sm btn-outline-light">
                <span class="btn btn-sm mr-2">
                  <i class="fas fa-arrow-alt-right mr-1 "></i>  {{trans_choice('general.activities',0)}}
                </span>
            </a>
        </div>
        <div class="ml-auto w-auto">
            <livewire:poa.status.poa-status :poa="$poa"/>
        </div>
    </div>
@endsection

@section('content')

    <div>
        <div class="p-2">
            <div class="d-flex flex-row-reverse">
                <div>
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#poa-create-rescheduling"
                       class="btn btn-success btn-sm mb-2 mr-2 ml-auto">
                        <span class="fas fa-plus mr-1"></span> &nbsp;{{ trans('general.add_new') }}
                    </a>
                </div>
            </div>
            <h2 class="text-center text-info fs-2x fw-700 mt-2 mb-2">{{trans('general.rescheduling')}}</h2>

            @if($poa->reschedulings->count()>0)
                <div class="table-responsive">
                    <table class="table table-light table-hover">
                        <thead>
                        <tr>
                            <th class="w-auto table-th text-center">{{ __('general.description') }}</th>
                            <th class="w-auto table-th text-center">{{ __('general.phase') }}</th>
                            <th class="w-auto table-th text-center">{{ __('general.state') }}</th>
                            <th class="w-auto table-th text-center">{{trans('general.status')}}</th>
                            <th class="w-auto table-th text-center">{{ __('general.poa_request_user') }}</th>
                            <th class="w-auto table-th text-center">{{ __('general.poa_answer_user') }}</th>
                            <th class="w-10 table-th text-center">{{ __('general.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($poa->reschedulings as $item)
                            <tr class="tr-hover text-center">
                                <td>{{$item->description}}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                            <span class="badge badge- {{ \App\Models\Poa\Poa::PHASE_BG[$item->phase] }}
                                                    badge-pill">
                                                {{ $item->phase }}
                                            </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        @if($item->state)
                                            <span class="badge badge- {{ \App\Models\Poa\Poa::STATUS_BG[$item->state] }} badge-pill">
                                                {{ $item->state }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge- {{  \App\Models\Poa\PoaRescheduling::STATUSES_BG[$item->status] }} badge-pill">{{ $item->status }}</span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="" @if($item->applicant) data-toggle="tooltip" data-placement="top"
                                             title="{{ $item->applicant->getFullName() }}" data-original-title="{{ $item->applicant->getFullName() }}" @endif>
                                            <div class="dropdown-item">
                                                            <span class="mr-2">
                                                                <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle width-1">
                                                            </span>
                                                <span class="pt-1">{{ $item->applicant->getFullName() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($item->approver)
                                        <div class="d-flex justify-content-center">
                                            <div class="" @if($item->approver) data-toggle="tooltip" data-placement="top"
                                                 title="{{ $item->approver->getFullName() }}" data-original-title="{{ $item->approver->getFullName() }}" @endif>
                                                <div class="dropdown-item">
                                                            <span class="mr-2">
                                                                <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle width-1">
                                                            </span>
                                                    <span class="pt-1">{{ $item->approver->getFullName() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($item->status== \App\Models\Poa\PoaRescheduling::STATUS_OPENED)
                                        <a href="javascript:void(0)"
                                           data-toggle="modal"
                                           data-target="#poa-approve-rescheduling"
                                           data-item-id="{{$item->id}}">
                                            <i class="fas fa-check-circle mr-1 text-info"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="Aprobar"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                           data-toggle="modal"
                                           data-target="#poa-edit-rescheduling"
                                           data-item-id="{{$item->id}}">
                                            <i class="fas fa-edit mr-1 text-info"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="Editar"></i>
                                        </a>
                                        <x-delete-link action="{{ route('poa.delete_rescheduling', $item->id) }}" id="{{ $item->id }}"/>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-empty-content>
                    <x-slot name="title">
                        No existen reprogramaciones creadas
                    </x-slot>
                </x-empty-content>
            @endif
        </div>
        <div wire:ignore>
            <livewire:poa.reschedulings.poa-create-rescheduling :poaId="$poa->id"/>
        </div>
        <div wire:ignore>
            <livewire:poa.reschedulings.poa-edit-rescheduling/>
        </div>
        <div wire:ignore>
            <livewire:poa.reschedulings.poa-approve-rescheduling/>
        </div>
    </div>
@endsection
@push('page_script')
    <script>
        Livewire.on('toggleCreateRes', () => $('#poa-create-rescheduling').modal('toggle'));
        Livewire.on('toggleEditRes', () => $('#poa-edit-rescheduling').modal('toggle'));

        $('#poa-edit-rescheduling').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('item-id');
            //Livewire event trigger
            Livewire.emit('openEditRescheduling', id);
        });
        $('#poa-approve-rescheduling').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('item-id');
            //Livewire event trigger
            Livewire.emit('openApproveRescheduling', id);
        });
    </script>
@endpush