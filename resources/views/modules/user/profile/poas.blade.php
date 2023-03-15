<div class="card mb-g">
    <div class="row row-grid no-gutters">
        <div class="col-12">
            <div class="p-3">
                <h2 class="mb-0 fs-xl">
                    {{trans('general.poas')}}
                </h2>
            </div>
        </div>
        @foreach($user->poas  as $poa)
            <div class="col-6">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="px-3 py-2 d-flex align-items-center chart">
                                            <span class="d-inline-block ml-2 text-muted mr-2">
                                                                               {{$poa->name}}
                                            </span>
                        <div class="js-easy-pie-chart color-success-500 position-relative d-inline-flex align-items-center justify-content-center"
                             id="chartExecution"
                             data-percent="{{ number_format($poa->calcProgress(),1)  }}" data-piesize="50"
                             data-linewidth="5" data-linecap="butt">
                            <div
                                    class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-lg">
                                <span class="js-percent d-block text-dark"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>