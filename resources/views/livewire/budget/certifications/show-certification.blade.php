<div wire:ignore.self class="modal fade fade" id="show-certification" tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        @if($transaction)
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4"><i
                                class="fas fa-plus-circle text-success"></i> {{ trans('general.show') }} {{trans_choice('general.certifications', 1)}} {{$transaction->type}} {{$transaction->number}}
                    </h5>
                    <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>

                <div class="modal-body">
                    @include('modules.budget.certifications.show.header')
                    <div class="d-flex flex-wrap mt-2 p-4">
                        <h2><i class="fa fa-money-bill text-success"></i> Detalles de la {{trans_choice('general.certifications',1)}}</h2>
                        <hr>
                        @include('modules.budget.certifications.show.view-poa-activity')
                        @include('modules.budget.certifications.show.view-project-activity')
                    </div>

                    @if($transaction->status instanceof \App\States\Transaction\Draft)
                        <div class="modal-footer justify-content-center">
                            @if($canApprove)
                                <div>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-success mr-2"
                                       wire:click="approveCertification">{{trans('general.approve')}}
                                    </a>
                                </div>
                            @endif
                            <div>
                                <a href="javascript:void(0)" class="btn btn-sm btn-warning"
                                   wire:click="declineCertification">{{trans('general.refuse')}}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

    </div>
</div>