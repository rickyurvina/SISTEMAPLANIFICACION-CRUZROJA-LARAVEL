<div>
    <div class="d-flex flex-row-reverse ml-auto ml-2 mt-1">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add_piat_modal">
            {{ trans('general.create') }} Matriz
        </button>
    </div>
    <div class="w-100 mt-4">
        <div class="table-responsive">
            <table class="table table-light table-hover">
                <thead>
                <tr>
                    <th class="w-15">
                        <a wire:click.prevent="sortBy('name')" role="button" href="#">
                            {{trans_choice('poa.piat_matrix_create_placeholder_name', 1)}}
                            <x-sort-icon sortDirection="{{$sortDirection}}" sortField="name"
                                         field="{{$sortField}}"></x-sort-icon>
                        </a>
                    </th>
                    <th class="w-15">
                        <a wire:click.prevent="sortBy('date')" role="button" href="#">
                            {{trans_choice('poa.piat_matrix_create_placeholder_date', 1)}}
                            <x-sort-icon sortDirection="{{$sortDirection}}" sortField="date"
                                         field="{{$sortField}}"></x-sort-icon>
                        </a>
                    </th>
                    <th class="w-15">
                        <a wire:click.prevent="sortBy('status')" role="button" href="#">
                            {{__('poa.piat_matrix_create_placeholder_status')}}
                            <x-sort-icon sortDirection="{{$sortDirection}}" sortField="status"
                                         field="{{$sortField}}"></x-sort-icon>
                        </a>
                    </th>
                    <th class="w-5">{{ trans('general.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($matrixs as $item)
                    <tr class="tr-hover" wire:loading.class.delay="opacity-50">
                        <td>
                            <div class="d-flex align-items-center">
                                <span>{{ $item->name }}</span>
                            </div>
                        </td>
                        <td>{{ $item->date }}</td>
                        <td>{{ $item->status }}</td>
                        <td class="text-center">
                            <div class="frame-wrap">
                                <div class="d-flex justify-content-start">
                                    <div class="p-2">
                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#edit_piat_modal"
                                           data-id="{{$item->id}}">
                                            <i class="fas fa-edit" aria-expanded="false"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="Editar"></i>
                                        </a>
                                    </div>
                                    <div class="p-2">
                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#report_piat_modal"
                                           data-id="{{$item->id}}">
                                            <i class="fas fa-book" aria-expanded="false"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="Reporte PIAT"></i>
                                        </a>
                                    </div>
                                    @if($item->is_terminated)
                                        <div class="p-2">
                                            <a href="{{route('piat.piat_rescheduling', $item->id)}}">
                                                <i class="fal fa-clock" aria-expanded="false"
                                                   data-toggle="tooltip" data-placement="top" title=""
                                                   data-original-title="Reprogramar Actividad PIAT"></i>
                                            </a>
                                        </div>
                                    @endif
                                    <div>
                                        <x-delete-link-livewire id="{{ $item->id }}"/>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="color-fusion-500 fs-3x py-3"><i class="fas fa-exclamation-triangle color-warning-900"></i> No se encontraron matrices</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div wire:ignore>
        <livewire:piat.poa-create-piat-modal :class="$class" :idModel="$idModel"/>
    </div>
    <div wire:ignore>
        <livewire:piat.poa-edit-piat-modal>
    </div>
    <div wire:ignore>
        <livewire:piat.poa-report-piat-modal/>
    </div>
</div>


@push('page_script')
    <script>
        Livewire.on('togglePiatEditModal', () => $('#edit_piat_modal').modal('toggle'));
        Livewire.on('togglePiatAddModal', () => $('#add_piat_modal').modal('toggle'));
        Livewire.on('togglePiatReportModal', () => $('#report_piat_modal').modal('toggle'));
        $('#edit_piat_modal').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('id');
            //Livewire event trigger
            Livewire.emit('loadEditForm', id);
        });

        $('#report_piat_modal').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('id');
            //Livewire event trigger
            Livewire.emit('loadReportForm', id);
        });

        $('#add_piat_modal').on('show.bs.modal', function (e) {
            //Livewire event trigger
            Livewire.emit('loadForm');
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
