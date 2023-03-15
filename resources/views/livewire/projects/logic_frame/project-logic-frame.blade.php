<div>
    <div class="d-flex flex-column">
        <div class="d-flex flex-nowrap">
            <div class="flex-grow-1 w-100" style="overflow: hidden auto">
                <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
                    <li class="nav-item" wire:ignore>
                        <a class="nav-link active" data-toggle="tab" href="#tab-logic-frame" role="tab"
                           aria-selected="true">{{ trans('general.general') }}</a>
                    </li>
                    <li class="nav-item" wire:ignore>
                        <a class="nav-link" data-toggle="tab" href="#tab-indicators" role="tab" aria-selected="false">Indicadores</a>
                    </li>
                    <li class="text-right w-100 m-0">
                        <a class="btn btn-outline-primary btn-xs shadow-0" wire:click="downloadLogicFrameExcel('{{$project->id}}')">
                            <i class="fas fa-file-excel"></i> {{trans('general.logic_frame')}}</a>
                    </li>
                    <br>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="tab-logic-frame" role="tabpanel" wire:ignore.self>
                        @include('modules.project.logicFrame.nav-header',['objectives'=>$objectives,'selectedObjectives'=>$selectedObjectives,'objectives' => $objectives,'messages' => $messages])
                        <div class="d-flex flex-wrap align-items-start">
                            @include('modules.project.logicFrame.panel-objectives',['project'=>$project])
                            @include('modules.project.logicFrame.table-results',['results' => $results])
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-indicators" role="tabpanel" wire:ignore.self>
                        @include('modules.project.indicators.list-indicators-projects',['project'=>$project,'objectives'=>$objectives,'results'=>$results])
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('page_script')
    <script>
        $('#project-create-services').on('show.bs.modal', function (e) {
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
            on('triggerDelete', id => {
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
                        call('delete', id);
                    }
                });
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
            on('triggerDeleteObjective', id => {
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
                        call('deleteObjective', id);
                    }
                });
            });
        });
    </script>

@endpush