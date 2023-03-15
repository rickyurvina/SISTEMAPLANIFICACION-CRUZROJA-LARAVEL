<div class="modal fade default-example-modal-right-lg" data-toggle="register-indicator-advance"
     id="register-indicator-advance" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true"
     wire:ignore.self>
    <div class="modal-dialog modal-dialog-right modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4"><i
                            class="fas fa-plus-circle text-success"></i> {{trans('indicators.indicator.register_advance')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetFields">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                @if($indicator)
                    <div class="card border mb-g">
                        <div class="card-header py-2">
                            <div class="card-title">
                                {{$indicator->name}}
                            </div>
                        </div>
                        <div class="card-body pl-4 pt-4 pr-4">
                            <div class="p-0">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th class="w-15 font-weight-bold">{{trans('general.start_date')}}</th>
                                        <th class="w-15 font-weight-bold">{{trans('general.end_date')}}</th>
                                        @if($indicator->threshold_type==\App\Models\Indicators\Indicator\Indicator::TYPE_TOLERANCE)
                                            <th class="w-15 font-weight-bold">{{trans('general.min')}}</th>
                                            <th class="w-15 font-weight-bold">{{trans('general.max')}}</th>
                                        @else
                                            <th class="w-15 font-weight-bold">{{trans('general.goal')}}</th>
                                        @endif
                                        <th class="w-15 font-weight-bold">{{trans('general.advance')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($indicator->indicatorGoals as $index => $goal)
                                        <tr wire:key="{{time().$goal->id}}">
                                            <td>{{ $goal->start_date->format('F j, Y') }}</td>
                                            <td>{{ $goal->end_date->format('F j, Y') }}</td>
                                            @if($indicator->threshold_type==\App\Models\Indicators\Indicator\Indicator::TYPE_TOLERANCE)
                                                <td>
                                                    <div class="p-2">
                                                        <livewire:components.input-text
                                                                :modelId="$goal->id"
                                                                class="{{\App\Models\Indicators\GoalIndicator\GoalIndicators::class}}"
                                                                field="min"
                                                                :rules="'required|numeric'"
                                                                :key="time().$goal->id"
                                                                defaultValue="{{ $goal->min }}"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="p-2">
                                                        <livewire:components.input-text
                                                                :modelId="$goal->id"
                                                                class="{{\App\Models\Indicators\GoalIndicator\GoalIndicators::class}}"
                                                                field="max"
                                                                :rules="'required|numeric'"
                                                                :key="time().$goal->id"
                                                                defaultValue="{{ $goal->max }}"/>
                                                    </div>
                                                </td>
                                            @else
                                                <td>
                                                    <div class="p-2">
                                                        <livewire:components.input-text
                                                                :modelId="$goal->id"
                                                                class="{{\App\Models\Indicators\GoalIndicator\GoalIndicators::class}}"
                                                                field="goal_value"
                                                                :rules="'required|numeric'"
                                                                :key="time().$goal->id"
                                                                defaultValue="{{ $goal->goal_value }}"/>
                                                    </div>
                                                </td>
                                            @endif
                                            <td>
                                                <div class="p-2">
                                                    <livewire:components.input-text
                                                            :modelId="$goal->id"
                                                            class="{{\App\Models\Indicators\GoalIndicator\GoalIndicators::class}}"
                                                            field="actual_value"
                                                            :rules="'required|numeric'"
                                                            :key="time().$goal->id"
                                                            defaultValue="{{ $goal->actual_value }}"/>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>