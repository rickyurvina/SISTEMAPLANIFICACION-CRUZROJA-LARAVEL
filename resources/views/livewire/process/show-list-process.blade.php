<div>
    <div class="d-flex flex-wrap mb-2">
        <div class="d-flex flex-wrap w-100">
            <div class="d-flex w-50">
                <div class="pr-2 d-flex flex-wrap w-100">
                    <div class="d-flex position-relative mr-auto w-100">
                        <i class="spinner-border spinner-border-sm position-absolute pos-left mx-3" style="margin-top: 0.75rem" wire:target="search" wire:loading></i>
                        <i class="fal fa-search position-absolute pos-left fs-lg mx-3" style="margin-top: 0.75rem" wire:loading.remove></i>
                        <input type="text" wire:model.debounce.300ms="search" class="form-control bg-subtlelight pl-6"
                               placeholder="Buscar...">
                    </div>
                </div>
            </div>
            <div class="d-flex w-20">
                <div class="position-relative w-100" x-data="{ open: false }">
                    <button class="btn btn-outline-secondary dropdown-toggle-custom w-100  @if(count($selectType) > 0) filtered @endif" x-on:click="open = ! open"
                            type="button">
                        <span class="spinner-border spinner-border-sm" wire:loading></span>
                        @if(count($selectType) > 0)
                            <span class="badge bg-white ml-2">
                                @foreach($selectType as $item)
                                    {{$item.' / '}}
                                @endforeach
                            </span>
                        @else
                            {{trans('general.type').' de '.trans_choice('process.process',0)}}
                        @endif
                    </button>
                    <div class="dropdown mb-2 w-100" x-on:click.outside="open = false" x-show="open"
                         style="will-change: top, left;top: 37px;left: 0;">
                        <div class="p-3 hidden-child" wire:loading.class.remove="hidden-child"
                             wire:target="searchLocation">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <div wire:loading.class="hidden-child">
                            <div style="max-height: 300px; overflow-y: auto" class="w-100">
                                @if(empty($typesProcess))
                                    <div class="dropdown-item" x-cloak
                                         @click="open = false">
                                        <span>{{ trans('general.type') }}</span>
                                    </div>
                                @endif
                                @foreach($typesProcess as $index => $item)
                                    <div class="dropdown-item cursor-pointer"
                                         wire:key="{{time().$index}}">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="i-department-{{ $item }}" wire:model="selectType"
                                                   value="{{ $item }}">
                                            <label class="custom-control-label"
                                                   for="i-department-{{ $item }}">{{ $item  }}</label>
                                        </div>
                                    </div>
                                @endforeach
                                @if(count($selectType) > 0 )
                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-item">
                                        <span wire:click="$set('selectType', [])" class="cursor-pointer">{{ trans('general.delete_selection') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(count($selectType) > 0 || $search != '')
                <div class="d-flex w-15">
                    <a href="javascript:void(0);" class="btn btn-outline-default ml-2" wire:click="cleanFilters()">{{ trans('common.clean_filters') }}</a>
                </div>
            @endif
        </div>
    </div>
    <div class="panel-container show">
        @if($processes->count()>0)
            <div class="card">
                <div class="table-responsive">
                    <table class="table  m-0">
                        <thead class="bg-primary-50">
                        <tr>
                            <th class="w-10">
                                <a wire:click.prevent="sortBy('code')" role="button" href="#">
                                    {{trans('general.code')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="code"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="w-auto">
                                <a wire:click.prevent="sortBy('name')" role="button" href="#">
                                    {{trans('general.name')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="name"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="w-15">
                                <a wire:click.prevent="sortBy('owner_id')" role="button" href="#">
                                    Dueño del proceso
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="owner_id"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="w-15">
                                <a wire:click.prevent="sortBy('type')" role="button" href="#">
                                    Tipo
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="type"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="color-primary-500 w-5">{{trans_choice('general.department',1)}}</th>
                            <th class="color-primary-500 w-5" aria-expanded="false"
                                data-toggle="tooltip" data-placement="top" title=""
                                data-original-title=" {{trans_choice('general.indicators',1)}}">IND
                            </th>
                            <th class="color-primary-500 w-5" aria-expanded="false"
                                data-toggle="tooltip" data-placement="top" title=""
                                data-original-title=" {{trans('general.nonconformity')}}">NO-CONF
                            </th>
                            <th class="color-primary-500 w-5" aria-expanded="false"
                                data-toggle="tooltip" data-placement="top" title=""
                                data-original-title=" {{trans('general.activities')}}">ACT
                            </th>
                            <th class="color-primary-500 w-15">
                                <div class="pl-2">
                                    {{ trans('general.actions') }}
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($processes as $index=>$item)

                            <tr wire:key="{{time().$index}}">
                                <td>{{$item->code}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->owner ? $item->owner->getFullName() :'-'}}</td>
                                <td>
                                    <span class="badge badge- {{ \App\Models\Process\Process::TYPES_BG[$item->type] }} badge-pill">{{ $item->type }}</span>

                                </td>
                                <td>{{$item->department_id ? $item->department->name :'-'}}</td>
                                <td>
                                    <a class="btn btn-info btn-sm btn-icon"
                                       href="{{ route('process.showIndicators', [$item->id, \App\Models\Process\Process::PHASE_CHECK]) }}"
                                       data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="Indicadores">
                                        {{$item->indicators->count()}}
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-info btn-sm btn-icon"
                                       href="{{ route('process.showConformities', [$item->id, \App\Models\Process\Process::PHASE_ACT]) }}"
                                       data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="{{trans('general.nonconformity')}}">
                                        {{$item->nonConformities->count()}}
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-info btn-sm btn-icon"
                                       href="{{ route('process.showActivities', [$item->id, \App\Models\Process\Process::PHASE_PLAN]) }}"
                                       data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="{{trans_choice('general.activities',1)}}">
                                        {{$item->activitiesProcess->count()}}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="frame-wrap">
                                        <div class="d-flex justify-content-start">
                                            <div class="p-1 mt-1">
                                                <a href="{{ route('process.showInformation', [$item->id, \App\Models\Process\Process::PHASE_PLAN]) }}"
                                                   aria-expanded="false"
                                                   data-toggle="tooltip" data-placement="top" title=""
                                                   data-original-title=" {{trans('process.plan')}}"><i
                                                            class="fas fa-calendar-check text-success ml-2"></i>
                                                </a>
                                            </div>
                                            <div class="p-1 mt-1">
                                                <a href="{{ route('process.showConformities', [$item->id, \App\Models\Process\Process::PHASE_ACT]) }}"
                                                   aria-expanded="false"
                                                   data-toggle="tooltip" data-placement="top" title=""
                                                   data-original-title=" {{trans('process.act')}}"><i
                                                            class="fas fa-book-open text-info ml-2"></i>
                                                </a>
                                            </div>
                                            <div class="p-1 mt-1">
                                                <a href="{{ route('process.showIndicators', [$item->id, \App\Models\Process\Process::PHASE_CHECK]) }}"
                                                   aria-expanded="false"
                                                   data-toggle="tooltip" data-placement="top" title=""
                                                   data-original-title="{{trans('process.check')}}"> <i
                                                            class="fas fa-ballot-check text-dark ml-2"></i>
                                                </a>
                                            </div>
                                            <div class="p-1 mt-1">
                                                <a href="{{ route('process.showFiles', [$item->id, \App\Models\Process\Process::PHASE_DO_PROCESS]) }}"
                                                   aria-expanded="false"
                                                   data-toggle="tooltip" data-placement="top" title=""
                                                   data-original-title=" {{trans('process.do')}}"><i
                                                            class="fas fa-pen-alt text-warning ml-2"></i></a>
                                            </div>
                                            @can('manage-process')
                                                <div class="p-1 mt-1">
                                                    <a
                                                            href="javascript:void(0)"
                                                            data-toggle="modal"
                                                            data-target="#update-process-modal"
                                                            data-item-id="{{$item->id}}">
                                                        <i class="fas fa-edit ml-2 text-info"
                                                           aria-expanded="false"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="{{trans('general.edit')}}"></i>
                                                    </a>
                                                </div>
                                                @if($item->activitiesProcess->count()<1 && $item->indicators->count()<1)
                                                    <div>
                                                        <x-delete-link-livewire id="{{ $item->id }}"/>
                                                    </div>
                                                @endif
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <x-pagination :items="$processes"/>
                </div>
            </div>
        @else
            <x-empty-content>
                <x-slot name="title">
                    No existen procesos
                </x-slot>
            </x-empty-content>
        @endif
    </div>
</div>
<div wire:ignore>
    <livewire:process.update-process/>
</div>
@push('page_script')
    <script>
        Livewire.on('toggleCreateProcess', () => $('#create-process-modal').modal('toggle'));
        Livewire.on('toggleUpdateProcess', () => $('#update-process-modal').modal('toggle'));
        $('#update-process-modal').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('item-id');
            //Livewire event trigger
            Livewire.emit('openEditProcess', id);
        });
    </script>
    <script>
        function deleteModel(id) {
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
                @this.call('delete', id);
                }
            });
        }
    </script>
@endpush