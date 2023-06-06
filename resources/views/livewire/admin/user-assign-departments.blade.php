<div wire:ignore.self class="modal fade" id="user_assign_departments" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg   modal-dialog-centered" role="document">
        <div class="modal-content">
            <div wire:ignore class="modal-header bg-primary text-white">
                <h5 class="modal-title">{{ trans('general.edit') }}</h5>
                <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="w-100 mx-auto">
                    <div class="row">
                        <div class="form-group col-6">
                            <label class="form-label" for="gender">{{ trans_choice('general.companies',1) }}</label>
                            <div class="input-group bg-white shadow-inset-2">
                                <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                    <i class="fas fa-building"></i>
                                                </span>
                                </div>
                                <select wire:model.defer="idCompany" wire:change="companySelection"
                                        class="custom-select bg-transparent @error('idCompany') is-invalid @enderror">
                                    <option value="" selected>
                                        {{ trans('general.form.select.field', ['field' => trans_choice('general.companies',1)]) }}
                                    </option>
                                    @foreach($companies as $item)
                                        <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-6">
                            <label class="form-label">{{ trans_choice('general.department',1) }}</label>
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
                            <th>{{ trans_choice('general.companies',1) }}</th>
                            <th>{{ trans_choice('general.department',1) }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($companyDepartments as $index => $item)
                            <tr>
                                <td>{{ $item['company'] }}</td>
                                <td>{{ $item['department'] }}</td>
                                <td><span wire:click="removeCompanyDepartment('{{ $index }}')"
                                          class="cursor-pointer trash"><i class="fas fa-trash
                                                text-danger"></i></span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-secondary" wire:click="resetForm" data-dismiss="modal" aria-label="Close"><i
                            class="fas fa-times"></i> {{ trans('general.cancel') }}</button>
                <button class="btn btn-primary" wire:click="update">
                    <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                </button>
            </div>
        </div>
    </div>
</div>
