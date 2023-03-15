<div>
    <div wire:ignore.self class="modal fade in" id="poa-assign-goals" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 90% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="text-info text-center">
                        {{ __('general.assign_goals') }} - {{ $program->planDetail->name ?? '' }}
                    </h2>
                    <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                @if($elementos)
                    @if($program)
                        <div class="modal-body pt-0">
                            <div class="" style="overflow: scroll;">
                                <table class="table table-bordered table-sm" style="width: 100%;">
                                    <thead class="thead-themed">
                                    <tr>
                                        <th class="text-left">{{trans('general.activity')}}</th>
                                        <th>{{trans('general.january')}}</th>
                                        <th>{{trans('general.february')}}</th>
                                        <th>{{trans('general.march')}}</th>
                                        <th>{{trans('general.april')}}</th>
                                        <th>{{trans('general.may')}}</th>
                                        <th>{{trans('general.june')}}</th>
                                        <th>{{trans('general.july')}}</th>
                                        <th>{{trans('general.august')}}</th>
                                        <th>{{trans('general.september')}}</th>
                                        <th>{{trans('general.october')}}</th>
                                        <th>{{trans('general.november')}}</th>
                                        <th>{{trans('general.december')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($elementos as $index => $element)
                                        @foreach($element as $key => $items)
                                            @if($loop->first)
                                                <tr class="bg-info-50" style="padding: 0.05rem !important;">
                                                    <td colspan="13">
                                                        <i class="{{ $items[0]['icon']}}"></i>
                                                        <strong>{{ $index }}</strong>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th scope="row" class="w-25 text-truncate-md text-truncate-lg text-truncate-sm"><strong>{{ $key}}</strong>
                                                </th>
                                                @foreach($items as $item)
                                                    <td style="max-width: 15px">
                                                        @if($poa->status instanceof \App\States\Poa\InProgress)
                                                            <livewire:components.input-inline-edit :modelId="$item['id']"
                                                                                                   class="{{\App\Models\Measure\MeasureAdvances::class}}"
                                                                                                   field="goal"
                                                                                                   :rules="'required|numeric|min:0'"
                                                                                                   defaultValue="{{$item['goal']}}"
                                                                                                   event="goalsUpdated"
                                                                                                   key="{{time().$item['id']}}"/>
                                                        @else
                                                            {{ $item['goal'] }}
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                @else
                    <x-empty-content>
                        <x-slot name="img">
                            <i class="fal fa-list" style="color: #2582fd;"></i>
                        </x-slot>
                        <x-slot name="title">
                            {{ trans_choice('general.activities',0) }}
                        </x-slot>
                        <x-slot name="info">
                            {{ trans('messages.info.empty_activities') }}
                        </x-slot>
                    </x-empty-content>
                @endif
            </div>
        </div>
    </div>
</div>
