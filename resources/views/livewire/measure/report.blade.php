<div>
    <div x-data="{ open: false }" x-cloak>
        <div class="card">
            <div class="card-header bg-primary-500 pr-3 d-flex align-items-center flex-wrap">
                <div class="card-title">REPORTE</div>
                <div class="tip cursor-pointer fw-900 ml-auto">
                    <button class="btn btn-sm shadow-0 btn-default cursor-pointer" @click="open = true"><i class="fas fa-tools"></i> Opciones</button>
                    <div class="tip-content fw-n" x-cloak x-show="open" @click.outside="open = false" style="width: 500px; z-index: 9999">
                        <div class="px-2" style="margin-top: -4px">
                            <span class="mb-4 fw-n">Opciones de visualización</span>

                            <div class="form-group text-left">
                                <label class="form-label">Número de Períodos del calendario para mostrar</label>
                                <select class="custom-select form-control w-25" wire:model.defer="numberOfPeriod">
                                    @foreach(range(1,24) as $period)
                                        <option value="{{ $period }}">{{ $period }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-left">
                                <span class="font-weight-bold">Mostrar los siguientes datos</span>
                                @foreach($options as $key => $option)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="{{ $key }}" checked="" wire:model.defer="options.{{ $key }}.show">
                                        <label class="custom-control-label" for="{{ $key }}">{{ $option['label'] }}</label>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                        <div class="px-2 pt-1 border-top text-right">
                            <button class="btn btn-success shadow-0 btn-sm w-100 mt-2" @click="open = false" wire:click="showOptions">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered colored-cells">
                <thead class="bg-primary-50">
                <tr>
                    <th class="text-center align-middle">INDICADOR</th>
                    @if($this->countOptions() > 1)
                        <th class="text-center align-middle">CAMPO</th>
                    @endif
                    @if($this->countOptions() > 0)
                        @foreach($periods as $period)
                            <th class="text-center">{{ $this->getPeriodName($period) }}</th>
                        @endforeach
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($metrics as $metric)
                    @foreach($this->selectedOptions() as $key => $option)
                        <tr>
                            @if ($loop->first)
                                <td class="font-weight-bold align-text-top" @if($this->countOptions() > 1) rowspan="{{ $this->countOptions() }}" @endif>{{ $metric['label'] }}</td>
                            @endif
                            @if($this->countOptions() > 0)
                                @if($this->countOptions() > 1)
                                    <td class="text-right">{{ $option['label'] }}</td>
                                @endif
                                @foreach($metric['scores'] as $score)
                                    <td class="text-center @if($key === 'showActual') color {{ $score['color'] }} @endif">
                                        <div class="color-wrapper">
                                            <span class="metric-raw-score">
                                               @switch($key)
                                                    @case('showActual')
                                                        {{ $score['actual'] }}
                                                        @break
                                                    @case('showScore')
                                                        {{ $score['score'] }}
                                                        @break
                                                    @case('showGoal')
                                                        {{ $score['goal'] }}
                                                        @break
                                                    @case('showVariance')
                                                        {{ $score['variance'] }}
                                                        @break
                                                    @case('showVariancePercent')
                                                        {{ $score['variancePercent'] }}
                                                        @break
                                                    @case('showTowardGoalPercent')
                                                        {{ $score['towardGoalPercent'] }}
                                                        @break
                                                @endswitch
                                            </span>
                                        </div>
                                    </td>
                                @endforeach
                            @endif
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

@push('css')
    <style>

        table.colored-cells td.color.green::before {
            border-top-color: rgba(150, 205, 0, .5);
        }

        table.colored-cells td.color.yellow::before {
            border-top-color: rgba(251, 204, 59, .5);
        }

        table.colored-cells td.color.red::before {
            border-top-color: rgba(242, 81, 49, .5);
        }

        table.colored-cells td.color::before {
            display: block;
            position: absolute;
            top: 4px;
            left: 4px;
            content: '';
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 14px 14px 0 0;
            border-color: transparent;
            pointer-events: none;
        }

        table.colored-cells tr:hover td.color::before {
            display: none;
        }

        table.colored-cells tr:hover td.color.green {
            color: #4b6700;
            background: rgba(150, 205, 0, .5) !important;
        }

        table.colored-cells tr:hover td.color.yellow {
            color: #7e661e;
            background: rgba(251, 204, 59, .5) !important;
        }

        table.colored-cells tr:hover td.color.red {
            color: #792919;
            background: rgba(242, 81, 49, .5) !important;
        }

        table.colored-cells td.color {
            padding: 14px 15px 11px;
            position: relative;
            font-weight: 600;
            z-index: 1;
            font-size: 15px;
            color: #616d7a;
            transition: none;
        }

        table.colored-cells tr:hover td.color {
            text-shadow: none;
            box-shadow: inset 0 0 0 4px #fff;
        }
    </style>
@endpush