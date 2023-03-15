<div>
    <div wire:ignore.self class="modal fade" id="project-create-lesson" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 70rem;">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Crear Lección Aprendida</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-6 required">
                            <label class="form-label"
                                   for="background">{{ trans('general.background') }}</label>
                            <textarea wire:model.defer="background" rows="3"
                                      class="form-control bg-transparent @error('background') is-invalid @enderror">
                        </textarea>
                            <div class="invalid-feedback">{{ $errors->first('background') }}</div>
                        </div>
                        <div class="form-group col-6 required">
                            <label class="form-label"
                                   for="causes">{{ trans('general.causes') }}</label>
                            <textarea wire:model.defer="causes" rows="3"
                                      class="form-control bg-transparent @error('causes') is-invalid @enderror">
                                            </textarea>
                            <div class="invalid-feedback">{{ $errors->first('causes') }}</div>
                        </div>
                        <div class="form-group col-6 required">
                            <label class="form-label"
                                   for="learned_lesson">{{ trans('general.learned_lesson') }}</label>
                            <textarea wire:model.defer="learned_lesson" rows="3"
                                      class="form-control bg-transparent @error('learned_lesson') is-invalid @enderror">
                                            </textarea>
                            <div class="invalid-feedback">{{ $errors->first('learned_lesson') }}</div>
                        </div>
                        <div class="form-group col-6 required">
                            <label class="form-label"
                                   for="corrective_lesson">{{ trans('general.corrective_lesson') }}</label>
                            <textarea wire:model.defer="corrective_lesson" rows="3"
                                      class="form-control bg-transparent @error('corrective_lesson') is-invalid @enderror">
                                            </textarea>
                            <div class="invalid-feedback">{{ $errors->first('personalNotes') }}</div>
                        </div>
                        <div class="form-group col-6 required">
                            <label class="form-label"
                                   for="evidences">{{ trans('general.evidences') }}</label>
                            <textarea wire:model.defer="evidences" rows="3"
                                      class="form-control bg-transparent @error('evidences') is-invalid @enderror">
                                            </textarea>
                            <div class="invalid-feedback">{{ $errors->first('evidences') }}</div>
                        </div>
                        <div class="form-group col-6 required">
                            <label class="form-label"
                                   for="recommendations">{{ trans('general.recommendations') }}</label>
                            <textarea wire:model.defer="recommendations" rows="3"
                                      class="form-control bg-transparent @error('recommendations') is-invalid @enderror">
                                            </textarea>
                            <div class="invalid-feedback">{{ $errors->first('recommendations') }}</div>
                        </div>

                        <x-form.modal.select id="type" label="{{ trans('general.type') }}" class="col-6">
                            <option value="">{{ trans('general.form.select.field', ['field' => trans('general.type')]) }}</option>
                            <option value="{{\App\Models\Projects\Project::TYPE_SUCCESS}}"> {{\App\Models\Projects\Project::TYPE_SUCCESS}}</option>
                            <option value="{{\App\Models\Projects\Project::TYPE_DANGER}}"> {{\App\Models\Projects\Project::TYPE_DANGER}}</option>
                        </x-form.modal.select>

                        <x-form.modal.select id="knowledge" label="{{ trans('general.knowledge') }}" class="col-6">
                            <option value="">{{ trans('general.form.select.field', ['field' => trans('general.knowledge')]) }}</option>
                            @foreach(\App\Models\Projects\ProjectLearnedLessons::KNOWLEDGE_AREAS  as $area)
                                <option value="{{$area}}"> {{$area}}</option>
                            @endforeach
                        </x-form.modal.select>
                    </div>


                </div>
                <div class="justify-content-center">
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
