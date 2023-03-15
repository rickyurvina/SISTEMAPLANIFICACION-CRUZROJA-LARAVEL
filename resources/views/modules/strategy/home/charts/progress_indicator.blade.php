<div class="row">
    @foreach($plan->planDetails as $obj)
        <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
            <h4 class="fw-900">{{ $obj->code }} {{ $obj->name }}</h4>
            @foreach($obj->indicators as $indicator)
                <div class="row ml-3 mb-3">
                    <div class="col-12">
                        <div class="d-flex mr-4">
                            <div class="js-easy-pie-chart color-{{ strtolower($indicator->status()) }}-500 position-relative d-inline-flex align-items-center justify-content-center mr-2"
                                 data-percent="{{ $indicator->progress() }}"
                                 data-piesize="40"
                                 data-linewidth="5" data-linecap="butt" data-scalelength="0">
                            </div>
                            <div>
                                <label class="fs-sm mb-0 mt-2 mt-md-0">{{ $indicator->name }}</label>
                                <h4 class="font-weight-bold mb-0">{{ $indicator->progress() }}%</h4>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>