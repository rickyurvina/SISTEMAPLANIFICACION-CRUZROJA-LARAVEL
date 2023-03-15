<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-sm-12 col-md-6  alert alert-info fade show" role="alert">
            <div class="d-flex align-items-center">
                <div class="alert-icon">
                                                    <span class="icon-stack icon-stack-md">
                                                        <i class="base-2 icon-stack-3x color-info-400"></i>
                                                        <i class="base-10 text-white icon-stack-1x"></i>
                                                        <i class="far fa-star color-info-800 icon-stack-2x"></i>
                                                    </span>
                </div>
                <div class="flex-1">
                    <span class="h4">{{trans('general.vision')}}</span>
                    <br>
                    {{$plan->vision ?? null}}
                </div>
            </div>
        </div>
        <div class="col-lg-6  col-sm-12  col-md-6 alert alert-info fade show" role="alert">
            <div class="d-flex align-items-center">
                <div class="alert-icon">
                                <span class="icon-stack icon-stack-md">
                                    <i class="base-2 icon-stack-3x color-info-400"></i>
                                    <i class="base-10 text-white icon-stack-1x"></i>
                                    <i class="fas fa-eye color-info-800 icon-stack-2x"></i>
                                </span>
                </div>
                <div class="flex-1">
                    <span class="h4"> {{trans('general.mission')}}</span>
                    <br>
                    {{$plan->mission ?? null}}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-12 col-lg-4">
            <div class="panel-container show">
                <div class="flex-1 text-center">
                    <h2 style="font-size: 15px; font-weight: 700">
                        {{trans('general.execution_poa')}}-{{date('Y')}}
                    </h2>
                    @if($ejecuccionGeneral>0)
                        <div id="chartdivEjecucionPoa" style="height: 300px; width: 100%">
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-12 col-lg-8 text-right" style="margin-top: -1.5%">
            <div class="panel" style="margin-bottom: 0.1%; -webkit-box-shadow: none !important; box-shadow: none !important; border: 0 !important; border-bottom: 0px">
                <div class="panel-toolbar" style=" display: list-item">
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10"
                            data-original-title="Pantalla Completa"></button>
                </div>
                <div class="panel-container show" style=" height: 27rem">
                    @if(count($ejectuadoJuntasArr)>0)
                        <div id="chartdivPorProvincias" style="height: 100%; width: 100%"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if($selectedProvince!=null)
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 text-right">
                <div class="panel" style="margin-bottom: 0.1%; -webkit-box-shadow: none !important; box-shadow: none !important; border: 0 !important; border-bottom: 0px">
                    <div class="panel-toolbar" style=" display: list-item">
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10"
                                data-original-title="Pantalla Completa"></button>
                    </div>
                    <div class="panel-container show" style=" height: 28rem">
                        <div id="chartdivPorJuntas" style="height: 100%; width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
