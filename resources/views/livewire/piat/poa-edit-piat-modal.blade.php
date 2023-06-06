<div>
    <div wire:ignore.self class="modal fade" id="edit_piat_modal" tabindex="-1" role="dialog" aria-hidden="true"
         style="height: 100%;">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div wire:ignore class="modal-header bg-primary text-white">
                    <h5 class="modal-title">{{ trans('general.poa_activity_piat_edit_modal') }}</h5>
                    <button type="button" data-dismiss="modal" class="close text-white" aria-label="Close">
                        <span aria-hidden="true"><i class="far fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="panel-content">
                        <div class="d-flex flex-wrap">
                            <div class="mr-auto w-90">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#activityWorkshop" role="tab"
                                           aria-selected="true" wire:ignore>
                                            <i class="fal fa-user text-primary"></i>
                                            <span class="hidden-sm-down ml-1">Actividades / Talleres</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#workshopAgenda" role="tab"
                                           aria-selected="false" wire:ignore>
                                            <i class="fal fa-address-card"></i>
                                            <span class="hidden-sm-down ml-1">Agenda</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#requirements" role="tab"
                                           aria-selected="false" wire:ignore>
                                            <i class="fal fa-address-card"></i>
                                            <span class="hidden-sm-down ml-1">Requerimientos</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#files" role="tab"
                                           aria-selected="false" wire:ignore>
                                            <i class="fal fa-file"></i>
                                            <span class="hidden-sm-down ml-1">Archivos y Comentarios</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="ml-auto p-2">
                                @if(!$is_terminated)
                                    <button wire:click="terminate()" type="button" class="btn btn-danger btn-sm">
                                        <span aria-hidden="true">Terminar</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="tab-content border border-top-0 p-3">
                            <div class="tab-pane fade show active margin-left" id="activityWorkshop" role="tabpanel"
                                 wire:ignore.self>
                                @include('modules.piat.edit.summary-edit')
                            </div>
                            <div class="tab-pane fade" id="workshopAgenda" role="tabpanel" wire:ignore.self>
                                @include('modules.piat.edit.workshops')
                            </div>
                            <div class="tab-pane fade" id="requirements" role="tabpanel" wire:ignore.self>
                                @include('modules.piat.edit.requirements')
                            </div>
                            <div class="tab-pane fade" id="files" role="tabpanel" wire:ignore.self>
                                @include('modules.piat.files')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>