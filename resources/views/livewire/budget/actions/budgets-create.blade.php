<div wire:ignore.self class="modal fade fade" id="budgets-create" tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4"><i class="fas fa-plus-circle text-success"></i> {{ trans('general.add_new') . ' ' . trans_choice('budget.budget', 1) }}</h5>
                    <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <form method="post" autocomplete="off" wire:submit.prevent="submit()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label class="form-label" for="year">{{ trans('general.year') }}</label><br>
                                <input type="text" wire:model.defer="year" id="year" class="form-control @error('year') is-invalid @enderror">
                                @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label class="form-label" for="description">{{ trans('general.description') }}</label>
                                <input type="text" wire:model.defer="description" id="description" class="form-control @error('description') is-invalid @enderror">
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <x-form.modal.footer wirecancelevent="resetForm"></x-form.modal.footer>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('page_script')
    <script>

    </script>
@endpush