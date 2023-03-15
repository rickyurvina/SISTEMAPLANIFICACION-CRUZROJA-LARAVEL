@extends('layouts.admin')

@section('title', __('general.poa_goal_change_request'))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-align-left text-primary"></i> {{ __('general.poa_goal_change_request') }}
    </h1>
@endsection

@section('content')

    <div class="card">
        @if($requests)
            <div class="table-responsive">
                <table class="table m-0">
                    <thead class="bg-primary-50">
                    <tr>
                        <th class="w-10">{{__('poa.poa_goal_request_change_date')}}</th>
                        <th class="w-20">{{ trans_choice('poa.activity', 1)}}</th>
                        <th class="w-20">{{trans_choice('poa.indicator', 1)}}</th>
                        <th class="w-5 text-center"># Cambios</th>
                        <th class="w-10 text-center">Usuario</th>
                        <th class="w-10 text-center">{{__('poa.status')}}</th>
                        <th class="w-10 text-center">Poa</th>
                        <th class="w-10 text-center">Sede</th>
                        <th class="text-center color-primary-500 w-5">{{ trans('general.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($requests as $item)
                        <tr>
                            <td class="d-none"></td>
                            <td>{{ $item['date'] }}</td>
                            <td>{{ $item['activity'] }}</td>
                            <td>{{ $item['indicator'] }}</td>
                            <td class="text-center">{{ $item['number_requests'] }} Metas</td>
                            <td class="text-center">{{ $item['user'] }}</td>

                            <td class="text-center">
                                @switch($item['status'])
                                    @case(\App\Models\Poa\PoaIndicatorGoalChangeRequest::STATUS_OPEN)
                                    <span class="badge badge-primary badge-pill">{{ $item['status'] }}</span>
                                    @break
                                    @case(\App\Models\Poa\PoaIndicatorGoalChangeRequest::STATUS_APPROVED)
                                    <span class="badge badge-success badge-pill">{{ $item['status'] }}</span>
                                    @break
                                    @case(\App\Models\Poa\PoaIndicatorGoalChangeRequest::STATUS_DENIED)
                                    <span class="badge badge-danger badge-pill">{{ $item['status'] }}</span>
                                    @break
                                @endswitch
                            </td>
                            <td class="text-center">{{ $item['poa'] }}</td>
                            <td class="text-center">{{ $item['company'] }}</td>

                            <td class="text-center w-20">
                            <span data-toggle="modal" data-target="#edit-request-modal" data-request-id="{{ $item['id'] }}">
                                <a class="mr-2" href="javascript:void(0);"
                                   data-toggle="tooltip"
                                   data-placement="top" data-original-title="{{ __('poa.edit') }}">
                                    <i class="fas fa-external-link mr-1 text-info"></i>
                                </a>
                            </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <livewire:poa.requests.poa-goal-change-request/>
        @else
            <x-empty-content>
                <x-slot name="img">
                    <i class="fas fa-ballot" style="color: #2582fd;"></i>
                </x-slot>
                <x-slot name="title">
                    Solicitudes de cambios de metas
                </x-slot>
                <x-slot name="info">
                    Todavia no se han registrado solicitudes
                </x-slot>

            </x-empty-content>
        @endif
    </div>
@endsection

@push('page_script')
    <script>
        Livewire.on('toggleModalGoalChangeRequest', () => $('#edit-request-modal').modal('toggle'));

        $('#edit-request-modal').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let requestId = $(e.relatedTarget).data('request-id');
            //Livewire event trigger
            Livewire.emit('requestGoalChangeEdit', requestId);
        });
    </script>
@endpush