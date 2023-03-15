<div>
    <x-dropdown-simple>
        <x-slot name="trigger">
            @if($defaultValue && $defaultValue['icon'])
                <i class="{{ $defaultValue['icon'] }} fw-700"></i>
            @endif
            <span class="pl-2">{{ $defaultValue['text'] ?? trans('general.none') }}</span>
        </x-slot>

        @foreach($items as $index => $value)
            <div class="dropdown-item" wire:click="$set('newValue', '{{ $index }}')">
                @if($value['icon'])
                    <i class="{{ $value['icon'] }} mx-1 fw-700"></i>
                    <span class=" {{ $value['style'] ?? ''  }}">{{ $value['text'] }}</span>
                @else
                    <span class=" {{ $value['style'] ?? ''  }}">{{ $value['text'] }}</span>
                @endif
            </div>
        @endforeach

    </x-dropdown-simple>
</div>
