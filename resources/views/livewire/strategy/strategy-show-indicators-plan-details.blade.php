<div>
    <ol class="breadcrumb bg-transparent breadcrumb-sm pl-0 pr-0">
        @foreach($planRegisteredTemplateDetailsBreadcrumbs as $item)
            <li class="breadcrumb-item {{ $item['link'] == '' ? 'active' : '' }}">
                @if($item['link'] == '')
                    @if($item['first'])
                        <i class="fal fa-folder-open mr-1"></i>
                    @endif <a class="fs-2x color-black"> {{ $item['name'] }}</a>
                @else
                    <a href="{{ $item['link'] }}" class="fs-2x">@if($item['first'])
                            <i class="fal fa-folder-open mr-1"></i>
                        @endif{{ $item['name'] }}</a>
                @endif
            </li>
        @endforeach
    </ol>
    <div>
        <div class="panel-hdr">
            <h2>{{ $planDetail->fullCode . ' - ' . $planDetail->name }}</h2>
            @if($planDetail->plan->status != \App\Models\Strategy\Plan::ARCHIVED)
                <div class="panel-toolbar ml-auto">
                    <a href="#indicator-create-modal"
                       class="btn btn-success btn-sm"
                       data-toggle="modal"
                       data-target="#indicator-create-modal"
                       data-detail-id="{{$planDetailId}}"
                       data-detail-type="{{$type}}">
                        <span class="fas fa-plus mr-1"></span>
                        {{ trans('general.add_new') }}
                    </a>
                </div>
            @endif
        </div>
        <div class="card-header">
            <div class="d-flex position-relative ml-auto w-100">
                <i class="spinner-border spinner-border-sm position-absolute pos-left mx-3" style="margin-top: 0.75rem"
                   wire:target="search" wire:loading></i>
                <i class="fal fa-search position-absolute pos-left fs-lg mx-3" style="margin-top: 0.75rem"
                   wire:loading.remove></i>
                <input type="text" wire:model.debounce.300ms="search" class="form-control bg-subtlelight pl-6"
                       placeholder="Buscar por nombre">
            </div>
        </div>
        <table class="table m-0">
            <thead class="bg-primary-50">
            <tr>
                <th class="w-10">{{  trans('general.code') }}</th>
                <th class="w-10">{{ trans('general.type') }}</th>
                <th class="w-10">{{ trans('general.category') }}</th>
                <th class="w-65">{{ trans('general.name') }}</th>
                <th class="w-10">{{ trans('general.weight') }}</th>
                <th class="text-center color-primary-500 w-10">{{ trans('general.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($measures as $measure)
                <tr>
                    <td># {{ $measure->indicatorable->full_code.'.'. $measure->code }}</td>
                    <td>{{ $measure->scoringType->name }}</td>
                    <td>{{ $measure->category }}</td>
                    <td>{{ $measure->name }}</td>
                    <td>{{ weight($measures->sum('weight'), $measure->weight) }}%</td>
                    <td class="text-center">
                        @if($planDetail->plan->status != \App\Models\Strategy\Plan::ARCHIVED)
                            <div class="frame-wrap">
                                <div class="d-flex justify-content-start">
                                    <div class="p-2"><a href="#"
                                                        data-toggle="modal"
                                                        data-target="#weights">
                                            <i class="fas fa-balance-scale mr-1 text-info"
                                               data-toggle="tooltip" data-placement="top"
                                               data-original-title="Editar Pesos"></i>
                                        </a></div>
                                    <div class="p-2">
                                        <a href="javascript:void(0)"
                                           data-toggle="modal"
                                           data-target="#measure-edit-modal"
                                           data-measure-id="{{$measure->id}}">
                                            <i class="fas fa-edit mr-1 text-info"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="Editar"></i>
                                        </a>
                                    </div>
                                    <div class="p-2">
                                        <x-delete-link-icon
                                                action="{{ route('destroy.measure.strategy', $measure->id) }}"
                                                id="{{ $measure->id }}"></x-delete-link-icon>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div wire:ignore>
        <livewire:measure.measure-create/>
    </div>
    <div wire:ignore>
        <livewire:components.weights :items="$measures"/>
    </div>
    <div wire:ignore.self>
        <livewire:measure.measure-edit/>
    </div>
</div>

@push('page_script')
    <script>
        $('#indicator-create-modal').on('show.bs.modal', function (e) {
            let model = "App\\Models\\Strategy\\PlanDetail";
            let id = $(e.relatedTarget).data('detail-id');
            let type = $(e.relatedTarget).data('detail-type');
            window.livewire.emitTo('measure.measure-create', 'show', model, id, type);
        });
        $('#measure-edit-modal').on('show.bs.modal', function (e) {
            let id = $(e.relatedTarget).data('measure-id');
            window.livewire.emitTo('measure.measure-edit', 'show', id);
        });
    </script>
@endpush
