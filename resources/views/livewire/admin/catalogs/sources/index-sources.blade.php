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
            @if($search != '')
                <div class="d-flex w-15">
                    <a href="javascript:void(0);" class="btn btn-outline-default ml-2" wire:click="cleanFilters()">{{ trans('common.clean_filters') }}</a>
                </div>
            @endif
            <div class="d-flex ml-auto">
                <button type="button" class="btn btn-success border-0 shadow-0" data-toggle="modal"
                        data-target="#create-source">{{ trans('general.create')}} {{trans_choice('general.sources', 2)}}
                </button>
            </div>
        </div>
    </div>
    <div class="panel-container show">
        @if($sources->count()>0)
            <div class="card">
                <div class="table-responsive">
                    <table class="table  m-0">
                        <thead class="bg-primary-50">
                        <tr>
                            <th class="w-auto">
                                <a wire:click.prevent="sortBy('name')" role="button" href="#">
                                    {{trans('general.name')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="name"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="w-15">
                                <a wire:click.prevent="sortBy('institution')" role="button" href="#">
                                    {{ trans('general.institution')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="institution"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="w-15">
                                <a wire:click.prevent="sortBy('description')" role="button" href="#">
                                    {{trans('general.description')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="description"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="w-15">
                                <a wire:click.prevent="sortBy('type')" role="button" href="#">
                                    {{ trans('general.type')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="type"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="color-primary-500 w-15">
                                <div class="pl-2">
                                    {{ trans('general.actions') }}
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sources as $index=>$item)
                            <tr wire:key="{{time().$index}}">
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->institution }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->type? trans('indicators.indicator.TYPE_'.$item->type) :''}}</td>
                                <td class="text-center">
                                    <div class="frame-wrap">
                                        <div class="d-flex justify-content-start">
                                            <div class="p-1 mt-1">
                                                <a
                                                        href="javascript:void(0)"
                                                        data-toggle="modal"
                                                        data-target="#update-source"
                                                        data-item-id="{{$item->id}}">
                                                    <i class="fas fa-edit ml-2 text-info"
                                                       aria-expanded="false"
                                                       data-toggle="tooltip" data-placement="top" title=""
                                                       data-original-title="{{trans('general.edit')}}"></i>
                                                </a>
                                            </div>
                                            <div>
                                                <x-delete-link-livewire id="{{ $item->id }}"/>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <x-pagination :items="$sources"/>
                </div>
            </div>
        @else
            <x-empty-content>
                <x-slot name="title">
                    No existen fuentes de información
                </x-slot>
            </x-empty-content>
        @endif
    </div>
</div>
<div wire:ignore>
    <livewire:admin.catalogs.sources.create-source/>
</div>
<div wire:ignore>
    <livewire:admin.catalogs.sources.edit-source/>
</div>
@push('page_script')
    <script>
        Livewire.on('toggleCreateSource', () => $('#create-source').modal('toggle'));
        Livewire.on('toggleUpdateSource', () => $('#update-source').modal('toggle'));
        $('#update-source').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('item-id');
            //Livewire event trigger
            Livewire.emit('openSource', id);
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
                    @this.
                    call('delete', id);
                }
            });
        }
    </script>
@endpush