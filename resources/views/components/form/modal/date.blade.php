@props(['id' => '', 'type' => 'text', 'placeholder' => '', 'label' => '', 'value' => '', 'required' => '', 'readonly' => '', 'defer' =>  true])

<div {{ $attributes }}>
  <label class="form-label {{ $required }}" for="{{ $id }}">{{ $label }}</label>
  <input wire:model{{ $defer ? '.defer':'' }}="{{ $id }}" type="date" name="{{ $id }}" id="{{ $id }}"
         class="form-control @error($id) is-invalid @enderror"
         value="{{ $value }}" placeholder="{{ $placeholder }}" {{ $readonly }}>
  <div class="invalid-feedback">{{ $errors->first($id) }}</div>
</div>