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
                    <button type="button" class="btn btn-success border-0 shadow-0 ml-auto" data-toggle="modal"
                            data-target="#non-conformity-action">{{ trans('general.create')}} {{trans('general.action')}}
                    </button>
                </div>
            </div>
            @if($actions->count()>0)
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead class="bg-primary-50">
                        <tr>
                            <th class="table-th text-primary">
                                <a wire:click.prevent="sortBy('name')" role="button" href="#">
                                    {{__('general.name')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="name"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="table-th text-primary">
                                <a wire:click.prevent="sortBy('implantation_date')" role="button" href="#">
                                    {{trans('general.implantation_date')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="implantation_date"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="table-th text-primary">
                                <a wire:click.prevent="sortBy('status')" role="button" href="#">
                                    {{trans('general.status')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="status"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="table-th text-primary">
                                <a wire:click.prevent="sortBy('start_date')" role="button" href="#">
                                    {{trans('general.start_date')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="start_date"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="table-th text-primary">
                                <a wire:click.prevent="sortBy('end_date')" role="button" href="#">
                                    {{trans('general.end_date')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="end_date"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="table-th text-primary"><a href="#">{{ trans('general.responsible') }} </a></th>
                            <th class="w-10 table-th text-primary"><a href="#">{{ trans('general.actions') }} </a></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($actions as $item)
                            <tr class="tr-hover" wire:ignore wire:key="{{time().$item->id}}">
                                <td>
                                    <div class="d-flex">
                                        {{$item->name}}
                                    </div>
                                </td>
                                <td>
                                    {{$item->implantation_date->format('j F, Y')}}
                                </td>
                                <td>
                                    <div class="d-flex">
                                        {{$item->status}}
                                    </div>
                                </td>
                                <td>
                                    {{$item->start_date->format('j F, Y')}}
                                </td>
                                <td>
                                    {{$item->end_date->format('j F, Y')}}
                                </td>
                                <td>
                                    {{$item->user_id ? $item->responsible->getFullName():'-'}}
                                </td>
                                <td>
                                    @if($item->status==App\Models\Process\NonConformitiesActions::STATUS_OPEN)
                                        <a
                                                href="javascript:void(0)"
                                                data-toggle="modal"
                                                data-target="#edit-non-conformity-action"
                                                data-item-id="{{$item->id}}">
                                            <i class="fas fa-edit ml-2 text-info"
                                               aria-expanded="false"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="{{trans('general.edit')}}"></i>
                                        </a>
                                        <a
                                                href="javascript:void(0)"
                                                wire:click="$emit('triggerDelete', '{{ $item->id }}')"
                                                aria-expanded="false"
                                                data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="{{trans('general.delete')}}">
                                            <i class="fas fa-trash ml-2 text-danger"
                                            ></i>
                                        </a>
                                    @endif
                                </td>
                        @endforeach
                        </tbody>
                    </table>
                    <x-pagination :items="$actions"/>
                </div>
            @else
                <x-empty-content>
                    <x-slot name="title">
                        {{ trans('general.there_are_no_actions') }}
                    </x-slot>
                </x-empty-content>
            @endif
        </div>
    </div>
</div>
<div wire:ignore>
    <livewire:process.non-conformities.actions.create-non-conformity-actions :nonConformityId="$nonConformity->id"/>
</div>
<div wire:ignore>
    <livewire:process.non-conformities.actions.edit-non-conformity-actions/>
</div>
@push('page_script')
    <script>
        $('#edit-non-conformity-action').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('item-id');
            //Livewire event trigger
            Livewire.emit('openEditAction', id);
        });
        Livewire.on('toggleCreateAction', () => $('#non-conformity-action').modal('toggle'));
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

        @this.on('triggerDelete', id => {
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
                @this.call('deleteAction', id);
                }
            });
        });
        })
    </script>
@endpush
