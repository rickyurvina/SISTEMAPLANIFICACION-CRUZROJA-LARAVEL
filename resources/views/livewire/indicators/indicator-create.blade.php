<div>
    <div
            x-data="{
                show: @entangle('show'),
                type: @entangle('type')
            }"
            x-init="$watch('show', value => {
            if (value) {
                $('#indicator-create-modal').modal('show')
            } else {
                $('#indicator-create-modal').modal('hide');
            }
        })"
            x-on:keydown.escape.window="show = false"
            x-on:close.stop="show = false"
    >
        <div wire:ignore.self class="modal fade" id="indicator-create-modal" tabindex="-1" role="dialog" aria-hidden="true"
             data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-center modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary color-white">
                        <h5 class="modal-title h4">{{ trans('indicators.indicator.create_indicator')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" x-on:click="show = false">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
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
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary mr-1" x-on:click="show = false">
                            <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                        </button>
                        <button class="btn btn-primary" wire:click="save">
                            <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
