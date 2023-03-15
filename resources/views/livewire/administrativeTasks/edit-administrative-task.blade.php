<div wire:ignore.self class="modal fade in" id="project-edit-administrative-task" tabindex="-1" role="dialog"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4">Editar Actividad Administrativa</h5>
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
                    <x-form.modal.select id="status" class="col-4" label="Estado">
                        <option value="">{{ trans('general.form.select.field', ['field' => trans('general.status')]) }}</option>
                        @foreach(\App\Models\AdministrativeTasks\AdministrativeTask::STATUSES  as $item)
                            <option value="{{$item}}"> {{$item}}</option>
                        @endforeach
                    </x-form.modal.select>
                    <div class="form-group col-4 required">
                        <label class="form-label" for="start_date">{{ trans('general.start_date') }}</label>
                        <div class="input-group">
                            <input type="date" wire:model.defer="start_date"
                                   class="form-control bg-transparent @error('start_date') is-invalid @enderror"
                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.start_date')]) }}">
                            <div class="invalid-feedback">{{ $errors->first('start_date') }}</div>
                        </div>
                    </div>

                    <div class="form-group col-4 required">
                        <label class="form-label" for="end_date">{{ trans('general.end_date') }}</label>
                        <div class="input-group">
                            <input type="date" wire:model.defer="end_date"
                                   class="form-control bg-transparent @error('end_date') is-invalid @enderror"
                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.end_date')]) }}">
                            <div class="invalid-feedback">{{ $errors->first('end_date') }}</div>
                        </div>
                    </div>
                    <x-form.modal.textarea id="description"
                                           label="{{ __('general.description') }}"
                                           class="form-group col-12">
                    </x-form.modal.textarea>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="mt-2">
                            <label>Lista de Comprobación: </label>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar"
                                     style="width: {{$advanceSubTasks}}%"
                                     aria-valuenow="{{$advanceSubTasks}}" aria-valuemin="0"
                                     aria-valuemax="100">{{$advanceSubTasks}}%
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($activitySubTasks)
                        <div class="col-12 mt-1 mb-1">
                            @foreach($activitySubTasks as $subTask)
                                <div class="d-flex flex-wrap">
                                    <div class="custom-control custom-checkbox w-75">
                                        <input type="checkbox" id="subTasks.{{$subTask->id}}"
                                               wire:model="subTasks.{{$subTask->id}}"
                                               value="{{$subTask->id}}">
                                        <label for="subTasks.{{$subTask->id}}">{{substr($subTask->name,0,10)}}</label>
                                    </div>
                                    <a class="ml-auto" href="javascript:void(0)"
                                       wire:click="deleteSubTask({{$subTask->id}})">
                                        <i class="fas fa-trash mr-1 text-danger" data-toggle="tooltip"
                                           data-placement="top"
                                           title="" data-original-title="Eliminar"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="form-group col-12">
                        <livewire:components.list-view title="Lista de Comprobación"
                                                       event="subTaskAdded"
                        />
                    </div>
                    @if($task)
                        <div class="col-12">
                            <div class="mt-2">
                                <livewire:components.files :modelId="$task->id"
                                                           model="\App\Models\AdministrativeTasks\AdministrativeTask"
                                                           folder="administrativeTasks"/>
                            </div>
                            <div class="mt-2">
                                <x-label-section>{{ trans('general.comments') }}</x-label-section>
                                <livewire:components.comments :modelId="$task->id"
                                                              class="\App\Models\AdministrativeTasks\AdministrativeTask"
                                                              :key="time().$task->id"
                                                              identifier="administrativeTasks"/>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <x-form.modal.footer wirecancelevent="resetForm" wiresaveevent="updateTask"></x-form.modal.footer>
            </div>
        </div>
    </div>
</div>
