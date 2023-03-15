<div>
    <div wire:ignore.self class="modal fade in" id="update-threshold" data-backdrop="static" data-keyboard="false" tabindex="-1"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary color-white">
                    <h5 class="modal-title h4">{{ trans('general.create').' '.trans_choice('general.sources', 2)  }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="far fa-times color-white"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($threshold)
                        <div class="row">
                            <x-form.modal.text id="name" label="{{ __('general.name') }}" required="required"
                                               class="form-group col-6 required"
                                               placeholder="{{ __('general.form.enter', ['field' => __('general.name')]) }}">
                            </x-form.modal.text>

                            <div class="row col-lg-12 col-md-12">
                                <div class="col-sm-12 col-lg-12">
                                    <table id="dt-basic-example" class="table table-bordered table-striped w-100 dataTable no-footer dtr-inline" role="grid"
                                           aria-describedby="dt-basic-example_info">
                                        <thead>
                                        <tr>
                                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic-example" rowspan="1" colspan="3">
                                                <h3>{{trans('threshold.form.upward')}}</h3></th>
                                        </tr>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1" colspan="1">
                                                <span class="form-label badge badge-primary badge-pill"></span></th>
                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1" colspan="1">{{ trans('general.min') }}</th>
                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1" colspan="1">{{ trans('general.max') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr id="1" role="row" class="add">
                                            <td class="dtr-control">
                                                <span class="form-label badge badge-danger badge-pill">{{trans('threshold.form.unacceptable')}}</span>
                                            </td>
                                            <td class="dtr-control">
                                                <label>{{trans('indicators.indicator.less_or_equal_to')}}</label>
                                            </td>
                                            <td class="dtr-control">
                                                <input type="number" readonly name="maxAD" id="maxAD" class="border-0" value="{{$maxAD}}">
                                            </td>
                                        </tr>
                                        <tr id="1" role="row" class="add">
                                            <td class="dtr-control">
                                                <span class="form-label badge badge-warning badge-pill">{{trans('threshold.form.alert')}}</span>
                                            </td>
                                            <td class="dtr-control">
                                                <input type="number" name="minAW" min="0" pattern="^[0-9]+" id="minAW" onkeyup="PasarValor();"
                                                       class="form-control border-left-0 bg-transparent pl-0 @error('minAW') is-invalid @enderror"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.min')]) }}" wire:model.lazy="minAW">
                                            </td>
                                            <td class="dtr-control">
                                                <input type="number" name="maxAW" min="0" pattern="^[0-9]+" id="maxAW" onkeyup="PasarValor();"
                                                       class="form-control border-left-0 bg-transparent pl-0 @error('maxAW') is-invalid @enderror"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.max')]) }}" wire:model.lazy="maxAW">
                                            </td>
                                        </tr>
                                        <tr id="1" role="row" class="add">
                                            <td class="dtr-control">
                                                <span class="badge badge-success badge-pill">{{trans('threshold.form.acceptable')}}</span>
                                            </td>
                                            <td class="dtr-control">
                                                <label>{{trans('indicators.indicator.greater_or_equal_to')}}</label>
                                            </td>
                                            <td class="dtr-control">
                                                <input type="number" id="minAS" name="minAS" readonly class="border-0" value="{{$minAS}}">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row col-lg-12 col-md-12">
                                <div class="col-sm-12">
                                    <table id="dt-basic-example" class="table table-bordered table-striped w-100 dataTable no-footer dtr-inline" role="grid"
                                           aria-describedby="dt-basic-example_info">
                                        <thead>
                                        <tr>
                                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic-example" rowspan="1" colspan="3">
                                                <h3>{{trans('threshold.form.Falling')}}</h3></th>
                                        </tr>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1" colspan="1">
                                                <span class="form-label badge badge-primary badge-pill"></span></th>
                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1" colspan="1">{{ trans('general.min') }}</th>
                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1" colspan="1">{{ trans('general.max') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr id="1" role="row" class="add">
                                            <td class="dtr-control">
                                                <span class="form-label badge badge-danger badge-pill">{{trans('threshold.form.unacceptable')}}</span>
                                            </td>
                                            <td class="dtr-control">
                                                <label>{{trans('indicators.indicator.less_or_equal_to')}}</label>
                                            </td>
                                            <td class="dtr-control">
                                                <input type="number" readonly name="maxDD" id="maxDD" class="border-0" value="{{$maxDD}}">
                                            </td>
                                        </tr>
                                        <tr id="1" role="row" class="add">
                                            <td class="dtr-control">
                                                <span class="form-label badge badge-warning badge-pill">{{trans('threshold.form.alert')}}</span>
                                            </td>
                                            <td class="dtr-control">
                                                <input type="number" required name="minDW" min="0" pattern="^[0-9]+" id="minDW" onkeyup="PasarValor();"
                                                       class="form-control border-left-0 bg-transparent pl-0 @error('minDW') is-invalid @enderror"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.min')]) }}" wire:model.lazy="minDW">
                                            </td>
                                            <td class="dtr-control">
                                                <input type="number" required name="maxDW" min="0" pattern="^[0-9]+" id="maxDW" onkeyup="PasarValor();"
                                                       class="form-control border-left-0 bg-transparent pl-0 @error('maxDW') is-invalid @enderror"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.max')]) }}" wire:model.lazy="maxDW">
                                            </td>
                                        </tr>

                                        <tr id="1" role="row" class="add">
                                            <td class="dtr-control">
                                                <span class="badge badge-success badge-pill">{{trans('threshold.form.acceptable')}}</span>
                                            </td>
                                            <td class="dtr-control">
                                                <label>{{trans('indicators.indicator.greater_or_equal_to')}}</label>
                                            </td>
                                            <td class="dtr-control">
                                                <input type="number" readonly name="minDS" id="minDS" class="border-0" value="{{$minDS}}">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row col-lg-12 col-md-12">
                                <div class="col-sm-12">
                                    <table id="dt-basic-example" class="table table-bordered table-striped w-100 dataTable no-footer dtr-inline" role="grid"
                                           aria-describedby="dt-basic-example_info">
                                        <thead>
                                        <tr>
                                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic-example" rowspan="1" colspan="3">
                                                <h3>{{trans('threshold.form.tolerance_band')}}</h3></th>
                                        </tr>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1" colspan="1">
                                                <span class="form-label badge badge-primary badge-pill"></span></th>
                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1" colspan="1">{{ trans('general.min') }}</th>
                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1" colspan="1">{{ trans('general.max') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr id="1" role="row" class="add">
                                            <td class="dtr-control">
                                                <span class="form-label badge badge-danger badge-pill">{{trans('threshold.form.unacceptable')}}</span>
                                            </td>
                                            <td class="dtr-control">
                                                <label>{{trans('indicators.indicator.less_or_equal_to')}}</label>
                                            </td>
                                            <td class="dtr-control">
                                                <input type="number" readonly name="maxTD" id="maxTD" class="border-0" value="{{$maxTD}}">
                                            </td>
                                        </tr>
                                        <tr id="1" role="row" class="add">
                                            <td class="dtr-control">
                                                <span class="form-label badge badge-warning badge-pill">{{trans('threshold.form.alert')}}</span>
                                            </td>
                                            <td class="dtr-control">
                                                <input type="number" required name="minTW" min="0" pattern="^[0-9]+" id="minTW" onkeyup="PasarValor();"
                                                       class="form-control border-left-0 bg-transparent pl-0 @error('minTW') is-invalid @enderror"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.min')]) }}" wire:model.lazy="minTW">
                                            </td>
                                            <td class="dtr-control">
                                                <input type="number" required name="maxTW" min="0" pattern="^[0-9]+" id="maxTW" onkeyup="PasarValor();"
                                                       class="form-control border-left-0 bg-transparent pl-0 @error('maxTW') is-invalid @enderror"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.max')]) }}" wire:model.lazy="maxTW">
                                            </td>
                                        </tr>
                                        <tr id="1" role="row" class="add">
                                            <td class="dtr-control">
                                                <span class="badge badge-success badge-pill">{{trans('threshold.form.acceptable')}}</span>
                                            </td>
                                            <td class="dtr-control">
                                                <label>{{trans('indicators.indicator.greater_or_equal_to')}}</label>
                                            </td>
                                            <td class="dtr-control">
                                                <input type="number" readonly name="minTS" id="minTS" class="border-0" value="{{$minTS}}">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <br>
                        <div class="justify-content-center">
                            <x-form.modal.footer wirecancelevent="resetForm" wiresaveevent="save"></x-form.modal.footer>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>