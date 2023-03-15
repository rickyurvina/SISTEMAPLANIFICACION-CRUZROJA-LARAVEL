<div>
    @if($articulations->count()>0)
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover m-0 border-1">
                    <tbody>
                    @foreach($articulations->groupBy('plan_target_id') as $articulations2)
                        @foreach($articulations2->groupBy('plan_source_detail_id')  as  $index => $articulation)
                            @foreach($articulation as $planArticulation)
                                @if($loop->index==0 && $loop->parent->index==0)
                                    <tr class="text-center">
                                        <th colspan="2" style="background-color: #f2f2f2">
                                            {{trans('general.strategic_alignment_of')}} {{$planArticulation->sourcePlan->name}}
                                            {{trans('general.with')}} {{$planArticulation->targetPlan->name}}
                                        </th>
                                    </tr>
                                    <tr class="">
                                        <th style="background-color:  rgba(80,80,80,.02) ; color: #D52B1E">
                                            {{$planArticulation->sourceRegisteredTemplate->name}}
                                        </th>
                                        <th style="background-color:  rgba(80,80,80,.02) ; color: #D52B1E">
                                            {{$planArticulation->targetRegisteredTemplate->name}}
                                        </th>
                                    </tr>
                                @endif
                                <tr class="">
                                    @if($loop->first)
                                        <th class="align-middle"
                                            rowspan="{{count($articulation)}}">{{$planArticulation->sourcePlanDetail->name}} </th>
                                    @endif
                                    <th class="align-middle">{{$planArticulation->targetPlanDetail->name}} </th>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <x-empty-content>
            <x-slot name="title">
                {{trans('general.there_are_no_articulations')}}
            </x-slot>
        </x-empty-content>
    @endif
</div>
