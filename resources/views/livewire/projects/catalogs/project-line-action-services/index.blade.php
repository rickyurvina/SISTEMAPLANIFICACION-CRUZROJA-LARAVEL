<div>
    @include('livewire.projects.catalogs.project-line-action-services.create')
    @include('livewire.projects.catalogs.project-line-action-services.update')
    <div class="card">
        <div class="card-header pr-2 d-flex align-items-center flex-wrap">
            <div class="d-flex position-relative ml-auto w-100">
                <label for="search">
                    <i class="fal fa-search position-absolute pos-left fs-lg px-3 py-2 mt-1"></i>
                </label>
                <input type="text"
                       id="search"
                       name="search"
                       value="{{ request()->get('search', '') }}"
                       wire:model="search"
                       class="form-control bg-subtlelight pl-6"
                       placeholder="{{ trans('general.search_placeholder') }}">

            </div>
        </div>
        <div class="table-responsive">
            <table class="table m-0">
                <thead class="bg-primary-50">
                <tr>
                    <th scope="col">@sortablelink('code', trans('general.code'))</th>
                    <th scope="col">@sortablelink('name', trans('general.name'))</th>
                    <th scope="col">@sortablelink('description', trans('general.description'))</th>
                    <th scope="col">@sortablelink('description',trans_choice('project.line_actions', 1) )</th>
                    @can('project-crud-project')
                        <th class="text-center color-primary-500">{{ trans('general.actions') }}</th>
                    @endcan
                </tr>
                </thead>
                <tbody>
                @foreach($projectLineActionServices as $projectLineActionService)
                    <tr>
                        <th scope="row" class="text-nowrap align-middle">
                            {{ $projectLineActionService->code }}
                        </th>
                        <td>{{ $projectLineActionService->name }}</td>
                        <td>{{ $projectLineActionService->description }}</td>
                        <td>{{ $projectLineActionService->lineAction->name }}</td>
                        @can('project-crud-project')
                            <td>
                                <div class="d-flex justify-content-center">
                                    <button data-toggle="modal" data-target="#updateModal"
                                            wire:click="edit({{ $projectLineActionService->id }})"
                                            class="btn btn-link">
                                        <i class="fas fa-edit mr-1 text-info"
                                           data-toggle="tooltip" data-placement="top" title=""
                                           data-original-title="Editar"></i>
                                    </button>
                                    <x-delete-link-livewire id="{{ $projectLineActionService->id }}"/>
                                </div>
                            </td>
                        @endcan
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $projectLineActionServices->links() }}
    </div>
</div>
@push('page_script')
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
                    window.livewire.emit('delete', id)
                }
            });
        }
    </script>
@endpush


