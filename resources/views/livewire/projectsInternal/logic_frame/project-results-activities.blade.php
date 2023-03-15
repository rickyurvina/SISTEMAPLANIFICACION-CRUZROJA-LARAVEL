<div>
    <div class="d-flex flex-column">
        <div class="d-flex flex-nowrap">
            <div class="flex-grow-1 w-100" style="overflow: hidden auto">
                <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
                    @if(session('company_id')===$project->company_id)
                        <li class="nav-item" wire:ignore.self>
                            <a class="nav-link active" data-toggle="tab" href="#tab-general" role="tab" aria-selected="true">{{ trans('general.general') }}</a>
                        </li>
                    @endif
                    <li class="nav-item" wire:ignore.self>
                        <a class="nav-link" data-toggle="tab" href="#tab-implementation" role="tab" aria-selected="false">Ejecución de Actividades</a>
                    </li>
                    <li class="nav-item" wire:ignore.self>
                        <a class="nav-link" data-toggle="tab" href="#tab-indicators" role="tab" aria-selected="false">Indicadores</a>
                    </li>
                </ul>
                <div class="tab-content">
                    @include('modules.project.resultsActivities.top-header-results')

{{--                    <div class="d-flex mb-2 mt-1">--}}
{{--                        <div class="input-group bg-white shadow-inset-2 w-25 mr-2">--}}
{{--                            <input type="text" class="form-control border-right-0 bg-transparent pr-0"--}}
{{--                                   placeholder="{{ trans('general.filter') . ' ' . trans_choice('general.activities', 2) }} ..."--}}
{{--                                   wire:model="search">--}}
{{--                            <div class="input-group-append">--}}
{{--                                        <span class="input-group-text bg-transparent border-left-0">--}}
{{--                                            <i class="fal fa-search"></i>--}}
{{--                                        </span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        @if(count($results) > 0)--}}
{{--                            <div class="btn-group">--}}
{{--                                <button class="btn btn-outline-secondary dropdown-toggle @if(count($selectedResults) > 0) filtered @endif"--}}
{{--                                        type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                    {{ trans_choice('general.result',2)}}--}}
{{--                                    @if(count($selectedResults) > 0)--}}
{{--                                        <span class="badge bg-white ml-2">{{ count($selectedResults) }}</span>--}}
{{--                                    @endif--}}
{{--                                </button>--}}
{{--                                <div class="dropdown-menu">--}}
{{--                                    @foreach($results as $result)--}}
{{--                                        <div class="dropdown-item">--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="i-program-{{ $result->id}}" wire:model="selectedResults"--}}
{{--                                                       value="{{ $result->id }}">--}}
{{--                                                <label class="custom-control-label"--}}
{{--                                                       for="i-program-{{ $result->id }}">{{ strlen($result->text)>40? substr($result->text , 0,40).'...': $result->text  }}</label>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    @endforeach--}}
{{--                                    <div class="dropdown-divider"></div>--}}
{{--                                    <div class="dropdown-item">--}}
{{--                                        <span wire:click="$set('selectedResults', [])">{{ trans('general.delete_selection') }}</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="dropdown-item">--}}
{{--                                        <div class="custom-control custom-switch">--}}
{{--                                            <input type="checkbox" class="custom-control-input" id="showProgramPanel" checked="" wire:model="showProgramPanel">--}}
{{--                                            <label class="custom-control-label" for="showProgramPanel">{{ trans('general.show_panel_results') }}</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                        @if(count($selectedResults) > 0 || $search != '')--}}
{{--                            <a class="btn btn-outline-default ml-2" wire:click="clearFilters()">{{ trans('common.clean_filters') }}</a>--}}
{{--                        @endif--}}
{{--                        @if($project->phase instanceof \App\States\Project\Planning)--}}
{{--                            <button type="button" class="btn btn-success border-0 shadow-0 ml-2" data-toggle="modal"--}}
{{--                                    data-target="#project-create-result-activity">{{ trans('general.create')}} {{trans('general.activity')}}--}}
{{--                            </button>--}}
{{--                        @endif--}}
{{--                    </div>--}}
                    @if(session('company_id')===$project->company_id)
                        <div class="tab-pane fade active show" id="tab-general" role="tabpanel" wire:ignore.self>
                            @include('modules.projectInternal.activities.index-activities-by-resullt')
                        </div>
                    @endif
                    <div class="tab-pane fade" id="tab-implementation" role="tabpanel" wire:ignore.self>
                        @include('modules.projectInternal.activities.execution-activities')
                    </div>
                    <div class="tab-pane fade" id="tab-indicators" role="tabpanel" wire:ignore.self>
                        @include('modules.projectInternal.activities.indicators')
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
        @this.on('triggerDeleteIndicator', id => {
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
                @this.call('deleteIndicator', id);
                }
            });
        });
        @this.on('triggerEdit', id => {
            Livewire.emit('loadIndicatorEditData', id);
            $('#indicator-edit-modal').modal('toggle');
        });
        @this.on('triggerAdvance', id => {
            Livewire.emit('actionLoad', id);
            $('#register-indicator-advance').modal('toggle');
        });
        @this.on('triggerEdit', id => {
            Livewire.emit('loadIndicatorEditData', id);
            $('#indicator-edit-modal').modal('toggle');
        });

        @this.on('registerAdvance', id => {

            window.livewire.emitTo('projects.activities.project-register-advance-activity', 'openAdvance', {id: id, internal: true});

        });
        @this.on('triggerAdvance', id => {
            Livewire.emit('actionLoad', id);
            $('#register-indicator-advance').modal('toggle');
        });


        @this.on('triggerDeleteActivity', id => {
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
                @this.call('deleteActivity', id);
                }
            });
        });

        @this.on('triggerDeleteResult', id => {
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
                @this.call('deleteResult', id);
                }
            });
        });
        });
    </script>

@endpush