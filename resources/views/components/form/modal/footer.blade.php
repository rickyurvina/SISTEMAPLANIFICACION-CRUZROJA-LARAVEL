@props(['wirecancelevent' => '', 'wiresaveevent' => ''])

<div class="card-footer text-muted py-2 text-center">
    <a wire:click="{{ $wirecancelevent }}" href="javascript:void(0);" class="btn btn-outline-secondary mr-1" data-dismiss="modal">
        <i class="fas fa-times"></i> {{ trans('general.cancel') }}
    </a>
    <button wire:click="{{ $wiresaveevent }}" type="submit" class="btn btn-primary">
        <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
    </button>
</div>