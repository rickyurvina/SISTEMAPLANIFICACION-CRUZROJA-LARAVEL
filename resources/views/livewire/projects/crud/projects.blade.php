<div>
    <div class="d-flex flex-wrap mb-1">
        <h1 class="mr-3">
            <i class="subheader-icon fal fa-list-ul"></i> <span class="fw-300">Proyectos</span>
        </h1>
        @if($projects->count()>0)
            <div class="mr-3">
                <button class="btn btn-primary btn-sm" wire:click="verifyVisibility"><i
                            class="fas fa-list fa-lg"></i>
                </button>
                <button class="btn btn-primary btn-sm" wire:click="verifyVisibility"><i class="fas fa-th fa-lg"></i>
                </button>
            </div>
        @endif
        <div class="subheader-block d-lg-flex align-items-end ml-auto">
            @can('project-super-admin')
                <livewire:projects.c-r-u-d.create-project/>
            @endcan
        </div>
    </div>

    @if(!$cardView)
        @include('modules.project.home.card-view')
    @else
        @include('modules.project.home.table-view')
    @endif

</div>
@push('page_script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @this.
            on('deleteProject', id => {
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
            });
        })
    </script>
@endpush