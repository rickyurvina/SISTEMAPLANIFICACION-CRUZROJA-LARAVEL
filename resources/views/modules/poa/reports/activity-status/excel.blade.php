<table class="border border-dark m-0">
    <thead class="border border-dark bg-primary-50">
    <tr class="border border-dark">
        <th class="border border-dark text-center" style="width: 20%">{{ strtoupper(__('poa.program')) }}</th>
        <th class="border border-dark text-center"
            style="width: 30%">{{ strtoupper(trans_choice('poa.indicator', 2)) }}</th>
        <th class="border border-dark text-center"
            style="width: 30%">{{ strtoupper(trans_choice('poa.activity', 2)) }}</th>
        <th class="border border-dark text-center" style="width: 10%">{{ strtoupper(__('poa.responsible')) }}</th>
        <th class="border border-dark text-center" style="width: 10%">{{ strtoupper(__('poa.status')) }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $items)
        @foreach($items as $item)
            <tr class="border border-dark">
                @if($loop->first)
                    <td class="border border-dark" rowspan="{{count($items)}}">{{ $item['programName'] }}</td>
                @endif
                <td class="border border-dark">{{ $item['indicator'] }}</td>
                <td class="border border-dark">{{ $item['activity'] }}</td>
                <td class="border border-dark">{{ $item['responsible'] }}</td>
                <td class="border border-dark">
                    @switch($item['status'])
                        @case( \App\Models\Poa\PoaActivity::STATUS_SCHEDULED)
                            <span class="badge badge-info badge-pill">
                                        {{ $item['status'] }}
                                    </span>
                            @break
                        @case( \App\Models\Poa\PoaActivity::STATUS_IN_PROGRESS)
                            <span class="badge badge-success badge-pill">
                                        {{ $item['status'] }}
                                    </span>
                            @break
                        @case( \App\Models\Poa\PoaActivity::STATUS_ON_DELAY)
                            <span class="badge badge-warning badge-pill">
                                        {{ $item['status'] }}
                                    </span>
                            @break
                        @case( \App\Models\Poa\PoaActivity::STATUS_FINISHED)
                            <span class="badge badge-success badge-pill">
                                        {{ $item['status'] }}
                                    </span>
                            @break
                        @default
                            <span class="badge badge-info badge-pill">
                                        {{ $item['status'] }}
                                    </span>
                    @endswitch
                </td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>