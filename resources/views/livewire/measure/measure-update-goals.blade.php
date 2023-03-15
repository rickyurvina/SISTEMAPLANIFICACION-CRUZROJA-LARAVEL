<div>
    <div
            x-data="{
                show: @entangle('show'),
            }"
            x-init="$watch('show', value => {
            if (value) {
                $('#measure-update-goals').modal('show')
            } else {
                $('#measure-update-goals').modal('hide');
            }
        })"
            x-on:keydown.escape.window="show = false"
            x-on:close.stop="show = false"
    >

        <div wire:ignore.self class="modal fade" id="measure-update-goals" tabindex="-1" role="dialog" aria-hidden="true"
             data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title h4"><i class="fas fa-plus-circle text-success"></i> {{ trans('indicators.indicator.edit_indicator')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" x-on:click="show = false">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        </button>
                    </div>
                    @if($measure)
                        <div class="modal-body">
                            <div class="card border mb-g">
                                <div class="card-header py-2">
                                    <div class="card-title">
                                        {{$measure->name}}
                                    </div>
                                </div>
                                <div class="card-body pl-4 pt-4 pr-4">
                                    <div class="p-0">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th class="w-15 font-weight-bold">{{trans('general.start_date')}}</th>
                                                <th class="w-15 font-weight-bold">{{trans('general.end_date')}}</th>
                                                <th class="w-40 font-weight-bold" colspan="2">Límites</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($scores as $index => $score)
                                                <tr>
                                                    <td>{{ $score->period->start_date->format('F j, Y') }}</td>
                                                    <td>{{ $score->period->end_date->format('F j, Y') }}</td>
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
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary mr-1" x-on:click="show = false">
                            <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                        </button>
                        <button class="btn btn-success" wire:click="save">
                            <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('page_script')
    <script>
        $(document).ready(function () {
            $('#select-category').select2({
                placeholder: "{{ trans('general.select') }}"
            });
        });
    </script>
@endpush