@props(['name' => ''])

<button type="button" {{ $attributes }} data-toggle="modal">
    {{ $slot }}{{ $name }}
</button>
