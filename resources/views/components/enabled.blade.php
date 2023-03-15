@props(['enabled' => false])

@if ($enabled)
    <span class="badge badge-success badge-pill">{{ trans('general.yes') }}</span>
@else
    <span class="badge badge-danger badge-pill">{{ trans('general.no') }}</span>
@endif