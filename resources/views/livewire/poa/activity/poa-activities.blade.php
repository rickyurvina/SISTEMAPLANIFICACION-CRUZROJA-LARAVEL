<div>
    <div class="d-flex mb-3">
        <div class="input-group bg-white shadow-inset-2 w-25 mr-2">
            <input type="text" class="form-control border-right-0 bg-transparent pr-0" placeholder="{{ trans('general.filter') . ' ' . trans_choice('general.activities', 2) }} ..."
                   wire:model="search">
            <div class="input-group-append">
                <span class="input-group-text bg-transparent border-left-0">
                    <i class="fal fa-search"></i>
                </span>
            </div>
        </div>

        @if(count($programsLeftList) > 0)
            <div class="btn-group">
                <button class="btn btn-outline-secondary dropdown-toggle @if(count($selectedPrograms) > 0) filtered @endif"
                        type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ trans_choice('general.programs', 2) }}
                    @if(count($selectedPrograms) > 0)
                        <span class="badge bg-white ml-2">{{ count($selectedPrograms) }}</span>
                    @endif
                </button>
                <div class="dropdown-menu width35">
                    @foreach($programs as $program)
                        <div class="dropdown-item" style=" white-space: nowrap !important; overflow: hidden !important;text-overflow: ellipsis !important;"
                             title="{{ $program->planDetail->name }}">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="i-program-{{ $program['id'] }}" wire:model="selectedPrograms" value="{{ $program['id'] }}">
                                <label class="custom-control-label" for="i-program-{{ $program['id'] }}">{{ $program->planDetail->name }}</label>
                            </div>
                        </div>
                    @endforeach
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-item">
                        <span wire:click="$set('selectedPrograms', [])">{{ trans('general.delete_selection') }}</span>
                    </div>
                    <div class="dropdown-item">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="showProgramPanel" checked="" wire:model="showProgramPanel">
                            <label class="custom-control-label" for="showProgramPanel">{{ trans('general.show_panel_programs') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(count($selectedPrograms) > 0 || $search != '')
            <a href="javascript:void(0);" class="btn btn-outline-default ml-2" wire:click="cleanFilters()">{{ trans('common.clean_filters') }}</a>
        @endif
        <button type="button" class="btn btn-success border-0 shadow-0 ml-2" data-toggle="modal"
                data-target="#poa-create-activity-modal">{{ trans('general.create') }}</button>
        <button type="button" class="btn btn-success btn-sm ml-2" data-toggle="modal" data-target="#poa_charge_excel">
            <i class="fas fa-file-excel mr-1"></i>
            {{ trans('general.excel') }}
        </button>
    </div>
    <div class="d-flex align-items-start">
        @if($showProgramPanel)
            <div class="panel w-30 mr-3">
                <div class="panel-hdr">
                    <h2>
                        {{ trans_choice('general.programs', 2) }}
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-toggle="tooltip" data-offset="0,10" data-original-title="{{ trans('general.close') }}"
                                wire:click="$set('showProgramPanel', false)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="accordion accordion-outline accordion-clean" id="accordion-progrms">
                            @foreach($programsLeftList as $program)
                                <div class="card mb-1">
                                    <div class="card-header">
                                        <a href="javascript:void(0);" class="card-title py-2 collapsed w-100" data-toggle="collapse" data-target="#accordion-p-{{ $program['id'] }}"
                                           aria-expanded="false">
                                            <div class="w-5 mr-2">
                                                <span class="color-item shadow-hover-5" style="background-color: {{ $program['color'] }}"></span>
                                            </div>
                                            <div class="w-75 ml-2 text-left">
                                                <span>  {{  $program->planDetail->name }}</span>
                                            </div>
                                            <span class="ml-auto">
                                                <span class="collapsed-reveal">
                                                    <i class="fal fa-minus fs-xl"></i>
                                                </span>
                                                <span class="collapsed-hidden">
                                                    <i class="fal fa-plus fs-xl"></i>
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                    <div id="accordion-p-{{ $program['id'] }}" class="collapse">
                                        <div class="card-body">
                                            <div class="d-flex flex-column">
                                                <div class="dropdown-item cursor-pointer" style="border-radius: 4px" data-toggle="modal"
                                                     data-target="#poa-create-activity-modal"
                                                     data-program-id="{{ $program['id'] }}">
                                                    <i class="fas fa-plus-circle mr-2"></i> {{ trans('general.create') . ' ' . trans_choice('general.activities', 1) }}
                                                </div>
                                                <div class="dropdown-item cursor-pointer" style="border-radius: 4px" data-toggle="modal"
                                                     data-target="#poa-assign-weights"
                                                     data-program-id="{{ $idPoa }}">
                                                    <i class="fal fa-weight-hanging mr-2"></i> {{  trans_choice('general.assign_weights', 1) }}
                                                </div>
                                                <div class="dropdown-item cursor-pointer" style="border-radius: 4px" data-toggle="modal"
                                                     data-target="#poa-assign-goals"
                                                     data-program-id="{{ $program['id'] }}">
                                                    <i class="fas fa-tasks mr-2"></i> {{  trans_choice('general.assign_goals', 1) }}
                                                </div>
                                                <div class="accordion" id="c-{{ $program['id'] }}">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <a href="javascript:void(0);" class="card-title p-2" data-toggle="collapse" data-target="#accordion-c-{{ $program['id']
                                                            }}" aria-expanded="true">
                                                                {{ __('general.change_color') }}
                                                            </a>
                                                        </div>
                                                        <div id="accordion-c-{{ $program['id'] }}" class="collapse">
                                                            <div class="card-body">
                                                                <livewire:components.color-palette :modelId="$program['id']" :key="time().$loop->index"
                                                                                                   class="App\Models\Poa\PoaProgram" field="color"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="w-100">
            <div class="table-responsive">
                <table class="table table-light table-hover">
                    <thead>
                    <tr>
                        <th class="w-15">@sortablelink('planDetail.name', trans_choice('general.programs', 1))</th>
                        <th class="w-20">@sortablelink('measure.name', trans_choice('general.indicators', 1))</th>
                        <th class="w-25">@sortablelink('name', __('poa.name'))</th>
                        <th class="w-10">@sortablelink('poa_weight', __('general.weight'))</th>
                        <th class="w-15">@sortablelink('responsible.name', __('general.responsible'))</th>
                        <th class="w-5">@sortablelink('goal', __('general.goal'))</th>
                        <th class="w-10"><a href="#">{{ trans('general.actions') }} </a></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($activities as $item)
                        <tr class="tr-hover" wire:loading.class.delay="opacity-50">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="w-35">
                                        <span class="color-item shadow-hover-5 mr-2 cursor-default" style="background-color: {{ $item->program->color }}"></span>

                                    </div>
                                    <div class="w-65" style="overflow: hidden; text-overflow: ellipsis;">
                                        <span>
                                            {{ $item->planDetail->name }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span>
                                     <i class="{{$item->measure->unit->getIcon() }}"></i>
                                        {{$item->measure->name  }}
                                </span>
                            </td>
                            <td><a href="{{ route('activities.edit', ['activity' => $item->id]) }}">{{ $item->code ? $item->code . ' - ':'' }}{{ $item->name }}</a></td>
                            <td>{{ number_format($item->poa_weight, 2) }}</td>
                            <td>
                                @if($item->responsible)
                                    <span class="mr-2">
                                        <img src="{{ asset_cdn('img/user.svg') }}" class="rounded-circle width-1">
                                    </span>
                                    {{ $item->responsible->name }}
                                @else
                                    <span class="mr-2">
                                        <img src="{{ asset_cdn('img/user_off.png') }}" class="rounded-circle width-1">
                                    </span>
                                    {{ trans('general.not_assigned') }}
                                @endif
                            </td>
                            <td>
                                {{ $item->measureAdvances->sum('goal') }}
                            </td>
                            <td>
                                <div class="frame-wrap">
                                    <div class="d-flex justify-content-start">
                                        <div class="p-2">
                                            <a href="{{ route('activities.edit', ['activity' => $item->id]) }}" class="mr-2"
                                               data-toggle="tooltip"
                                               data-placement="top" title=""
                                               data-original-title="{{ trans('general.edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                        @if($item->validateCrateBudget())
                                            <div class="p-2">
                                                <a href="{{route('poa.expenses_activity',$item)}}" class="mr-2"
                                                   data-toggle="tooltip"
                                                   data-placement="top" title=""
                                                   data-original-title="{{ trans('budget.budget') }}">
                                                    <i class="fas fa-money-bill text-success"></i>
                                                </a>
                                            </div>
                                        @endif
                                        <div class="p-2">
                                            <button href="#" data-toggle="tooltip" class="color-danger-500 border-0 bg-transparent"
                                                    data-placement="top" title=""
                                                    data-original-title="{{ trans('general.delete') }}" wire:click="$emit('triggerDelete', '{{ $item->id }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="d-flex align-items-center justify-content-center">
                                    <span class="color-fusion-500 fs-3x py-3"><i class="fas fa-exclamation-triangle color-warning-900"></i> No se encontraron actividades</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <x-pagination :items="$activities"/>
        </div>
    </div>
    <div wire:ignore>
        <livewire:poa.poa-charge-excel :idPoa="$idPoa"/>
    </div>
</div>
@push('page_script')
    <script>
        Livewire.on('togglePoaChargeExcel', () => $('#poa_charge_excel').modal('toggle'));
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            @this.
            on('triggerDelete', id => {
                Swal.fire({
                    title: '{{ trans('messages.warning.sure') }}',
                    text: '{{ trans('messages.warning.delete') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'var(--danger)',
                    confirmButtonText: '<i class="fas fa-trash"></i> {{ trans('general.yes') . ', ' . trans('general.delete') }}',
                    cancelButtonText: '<i class="fas fa-times"></i> {{ trans('general.no') . ', ' . trans('general.cancel') }}'
                }).then((result) => {
                    if (result.value) {
                        @this.
                        call('delete', id);
                    }
                });
            });
        })
    </script>
@endpush
