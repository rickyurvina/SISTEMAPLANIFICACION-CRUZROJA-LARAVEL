<div>
    <div wire:ignore.self class="modal fade" id="project-edit-validation" tabindex="-1" role="dialog" aria-hidden="true"
         data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 70rem;">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Actualizar Validación</h5>
                    <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <x-label-section>{{$state ?? ''}}</x-label-section>
                            <hr>
                        </div>
                        <div class="form-group col-12 required">
                            <label class="form-label" for="departments">Departamentos</label>
                            <div class="detail ml-2">
                                @if($departments)
                                    <select class="form-control select2-hidden-accessible" multiple=""
                                            id="select-department">
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ in_array($department->id, $existingDepartments) ? 'selected':'' }}>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-12">
                            <label class="form-label" for="relations">Relaciones</label>
                            <div class="detail ml-2">
                                @if($relations)
                                    <select class="form-control select2-hidden-accessible" multiple=""
                                            id="select-relations">
                                        @foreach($relations as $relation)
                                            <option value="{{ $relation }}" {{ in_array($relation, $existingRelations) ? 'selected':'' }}>{{trans('general.'.$relation) }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-12">
                            <label class="form-label" for="fields">Campos</label>
                            <div class="detail ml-2">
                                @if($tableFields)
                                    <select class="form-control select2-hidden-accessible" multiple=""
                                            id="select-fields">
                                        @foreach($tableFields as $field)
                                            <option value="{{ $field}}" {{ in_array($field, $existingFields) ? 'selected':'' }}>{{ trans('general.'.$field)}}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="justify-content-center">
                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="col-12">
                                <a class="btn btn-outline-secondary mr-1" wire:click="resetForm" type="button"
                                   class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                                </a>
                                <button wire:click="save" class="btn btn-primary">
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
            $('#select-department').select2({
                placeholder: "{{ trans('general.select') }}",
                dropdownParent: $("#project-edit-validation")

            }).on('change', function (e) {
            @this.set('departmentsSelect', $(this).val());
            });

            $('#select-relations').select2({
                placeholder: "{{ trans('general.select') }}",
                dropdownParent: $("#project-edit-validation")

            }).on('change', function (e) {
            @this.set('relationsSelect', $(this).val());
            });

            $('#select-fields').select2({
                placeholder: "{{ trans('general.select') }}",
                dropdownParent: $("#project-edit-validation")

            }).on('change', function (e) {
            @this.set('fieldsSelect', $(this).val());
            });

        });
        document.addEventListener('livewire:load', function (event) {
        @this.on('refreshDropdown', function () {
            $('#select-department').select2({
                placeholder: "{{ trans('general.select') }}",
                dropdownParent: $("#project-edit-validation")

            }).on('change', function (e) {
            @this.set('departmentsSelect', $(this).val());
            });

            $('#select-relations').select2({
                placeholder: "{{ trans('general.select') }}",
                dropdownParent: $("#project-edit-validation")

            }).on('change', function (e) {
            @this.set('relationsSelect', $(this).val());
            });

            $('#select-fields').select2({
                placeholder: "{{ trans('general.select') }}",
                dropdownParent: $("#project-edit-validation")

            }).on('change', function (e) {
            @this.set('fieldsSelect', $(this).val());
            });
        });
        });
    </script>

@endpush
