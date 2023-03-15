@props(['route' => '', 'label' => '', 'icon' => ''])

<a href="{{ $route }}" {{ $attributes }}>
    <i class="fas {{ $icon }}"></i> {{ $label }}
</a>
