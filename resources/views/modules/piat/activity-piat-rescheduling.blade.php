@extends('layouts.admin')

@section('title', __('poa.activities_poa'))

@push('css')
    <style>
        .subheader {
            margin-bottom: 8px !important;
        }
    </style>
@endpush

@section('content')
    @can('view-reschedulings-poa-activity-piat'||'manage-reschedulings-poa-activity-piat')
        <div>
            <div class="p-2">
                @can('manage-reschedulings-poa-activity-piat')
                    <div class="d-flex flex-row-reverse">
                        <div>
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#poa-piat-activity-rescheduling"
                               class="btn btn-success btn-sm mb-2 mr-2 ml-auto">
                               {{ trans('general.create_rescheduling') }}
                            </a>
                        </div>
                    </div>
                @endcan
                <h2 class="text-center text-info fs-2x fw-700 mt-2 mb-2">{{trans('general.rescheduling')}}  {{$piat->name}}</h2>

                @if($piat->reschedulings->count()>0)
                    <div class="table-responsive">
                        <table class="table table-light table-hover">
                            <thead>
                            <tr>
                                <th class="w-auto table-th text-center">{{ __('general.description') }}</th>
                                <th class="w-auto table-th text-center">{{trans('general.status')}}</th>
                                <th class="w-auto table-th text-center">{{ __('general.poa_request_user') }}</th>
                                <th class="w-auto table-th text-center">{{ __('general.poa_answer_user') }}</th>
                                <th class="w-10 table-th text-center">{{ __('general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($piat->reschedulings as $item)
                                <tr class="tr-hover text-center">
                                    <td>{{$item->description}}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                <span class="badge badge- {{ \App\Models\Poa\Piat\PoaActivityPiatRescheduling::STATUSES_BG[$item->status] }}
                                        badge-pill">
                                    {{ $item->status }}
                                </span>
                                        </div>
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
                                        @can('manage-reschedulings-poa-activity-piat')
                                            @if($item->status==\App\Models\Projects\ProjectRescheduling::STATUS_OPENED)
                                                @can('approve-rescheduling-poa-activity-piat')
                                                    <a href="javascript:void(0)"
                                                       data-toggle="modal"
                                                       data-target="#approve-poa-activity-piat-rescheduling"
                                                       data-item-id="{{$item->id}}">
                                                        <i class="fas fa-check-circle mr-1 text-info"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="Aprobar"></i>
                                                    </a>
                                                @endcan
                                                <a href="javascript:void(0)"
                                                   data-toggle="modal"
                                                   data-target="#edit-poa-activity-piat-rescheduling"
                                                   data-item-id="{{$item->id}}">
                                                    <i class="fas fa-edit mr-1 text-info"
                                                       data-toggle="tooltip" data-placement="top" title=""
                                                       data-original-title="Editar"></i>
                                                </a>
                                                <x-delete-link action="{{ route('piat.delete_piat_rescheduling', $item->id) }}" id="{{ $item->id }}"/>
                                            @endif
                                        @endcan
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
        </div>
        <div wire:ignore>
            <livewire:piat.reschedulings.poa-activity-piat-rescheduling :piatId="$piat->id"/>
        </div>
        <div wire:ignore>
            <livewire:piat.reschedulings.edit-poa-activity-piat-rescheduling :piatId="$piat->id"/>
        </div>
        <div wire:ignore>
            <livewire:piat.reschedulings.approve-poa-activity-piat-rescheduling/>
        </div>
    @endcan
@endsection

@push('page_script')
    <script>
        Livewire.on('toggleCreateRes', () => $('#poa-piat-activity-rescheduling').modal('toggle'));
        Livewire.on('toggleEditRes', () => $('#edit-poa-activity-piat-rescheduling').modal('toggle'));

        $('#edit-poa-activity-piat-rescheduling').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('item-id');
            //Livewire event trigger
            Livewire.emit('openEditRescheduling', id);
        });
        $('#approve-poa-activity-piat-rescheduling').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('item-id');
            //Livewire event trigger
            Livewire.emit('openApproveRescheduling', id);
        });
    </script>
@endpush