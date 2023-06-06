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
                    @can('process-manage-conformities')
                        <button type="button" class="btn btn-success border-0 shadow-0 ml-auto" data-toggle="modal"
                                data-target="#create-non-conformity">{{ trans('general.create')}} {{trans('general.nonconformity')}}
                        </button>
                    @endcan
                </div>
            </div>
            @if($nonConformities->count()>0)
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead class="bg-primary-50">
                        <tr>
                            <th class="text-primary table-th w-10">
                                <a wire:click.prevent="sortBy('number')" role="button" href="#">
                                    {{trans('general.number')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="number"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="text-primary table-th w-10">
                                <a wire:click.prevent="sortBy('code')" role="button" href="#">
                                    {{trans('general.code')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="code"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="text-primary table-th w-15">
                                <a wire:click.prevent="sortBy('type')" role="button" href="#">
                                    {{trans('general.type')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="type"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="text-primary table-th w-5">
                                <a wire:click.prevent="sortBy('state')" role="button" href="#">
                                    {{trans('general.state')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="state"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="text-primary table-th w-10">
                                <a wire:click.prevent="sortBy('date')" role="button" href="#">
                                    {{trans('general.date')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="date"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="text-primary w-20 table-th">
                                <a wire:click.prevent="sortBy('description')" role="button" href="#">
                                    {{trans('general.description')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="description"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="text-primary w-20 table-th">
                                <a wire:click.prevent="sortBy('evidence')" role="button" href="#">
                                    {{trans('general.evidence')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="evidence"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="text-primary w-10 table-th"><a href="#">{{ trans('general.actions') }} </a></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($nonConformities as $item)
                            <tr class="tr-hover" wire:ignore wire:key="{{time().$item->id}}">
                                <td>
                                    {{$item->number}}
                                </td>
                                <td>
                                    {{$item->code}}
                                </td>
                                <td>
                                    {{$item->type}}
                                </td>
                                <td>
                                    <span class="badge badge- {{ \App\Models\Process\NonConformities::TYPE_BG[$item->state]}} badge-pill">{{ $item->state }}</span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        {{$item->date->format('j F, Y')  }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        {{$item->description}}
                                    </div>
                                </td>
                                <td>
                                    {{$item->evidence}}
                                </td>
                                <td>
                                    @can('process-manage-conformities')
                                        <a href="{{route('nonConformities.edit',[$item->id,$subMenu, $pageIndex])}}"
                                           data-toggle="tooltip" data-placement="top" title="" class="mr-1"
                                           data-original-title="Editar">
                                            <i class="fas fa-edit mr-1 text-info"
                                            ></i>
                                        </a>
                                        @can('process-close-conformities')
                                            <a href="javascript:void(0)"
                                               data-toggle="modal"
                                               data-target="#manage-non-conformity"
                                               data-item-id="{{$item->id}}">
                                                <i class="fas fa-address-card text-info"
                                                   data-toggle="tooltip" data-placement="top" title="Gestionar"
                                                   data-original-title="Gestionar"></i>
                                            </a>
                                        @endcan
                                        @if($item->actions->count()==0)
                                            <x-delete-link-livewire id="{{ $item->id }}"/>
                                        @endif
                                    @endcan
                                </td>
                        @endforeach
                        </tbody>
                    </table>
                    <x-pagination :items="$nonConformities"/>
                </div>
            @else
                <x-empty-content>
                    <x-slot name="title">
                        {{ trans('general.there_are_no_nonconformities') }}
                    </x-slot>
                </x-empty-content>
            @endif
        </div>
    </div>
</div>
<div wire:ignore>
    <livewire:process.non-conformities.manage-non-conformity/>
</div>
@push('page_script')
    <script>
        Livewire.on('toggleCreateNonConformity', () => $('#create-non-conformity').modal('toggle'));
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

    <script>
        $('#manage-non-conformity').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('item-id');
            //Livewire event trigger
            Livewire.emit('openManage', id);
        });
    </script>
@endpush