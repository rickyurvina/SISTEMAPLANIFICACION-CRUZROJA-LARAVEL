@props(['id' => '', 'label' => '', 'items' => [], 'key' => 'name', 'actual' => []])

<div class="form-group required col-6">
    <label class="form-label">{{ $label }}</label>
    @foreach($items as $item)
        <div class="custom-control custom-checkbox">
            <input id="{{ $id . $loop->index }}" type="checkbox" name="{{ $id.'[]' }}" value="{{ $item->id }}"
                   class="custom-control-input @error($id) is-invalid @enderror {{ ($errors->has('validated') && !$errors->has($id)) ? 'is-valid':'' }}"
                    {{ collect($actual)->contains($item->id) ? 'checked':'' }} >
            <label for="{{ $id . $loop->index }}" class="custom-control-label">{{ $item->{$key} }}</label>
            <div class="invalid-feedback">{{ $errors->first($id) }}</div>
        </div>
    @endforeach
    {{ old('items') }}
</div>