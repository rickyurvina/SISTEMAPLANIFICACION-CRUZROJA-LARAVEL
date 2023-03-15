@props(['id' => '', 'label' => ''])

<div {{ $attributes->merge(['class' => 'form-group']) }}>
  <label class="form-label" for="{{ $id }}">{{ $label }}</label>
  <select name="{{ $id }}" id="{{ $id }}" class="form-control custom-select @error($id) is-invalid @enderror"
  {{ ($errors->has('validated') && !$errors->has($id)) ? 'is-valid':'' }}">
  {{ $slot }}
  </select>
  @error($id)
  <div class="invalid-feedback">{{ $errors->first($id) }}</div> @enderror
</div>