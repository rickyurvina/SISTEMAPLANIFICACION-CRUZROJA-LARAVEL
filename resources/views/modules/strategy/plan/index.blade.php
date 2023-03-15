@extends('layouts.admin')

@section('title', trans_choice('general.plan', 2))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-align-left text-primary"></i> {{ trans_choice('general.plan', 2) }}
    </h1>
    @if(Gate::check('strategy-plan-crud-strategy') || Gate::check('strategy-crud-strategy'))
        <a href="{{ route('plans.create') }}" class="btn btn-success btn-sm" data-toggle="modal"
           data-target="#new-modal-plan"><span class="fas fa-plus mr-1"></span>
            {{ trans('general.add_plan_strategy') }}
        </a>
    @endif
@endsection

@section('content')

    @if($plans->count()>0)
        <div class="card">
            <x-search route="{{ route('plans.index') }}"/>
            <div class="table-responsive">
                <table class="table m-0">
                    <thead class="bg-primary-50">
                    <tr>
                        <th class="w-15 color-primary-500 ">@sortablelink('name', trans('general.name'))</th>
                        <th class="w-15 color-primary-500 ">{{trans('general.start_date')}}</th>
                        <th class="w-15 color-primary-500 ">{{trans('general.end_date')}}</th>
                        <th class="w-5 color-primary-500 ">{{trans('general.status')}}</th>
                        <th class="w-5  color-primary-500 text-center">{{ trans('general.objectives_name')}}</th>
                        @if(Gate::check('strategy-plan-crud-strategy') || Gate::check('strategy-crud-strategy'))
                            <th class="text-center color-primary-500 w-5">{{ trans('general.actions') }}</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($plans as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->temporality_start }}</td>
                            <td>{{ $item->temporality_end }}</td>
                            <td>
                                @switch($item->status)
                                    @case(\App\Models\Strategy\Plan::DRAFT)
                                    <small class="badge badge-info badge-pill text-center w-100"
                                           style="height: 30px; align-items: center; display: grid">{{ __('general.poa_draft') }}</small>
                                    @break
                                    @case(\App\Models\Strategy\Plan::ACTIVE)
                                    <small class="badge badge-success badge-pill text-center w-100"
                                           style="height: 30px; align-items: center; display: grid">{{ __('general.enabled') }}</small>
                                    @break
                                    @case(\App\Models\Strategy\Plan::ARCHIVED)
                                    <small class="badge badge-primary badge-pill text-center w-100"
                                           style="height: 30px; align-items: center; display: grid">{{ __('general.archived') }}</small>
                                    @break
                                @endswitch
                            </td>
                            <td class="text-center w-5">
                                @if($item->planRegisteredTemplateDetails->where('parent_id',null)->count() > 1)
                                    <a class="mr-2 btn btn-info btn-sm btn-icon waves-effect waves-themed"
                                       href="{{ route('plans.details', ['plan' => $item->id]) }}"
                                       data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="Navegar">
                                        <i class="fas fa-window-restore"></i>
                                    </a>
                                @else
                                    <a class="mr-2 btn btn-info btn-sm btn-icon waves-effect waves-themed"
                                       href="{{ route('plans.detail',
                                                ['plan' => $item->id, 'level' => 1,]) }}"
                                       data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="Detalles">
                                        {{$item->planDetails->where('parent_id',null)->count()}}
                                    </a>
                                @endif

                            </td>
                            @if(Gate::check('strategy-plan-crud-strategy') || Gate::check('strategy-crud-strategy'))
                                <td class="text-center w-20">
                                    @if($item->status != \App\Models\Strategy\Plan::ARCHIVED)
                                        <a href="#" data-toggle="modal" data-plan-id="{{ $item->id }}"
                                           data-target="#edit-modal-plan">
                                            <i class="fas fa-edit mr-1 text-info"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="Editar"></i></a>
                                        @if($item->status==\App\Models\Strategy\Plan::DRAFT)
                                            <x-delete-link-icon
                                                    action="{{ route('plan.delete', ['plan' => $item->id]) }}"
                                                    id="{{ $item->id }}">
                                            </x-delete-link-icon>
                                        @endif
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <x-pagination :items="$plans"/>
        </div>
    @else

        <x-empty-content>
            <x-slot name="title">
                No existen planes definidos
            </x-slot>
        </x-empty-content>

    @endif
    <livewire:strategy.plan-create/>
    <livewire:strategy.plan-edit/>
@endsection

@push('page_script')
    <script>
        function openArticulations(id) {
            Livewire.emit('openArticulations', id);
        }

        $('#edit-modal-plan').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let planId = $(e.relatedTarget).data('plan-id');
            //Livewire event trigger
            Livewire.emit('loadForm', planId);
        });
        $("#edit-modal-plan").on("hidden.bs.modal", function () {
            // Aquí va el código a disparar en el evento
            location.reload()
        });

    </script>
@endpush