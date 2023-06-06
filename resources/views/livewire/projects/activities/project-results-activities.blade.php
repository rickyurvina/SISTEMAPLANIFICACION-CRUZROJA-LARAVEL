<div>
    <div class="d-flex flex-column">
        <div class="d-flex flex-nowrap">
            <div class="flex-grow-1 w-100" style="overflow: hidden auto">
                <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
                    @if(session('company_id')===$project->company_id || in_array(session('company_id'),$project->subsidiaries->pluck('company_id')->toArray()))
                        <li class="nav-item" wire:ignore>
                            <a class="nav-link active" data-toggle="tab" href="#tab-general" role="tab"
                               aria-selected="true">{{ trans('general.general') }}</a>
                        </li>
                    @endif
                    <li class="nav-item" wire:ignore>
                        <a class="nav-link" data-toggle="tab" href="#tab-implementation" role="tab"
                           aria-selected="false">Ejecución de Actividades</a>
                    </li>
                    <li class="nav-item" wire:ignore>
                        <a class="nav-link" data-toggle="tab" href="#tab-indicators" role="tab" aria-selected="false">Indicadores</a>
                    </li>
                </ul>
                <div class="tab-content">
                    @include('modules.project.resultsActivities.top-header-results')
                    @if(session('company_id')===$project->company_id || in_array(session('company_id'),$project->subsidiaries->pluck('company_id')->toArray()))
                        <div class="tab-pane fade active show" id="tab-general" role="tabpanel" wire:ignore.self>
                            @include('modules.project.resultsActivities.activities-by-result-index')
                        </div>
                    @endif
                    <div class="tab-pane fade" id="tab-implementation" role="tabpanel" wire:ignore.self>
                        @include('modules.project.resultsActivities.list-activities')
                    </div>
                    <div class="tab-pane fade" id="tab-indicators" role="tabpanel" wire:ignore.self>
                        @include('modules.project.indicators.list-indicators-projects')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('page_script')
    <script>
        Livewire.on('toggleRegisterAdvance', () => $('#register-indicator-advance').modal('toggle'));
        Livewire.on('toggleIndicatorShowModal', () => $('#indicator-show-modal').modal('toggle'));

        $('#project-create-activity').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let resultId = $(e.relatedTarget).data('result-id');
            //Livewire event trigger
            Livewire.emit('loadServices', resultId);
        });
        document.addEventListener('DOMContentLoaded', function () {
            $('div.dropdown-item, .color-item').on('click', function () {
                $(".open-drop").dropdown("hide");
            });
            @this.
            on('triggerDeleteIndicator', id => {
                Swal.fire({
                    title: '{{ trans('messages.warning.sure') }}',
                    text: '{{ trans('messages.warning.delete') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'var(--danger)',
                    confirmButtonText: '<i class="fas fa-trash"></i> {{ trans('general.yes') . ', ' . trans('general.delete') }}',
                    cancelButtonText: '<i class="fas fa-times"></i> {{ trans('general.no') . ', ' . trans('general.cancel') }}'
                }).then((result) => {
                    //if user clicks on delete
                    if (result.value) {
                        // calling destroy method to delete
                        @this.
                        call('deleteIndicator', id);
                    }
                });
            });
            @this.
            on('triggerEdit', id => {
                Livewire.emit('loadIndicatorEditData', id);
                $('#indicator-edit-modal').modal('toggle');
            });
            @this.
            on('triggerAdvance', id => {
                Livewire.emit('actionLoad', id);
                $('#register-indicator-advance').modal('toggle');
            });

            @this.
            on('registerAdvance', id => {
                window.livewire.emitTo('projects.activities.project-register-advance-activity', 'openAdvance', {id: id});
            });

            @this.
            on('triggerDeleteActivity', id => {
                Swal.fire({
                    title: '{{ trans('messages.warning.sure') }}',
                    text: '{{ trans('messages.warning.delete') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'var(--danger)',
                    confirmButtonText: '<i class="fas fa-trash"></i> {{ trans('general.yes') . ', ' . trans('general.delete') }}',
                    cancelButtonText: '<i class="fas fa-times"></i> {{ trans('general.no') . ', ' . trans('general.cancel') }}'
                }).then((result) => {
                    //if user clicks on delete
                    if (result.value) {
                        // calling destroy method to delete
                        @this.
                        call('deleteActivity', id);
                    }
                });
            });

            @this.
            on('triggerDeleteResult', id => {
                Swal.fire({
                    title: '{{ trans('messages.warning.sure') }}',
                    text: '{{ trans('messages.warning.delete') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'var(--danger)',
                    confirmButtonText: '<i class="fas fa-trash"></i> {{ trans('general.yes') . ', ' . trans('general.delete') }}',
                    cancelButtonText: '<i class="fas fa-times"></i> {{ trans('general.no') . ', ' . trans('general.cancel') }}'
                }).then((result) => {
                    //if user clicks on delete
                    if (result.value) {
                        // calling destroy method to delete
                        @this.
                        call('deleteResult', id);
                    }
                });
            });
        });
    </script>

@endpush