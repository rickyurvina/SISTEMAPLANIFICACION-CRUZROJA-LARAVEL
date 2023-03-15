@extends('layouts.admin')

@section('title', __('poa.list_poas'))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-align-left text-primary"></i> {{ __('poa.list_poas') }}
    </h1>
    @if($companyFind->level!=2)
        @can('poa-crud-poa')
            <a href="javascript:void(0);" data-toggle="modal" data-target="#create-modal-poa" class="btn btn-success btn-sm">
                <span class="fas fa-plus mr-1"></span>
                {{ trans('general.add_new') }}
            </a>
        @endcan
    @endif
@endsection

@section('content')
    @if($poas)
        <div class="table-responsive">
            <table class="table table-hover m-0">
                <thead class="bg-primary-50">
                <tr>
                    <th class="w-5 table-th text-info"> {{trans('poa.year')}}</th>
                    <th class="w-25 table-th text-info">{{trans('poa.name')}}</th>
                    <th class="w-15 table-th text-info">{{trans('poa.responsible')}}</th>
                    <th class="w-10 table-th text-info">{{trans('general.phase')}}</th>
                    <th class="w-10 table-th text-info">{{trans('poa.status')}}</th>
                    <th class="w-10 table-th text-info">{{trans('poa.reviewed')}}</th>
                    <th class="w-10 table-th text-info">{{trans('poa.progress')}}</th>
                    @can('poa-crud-poa')
                        <th class="w-15 table-th"><a href="#">{{ trans('general.actions') }}</a></th>
                    @endcan
                </tr>
                </thead>
                <tbody>
                @foreach($poas as $item)
                    <tr>
                        <td>{{ $item->year }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->responsible->name }}</td>
                        <td>
                            <span class="badge {{ $item->phase->color() }}">{{ $item->phase->label() }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $item->status->color() }} badge-pill">{{ $item->status->label() }}</span>
                        </td>
                        <td>
                            @if($item->reviewed)
                                <span class="badge badge-success badge-pill">{{ __('general.yes') }}</span>
                            @else
                                <span class="badge badge-danger badge-pill">{{ __('general.no') }}</span>
                            @endif
                        </td>
                        <td class="w-10">
                            {!! $item->thresholdProgress() !!}
                        </td>
                        @can('poa-crud-poa')
                            <td>
                                <span data-toggle="modal" data-target="#approve-modal-poa" data-id="{{ $item->id }}">
                                    <a class="mr-2" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="Aprobar">
                                        <i class="fas fa-check-circle mr-1 text-success @if($item->approved) text-success @else text-info @endif "></i>
                                    </a>
                                </span>
                                @if(!$item->isClosed())
                                    <span data-toggle="modal" data-target="#edit-modal-poa" data-id="{{ $item->id }}">
                                        <a class="mr-2" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                                           data-original-title="Editar">
                                            <i class="fas fa-edit mr-1 text-info"></i>
                                        </a>
                                    </span>
                                @endif
                                <a class="mr-2" href="{{ route('poas.activities.index', ['poa' => $item->id]) }}"
                                   data-toggle="tooltip" data-placement="top" title=""
                                   data-original-title="Ver Actividades">
                                    <i class="fas fa-arrow-alt-right"></i>
                                </a>
                                @if(!$item->isClosed())
                                    <a class="mr-2" href="{{ route('poa.config', ['poaId' => $item->id]) }}"
                                       data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="{{trans('general.settings')}}">
                                        <i class="fas fa-cog text-success"></i>
                                    </a>
                                @endif
                                @if($item->canBeReplicated())
                                    <a class="mr-2" href="{{ route('poa.replicate', ['poaId' => $item->id]) }}"
                                       data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="Duplicar POA"
                                    >
                                        <i class="fas fa-check-double text-secondary"></i>
                                    </a>
                                @endif
                                @if($item->status instanceof \App\States\Poa\InProgress)
                                    <a class="mr-2" href="{{ route('poa.goal_change_request', ['poaId' => $item->id]) }}"
                                       data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="Solicitudes de cambio de metas"
                                    >
                                        <i class="fas fa-file-signature text-danger"></i>
                                    </a>
                                @endif
                                <a class="mr-2" href="{{ route('poa.budget', $item->id) }}"
                                   data-toggle="tooltip" data-placement="top" title=""
                                   data-original-title="Presupuesto"
                                >
                                    <i class="fas fa-money-bill text-success"></i>
                                </a>
                                @can('poa-crud-poa')
                                    @if(!$item->isClosed())
                                        <x-delete-link action="{{ route('poas.destroy', $item->id) }}" id="{{ $item->id }}"/>
                                    @endif
                                @endcan

                            </td>
                        @endcan
                    </tr>
                @endforeach
                </tbody>
            </table>
            <x-pagination :items="$poas"/>
        </div>
    @endif
    @include('modules.poa.poas.groups-poas-by-province')
    <div wire:ignore>
        <livewire:poa.poa-edit/>
    </div>
    <div wire:ignore>
        <livewire:poa.poa-approve/>
    </div>
    <div wire:ignore>
        <livewire:poa.poa-create/>
    </div>

@endsection

@push('page_script')

    <script>
        $('#edit-modal-poa').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let poaId = $(e.relatedTarget).data('id');
            //Livewire event trigger
            Livewire.emit('loadForm', poaId);
        });
    </script>

    <script>
        $('#approve-modal-poa').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let poaId = $(e.relatedTarget).data('id');
            //Livewire event trigger
            Livewire.emit('mount', poaId);
        });
    </script>
@endpush