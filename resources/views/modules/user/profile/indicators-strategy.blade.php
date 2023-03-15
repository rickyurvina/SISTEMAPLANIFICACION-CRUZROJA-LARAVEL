<div class="card mb-g">
    <div class="row row-grid no-gutters">
        <div class="col-12">
            <div class="p-3">
                <h2 class="mb-0 fs-xl">
                    {{trans_choice('general.indicators',2)}} - {{trans('general.strategy')}}
                </h2>
            </div>
        </div>
        @foreach($user->measures as $indicator)
            @if($loop->iteration<=5)
                <div class="col-12">
                    <div class="p-3">
                        <a href="javascript:void(0)"
                           data-toggle="modal"
                           data-target="#measure-show-modal"
                           data-measure-id="{{$indicator->id}}">{{$indicator->name}}
                        </a>
                    </div>
                </div>
            @endif
        @endforeach
        <div class="collapse" id="collapseMeasures">
            @foreach($user->measures as $indicator)
                @if($loop->iteration>5)
                    <div class="col-12">
                        <div class="p-3">
                            <a href="javascript:void(0)"
                               data-toggle="modal"
                               data-target="#measure-show-modal"
                               data-measure-id="{{$indicator->id}}">
                                {{$indicator->name}}
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="col-12">
            <div class="p-3 text-center">
                <a data-toggle="collapse" href="#collapseMeasures" role="button" aria-expanded="false" aria-controls="collapseMeasures"
                   class="btn-link font-weight-bold">{{trans('general.see_more')}}</a>
            </div>
        </div>
    </div>
</div>