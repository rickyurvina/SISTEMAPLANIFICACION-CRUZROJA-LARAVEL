@props(['id' => '', 'label' => '', 'enabled' => false])

<div class="form-group col-6 required">
    <label class="form-label" for="">{{ $label }}</label>
    <div class="frame-wrap mb-0">
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-success waves-effect waves-themed {{ $enabled ? 'active':'' }}">
                <input type="radio" name="{{ $id }}" id="option1" {{ $enabled ? 'checked="checked"':'' }} value="1"> {{ trans('general.yes') }}
            </label>
            <label class="btn btn-danger waves-effect waves-themed {{ !$enabled ? 'active':'' }}">
                <input type="radio" name="{{ $id }}" id="option2" {{ !$enabled ? 'checked="checked"':'' }} value="0"> {{ trans('general.no') }}
            </label>
        </div>
    </div>
</div>