@props(['route' => '', 'label' => '', 'icon' => ''])

<a href="{{ $route }}" class="btn btn-success btn-sm">
    <i class="fas {{ $icon }}"></i> {{ $label }}
</a>
