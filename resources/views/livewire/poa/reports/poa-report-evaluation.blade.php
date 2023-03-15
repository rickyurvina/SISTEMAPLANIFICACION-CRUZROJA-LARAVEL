<div>
    @include('modules.poa.reports.general-evaluation.header')
    <div id="panel-10" class="panel">
        <div class="panel-hdr">
            <h2>
                {{trans('poa.evaluation_general_red')}} <span class="fw-300"><i>{{$selectYears}}</i></span>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10"
                        data-original-title="Collapse"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10"
                        data-original-title="Fullscreen"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <ul class="nav nav-pills nav-justified" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#js_change_pill_justified-1" wire:ignore>{{trans('poa.evaluation_general_red')}}</a>
                    </li>
                    @foreach($groupObjectives as $index => $objective)
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#js_change_pill_justified-2{{$index}}" wire:ignore>{{$planDetails->find($index)->name}}</a>
                        </li>
                    @endforeach
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#js_change_pill_justified-4" wire:ignore>{{trans('poa.evaluation_general_participation')}}</a>
                    </li>
                </ul>
                <div class="tab-content py-3">
                    <div class="tab-pane fade show active" id="js_change_pill_justified-1" role="tabpanel" wire:ignore>
                        <div id="chartdivObjectives" style="width: 100%; height: 500px"></div>
                    </div>
                    <div class="tab-pane fade" id="js_change_pill_justified-21" role="tabpanel" wire:ignore>
                        <div id="chartdivObjetive11" style="width: 100%; height: 500px"></div>
                    </div>
                    <div class="tab-pane fade" id="js_change_pill_justified-22" role="tabpanel" wire:ignore>
                        <div id="chartdivObjetive2" style="width: 100%; height: 500px"></div>
                    </div>
                    <div class="tab-pane fade" id="js_change_pill_justified-4" role="tabpanel" wire:ignore>
                        <div class="row">
                            @include('modules.poa.reports.general-evaluation.filter-participation')
                            <div id="chartdivParticipation" class="p-2" style="width: 100%; height: 500px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('page_script')
    @include('modules.poa.reports.general-evaluation.territorial-network')
    @include('modules.poa.reports.general-evaluation.first_objective')
    @include('modules.poa.reports.general-evaluation.second_objective')
    @include('modules.poa.reports.general-evaluation.participation')
@endpush
