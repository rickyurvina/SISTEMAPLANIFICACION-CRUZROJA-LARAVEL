<div>
    <x-dropdown-simple>
        <x-slot name="trigger">
            <span class="pl-2">{{ $defaultValue ?? trans('general.none') }}</span>
        </x-slot>

        @foreach($items as $index => $value)
            <div class="dropdown-item" wire:click="$set('newValue', '{{ $index }}')">
                <span>{{ $value }}</span>
            </div>
        @endforeach

    </x-dropdown-simple>
</div>
