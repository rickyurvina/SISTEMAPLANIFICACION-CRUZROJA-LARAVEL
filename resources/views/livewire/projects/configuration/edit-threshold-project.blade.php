<div>
    <div wire:ignore.self class="modal fade" id="edit_threshold" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 70rem;">
            @if($threshold)
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">{{trans('general.edit').' '. trans_choice('general.thresholds',1)}} {{$threshold->id}}</h5>
                        <button wire:click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th colspan="2" class="text-center text-primary">{{trans('general.estimated_time')}}</th>
                                    <th colspan="2" class="text-center text-primary">{{trans('general.progress')}}</th>
                                </tr>
                                <tr>
                                    <th>{{trans('general.min')}}</th>
                                    <th>{{trans('general.max')}}</th>
                                    <th>{{trans('general.min')}}</th>
                                    <th>{{trans('general.max')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="w-25">
                                        <div>
                                            <div class="input-group">
                                                <input type="text" step="0.01" min="0" wire:model.defer="timeMin" id="timeMin"
                                                       class="form-control @error('timeMin') is-invalid @enderror">
                                                @error('timeMin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </td>
                                    <td class="w-25">
                                        <div>
                                            <div class="input-group">
                                                <input type="text" step="0.01" min="0" wire:model.defer="timeMax" id="timeMax"
                                                       class="form-control @error('timeMax') is-invalid @enderror">
                                                @error('timeMax')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </td>
                                    <td class="w-25">
                                        <div>
                                            <div class="input-group">
                                                <input type="text" step="0.01" min="0" wire:model.defer="progressMin" id="progressMin"
                                                       class="form-control @error('progressMin') is-invalid @enderror">
                                                @error('progressMin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </td>
                                    <td class="w-25">
                                        <div>
                                            <div class="input-group">
                                                <input type="text" step="0.01" min="0" wire:model.defer="progressMax" id="progressMax"
                                                       class="form-control @error('progressMax') is-invalid @enderror">
                                                @error('progressMax')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="justify-content-center">
                        <div class="card-footer text-center">
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-outline-secondary mr-1" wire:click="closeModal"  data-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                                    </button>
                                    <button wire:click="edit" class="btn btn-primary" >
                                        <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
