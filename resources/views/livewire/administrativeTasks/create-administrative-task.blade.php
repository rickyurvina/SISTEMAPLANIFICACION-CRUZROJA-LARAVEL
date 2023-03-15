<div wire:ignore.self class="modal fade in" id="project-create-administrative-task" tabindex="-1" role="dialog"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4">{{ __('general.poa_create_activity_title') }} Administrativa</h5>
                <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <x-form.modal.text id="name" label="{{ trans('general.name')}}"
                                       class="form-group col-12 required"
                                       placeholder="{{ __('general.form.enter', ['field' => __('general.name')]) }}">
                    </x-form.modal.text>
                    <x-form.modal.select id="user_id" class="form-group col-4 required"
                                         label="Asignado a">
                        <option value="">{{ __('general.form.select.field', ['field' => __('general.responsible')]) }}</option>
                        @foreach($users as $item)
                            <option value="{{ $item->id }}">{{ $item->getFullName() }}</option>
                        @endforeach
                    </x-form.modal.select>
                    <x-form.modal.select id="priority" class="col-4 required" label="Prioridad">
                        <option value="">{{ trans('general.form.select.field', ['field' => trans('general.priority')]) }}</option>
                        @foreach(\App\Models\AdministrativeTasks\AdministrativeTask::PRIORITIES  as $item)
                            <option value="{{$item}}"> {{$item}}</option>
                        @endforeach
                    </x-form.modal.select>
                    <div class="form-group col-4 required">
                        <label class="form-label required" for="start_date">{{ trans('general.start_date') }}</label>
                        <div class="input-group">
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

                    <x-form.modal.select id="frequency_number" label="{{ trans('general.frequency_number') }}"
                                         class="col-3">
                        <option value="">{{ trans('general.form.select.field', ['field' => trans('general.frequency_number')]) }}</option>
                        @for($i=1; $i<=29;$i++)
                            <option value={{$i}}>{{$i}}</option>
                        @endfor
                    </x-form.modal.select>
                    <x-form.modal.text type="date" id="frequency_limit" label="{{ __('general.frequency_limit') }}"
                                       class="form-group col-3">
                    </x-form.modal.text>
                    <x-form.modal.textarea id="description"
                                           label="{{ __('general.description') }}"
                                           class="form-group col-12">
                    </x-form.modal.textarea>

                    <div class="form-group col-12">
                        <livewire:components.list-view title="Lista de Comprobación"
                                                       event="subTaskAdded"
                        />
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <x-form.modal.footer wirecancelevent="resetForm" wiresaveevent="submitTask"></x-form.modal.footer>
            </div>
        </div>
    </div>
</div>
