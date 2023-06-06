<div>
    <div class="panel-container show">
        <div class="card">
            <div class="card-header d-flex flex-wrap w-100">
                <div class="d-flex position-relative" style="width: 90%">
                    <i class="spinner-border spinner-border-sm position-absolute pos-left mx-3" style="margin-top: 0.75rem" wire:target="search" wire:loading></i>
                    <i class="fal fa-search position-absolute pos-left fs-lg mx-3" style="margin-top: 0.75rem" wire:loading.remove></i>
                    <input type="text" wire:model.debounce.300ms="search" class="form-control bg-subtlelight pl-6"
                           placeholder="Buscar...">
                </div>
                <div class="d-flex ml-auto w-10">
                    @if($pageIndex==\App\Models\Process\Process::PHASE_CHECK)
                        @can('process-manage-indicators')
                            <button class="btn btn-success border-0 shadow-0 ml-auto"
                                    wire:click="$emit('show', 'App\\Models\\Process\\Process', '{{ $process->id }}')">
                                {{ trans('general.create') }} Indicador
                            </button>
                        @endcan
                    @endif
                </div>
            </div>
            @if($indicators->count()>0)
                <div class="table-responsive">
                    <table class="table  m-0">
                        <thead class="bg-primary-50">
                        <tr>
                            <th>@sortablelink('name', trans('general.name'))</th>
                            <th>@sortablelink('indicator_units_id', trans('general.indicator_unit'))</th>
                            <th>@sortablelink('total_goal_value', trans('general.goal'))</th>
                            <th>@sortablelink('total_actual_value', trans('general.advance'))</th>
                            <th class="text-primary">{{ trans('general.progress')}}</th>
                            <th class="text-primary">{{ trans('general.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($indicators as $indicator)
                            <tr wire:key="{{time().$indicator->code}}">
                                <td>{{ $indicator->name }}</td>
                                <td>  {{ $indicator->indicatorUnit->name }}</td>
                                <td>{{ $indicator->total_goal_value>0 ?  $indicator->total_goal_value : '0.00'}}</td>
                                <td>{{ $indicator->total_actual_value>0 ?  $indicator->total_actual_value : '0.00'}}</td>
                                <td>
                                    <span class="form-label badge {{$indicator->getStateIndicator()[0]?? null}}  badge-pill">{{$indicator->getStateIndicator()[1]?? null}}</span>
                                </td>
                                <td class="text-center">
                                    <div class="frame-wrap" wire:key="{{ 'r.i.' . $loop->index }}">
                                        <div class="d-flex justify-content-start">
                                            @can('process-manage-indicators')
                                                <div class="p-2 mt-1">
                                                    <div class="cursor-pointer"
                                                         wire:click="$emit('triggerAdvance','{{ $indicator->id }}')">
                                                            <span class="color-success-700"><i
                                                                        class="far fa-calendar-alt" aria-expanded="false"
                                                                        data-toggle="tooltip" data-placement="top" title=""
                                                                        data-original-title="Avance"></i></span>
                                                    </div>
                                                </div>
                                            @endcan
                                            @can('process-view-indicators')
                                                <div class="p-2 mt-1">
                                                    <div class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ver"
                                                         wire:click="$emitTo('indicators.indicator-show', 'open', {{ $indicator->id }})">
                                                                                    <span class="color-info-700"><i
                                                                                                class="far fa-eye"></i></span>
                                                    </div>
                                                </div>
                                            @endcan
                                            @if($pageIndex==\App\Models\Process\Process::PHASE_CHECK)
                                                @can('process-manage-indicators')
                                                    <div class="p-2 mt-1">
                                                        <div class="cursor-pointer" aria-expanded="false" data-toggle="tooltip" data-placement="top" title=""
                                                             data-original-title="Editar" wire:click="$emit('triggerEdit','{{$indicator->id}}')"><i
                                                                    class="fas fa-edit mr-1 text-info"></i>
                                                        </div>
                                                    </div>
                                                @endcan
                                            @endif
                                            @if($pageIndex==\App\Models\Process\Process::PHASE_CHECK)
                                                @can('process-manage-indicators')
                                                    <div class="p-2 mt-1">
                                                        <a href="javascript:void(0);" class="cursor-pointer" wire:click="$emit('triggerDeleteIndicator', '{{ $indicator->id }}')"
                                                           aria-expanded="false"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="Eliminar"
                                                        ><i class="fas fa-trash-alt text-danger"></i>
                                                        </a>
                                                    </div>
                                                @endcan
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-empty-content>
                    <x-slot name="title">
                        No existen indicadores asociados
                    </x-slot>
                </x-empty-content>
            @endif
        </div>

    </div>

</div>
<div wire:ignore>
    <div class="modal fade fade" id="indicator-show-modal" tabindex="-1" style="display: none;" role="dialog"
         aria-hidden="true">
        <livewire:indicators.indicator-show/>
    </div>
</div>
<div wire:ignore>
    <livewire:indicators.indicator-edit/>
</div>
<div wire:ignore>
    <livewire:indicators.indicator-create/>
</div>
<div wire:ignore>
    <livewire:indicators.indicator-register-advance/>
</div>

@push('page_script')
    <script>
        Livewire.on('toggleIndicatorShowModal', () => $('#indicator-show-modal').modal('toggle'));
        Livewire.on('toggleIndicatorEditModal', () => $('#indicator-edit-modal').modal('toggle'));
        Livewire.on('toggleRegisterAdvance', () => $('#register-indicator-advance').modal('toggle'));
        Livewire.on('triggerAdvance', id => {
            $('#register-indicator-advance').modal('toggle');
            Livewire.emit('actionLoad', id);
        });


    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @this.
            on('triggerEdit', id => {
                Livewire.emit('loadIndicatorEditData', id);
                $('#indicator-edit-modal').modal('toggle');
            });
            @this.
            on('triggerDeleteIndicator', id => {
                Swal.fire({
                    title: '{{ trans('messages.warning.sure') }}',
                    text: '{{ trans('messages.warning.delete') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'var(--danger)',
                    confirmButtonText: '<i class="fas fa-trash"></i> {{ trans('general.yes') . ', ' . trans('general.delete') }}',
                    cancelButtonText: '<i class="fas fa-times"></i> {{ trans('general.no') . ', ' . trans('general.cancel') }}'
                }).then((result) => {
                    //if user clicks on delete
                    if (result.value) {
                        // calling destroy method to delete
                        @this.
                        call('deleteIndicator', id);
                    }
                });
            });
        });
    </script>
@endpush
