<div>
   <div class="card">
      <div class="table-responsive">
         <table class="table table-hover m-0 border-1">
            <tbody>
            @if($articulations)
               @foreach($articulations->groupBy('plan_target_id') as $articulations2)
                  @foreach($articulations2->groupBy('plan_source_detail_id')  as  $index => $articulation)
                     @foreach($articulation as $planArticulation)
                        @if($loop->index==0 && $loop->parent->index==0)
                           <tr class="text-center">
                              <th colspan="2" style="background-color: #f2f2f2">
                                 Alineación estratégica de {{$planArticulation->sourcePlan->name}} con {{$planArticulation->targetPlan->name}}
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
                              <th class="align-middle" rowspan="{{count($articulation)}}">{{$planArticulation->sourcePlanDetail->name}} </th>
                           @endif
                           <th class="align-middle">{{$planArticulation->targetPlanDetail->name}} </th>
                        </tr>
                     @endforeach
                  @endforeach
               @endforeach
            @endif
            </tbody>
         </table>
      </div>
   </div>
</div>
