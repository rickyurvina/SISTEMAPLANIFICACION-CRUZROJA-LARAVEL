@if($selectProvinces!=null)
    @foreach($total as $index => $year)
        @foreach($year['data'] as $program)
            <table class="border border-dark m-0 w-100">
                <thead class="border border-dark">
                @if($loop->first)
                    <tr class="border border-dark">
                        <th colspan="@if($visibilityByMonth==true)53 @else 5 @endif"
                            class="border border-dark text-center font-weight-bold fs-2x">{{trans('general.goals_title')}}</th>
                    </tr>
                @endif
                <tr>
                    <th class="border border-dark font-weight-bold fs-2x">{{trans('general.specific_objective')}}</th>
                    <th class="border border-dark text-center" colspan="@if($visibilityByMonth==true)52 @else 2 @endif">{{$program['specificGoal']}}</th>
                </tr>
                <tr>
                    <th class="border border-dark font-weight-bold fs-2x">{{trans('general.program')}}</th>
                    <td class="border border-dark  text-center bg-blue-cre"
                        colspan="@if($visibilityByMonth==true)52 @else 2 @endif">
                        {{$program['programName']}}
                    </td>
                </tr>
                <tr class="border border-dark">
                    <th class="border border-dark  text-center bg-fusion-500" rowspan="3">{{trans_choice('general.indicators',2)}}
                        <i class="fal fa-arrow-down"></i>
                    </th>
                    <th colspan="@if($visibilityByMonth==true)13 @else 1 @endif" rowspan="2"
                        class="border border-dark text-center bg-fusion-50">
                        {{trans('general.goal')}}
                    </th>
                    <th colspan="@if($visibilityByMonth==true)36 @else 1 @endif"
                        class="border border-dark text-center bg-info-700">
                        {{trans('general.advance')}}</th>
                </tr>
                <tr>
                    @if($visibilityByMonth==true)
                        @foreach (range(1, 12) as $month)
                            <th class="border border-dark text-center bg-info-700" colspan="3">
                                {{\App\Models\Indicators\Indicator\Indicator::FREQUENCIES[12][$month]}}</th>
                        @endforeach
                    @endif
                    <th colspan="1" rowspan="2" class="border border-success text-center fs-1x font-weight-bolder">{{trans('general.total')}}</th>
                    <th colspan="1" rowspan="2"
                        class="border border-dark text-center bg-info-500 fs-1x fw-900">{{trans('general.progress')}}</th>
                </tr>
                <tr>
                    @if($visibilityByMonth==true)
                        @foreach (range(1, 12) as $month)
                            <th class="border border-dark text-center bg-fusion-50">
                                {{\App\Models\Indicators\Indicator\Indicator::FREQUENCIES[12][$month]}}</th>
                        @endforeach
                    @endif
                    <th colspan="1" class="border border-success text-center fs-1x font-weight-bolder">{{trans('general.total')}}</th>
                    @if($visibilityByMonth==true)
                        @foreach (range(1, 12) as $month)
                            <th class="border border-dark text-center bg-info-700">H</th>
                            <th class="border border-dark text-center bg-info-700">M</th>
                            <th class="border border-dark text-center bg-info-400">T</th>
                        @endforeach
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($program as $index => $activity)
                    <tr>
                        @if(is_array($activity))
                            @if(isset($activity['activityIndicatorName']))
                                <td class="border border-dark" style="width: 20%">{{$activity['activityIndicatorName']}}</td>
                                @if($visibilityByMonth==true)
                                    @foreach($activity as $month)
                                        @if(is_array($month))
                                            <td class="border border-dark" style="width: 1.5%">
                                                {{$month['planned']}}
                                            </td>
                                        @endif
                                    @endforeach
                                @endif
                                <td class="border border-success text-center fs-1x font-weight-bolder" style="width: 3%">
                                    {{$activity['sum_planned']}}
                                </td>
                                @if($visibilityByMonth==true)
                                    @foreach($activity as $month)
                                        @if(is_array($month))
                                            <td class="border border-dark" style="width: 1.5%">{{$month['men']}}</td>
                                            <td class="border border-dark" style="width: 1.5%">{{$month['women']}}</td>
                                            <td class="border border-dark" style="width: 1.5%">{{$month['progress']}}</td>
                                        @endif
                                    @endforeach
                                @endif
                                <td class="border border-success text-center fs-1x font-weight-bolder" style="width: 3%">
                                    {{$activity['sum_progress']}}
                                </td>
                                <td class="border text-center" style="width: 3%">{!! $activity['progress']!!}</td>
                            @endif
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endforeach
    @endforeach
@else
    @foreach($data as $poa)
        @foreach($poa['data'] as $program)
            <table class="border border-dark m-0 w-100">
                <thead class="border border-dark">
                @if($loop->first)
                    <tr class="border border-dark">
                        <th colspan="@if($visibilityByMonth==true)53 @else 5 @endif"
                            class="border border-dark text-center font-weight-bold fs-2x">{{trans('general.goals_title')}}</th>
                    </tr>
                @endif
                <tr>
                    <th class="border border-dark font-weight-bold fs-2x">{{trans('general.specific_objective')}}</th>
                    <th class="border border-dark text-center"
                        colspan="@if($visibilityByMonth==true)52 @else 2 @endif">{{$program['specificGoal']}}</th>
                </tr>
                <tr>
                    <th class="border border-dark font-weight-bold fs-2x">{{trans('general.program')}}</th>
                    <td class="border border-dark  text-center bg-blue-cre" style="width: 30%"
                        colspan="@if($visibilityByMonth==true)52 @else 2 @endif">{{$program['programName']}}</td>
                </tr>
                <tr class="border border-dark">
                    <th class="border border-dark  text-center bg-fusion-500" rowspan="3">{{trans_choice('general.activities',2)}} <i
                                class="fal fa-arrow-down"></i></th>
                    <th colspan="@if($visibilityByMonth==true)13 @else 1 @endif"
                        class="border border-dark text-center bg-fusion-50" style="width:30%" rowspan="2">{{trans('general.goal')}}</th>
                    <th colspan="@if($visibilityByMonth==true)36@else 1 @endif"
                        class="border border-dark text-center bg-info-700" style="width: 30%">
                        {{trans('general.advance')}}
                    </th>
                </tr>
                <tr>
                    @if($visibilityByMonth==true)
                        @foreach (range(1, 12) as $month)
                            <th class="border border-dark text-center bg-info-700" colspan="3">
                                {{\App\Models\Indicators\Indicator\Indicator::FREQUENCIES[12][$month]}}</th>
                        @endforeach
                    @endif
                    <th colspan="1" rowspan="2" class="border border-success text-center fs-1x font-weight-bolder">{{trans('general.total')}}</th>
                    <th colspan="1" rowspan="2"
                        class="border border-dark text-center bg-info-500 fs-1x fw-900">{{trans('general.progress')}}</th>
                </tr>
                <tr>
                    @if($visibilityByMonth==true)
                        @foreach (range(1, 12) as $month)
                            <th class="border border-dark text-center bg-fusion-50">
                                {{\App\Models\Indicators\Indicator\Indicator::FREQUENCIES[12][$month]}}</th>
                        @endforeach
                    @endif
                    <th colspan="1" class="border border-success text-center fs-1x font-weight-bolder">{{trans('general.total')}}</th>
                    @if($visibilityByMonth==true)
                        @foreach (range(1, 12) as $month)
                            <th class="border border-dark text-center bg-info-700">H</th>
                            <th class="border border-dark text-center bg-info-700">M</th>
                            <th class="border border-dark text-center bg-info-400">T</th>
                        @endforeach
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($program as $index => $activity)
                    <tr>
                        @if(is_array($activity))
                            @if(isset($activity['id']))
                                <td class="border border-dark" style="width: 20%">
                                    <a href="javascript:void(0);" aria-expanded="false"
                                       wire:click="$emitTo('poa.reports.poa-show-activity', 'open', {{ $activity['id'] }})">
                                        {{$activity['activityName']}}
                                    </a>
                                </td>
                                @if($visibilityByMonth==true)
                                    @foreach($activity as $month)
                                        @if(is_array($month))
                                            <td class="border border-dark text-center" style="width: 1.5%">{{$month['planned']}}</td>
                                        @endif
                                    @endforeach
                                @endif
                                <td class="border border-success text-center fs-1x font-weight-bolder" style="width: 3%">{{$activity['sum_planned']}}</td>
                                @if($visibilityByMonth==true)
                                    @foreach($activity as $month)
                                        @if(is_array($month))
                                            <td class="border border-dark text-center" style="width: 1.5%">{{$month['men']}}</td>
                                            <td class="border border-dark text-center" style="width: 1.5%">{{$month['women']}}</td>
                                            <td class="border border-primary text-center" style="width: 1.5%">{{$month['progress']}}</td>
                                        @endif
                                    @endforeach
                                @endif
                                <td class="border border-success text-center fs-1x font-weight-bolder" style="width: 3%">{{$activity['sum_progress']}}</td>
                                <td class="border text-center" style="width: 3%">{!! $activity['progress']!!}</td>
                            @endif
                        @endif
                    </tr>
                @endforeach
                @if($visibilityByMonth==true)
                    <tr>
                        <td class="border border-dark text-center bg-info-200" colspan="14">
                            TOTALES HyM {{$program['programName']}}
                        </td>
                        @foreach (\App\Models\Indicators\Indicator\Indicator::FREQUENCIES[12] as $month)
                            <td class="border border-success text-center fs-1x font-weight-bolder"
                                style="width: 1.5%">{{$program['totals'][$month]['men']}}</td>
                            <td class="border border-success text-center fs-1x font-weight-bolder"
                                style="width: 1.5%">{{$program['totals'][$month]['women']}}</td>
                            <td></td>
                        @endforeach
                    </tr>
                @endif
                </tbody>
            </table>
        @endforeach
    @endforeach
@endif