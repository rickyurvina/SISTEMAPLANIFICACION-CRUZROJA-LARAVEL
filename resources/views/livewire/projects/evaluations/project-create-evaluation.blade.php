<div>
    <div wire:ignore.self class="modal fade" id="project-create-evaluation" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 70rem;">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">{{__('general.create')}} {{trans('general.evaluation')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="row">
                                <div class="form-group col-md-12 col-sm-12 required">
                                    <label class="form-label" for="name">{{ trans('general.name') }}</label><br>
                                    <input type="text" wire:model.defer="name" id="name" class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-group col-12 required">
                                    <label class="form-label"
                                           for="causes">{{ trans('general.methodology') }}</label>
                                    <textarea wire:model.defer="methodology" rows="3"
                                              class="form-control bg-transparent @error('methodology') is-invalid @enderror">
                                            </textarea>
                                    <div class="invalid-feedback">{{ $errors->first('methodology') }}</div>
                                </div>
                                <div class="form-group col-12 required">
                                    <label class="form-label"
                                           for="systematization">{{ trans('general.systematization') }}</label>
                                    <textarea wire:model.defer="systematization" rows="3"
                                              class="form-control bg-transparent @error('systematization') is-invalid @enderror">
                                            </textarea>
                                    <div class="invalid-feedback">{{ $errors->first('systematization') }}</div>
                                </div>
                                <div class="form-group col-12 required" wire:ignore>
                                    <label class="form-label" for="variables">{{ trans('general.variables') }}</label>
                                    <div class="detail ml-2">
                                        <select class="form-control select2-hidden-accessible" multiple="" id="select-subsidiary">
                                            @foreach(\App\Models\Projects\ProjectEvaluation::VARIABLES as $variable)
                                                <option value="{{$variable}}" data-select2-id="{{$variable}}">{{$variable}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <x-form.modal.select id="phase" label="{{ trans('general.phase') }}" class="col-6">
                                    <option value="">{{ trans('general.form.select.field', ['field' => trans('general.phase')]) }}</option>
                                    @foreach(\App\Models\Projects\ProjectEvaluation::PHASES as $phase)
                                        <option value="{{$phase}}"> {{$phase}}</option>
                                    @endforeach
                                </x-form.modal.select>

                                <x-form.modal.select id="state" label="{{ trans('general.state') }}" class="col-6">
                                    <option value="">{{ trans('general.form.select.field', ['field' => trans('general.state')]) }}</option>
                                    @foreach(\App\Models\Projects\ProjectEvaluation::STATES as $state)
                                        <option value="{{$state}}"> {{$state}}</option>
                                    @endforeach
                                </x-form.modal.select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="col-12">
                                <a class="btn btn-outline-secondary mr-1" wire:click="closeModal">
                                    <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                                </a>
                                <button wire:click="create" class="btn btn-primary">
                                    <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('page_script')
    <script>
        $(document).ready(function () {
            $('#select-subsidiary').select2({
                placeholder: "{{ trans('general.select') }}",
                dropdownParent: $("#project-create-evaluation")

            }).on('change', function (e) {
            @this.set('variablesSelect', $(this).val());
            });

        });
    </script>

@endpush