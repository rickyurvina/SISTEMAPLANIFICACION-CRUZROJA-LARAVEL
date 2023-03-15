<div>
    <div class="panel-container show">
        <div class="card">
            <div class="card-header d-flex flex-wrap w-100">
                @if($activities->count()>0)
                    <div class="d-flex position-relative" style="width: 90%">
                        <i class="spinner-border spinner-border-sm position-absolute pos-left mx-3" style="margin-top: 0.75rem" wire:target="search" wire:loading></i>
                        <i class="fal fa-search position-absolute pos-left fs-lg mx-3" style="margin-top: 0.75rem" wire:loading.remove></i>
                        <input type="text" wire:model.debounce.300ms="search" class="form-control bg-subtlelight pl-6"
                               placeholder="Buscar...">
                    </div>
                @endif
                <div class="d-flex ml-auto w-10">
                    <button type="button" class="btn btn-success border-0 shadow-0 ml-auto" data-toggle="modal"
                            data-target="#plan-create-activity">{{ trans('general.create')}} {{trans('general.activity')}}
                    </button>
                </div>
            </div>
            @if($activities->count()>0)
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead class="bg-primary-50">
                        <tr>
                            <th class="table-th text-primary">
                                <a wire:click.prevent="sortBy('code')" role="button" href="#">
                                    {{trans('general.code')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="code"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="table-th text-primary">
                                <a wire:click.prevent="sortBy('name')" role="button" href="#">
                                    {{__('general.name')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="name"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a></th>
                            <th class="table-th text-primary">
                                <a wire:click.prevent="sortBy('description')" role="button" href="#">
                                    {{trans('general.description')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="description"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="table-th text-primary"><a href="#">{{ trans('general.responsible') }} </a></th>
                            <th class="table-th text-primary"><a href="#">{{ trans('general.start_date') }} </a></th>
                            <th class="table-th text-primary"><a href="#">{{ trans('general.end_date') }} </a></th>

                            <th class="w-10 table-th text-primary"><a href="#">{{ trans('general.actions') }} </a></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($activities as $item)
                            <tr class="tr-hover" wire:ignore wire:key="{{time().$item->id}}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{$item->code }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{$item->name}}
                                    </div>
                                </td>
                                <td>
                                    {{$item->description}}
                                </td>
                                <td>
                                    {{$item->user_id ? $item->responsible->getFullName():'-'}}
                                </td>
                                <td>
                                    {{$item->start_date->format('j F, Y')}}
                                </td>
                                <td>
                                    {{$item->end_date->format('j F, Y')}}
                                </td>
                                <td>
                                    <a
                                            href="javascript:void(0)"
                                            data-toggle="modal"
                                            data-target="#edit-change-activity"
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
                                </td>
                        @endforeach
                        </tbody>
                    </table>
                    <x-pagination :items="$activities"/>
                </div>
            @else
                <x-empty-content>
                    <x-slot name="title">
                        {{ trans('general.there_are_no_activities') }}
                    </x-slot>
                </x-empty-content>
            @endif
        </div>
    </div>
</div>
<div wire:ignore>
    <livewire:process.plan-changes.changes-activities.create-changes-activities
            :changeId="$this->processPlanChanges->id"/>
</div>
<div wire:ignore>
    <livewire:process.plan-changes.changes-activities.edit-changes-activities/>
</div>
@push('page_script')
    <script>
        $('#edit-change-activity').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('item-id');
            //Livewire event trigger
            Livewire.emit('openEditActivity', id);
        });
        Livewire.on('toggleCreateActivity', () => $('#plan-create-activity').modal('toggle'));

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
                @this.call('deleteActivity', id);
                }
            });
        });
        })
    </script>
@endpush
