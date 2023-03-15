<div class="card mb-g">
    <div class="row row-grid no-gutters">
        <div class="col-12">
            <div class="p-3">
                <h2 class="mb-0 fs-xl">
                    {{trans('general.activities_created_poas')}}
                </h2>
            </div>
        </div>
        @foreach($poaActivities  as $activities)
            @if($loop->iteration<=3)
                <div class="col-12">
                    <div class="p-3">
                        <div class="fw-500 fs-xs">
                            <a href="javascript:void(0);" aria-expanded="false"
                               wire:click="$emitTo('poa.reports.poa-show-activity', 'open', {{ $activities->id }})">
                                {{$activities->name}}-{{$activities->program->poa->name}}
                            </a>
                        </div>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar bg-primary-300 bg-primary-gradient {{$activities->progress()>50 ? ' bg-primary-300 bg-primary-gradient':' bg-danger-300 bg-warning-gradient' }}"
                                 role="progressbar" style="width: {{$activities->progress()}}%"
                                 aria-valuenow="80" aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        <div class="collapse" id="collapseActivities">
            @foreach($poaActivities  as $activities)
                @if($loop->iteration>3)
                    <div class="col-12">
                        <div class="p-3">
                            <div class="fw-500 fs-xs">
                                <a href="javascript:void(0);" aria-expanded="false"
                                   wire:click="$emitTo('poa.reports.poa-show-activity', 'open', {{ $activities->id }})">
                                    {{$activities->name}}-{{$activities->program->poa->name}}
                                </a>
                            </div>
                            <div class="progress progress-xs mt-2">
                                <div class="progress-bar bg-primary-300 bg-primary-gradient {{$activities->progress()>50 ? ' bg-primary-300 bg-primary-gradient':' bg-danger-300 bg-warning-gradient' }}"
                                     role="progressbar" style="width: {{$activities->progress()}}%"
                                     aria-valuenow="80" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="col-12">
            <div class="p-3 text-center">
                <a data-toggle="collapse" href="#collapseActivities" role="button" aria-expanded="false" aria-controls="collapseActivities"
                   class="btn-link font-weight-bold">{{trans('general.see_more')}}</a>
            </div>
        </div>
    </div>
</div>