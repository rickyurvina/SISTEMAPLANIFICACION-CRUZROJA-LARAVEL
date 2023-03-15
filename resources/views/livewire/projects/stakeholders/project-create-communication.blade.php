<div>
    <div wire:ignore.self class="modal fade" id="project-create-communication" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 70rem;">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Plan de comunicaciones de {{$project->name}}</h5>
                    <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="panel-content">
                        <div class="row">
                            <div class="form-group col-6">
                                <label class="form-label required" for="contact_approve">{{ trans('general.contact_approve') }}</label>
                                <div class="input-group bg-white shadow-inset-2">
                                    <div class="input-group-prepend">
                                                            <span class="input-group-text bg-transparent border-right-0">
                                                                <i class="fas fa-book-user"></i>
                                                            </span>
                                    </div>
                                    <select wire:model.defer="prj_project_stakeholder_id"
                                            class="custom-select bg-transparent @error('prj_project_stakeholder_id') is-invalid @enderror">
                                        <option value=""
                                                selected>{{ trans('general.form.select.field', ['field' => trans('general.stakeholder')]) }}</option>
                                        @foreach($stakeholders as $item)
                                            <option value="{{ $item->id }}">{{ $item->interested->getFullName() }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">{{ $errors->first('prj_project_stakeholder_id') }}</div>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label class="form-label required" for="responsible_send_information">{{ trans('general.responsible_send_information') }}</label>
                                <div class="input-group bg-white shadow-inset-2 required">
                                    <div class="input-group-prepend">
                                                            <span class="input-group-text bg-transparent border-right-0">
                                                                <i class="fas fa-book-user"></i>
                                                            </span>
                                    </div>
                                    <select wire:model.defer="user_id"
                                            class="custom-select bg-transparent @error('user_id') is-invalid @enderror">
                                        <option value=""
                                                selected>{{ trans('general.form.select.field', ['field' => trans('general.responsible_send_information')]) }}</option>
                                        @foreach($users as $item)
                                            <option value="{{ $item->user->id }}">{{ $item->user->getFullName() }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">{{ $errors->first('user_id') }}</div>
                                </div>
                            </div>
                            <div class="form-group col-6 required">
                                <label class="form-label" for="information_type" required="required">{{ trans('general.information_type') }}</label>
                                <div class="input-group bg-white shadow-inset-2">
                                    <div class="input-group-prepend required">
                                                        <span class="input-group-text bg-transparent border-right-0">
                                                        <i class="fal fa-newspaper"></i>
                                                        </span>
                                    </div>
                                    <input type="text" wire:model.defer="information_type"
                                           class="form-control bg-transparent @error('information_type') is-invalid @enderror"
                                           placeholder="{{ trans('general.form.enter', ['field' => trans('general.information_type')]) }}">
                                    <div class="invalid-feedback">{{ $errors->first('information_type') }}</div>
                                </div>
                            </div>
                            <div class="form-group col-6 required">
                                <label class="form-label" for="format_information_presentation">{{ trans('general.format_information_presentation') }}</label>
                                <div class="input-group bg-white shadow-inset-2">
                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-transparent border-right-0">
                                                        <i class="fal fa-newspaper"></i>
                                                        </span>
                                    </div>
                                    <input type="text" wire:model.defer="format_information_presentation"
                                           class="form-control bg-transparent @error('format_information_presentation') is-invalid @enderror"
                                           placeholder="{{ trans('general.form.enter', ['field' => trans('general.information_type')]) }}">
                                    <div class="invalid-feedback">{{ $errors->first('format_information_presentation') }}</div>
                                </div>
                            </div>
                            <div class="form-group col-3 required">
                                <label class="form-label" for="start_date">{{ trans('general.start_date') }}</label>
                                <div class="input-group bg-white shadow-inset-2">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0">
                                               <i class="fal fa-calendar"></i>
                                            </span>
                                    </div>
                                    <input type="date" wire:model.defer="start_date"
                                           class="form-control bg-transparent @error('start_date') is-invalid @enderror"
                                           placeholder="{{ trans('general.form.enter', ['field' => trans('general.start_date')]) }}">
                                    <div class="invalid-feedback">{{ $errors->first('start_date') }}</div>
                                </div>
                            </div>
                            <div class="form-group col-3 required">
                                <label class="form-label" for="end_date">{{ trans('general.end_date') }}</label>
                                <div class="input-group bg-white shadow-inset-2">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0">
                                              <i class="fal fa-calendar"></i>
                                            </span>
                                    </div>
                                    <input type="date" wire:model.defer="end_date"
                                           class="form-control bg-transparent @error('end_date') is-invalid @enderror"
                                           placeholder="{{ trans('general.form.enter', ['field' => trans('general.end_date')]) }}">
                                    <div class="invalid-feedback">{{ $errors->first('end_date') }}</div>
                                </div>
                            </div>

                            <x-form.modal.select id="frequency" label="{{ trans('general.frequency') }}" class="col-3">
                                <option value="">{{ trans('general.form.select.field', ['field' => trans('general.frequency')]) }}</option>
                                @foreach(\App\Models\Projects\Stakeholders\ProjectCommunicationMatrix::FREQUENCIES as $item)
                                    <option value={{$item}}>{{trans('general.labels.status_'.$item)}}</option>
                                @endforeach
                            </x-form.modal.select>

                            <x-form.modal.select id="frequency_number" label="{{ trans('general.frequency_number') }}" class="col-3">
                                <option value="">{{ trans('general.form.select.field', ['field' => trans('general.frequency_number')]) }}</option>
                                @for($i=1; $i<=29;$i++)
                                    <option value={{$i}}>{{$i}}</option>
                                @endfor
                            </x-form.modal.select>


                            <x-form.modal.text type="date" id="frequency_limit" label="{{ __('general.frequency_limit') }}"
                                               class="form-group col-3">
                            </x-form.modal.text>

                        </div>
                    </div>
                </div>
                <div class="justify-content-center">
                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="col-12">
                                <a class="btn btn-outline-secondary mr-1" wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
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
