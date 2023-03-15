@props(['urlBack' => url()->previous()])

<div class="card-footer text-center">
    <div class="row">
        <div class="col-12">
            <a href="{{ $urlBack }}" class="btn btn-outline-secondary mr-1">
                <i class="fas fa-times"></i> {{ trans('general.cancel') }}
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
            </button>
        </div>
    </div>
</div>