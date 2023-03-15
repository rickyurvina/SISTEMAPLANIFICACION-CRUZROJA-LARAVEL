@props(['name' => ''])

<button type="button" {{ $attributes }}>
    {{ $slot }}{{ $name }}
</button>