<div>
    <div class="w-100">
        <a href="javascript:void(0);" data-toggle="modal" data-target="#project-create-acquisition" data-id="{{$projectId}}" class="btn btn-success btn-sm mb-2 mr-2">
            &nbsp;{{ trans('general.create') }} {{ trans('general.acquisition') }}
        </a>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table class="table m-0">
                <thead class="bg-primary-50">
                <tr>
                    <th> {{trans('general.prj_acquisitions_item_code')}}</th>
                    <th> {{trans('general.prj_acquisitions_item_description')}}</th>
                    <th> {{trans('general.prj_acquisitions_description')}}</th>
                    <th> {{trans('general.prj_acquisitions_unit')}}</th>
                    <th> {{trans('general.prj_acquisitions_quantity')}}</th>
                    <th> {{trans('general.prj_acquisitions_price')}}</th>
                    <th> {{trans('general.prj_acquisitions_total_price')}}</th>
                    <th> {{trans('general.prj_acquisitions_mode')}}</th>
                    <th> {{trans('general.prj_acquisitions_date')}}</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($acquisitions as $item)
                    <tr>
                        <td>
                            {{ $item->product->code }}
                        </td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->unit->description }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">$ {{ $item->price }}</td>
                        <td class="text-right">$ {{ $item->total_price }}</td>
                        <td>{{ $item->mode->description }}</td>
                        <td>{{ $item->date }}</td>
                        <td class="text-center">
                            <a href="javascript:void(0);" aria-expanded="false" data-toggle="modal" data-target="#project-edit-acquisition" data-id="{{ $item->id }}">
                                <i class="fas fa-edit mr-1 text-info"
                                   data-toggle="tooltip" data-placement="top" title=""
                                   data-original-title="Editar"></i></a>
                            <button class="border-0 bg-transparent" wire:click="$emit('acquisitionDelete', '{{ $item->id }}')" data-toggle="tooltip"
                                    data-placement="top" title="Eliminar"
                                    data-original-title="Eliminar"><i class="fas fa-trash mr-1 text-danger"></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <th></th>
                <th>{{ __('general.prj_acquisitions_total_title') }}</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class="text-right">$ {{ $acquisitions->sum('total_price') }}</th>
                <th></th>
                <th></th>

                </tfoot>
            </table>
        </div>

    </div>
    <div wire:ignore.self>
        <livewire:projects.acquisitions.project-create-acquisition :id="$projectId"/>
    </div>
    <div wire:ignore.self>
        <livewire:projects.acquisitions.project-edit-acquisition :id="$projectId"/>
    </div>
</div>
@push('page_script')
    <script>
        Livewire.on('toggleProjectCreateAcquisition', () => $('#project-create-acquisition').modal('toggle'));
        Livewire.on('toggleProjectEditAcquisition', () => $('#project-edit-acquisition').modal('toggle'));
        document.addEventListener('DOMContentLoaded', function () {

        @this.on('acquisitionDelete', id => {
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
        });
        });

        $('#project-edit-acquisition').on('show.bs.modal', function (e) {
            let acquisitionId = $(e.relatedTarget).data('id');
            //Livewire event trigger
            Livewire.emit('loadForm', acquisitionId);
        });

        $('#project-create-acquisition').on('show.bs.modal', function (e) {
            $('#select2').empty();
            //Livewire event trigger
            Livewire.emit('loadCreateForm', {{ $projectId }});
        });
    </script>
@endpush