<div class="col-xl-12">
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2 class="text-center">
                {{$provinces->find($selectProvinces)->name}} <span class="fw-300"><i>{{$selectYears}}</i></span>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10"
                        data-original-title="Collapse"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10"
                        data-original-title="Fullscreen"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                        data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container  show">
            <div class="panel-content">
                <table class="border border-dark m-0 w-100" wire:loading.class.delay="opacity-50">
                    <thead class="border border-dark bg-primary-50">
                    <tr class="border border-dark">
                        <th colspan="4"
                            class="border border-dark text-center">{{ trans('general.report_general')}}</th>
                    </tr>
                    <tr>
                        <th class="border border-dark text-center"
                            style="width: 30%">{{ trans('general.reached_people_objective') }}</th>
                        <th class="border border-dark text-center">{{trans('general.goal')}}</th>
                        <th class="border border-dark text-center">{{trans('general.actual')}}</th>
                        <th class="border border-dark text-center">{{trans('general.progress')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($dataReportObjectivesTotal[$selectYears] ))
                        @forelse($dataReportObjectivesTotal[$selectYears] as $index => $poaYear)
                            <tr class="border border-dark">
                                <td class="border border-dark text-center">
                                    {{$index}}
                                </td>
                                <td class="border border-dark text-center">
                                    {{$poaYear['goal']}}
                                </td>
                                <td class="border border-dark text-center">
                                    {{$poaYear['actual']}}
                                </td>
                                <td class="border border-dark text-center">
                                    {!! $poaYear['progress'] !!}
                                </td>
                            </tr>
                        @empty
                            <div class="text-center col-12">
                                <x-empty-content>
                                    <x-slot name="img">
                                        <img src="{{ asset_cdn("img/no_info.png") }}" width="auto" height="auto" alt="No Info">
                                    </x-slot>
                                </x-empty-content>
                            </div>
                        @endforelse
                    @endif
                    </tbody>
                </table>
                <table class="border border-dark m-0 w-100" wire:loading.class.delay="opacity-50">
                    <thead class="border border-dark bg-primary-50">
                    <tr class="border border-dark">
                        <th colspan="4"
                            class="border border-dark text-center">{{ trans('general.report_general_specific')}}</th>
                    </tr>
                    <tr>
                        <th class="border border-dark text-center"
                            style="width: 30%">{{ trans('general.reached_people_specific_objective') }}</th>
                        <th class="border border-dark text-center">{{trans('general.goal')}}</th>
                        <th class="border border-dark text-center">{{trans('general.actual')}}</th>
                        <th class="border border-dark text-center">{{trans('general.progress')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($dataReportObjectivesTotalSpecific[$selectYears] ))
                        @forelse($dataReportObjectivesTotalSpecific[$selectYears] as $index => $poaYear)
                            <tr class="border border-dark">
                                <td class="border border-dark text-center">
                                    {{$index}}
                                </td>
                                <td class="border border-dark text-center">
                                    {{$poaYear['goal']}}
                                </td>
                                <td class="border border-dark text-center">
                                    {{$poaYear['actual']}}
                                </td>
                                <td class="border border-dark text-center">
                                    {!! $poaYear['progress'] !!}
                                </td>
                            </tr>
                        @empty
                            <div class="text-center col-12">
                                <x-empty-content>
                                    <x-slot name="img">
                                        <img src="{{ asset_cdn("img/no_info.png") }}" width="auto" height="auto" alt="No Info">
                                    </x-slot>
                                </x-empty-content>
                            </div>
                        @endforelse
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
