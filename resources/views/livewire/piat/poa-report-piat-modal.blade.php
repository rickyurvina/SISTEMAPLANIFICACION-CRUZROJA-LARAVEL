<div>
    <div wire:ignore.self class="modal fade" id="report_piat_modal" tabindex="-1" role="dialog" aria-hidden="true"
         data-backdrop="static" data-keyboard="false"
         style="height: 100%;">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div wire:ignore class="modal-header bg-primary text-white">
                    <h5 class="modal-title">{{ trans('general.poa_activity_piat_report_modal') }}</h5>
                    <button type="button" data-dismiss="modal" class="close text-white" aria-label="Close" wire:click="resetModal">
                        <span aria-hidden="true"><i class="far fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="panel-content">
                        <div class="d-flex flex-wrap">
                            <div class="mr-auto">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#piatMatrix" role="tab"
                                           aria-selected="true" wire:ignore>
                                            <i class="fal fa-user text-primary"></i>
                                            <span class="hidden-sm-down ml-1">Matriz Piat</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#reportData" role="tab"
                                           aria-selected="false" wire:ignore>
                                            <i class="fal fa-ballot"></i>
                                            <span class="hidden-sm-down ml-1">Datos del Informe</span>
                                        </a>
                                    </li>
                                    @if($accomplished)
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#agreements" role="tab"
                                               aria-selected="false" wire:ignore>
                                                <i class="fal fa-check-double"></i>
                                                <span class="hidden-sm-down ml-1">Acuerdos y Compromisos</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#beneficiaries" role="tab"
                                               aria-selected="false" wire:ignore>
                                                <i class="fal fa-user-check"></i>
                                                <span class="hidden-sm-down ml-1">Beneficiarios</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#files" role="tab"
                                               aria-selected="false" wire:ignore>
                                                <i class="fal fa-file"></i>
                                                <span class="hidden-sm-down ml-1">Archivos y Comentarios</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="ml-auto">
                                @if($piatReport)
                                    @can('poa-approve-piat-report')
                                        @if($piatReport->approved_by==-1)
                                            <button wire:click="approveReport" type="button" class="btn btn-success btn-sm m-1 justify-content-center">
                                                <span aria-hidden="true">Aprobar</span>
                                            </button>
                                        @else
                                            <a href="{{route('piat.reportPiat',$piatReport)}}" class="btn btn-outline-primary btn-xs shadow-0"><i class="fas fa-file-pdf"></i>
                                                {{ trans('general.download') }}
                                            </a>
                                        @endcan
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="tab-content border border-top-0 p-3">
                            <div class="tab-pane fade show active" id="piatMatrix" role="tabpanel" wire:ignore.self>
                                @include('modules.piat.report.piat-matrix-details')
                            </div>
                            <div class="tab-pane fade" id="reportData" role="tabpanel" wire:ignore.self>
                                @include('modules.piat.report.report-data')
                            </div>
                            <div class="tab-pane fade" id="agreements" role="tabpanel" wire:ignore.self>
                                @include('modules.piat.report.agreements')
                            </div>
                            <div class="tab-pane fade" id="beneficiaries" role="tabpanel" wire:ignore.self>
                                @include('modules.piat.report.beneficiaries')
                            </div>
                            <div class="tab-pane fade" id="files" role="tabpanel" wire:ignore.self>
                                @include('modules.piat.report.files')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>