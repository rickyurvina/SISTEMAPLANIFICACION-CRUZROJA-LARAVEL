<div>
    <div class="row my-4">
        <div class="col-md-3 col-sm-12">
            @if($type == 'objective')
                <x-score score="{{ $currentScore['score'] }}" difScoreValue="{{ $difScore['value'] }}" difScoreColor="{{ $difScore['color'] }}"
                         hasData="{{ $beforeScore ? 'true':false }}"
                         beforePeriod="{{ $beforeScore && $beforeScore['frequency'] != $currentScore['year'] ?
                         $beforeScore['frequency'] . ' ' . $currentScore['year'] : $beforeScore['frequency'] ?? '' }}"></x-score>
            @elseif($currentScore)
                @switch($model->scoringType->code)
                    @case(\App\Models\Measure\ScoringType::TYPE_GOAL_RED_FLAG)
                        <x-score-measure-3-colors score="{{ $currentScore['score'] }}" red="{{ $currentScore['thresholds'][1] }}" goal="{{ $currentScore['thresholds'][2] }}"
                                                  performance="{{ $currentScore['value'] }}" difPerformance="{{ $difScore['value'] }}"
                                                  difPerformanceColor="{{ $difScore['color'] }}"
                                                  hasData="{{ $beforeScore ? 'true':false }}"
                                                  beforePeriod="{{ $beforeScore && $beforeScore['frequency'] != $currentScore['year'] ?
                         $beforeScore['frequency'] . ' ' . $currentScore['year'] : $beforeScore['frequency'] ?? '' }}">
                        </x-score-measure-3-colors>
                        @break
                    @case(\App\Models\Measure\ScoringType::TYPE_THREE_COLORS)
                        <x-score-measure-3-colors score="{{ $currentScore['score'] }}" red="{{ $currentScore['thresholds'][2] }}" goal="{{ $currentScore['thresholds'][3] }}"
                                                  performance="{{ $currentScore['value'] }}" difPerformance="{{ $difScore['value'] }}"
                                                  difPerformanceColor="{{ $difScore['color'] }}"
                                                  hasData="{{ $beforeScore ? 'true':false }}"
                                                  beforePeriod="{{ $beforeScore && $beforeScore['frequency'] != $currentScore['year'] ?
                         $beforeScore['frequency'] . ' ' . $currentScore['year'] : $beforeScore['frequency'] ?? '' }}">
                        </x-score-measure-3-colors>
                        @break

                @endswitch
            @else
                <x-score-measure-3-colors></x-score-measure-3-colors>
            @endif
        </div>
        <div class="col-md-9 col-sm-12">
            <div class="card">
                <div class="card-header bg-transparent fw-700">
                    DESEMPEÑO HISTÓRICO
                    <div class="spinner-border spinner-border-sm ml-3" role="status" wire:loading>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($type == 'objective')
                        @include('modules.strategy.home.charts.score_historical', ['historicalScore' => $scores])
                    @else
                        @include('modules.strategy.home.charts.measure_historical', ['historicalScore' => $scores])
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12 col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header bg-transparent fw-700">
                    @if($type == 'objective')
                        DATOS UTILIZADOS EN LOS CÁLCULOS-{{strtoupper( $elementTreeName)}}
                    @else
                        VALORES DE INDICADOR Y UMBRALES
                    @endif
                    <div class="spinner-border spinner-border-sm ml-3" role="status" wire:loading>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($type == 'objective')
                        <table class="table m-0">
                            <thead class="bg-gray-200">
                            <tr>
                                <th>{{trans('general.code')}}</th>
                                <th>{{mb_strtoupper( $elementTreeName)}}</th>
                                <th class="text-center">Resultado</th>
                                <th class="text-center">Ponderación</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($currentScore['dataUsed'] as $data)
                                <tr>
                                    <td class="text-center"><span>{{ $data['code'] }}</span></td>
                                    <td>
                                        <a href="{{ route('show.strategy.home', ['id' => $data['id'], 'type' => $data['type']]) }}">
                                            <i class="fas fa-stop-circle mr-3" style="color: {{ $data['color'] }}"></i>
{{--                                            <i class="{{$data['icon']}}"></i>--}}
                                        {{ $data['name'] }}
                                    </td>
                                    <td class="text-center"><span style="color: {{ $data['color'] }}">{{ $data['score'] }}</span></td>
                                    <td class="text-center">{{ weight(array_sum(array_column($currentScore['dataUsed'], 'weight')), $data['weight']) }}%</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        @if($currentScore && $currentScore['dataUsed'])
                            <table class="table m-0">
                                <thead class="bg-gray-200">
                                <tr>
                                    <th>{{trans('general.name')}}</th>
                                    <th class="text-center">Score</th>
                                    <th class="text-center">Valor</th>
                                    @foreach($model->scoringType->config as $index => $value)
                                        <th class="text-center">{{ $value['label'] }}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($currentScore['dataUsed'] as $data)
                                    <tr>
                                        <td>
                                            <i class="fas fa-stop-circle mr-3" style="color: {{ $data['color'] }}"></i>
                                            {{ $data['name'] }}
                                        </td>
                                        <td class="text-center"><span style="color: {{ $data['color'] }}">{{ $data['score'] }}</span></td>
                                        <td class="text-center">{{ $data['actual']  }}</td>
                                        @foreach($data['thresholds'] as $index => $value)
                                            <td class="text-center">{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-danger fs-2x">No existe información para el período seleccionado. Es posible que la frecuencia del indicador sea mayor a la
                                seleccionada.
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
