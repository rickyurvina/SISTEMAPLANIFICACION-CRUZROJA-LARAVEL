@if($selectProvinces!=null && $poaFinded==true)
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
        @foreach($dataReportObjectivesTotal[$selectYears] as $index => $poaYear)
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
                    {!! $poaYear['progress']  !!}
                </td>
            </tr>
        @endforeach
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
                style="width: 30%">{{ trans('general.reached_people_objective') }}</th>
            <th class="border border-dark text-center">{{trans('general.goal')}}</th>
            <th class="border border-dark text-center">{{trans('general.actual')}}</th>
            <th class="border border-dark text-center">{{trans('general.progress')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($dataReportObjectivesTotalSpecific[$selectYears] as $index => $poaYear)
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
                    {!! $poaYear['progress']  !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    @foreach($poaSelected as $year => $poa)
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
            @foreach($dataReportObjectives[$poa->year][$poa->id] as $index => $poaYear)
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
                        {!! $poaYear['progress']  !!}
                    </td>
                </tr>
            @endforeach
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
                    style="width: 30%">{{ trans('general.reached_people_objective') }}</th>
                <th class="border border-dark text-center">{{trans('general.goal')}}</th>
                <th class="border border-dark text-center">{{trans('general.actual')}}</th>
                <th class="border border-dark text-center">{{trans('general.progress')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($dataReportObjectivesSpecific[$poa->year][$poa->id] as $index => $poaYear)
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
                        {!! $poaYear['progress']  !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach
@endif