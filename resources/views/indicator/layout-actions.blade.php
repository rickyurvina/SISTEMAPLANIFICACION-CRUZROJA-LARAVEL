<div class="d-flex flex-wrap justify-content-center" wire:key="{{ 'r.i.' . $loop->index }}">
    <div class="p-2 cursor-pointer"
         wire:click="$emitTo('indicators.indicator-show', 'open', {{ $indicator->id }})">
                                                                        <span class="color-info-700"><i
                                                                                    class="far fa-eye" aria-expanded="false"
                                                                                    data-toggle="tooltip" data-placement="top" title=""
                                                                                    data-original-title="{{trans('general.show')}}"></i></span>
    </div>
    @if($indicator->type!=\App\Models\Indicators\Indicator\Indicator::TYPE_GROUPED)
        <div class="p-2 cursor-pointer" wire:click="$emit('triggerAdvance','{{ $indicator->id }}')">
                                                    <span class="color-success-700"><i
                                                                class="far fa-calendar-alt" aria-expanded="false"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="{{trans('general.advance')}}"></i>
                                                    </span>
        </div>
    @endif
    <div class="p-2 cursor-pointer"
         wire:click="$emit('triggerEdit', '{{ $indicator->id }}')">
                                                                        <span class="color-info-700"><i
                                                                                    class="fas fa-pencil-alt" aria-expanded="false"
                                                                                    data-toggle="tooltip" data-placement="top" title=""
                                                                                    data-original-title="{{trans('general.edit')}}"></i></span>
    </div>
    <div class="p-2 cursor-pointer"
         wire:click="$emit('triggerDeleteIndicator', '{{ $indicator->id }}')">
                                                                        <span class="color-danger-700"><i
                                                                                    class="fas fa-trash-alt" aria-expanded="false"
                                                                                    data-toggle="tooltip" data-placement="top" title=""
                                                                                    data-original-title="{{trans('general.delete')}}"></i></span>
    </div>
</div>