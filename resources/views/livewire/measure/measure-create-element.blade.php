<div class="accordion" id="accordion-{{ $element->id }}">
    @foreach($element->children as $item)
        <div class="card">
            <div class="card-header">
                <a href="javascript:void(0);" class="card-title collapsed px-3 py-2" data-toggle="collapse" wire:ignore.self
                   data-target="#accordion-{{ $item->id . $loop->index }}" aria-expanded="false">
                    {{ $item->name }}
                    <span class="ml-auto">
                        <span class="collapsed-reveal">
                            <i class="fal fa-minus fs-xl"></i>
                        </span>
                        <span class="collapsed-hidden">
                            <i class="fal fa-plus fs-xl"></i>
                        </span>
                    </span>
                </a>
            </div>
            <div id="accordion-{{ $item->id . $loop->index }}" class="collapse" data-parent="#accordion-{{ $element->id }}" style="" wire:ignore.self>
                <div class="card-body">

                    @if(count($item->measures()->childCalendarFrequency($calendarFrequency)->get()))
                        <div class="card border">
                            <ul class="list-group list-group-flush">
                                @foreach($item->measures()->childCalendarFrequency($calendarFrequency)->get() as $measure)
                                    <li class="list-group-item cursor-pointer @if($this->isSelected($measure->id)) bg-success-500 @endif"
                                        wire:click="measureSelected({{ $measure }})">
                                        {{ $measure->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- nested -->
                    @include('livewire.measure.measure-create-element', ['element' => $item])
                </div>
            </div>
        </div>
    @endforeach
</div>
