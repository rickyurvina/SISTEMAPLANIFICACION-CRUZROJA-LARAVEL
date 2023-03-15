<div class="modal fade default-example-modal-right-lg projectUpdate-modal-right" data-toggle="registerAdvance"
     id="registerAdvance" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-right modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4"><i class="fas fa-plus-circle text-success"></i> {{trans('indicators.indicator.register_advance')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            @if($sumGoals>0)
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-lg-4 ">
                                    <label class="form-label" for="code">{{ trans('general.code') }} {{ trans_choice('general.indicators', 1) }}</label>
                                    <label class="form-label" for="code">{{ $code }}</label>
                                </div>
                                <div class="form-group col-lg-4 ">
                                    <label class="form-label" for="name">{{ trans('general.name') }} {{ trans_choice('general.indicators', 1) }}</label>
                                    <label class="form-label" for="name">{{ $name }}</label>
                                </div>
                                <div class="form-group col-lg-4 ">
                                    <label class="form-label" for="base_line">{{ trans('indicators.indicator.base_line') }}</label>
                                    <label class="form-label" for="base_line">{{ $base_line }}</label>
                                </div>
                                <div class="form-group col-lg-4 ">
                                    <label class="form-label" for="indicator_units_id">{{ trans('indicators.indicator.unit_of_measurement') }}</label>
                                    <div class="input-group bg-white shadow-inset-2">
                                        <label class="form-label" for="name">{{ $this->indicator->indicatorUnit->name }}</label>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4">
                                    <label class="form-label" for="frequency">{{ trans('indicators.indicator.frequency_update') }}</label>
                                    <div class="input-group bg-white shadow-inset-2">
                                        <label class="form-label" for="name">{{ $frequency }}</label>

                                    </div>
                                </div>

                                <div class="form-group col-lg-4">
                                    <label class="form-label" for="frequency">{{ trans('indicators.indicator.goal_value') }}</label>
                                    <div class="input-group bg-white shadow-inset-2">
                                        <h2>{{ $this->goalLabel  }}</h2>
                                    </div>
                                </div>

                            </div>

                            @if(isset($labelPeriod))
                                <div class="input-group bg-white shadow-inset-2">
                                    <div class="col-2 mb-1">
                                        <x-form.inputs.text type="text" label="{{$labelPeriod}}" name="actual_value" id="actual_value" class="mb-0"
                                                            wire:model="actual_value" value="{{$actual_value}}"/>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer text-center">
                            <div class="row">
                                <div class="col-12">
                                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mr-1">
                                        <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                                    </a>
                                    <button class="btn btn-success" wire:click="saveAdvance">
                                        <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-lg-12 ">
                                    <label class="form-label" for="code">{{trans('indicators.indicator.there_are_registered_goals')}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>