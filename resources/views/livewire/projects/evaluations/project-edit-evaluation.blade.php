<div>
    <div wire:ignore.self class="modal fade" id="project-edit-evaluation" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 70rem;">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Crear {{trans('general.evaluation')}}</h5>
                    <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
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

                                <div class="form-group col-md-12" wire:ignore>
                                    <label class="col-form-label col-form-label-sm"><b>{{ trans('general.departments') }}</b></label>
                                    <select class="form-control" multiple="multiple" id="select2-dropdown"></select>
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
                    @if($evaluation)
                        <div class="d-flex flex-wrap" wire:ignore.self>
                            <div class="mt-2 w-50 p-2">
                                <x-label-section>{{ trans('general.comments') }}</x-label-section>
                                <livewire:components.comments :modelId="$evaluation->id" class="\App\Models\Projects\ProjectEvaluation"
                                                              :key="time().$evaluation->id" identifier="evaluations"/>
                            </div>
                            <div class="mt-2 w-50 p-2">
                                <livewire:components.files :modelId="$evaluation->id" model="\App\Models\Projects\ProjectEvaluation" folder="evaluations"/>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="justify-content-center">
                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="col-12">
                                <a class="btn btn-outline-secondary mr-1" wire:click="closeModal">
                                    <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                                </a>
                                <button wire:click="edit" class="btn btn-primary">
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
        document.addEventListener('livewire:load', function (event) {
        @this.on('refreshDropdown', function () {
            let departments = [];

            $.each(@this.existingVariables, function (key, department) {
                departments.push({
                    text: department.name,
                    id: department.id,
                    selected: department.selected
                });
            });

            $('#select2-dropdown')
                .empty()
                .select2({
                    dropdownParent: $("#project-edit-evaluation"),
                    placeholder: "{{ trans('general.select').' '.trans('general.validations') }}",
                    data: departments
                }).on('change', function (e) {
            @this.set('variablesSelect', $(this).val());
            });
        });
        });

    </script>

@endpush