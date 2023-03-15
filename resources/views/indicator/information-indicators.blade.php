<th>{{$indicator->code}}</th>
<th>
    <i class="{{ $indicator->indicatorUnit->getIcon()}}"></i>
    {{$indicator->name}}
</th>
<th>{{$indicator->total_goal_value}}</th>
<th>{{$indicator->total_actual_value}}</th>
<td>
    @if($indicator->type==\App\Models\Indicators\Indicator\Indicator::TYPE_GROUPED)
        <span class="form-label badge {{$indicator->getStateGrouped()[0]?? null}}  badge-pill">{{$indicator->getStateGrouped()[1]?? null}}</span>
    @else
        <span class="form-label badge {{$indicator->getStateIndicator()[0]?? null}}  badge-pill">{{$indicator->getStateIndicator()[1]?? null}}</span>
    @endif
</td>
<th>
    <span class="pt-1">{{ $indicator->user->getFullName() }}</span>
</th>
<th class="text-center">
    @include('indicator.layout-actions')
</th>