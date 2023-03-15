<div class="card mb-g">
    <div class="row row-grid no-gutters">
        <div class="col-12">
            <div class="p-3">
                <h2 class="mb-0 fs-xl">
                    {{trans_choice('general.indicators',2)}}
                </h2>
            </div>
        </div>
        @foreach($user->indicators as $indicator)
            @if($loop->iteration<=5)
                <div class="col-12">
                    <div class="p-3">
                        <a href="javascript:void(0);" aria-expanded="false"
                           wire:click="$emitTo('indicators.indicator-show', 'open', {{ $indicator->id }})">{{$indicator->name}}</a>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar  {{$indicator->getStateIndicator()[1]>50 ? ' bg-primary-300 bg-primary-gradient':' bg-danger-300 bg-warning-gradient' }} "
                                 role="progressbar" style="width: {{$indicator->getStateIndicator()[1]?? null}}%" aria-valuenow="80" aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        <div class="collapse" id="collapseIndicators">
            @foreach($user->indicators as $indicator)
                @if($loop->iteration>5)
                    <div class="col-12">
                        <div class="p-3">
                            <a href="javascript:void(0);" aria-expanded="false"
                               wire:click="$emitTo('indicators.indicator-show', 'open', {{ $indicator->id }})">{{$indicator->name}}</a>
                            <div class="progress progress-xs mt-2">
                                <div class="progress-bar  {{$indicator->getStateIndicator()[1]>50 ? ' bg-primary-300 bg-primary-gradient':' bg-danger-300 bg-warning-gradient' }} "
                                     role="progressbar" style="width: {{$indicator->getStateIndicator()[1]?? null}}%" aria-valuenow="80" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="col-12">
            <div class="p-3 text-center">
                <a data-toggle="collapse" href="#collapseIndicators" role="button" aria-expanded="false" aria-controls="collapseIndicators"
                   class="btn-link font-weight-bold">{{trans('general.see_more')}}</a>
            </div>
        </div>
    </div>
</div>
