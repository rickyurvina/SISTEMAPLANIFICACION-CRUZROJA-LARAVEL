<div wire:ignore.self class="modal fade" id="edit_user_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div wire:ignore class="modal-header bg-primary text-white">
                <h5 class="modal-title">{{ trans('general.edit') }}</h5>
                <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>

            <div class="modal-body">
                <div class="panel-content">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#generalEdit" role="tab"
                               aria-selected="true" wire:ignore.self>
                                <i class="fal fa-user text-primary"></i>
                                <span class="hidden-sm-down ml-1">Información General</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#departamentosEdit" role="tab"
                               aria-selected="false"
                               wire:ignore.self>
                                <i class="fal fa-address-card"></i>
                                <span class="hidden-sm-down ml-1">Departamentos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#aditionalEdit" role="tab" aria-selected="false"
                               wire:ignore.self>
                                <i class="fal fa-address-card"></i>
                                <span class="hidden-sm-down ml-1">Datos Adicionales</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#filesEdit" role="tab" aria-selected="false"
                               wire:ignore.self>
                                <i class="fal fa-address-card"></i>
                                <span class="hidden-sm-down ml-1">Archivos Adjuntos</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content border border-top-0 p-3">
                    <div class="card tab-pane fade show active" id="generalEdit" role="tabpanel" wire:ignore.self>
                        @if($idContactEdit)
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-6 required">
                                            <label class="form-label" for="name">{{ trans('general.names') }}</label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-transparent border-right-0">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                </div>
                                                <input type="text" wire:model.defer="name"
                                                       class="form-control bg-transparent @error('name') is-invalid @enderror"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.names')]) }}"/>
                                                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group col-6 required">
                                            <label class="form-label"
                                                   for="surname">{{ trans('general.surnames') }}
                                            </label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-transparent border-right-0">
                                                        <i class="fas fa-id-card"></i>
                                                    </span>
                                                </div>
                                                <input type="text" wire:model.defer="surname"
                                                       class="form-control bg-transparent @error('surname') is-invalid @enderror"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.surnames')]) }}"/>
                                                <div class="invalid-feedback">{{ $errors->first('surname') }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group col-6 required">
                                            <label class="form-label" for="email">{{ trans('general.email') }}</label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-transparent border-right-0">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                </div>
                                                <input type="email" wire:model.defer="email"
                                                       class="form-control bg-transparent @error('email') is-invalid @enderror"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.email')]) }}"/>
                                                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group col-6 required">
                                            <label class="form-label" for="phone">
                                                {{ trans('general.personal_phone') }}
                                            </label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-transparent border-right-0">
                                                        <i class="fas fa-phone"></i>
                                                    </span>
                                                </div>
                                                <input type="text" wire:model.defer="phone"
                                                       class="form-control bg-transparent @error('phone') is-invalid @enderror"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.personal_phone')]) }}"/>
                                                <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group col-6">
                                            <label class="form-label" for="birth">
                                                {{ trans('general.date_birth') }}
                                            </label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-transparent border-right-0">
                                                        <i class="fas fa-birthday-cake"></i>
                                                    </span>
                                                </div>
                                                <input type="date" wire:model.defer="birth"
                                                       class="form-control bg-transparent"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.date_birth')]) }}"/>
                                            </div>
                                        </div>

                                        <div class="form-group col-6">
                                            <label class="form-label" for="gender">{{ trans('general.gender') }}</label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-transparent border-right-0">
                                                        <i class="fas fa-venus-mars"></i>
                                                    </span>
                                                </div>
                                                <select wire:model.defer="gender" class="custom-select bg-transparent">
                                                    <option value="" selected>
                                                        {{ trans('general.form.select.field', ['field' => trans('general.gender')]) }}
                                                    </option>
                                                    @foreach($genders as $item)
                                                        <option value="{{ $item->code }}">{{ $item->description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-6">
                                            <label class="form-label" for="businessPhone">
                                                {{ trans('general.business_phone') }}
                                            </label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-transparent border-right-0">
                                                        <i class="fas fa-fax"></i>
                                                    </span>
                                                </div>
                                                <input type="text" wire:model.defer="businessPhone"
                                                       class="form-control bg-transparent"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.business_phone')]) }}"/>
                                            </div>
                                        </div>

                                        <div class="form-group col-6">
                                            <label class="form-label"
                                                   for="customSwitch2">{{ trans('general.enabled') }}</label>
                                            <div class="custom-control custom-switch">
                                                <input wire:model="enabled"
                                                       type="checkbox" class="custom-control-input"
                                                       @if ($enabled === true) enabled="true" @endif
                                                       id="customSwitch2"
                                                       value="1">
                                                <label class="custom-control-label" for="customSwitch2"></label>
                                            </div>
                                        </div>

                                        <div class="form-group col-6">
                                            <label class="form-label"
                                                   for="password">{{ trans('general.password') }}</label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-transparent border-right-0">
                                                        <i class="fas fa-key"></i>
                                                    </span>
                                                </div>
                                                <input type="password" wire:model.defer="password"
                                                       class="form-control bg-transparent @error('password') is-invalid @enderror"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.password')]) }}"/>
                                                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group col-6">
                                            <label class="form-label" for="password_confirmation">
                                                {{ trans('auth.password.current_confirm') }}
                                            </label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-transparent border-right-0">
                                                        <i class="fas fa-key"></i>
                                                    </span>
                                                </div>
                                                <input type="password" wire:model.defer="password_confirmation"
                                                       class="form-control bg-transparent @error('password_confirmation') is-invalid @enderror"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('auth.password.current_confirm')]) }}"/>
                                                <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group col-6">
                                            <label class="form-label">{{ trans_choice('general.roles', 0) }}</label>
                                            @foreach($userRolesIds as $rol)
                                                <div>
                                                    <input wire:model="userRolesIds.{{ $loop->index }}.selected"
                                                           id="{{ 'roles' . $loop->index }}" type="checkbox"
                                                           value="{{ $rol['id'] }}"/>
                                                    <label for="{{ 'roles' . $loop->index }}">{{ $rol['name'] }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="form-group col-12">
                                            <label class="form-label" for="photo">{{ trans('general.photo') }}</label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-transparent border-right-0">
                                                        <i class="fas fa-image"></i>
                                                    </span>
                                                </div>
                                                <input type="file" wire:model="photo"
                                                       class="form-control bg-transparent"
                                                       placeholder="{{ trans('general.form.enter', ['field' => trans('general.photo')]) }}"/>
                                            </div>
                                        </div>

                                        <div class="form-group col-12">
                                            <label class="form-label" for="personalNotes">
                                                {{ trans('general.personal_notes') }}
                                            </label>
                                            <textarea wire:model.defer="personalNotes" rows="3"
                                                      class="form-control bg-transparent">
                                            </textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="card tab-pane fade" id="departamentosEdit" role="tabpanel" wire:ignore.self>
                        <div class="card-body pt-0">
                            <div class="w-100 mx-auto">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label class="form-label" for="gender">{{ trans('general.companies') }}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                    <i class="fas fa-building"></i>
                                                </span>
                                            </div>
                                            <select wire:model.defer="idCompany" wire:change="companySelection"
                                                    class="custom-select bg-transparent @error('idCompany') is-invalid @enderror">
                                                <option value="" selected>
                                                    {{ trans('general.form.select.field', ['field' => trans('general.companies')]) }}
                                                </option>
                                                @foreach($companies as $item)
                                                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">{{ $errors->first('idCompany') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label class="form-label">{{ trans('general.department') }}</label>
                                        @if( isset($idCompany))
                                            @foreach($userDepartmentsIds as $department)
                                                <div>
                                                    <input wire:model="userDepartmentsIds.{{ $loop->index }}.selected"
                                                            id="{{ 'departments' . $loop->index }}" type="checkbox"
                                                            value="{{ $department['id'] }}"
                                                            class="@error('userDepartmentsIds') is-invalid @enderror"/>
                                                    <label for="{{ 'departments' . $loop->index }}">{{ $department['name'] }}</label>
                                                    <div class="invalid-feedback">{{ $errors->first('userDepartmentsIds') }}</div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <button class="btn btn-primary" wire:click="addDepartment">
                                        <i class="fas fa-plus pr-2"></i> {{ trans('general.add') }}
                                    </button>
                                </div>
                            </div>

                            <div class="frame-wrap">
                                <table class="table m-0">
                                    <thead>
                                    <tr>
                                        <th>{{ __('general.companies') }}</th>
                                        <th>{{ __('general.department') }}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($companyDepartments as $item)
                                        <tr>
                                            <td>{{ $item['company'] }}</td>
                                            <td>{{ $item['department'] }}</td>
                                            <td><span wire:click="removeCompanyDepartment('{{ $item['department'] }}')"
                                                      class="cursor-pointer trash"><i class="fas fa-trash
                                                text-danger"></i></span></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card tab-pane fade" id="aditionalEdit" role="tabpanel" wire:ignore.self>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label class="form-label"
                                           for="jobTitle">{{ trans('general.job_title') }}</label>
                                    <div class="input-group bg-white shadow-inset-2">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                    <i class="fas fa-user-graduate"></i>
                                                </span>
                                        </div>
                                        <input type="text" wire:model.defer="jobTitle"
                                               class="form-control bg-transparent"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('general.job_title')]) }}">
                                    </div>
                                </div>

                                <div class="form-group col-6">
                                    <label class="form-label"
                                           for="employerCost">{{ trans('general.employer_cost') }}</label>
                                    <div class="input-group bg-white shadow-inset-2">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                    <i class="far fa-dollar-sign"></i>
                                                </span>
                                        </div>
                                        <input type="text" wire:model.defer="employerCost"
                                               class="form-control bg-transparent"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('general.employer_cost')]) }}">
                                    </div>
                                </div>

                                <div class="form-group col-6">
                                    <label class="form-label"
                                           for="contractType">{{ trans('general.contract_type') }}</label>
                                    <div class="input-group bg-white shadow-inset-2">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                    <i class="far fa-file-contract"></i>
                                                </span>
                                        </div>
                                        <input type="text" wire:model.defer="contractType"
                                               class="form-control bg-transparent"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('general.contract_type')]) }}">
                                    </div>
                                </div>

                                <div class="form-group col-3">
                                    <label class="form-label"
                                           for="contractStart">{{ trans('general.contract_start') }}</label>
                                    <div class="input-group bg-white shadow-inset-2">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                        </div>
                                        <input type="date" wire:model.defer="contractStart"
                                               class="form-control bg-transparent"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('general.contract_start')]) }}">
                                    </div>
                                </div>

                                <div class="form-group col-3">
                                    <label class="form-label"
                                           for="contractEnd">{{ trans('general.contract_end') }}</label>
                                    <div class="input-group bg-white shadow-inset-2">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                        </div>
                                        <input type="date" wire:model.defer="contractEnd"
                                               class="form-control bg-transparent"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('general.contract_end')]) }}">
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label class="form-label"
                                           for="workExperience">{{ trans('general.work_experience') }}</label>
                                    <textarea wire:model.defer="workExperience" rows="3"
                                              class="form-control bg-transparent">
                                                </textarea>
                                </div>

                                <div class="form-group col-4">
                                    <livewire:components.list-view title="{{ __('general.competencies') }}"
                                                                   event="competenceEdited"
                                                                   componentId="competence"
                                                                   :elementss="$competenceItems"
                                    />
                                </div>

                                <div class="form-group col-4">
                                    <livewire:components.list-view title="{{ __('general.working_skills') }}"
                                                                   event="skillEdited"
                                                                   componentId="skill"
                                                                   :elementss="$skillItems"
                                    />
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card tab-pane fade" id="filesEdit" role="tabpanel" wire:ignore.self>
                        <div class="card-body pt-0">
                            <div class="w-75 mx-auto">
                                <div class="row">
                                    <div class="form-group col-12 pl-2 pt-4">
                                        <x-fileupload
                                                wire:model.defer="fileEdit"
                                                allowRevert
                                                allowRemove
                                                allowFileSizeValidation
                                                maxFileSize="4mb"></x-fileupload>
                                        @error('fileEdit')
                                        <div class="alert alert-danger fade show" role="alert">
                                            {{__('general.file_required')}}
                                        </div>
                                        @enderror

                                    </div>
                                </div>
                                <div class="row">

                                    <div class="form-group col-6">
                                        <label class="form-label"
                                               for="filecoments">{{ trans('general.observations') }}</label>
                                        <textarea wire:model.defer="observationEdit" rows="1" id="filecoments"
                                                  class="form-control bg-transparent @error('observation') is-invalid @enderror"></textarea>
                                        <div class="invalid-feedback">{{ $errors->first('observation') }}</div>
                                    </div>

                                    <div class="form-group col-4">
                                        <label class="form-label" for="date">{{ trans('general.date') }}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <input class="form-control @error('date') is-invalid @enderror" id="date"
                                                   type="month" name="date"
                                                   wire:model.defer="date">
                                            <div class="invalid-feedback">{{ $errors->first('date') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-2 pt-4">
                                        <button class="btn btn-primary" wire:click="addEditFile">
                                            <i class="fas fa-plus pr-2"></i> {{ trans('general.add') }}
                                        </button>
                                    </div>

                                </div>
                            </div>

                            <div class="frame-wrap">
                                <table class="table m-0">
                                    <thead>
                                    <tr>
                                        <th>{{ __('general.file_name') }}</th>
                                        <th>{{ __('general.observations') }}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($filesEdit as $item)
                                        @if(!$item['delete'])
                                            <tr>
                                                <td>{{ $item['name'] }}</td>
                                                <td>{{ $item['observation'] }}</td>
                                                <td><span wire:click="removeEditFile('{{ $item['name'] }}')"
                                                          class="cursor-pointer trash"><i class="fas fa-trash
                                                text-danger"></i></span></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-secondary" wire:click="closeModal"><i
                            class="fas fa-times"></i> {{ trans('general.cancel') }}</button>
                <button class="btn btn-primary" wire:click="update">
                    <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                </button>
            </div>
        </div>
    </div>
</div>
@push('page_script')
    <script>
        document.addEventListener('livewire:load', function (event) {
        @this.on('refreshDropdown', function () {
            let companies = [];
            $.each(@this.existingCompanies, function (key, company) {
                companies.push({
                    text: company.name,
                    id: company.id,
                    selected: company.selected
                });
            });
            $('#editCompanies')
                .empty()
                .select2({
                    dropdownParent: $("#edit_user_modal"),
                    placeholder: "{{ trans('general.select') }}",
                    data: companies
                }).on('change', function (e) {
            @this.set('companySelect', $(this).val());
            });
        });
        });

        $('#defaultIndeterminate').prop('indeterminate', true)

        var toggleCheckbox = function () {
            $('#js-checkbox-toggle').toggleText('Change to CIRCLE', 'Change back to default');
            $('.frame-wrap .custom-checkbox').toggleClass('custom-checkbox-circle');
        }

        var toggleRadio = function () {
            $('#js-radio-toggle').toggleText('Change to ROUNDED', 'Change back to default');
            $('.frame-wrap .custom-radio').toggleClass('custom-radio-rounded');
        }
    </script>
@endpush