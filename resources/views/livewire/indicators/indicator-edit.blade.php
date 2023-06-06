<div wire:ignore.self class="modal fade" id="indicator-edit-modal" tabindex="-1" role="dialog" aria-hidden="true"
     data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-center modal-xl">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header bg-primary color-white">
                    <h5 class="modal-title h4"> {{ trans('indicators.indicator.edit_indicator') }}</h5>
                    <button type="button" wire:click="resetForm" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <fieldset>
                        <div class="card-body">
                            <div class="row">
                                @include('indicator.indicator.form.basic_data')
                                @include('indicator.indicator.form.behaviour')
                                @if($type===\App\Models\Indicators\Indicator\Indicator::TYPE_MANUAL)
                                    @include('indicator.indicator.form.type_manual')
                                @else
                                    @include('indicator.indicator.form.type_grouped')
                                @endif
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="card-footer text-center">
                    <div class="row">
                        <div class="col-12">
                            <a wire:click="resetForm" href="javascript:void(0);" class="btn btn-outline-secondary mr-1" data-dismiss="modal">
                                <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                            </a>
                            <button class="btn btn-primary" wire:click="editIndicator">
                                <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('page_script')
    <script>
        Livewire.on('toggleIndicatorEditModal', () => $('#indicator-edit-modal').modal('toggle'));
    </script>
@endpush