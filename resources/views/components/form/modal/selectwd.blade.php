@props(['id' => '', 'label' => '', 'required' => '', 'wireevent' => ''])

<div {{ $attributes }}>
    <label class="form-label {{ $required }}" for="{{ $id }}">{{ $label }}</label>
    <select wire:model="{{ $id }}" {{ $wireevent }} name="{{ $id }}" id="{{ $id }}"
            class="form-control custom-select @error($id) is-invalid @enderror">
        {{ $slot }}
    </select>
    @error($id)
    <div class="invalid-feedback">{{ $errors->first($id) }}</div> @enderror
</div>