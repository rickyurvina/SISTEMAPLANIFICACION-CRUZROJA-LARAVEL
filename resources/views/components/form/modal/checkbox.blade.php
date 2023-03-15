@props(['id' => '', 'id_value' => '', 'label' => '', 'value' => '', 'disabled' => ''])

<div {{ $attributes }}>
    <div class="custom-control custom-switch">
        <input wire:model="{{ $id }}" type="checkbox" class="custom-control-input" id="{{ $id }}"
               @if($id_value) checked @endif value="{{ $value }}" {{ $disabled }}>
        <label class="custom-control-label" for="{{ $id }}">
            {{ $label }}
        </label>
    </div>
</div>