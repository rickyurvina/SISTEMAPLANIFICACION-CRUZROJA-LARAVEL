@props(['type' => 'button', 'label' => '', 'icon' => ''])

<button type="{{ $type }}" class="btn btn-sm btn-success">
    <span class="fas {{ $icon }} mr-1"></span>
    {{ $label }}
</button>