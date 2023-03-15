<div class="modal fade" id="mission-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <img style="height: 50px" src="{{ asset('img/logo_cre_trans.png') }}">
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <div class="alert alert-info fade show mb-0" role="alert">
                            <div class="d-flex align-items-center">
                                <div class="alert-icon">
                                        <span class="icon-stack icon-stack-md">
                                            <i class="base-2 icon-stack-3x color-info-400"></i>
                                            <i class="base-10 text-white icon-stack-1x"></i>
                                            <i class="far fa-star color-info-800 icon-stack-2x"></i>
                                        </span>
                                </div>
                                <div class="flex-1">
                                    <span class="h4">Misión</span>
                                    <br>
                                    {{ $plan->mission }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <div class="alert alert-info fade show mb-0" role="alert">
                            <div class="d-flex align-items-center">
                                <div class="alert-icon">
                                        <span class="icon-stack icon-stack-md">
                                            <i class="base-2 icon-stack-3x color-info-400"></i>
                                            <i class="base-10 text-white icon-stack-1x"></i>
                                            <i class="fas fa-eye color-info-800 icon-stack-2x"></i>
                                        </span>
                                </div>
                                <div class="flex-1">
                                    <span class="h4">Visión</span>
                                    <br>
                                    {{ $plan->vision }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>