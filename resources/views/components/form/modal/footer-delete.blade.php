@props(['delete' => ''])

<div class="row">
    <div class="col-12">
        <a href="#" class="btn btn-outline-secondary mr-1" data-dismiss="modal">
            <i class="fas fa-times"></i> {{ trans('general.cancel') }}
        </a>
        @if($delete)
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-window-close pr-2"></i> {{ trans('general.delete') }}
            </button>
        @endif
    </div>
</div>
