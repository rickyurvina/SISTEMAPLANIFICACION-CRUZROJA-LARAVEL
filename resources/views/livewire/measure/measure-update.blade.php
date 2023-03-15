<div>
    <div class="card border">
        <div class="card-header py-2">
            <div class="card-title">
                Actualizar
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="w-50 font-weight-bold">Indicador</th>
                    <th class="w-15 font-weight-bold">Periodo</th>
                    <th class="w-15 font-weight-bold" colspan="2">Límites</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($scores as $index => $score)
                    <tr>
                        @if($score->scoreable::class ==  \App\Models\Measure\Measure::class)
                            <td>
                                 <span>
                                     <i class="{{$score->scoreable->unit->getIcon()}}"></i>
                                     {{ $score->scoreable->name }}
                                </span>
                              </td>
                        @else
                            <td>{{ $score->scoreable->name }}</td>
                        @endif
                        <td>{{ $score->period->start_date }}</td>
                        <td>
                            @if($score->scoreable->scoringType->code == \App\Models\Measure\ScoringType::TYPE_YES_NO)
                                <label class="form-label">{{ trans('indicators.indicator.is_yes_good') }}</label><br>
                                @if($score->scoreable->yes_good)
                                    <span><i class="fas fa-check text-success"></i> {{ trans('general.yes') }}</span>
                                @else
                                    <span><i class="fas fa-times text-danger"></i> {{ trans('general.no') }}</span>
                                @endif
                            @else
                                <div class="d-flex">
                                    @foreach ($score->scoreable->scoringType->config as $cIndex => $config)
                                        <div>
                                            <label class="form-label">{{ $config['label'] }}</label>
                                            <input type="text" class="form-control"
                                                   wire:model.defer="thresholds.{{ $score->id }}.{{ $cIndex }}">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-success" wire:click="save">
                <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
            </button>
        </div>
    </div>
</div>

@push('page_script')
    <script>
        $(document).ready(function () {

        });
    </script>
@endpush