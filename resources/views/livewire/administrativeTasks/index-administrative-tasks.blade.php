<div>
    <div class="d-flex mb-3 w-100 flex-wrap">
        <div class="input-group bg-white shadow-inset-2 w-25 mr-2">
            <input type="text" class="form-control border-right-0 bg-transparent pr-0"
                   placeholder="{{ trans('general.filter') . ' ' . trans_choice('general.activities', 2) }} ..."
                   wire:model="search">
            <div class="input-group-append">
                <span class="input-group-text bg-transparent border-left-0">
                    <i class="fal fa-search"></i>
                </span>
            </div>
        </div>
        @if(!$idProject)
            @if(count($projects) > 0)
                <div class="btn-group w-20">
                    <button class="btn btn-outline-secondary dropdown-toggle @if(count($selectedProjects) > 0) filtered @endif"
                            type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ trans_choice('general.project',2)}}
                        @if(count($selectedProjects) > 0)
                            <span class="badge bg-white ml-2">{{ count($selectedProjects) }}</span>
                        @endif
                    </button>
                    <div class="dropdown-menu" style="min-width: 30rem !important;">
                        @foreach($projects as $project)
                            <div class="dropdown-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="i-program-{{ $project['id'] }}" wire:model="selectedProjects"
                                           value="{{ $project['id'] }}">
                                    <label class="custom-control-label"
                                           for="i-program-{{ $project['id'] }}">{{ strlen($project['name'])>40? substr($project['name'], 0,40).'...': $project['name']  }}</label>
                                </div>
                            </div>
                        @endforeach
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-item">
                            <span wire:click="$set('selectedProjects', [])">{{ trans('general.delete_selection') }}</span>
                        </div>
                    </div>
                </div>
            @endif
            @if(count($selectedProjects) > 0 || $search != '')
                <a class="btn btn-outline-default ml-2 " wire:click="clearFilters()">{{ trans('common.clean_filters') }}</a>
            @endif
        @endif
        <div class="ml-auto">
            <button type="button" class="btn btn-success btn-sm"
                    data-toggle="modal"
                    data-target="#project-create-administrative-task"><i
                        class="fas fa-plus mr-1"></i>{{ trans('general.create')}} Actividad
            </button>
        </div>
    </div>
    <div class="table-responsive m-3 p-2">
        <table class="table table-light table-hover">
            <thead>
            <tr>
                <th class="w-20 table-th">{{__('general.name')}}</th>
                <th class="w-20 table-th">{{__('general.responsable')}}</th>
                <th class="w-20 table-th">Estado</th>
                <th class="w-10 table-th">Prioridad</th>
                <th class="w-10 table-th">{{__('general.end_date')}}</th>
                <th class="w-10 table-th"><a href="#">{{ trans('general.actions') }} </a></th>
            </tr>
            </thead>
            <tbody class="m-3 p-2">
            @foreach($administrativeTasks as $item)
                <tr class="tr-hover">
                    <td>
                        <div class="d-flex align-items-center">
                            {{$item->name }}
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($item->responsible)
                                {{$item->responsible->getFullName() }}
                            @else
                                -
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <span class="badge {{\App\Models\AdministrativeTasks\AdministrativeTask::STATUSES_BG[$item->status]}} badge-pill">{{$item->status }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <span class="badge {{\App\Models\AdministrativeTasks\AdministrativeTask::PRIORITIES_BG[$item->priority]}} badge-pill">{{$item->priority }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            {{$item->end_date}}
                        </div>
                    </td>
                    <td>
                        <a href="javascript:void(0)"
                           data-toggle="modal"
                           data-target="#project-edit-administrative-task"
                           data-item-id="{{$item->id}}">
                            <i class="fas fa-edit mr-1 text-info"
                               data-toggle="tooltip" data-placement="top" title=""
                               data-original-title="Editar"></i>
                        </a>
                        <x-delete-link-livewire id="{{ $item->id }}"/>

                    </td>

            @endforeach
            </tbody>
        </table>
        <x-pagination :items="$administrativeTasks"/>
    </div>
    <div wire:ignore>
        <livewire:administrative-tasks.create-administrative-task :idProject="$idProject"/>
    </div>
    <div wire:ignore>
        <livewire:administrative-tasks.edit-administrative-task/>
    </div>
</div>
@push('page_script')
    <script>
        Livewire.on('closeModalCreateAdministrativeTask', () => $('#project-create-administrative-task').modal('toggle'));
        Livewire.on('closeModalEditAdministrativeTask', () => $('#project-edit-administrative-task').modal('toggle'));

        $('#project-edit-administrative-task').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('item-id');
            //Livewire event trigger
            Livewire.emit('openEditAdminTask', id);
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