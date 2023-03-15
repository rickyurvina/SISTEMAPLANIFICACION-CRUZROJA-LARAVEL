@props(['id' => '', 'label' => '', 'multiple'])

<div {{ $attributes->merge(['class' => 'form-group']) }}>
    <label class="form-label required" for="{{ $id }}">{{ $label }}</label>
    <select name="{{ $multiple ? $id . '[]':$id  }}" id="{{ $id }}" class="form-control @error($id) is-invalid @enderror"
            {{ $multiple ? 'multiple="multiple"':''  }}>
        {{ $slot }}
    </select>
    <div class="invalid-feedback">{{ $errors->first($id) }}</div>
</div>

@push('page_script')
    <script>
        $("#{{ $id  }}").select2({
            placeholder: "{{ trans('general.select') }}"
        });
    </script>
@endpush