@props(['id' => '', 'label' => '', 'required' => '', 'readonly' => '','value'=>''])

<div {{ $attributes }}>
    <label class="form-label {{ $required }}" for="{{ $id }}">{{ $label }}</label>
    <textarea wire:model.defer="{{ $id }}" type="text" id="{{ $id }}" name="{{ $id }}"
              class="form-control @error($id) is-invalid @enderror" {{ $readonly }}></textarea>
    @error($id)
    <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>