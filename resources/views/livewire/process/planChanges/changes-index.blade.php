@can('view-changes-process'||'manage-changes-process')
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
                    @can('manage-activities-process-process')
                            @can('manage-changes-process')
                                <button type="button" class="btn btn-success border-0 shadow-0 ml-auto" data-toggle="modal"
                                        data-target="#plan-create-changes">{{ trans('general.create')}} {{trans('process.plan_changes')}}
                                </button>
                            @endcan
                        @endcan
                    </div>
                </div>
                @if($planChanges->count()>0)

                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead class="bg-primary-50">
                            <tr>
                                <th class="text-primary table-th">
                                    <a wire:click.prevent="sortBy('code')" role="button" href="#">
                                        {{trans('general.code')}}
                                        <x-sort-icon sortDirection="{{$sortDirection}}" sortField="code"
                                                     field="{{$sortField}}"></x-sort-icon>
                                    </a>
                                </th>
                                <th class="text-primary table-th">
                                    <a wire:click.prevent="sortBy('date')" role="button" href="#">
                                        {{trans('general.date')}}
                                        <x-sort-icon sortDirection="{{$sortDirection}}" sortField="date"
                                                     field="{{$sortField}}"></x-sort-icon>
                                    </a>
                                </th>
                                <th class="text-primary table-th">Elaborado por:</th>
                                <th class="text-primary table-th">
                                    <a wire:click.prevent="sortBy('description')" role="button" href="#">
                                        {{__('general.description')}}
                                        <x-sort-icon sortDirection="{{$sortDirection}}" sortField="description"
                                                     field="{{$sortField}}"></x-sort-icon>
                                    </a></th>
                                <th class="text-primary table-th">
                                    <a wire:click.prevent="sortBy('objective')" role="button" href="#">
                                        {{trans('general.objective')}}
                                        <x-sort-icon sortDirection="{{$sortDirection}}" sortField="objective"
                                                     field="{{$sortField}}"></x-sort-icon>
                                    </a>
                                </th>
                                <th class="text-primary table-th">
                                    <a wire:click.prevent="sortBy('consequence')" role="button" href="#">
                                        {{trans('general.consequence')}}
                                        <x-sort-icon sortDirection="{{$sortDirection}}" sortField="consequence"
                                                     field="{{$sortField}}"></x-sort-icon>
                                    </a>
                                </th>
                                <th class="text-primary table-th"><a href="#">{{ trans('general.actions') }} </a></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($planChanges as $item)
                                <tr class="tr-hover" wire:ignore wire:key="{{time().$item->id}}">
                                    <td>
                                        {{$item->code}}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{$item->date->format('j F, Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{$item->responsible->getFullName()}}
                                        </div>
                                    </td>
                                    <td>
                                        {{$item->description}}
                                    </td>
                                    <td>
                                        {{$item->objective}}
                                    </td>
                                    <td>
                                        {{$item->consequence}}
                                    </td>
                                    <td>
                                        @can('manage-changes-process')
                                            <a href="{{route('planChanges.edit',[$item->id,$subMenu, $pageIndex])}}"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="Editar">
                                                <i class="fas fa-edit mr-1 text-info"
                                                ></i>
                                            </a>
                                            <x-delete-link action="{{ route('planChanges.delete', [$item->id,$pageIndex]) }}"
                                                           id="{{ $item->id }}"/>
                                        @endcan
                                    </td>
                            @endforeach
                            </tbody>
                        </table>
                        <x-pagination :items="$planChanges"/>
                    </div>
                @else
                    <x-empty-content>
                        <x-slot name="title">
                            {{ trans('general.there_are_no_changes') }}
                        </x-slot>
                    </x-empty-content>
                @endif
            </div>

        </div>
    </div>
@endcan
@push('page_script')
    <script>
        Livewire.on('toggleCreateChange', () => $('#plan-create-changes').modal('toggle'));
    </script>
@endpush
