<div>
    <div wire:ignore.self class="modal fade" id="project-create-rescheduling" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 70rem;">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Solicitar Reprogramación</h5>
                    <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-12 required">
                            <label class="form-label"
                                   for="description">{{ trans('general.description') }}</label>
                            <textarea wire:model.defer="description" rows="3"
                                      class="form-control bg-transparent @error('description') is-invalid @enderror">
                        </textarea>
                            <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                        </div>
                        <div class="col-12">
                            <x-label-section>Indicar la Fase y Estado a la que desea vovler</x-label-section>
                        </div>

                        <x-form.modal.select id="phase" label="{{ trans('general.phase') }}" class="col-6" wire:model="phase">
                            <option value="">{{ trans('general.form.select.field', ['field' => trans('general.phase')]) }}</option>
                            @foreach(\App\Models\Projects\Project::PHASES  as $item)
                                <option value="{{$item::label()}}"> {{$item::label()}}</option>
                            @endforeach
                        </x-form.modal.select>

                        <x-form.modal.select id="state" label="{{ trans('general.state') }}" class="col-6">
                            <option value="">{{ trans('general.form.select.field', ['field' => trans('general.state')]) }}</option>
                            @foreach($arrayStates  as $area)
                                <option value="{{$area::label()}}"> {{$area::label()}}</option>
                            @endforeach
                        </x-form.modal.select>
                    </div>


                </div>
                <div class="justify-content-center">
                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="col-12">
                                <a class="btn btn-outline-secondary mr-1" wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
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
