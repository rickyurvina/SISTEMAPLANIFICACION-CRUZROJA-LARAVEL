<div>
    <div wire:ignore.self class="modal fade in" id="edit-non-conformity-action" tabindex="-1" role="dialog"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary color-white">
                    <h5 class="modal-title h4">{{ __('general.edit_template_strategy') }} {{__('general.action')}}</h5>
                    <button wire:click="updateIndex" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($action)
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-nowrap">
                                <div class="flex-grow-1 w-100" style="overflow: hidden auto">
                                    <div class="pl-2 content-detail">
                                        <div class="d-flex flex-wrap w-100">
                                            <x-label-detail>{{__('general.name')}}:</x-label-detail>
                                            <div class="detail">
                                                <livewire:components.input-inline-edit :modelId="$action->id"
                                                                                       class="{{\App\Models\Process\NonConformitiesActions::class}}"
                                                                                       field="name"
                                                                                       :rules="'required|max:200'"
                                                                                       type="text"
                                                                                       event="actionCreated"
                                                                                       defaultValue="{{ $action->name ?? ''}}"
                                                                                       :key="time().$action->id"/>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap">
                                            <x-label-detail>{{ trans('general.responsible') }}</x-label-detail>
                                            <div class="detail">
                                                <livewire:components.dropdown-user :modelId="$action->id"
                                                                                   modelClass="{{\App\Models\Process\NonConformitiesActions::class}}"
                                                                                   field="user_id"
                                                                                   event="activityCreated"
                                                                                   :key="time().$action->id"
                                                                                   :user="$action->responsible"/>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap w-50 mt-2">
                                            <x-label-detail>{{trans('general.start_date')}}</x-label-detail>
                                            <div class="detail">
                                                <livewire:components.date-inline-edit :modelId="$action->id"
                                                                                      class="{{\App\Models\Process\NonConformitiesActions::class}}"
                                                                                      field="start_date" type="date"
                                                                                      event="startDateModified"
                                                                                      :rules="'required|before:'.$action->end_date"
                                                                                      defaultValue="{{$action->start_date ? $action->start_date->format('Y M d'): 'Seleccione Fecha'}}"
                                                                                      :key="time().$action->id"
                                                />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap w-50 mt-2">
                                            <x-label-detail>{{trans('general.end_date')}}</x-label-detail>
                                            <div class="detail">
                                                <livewire:components.date-inline-edit :modelId="$action->id"
                                                                                      class="{{\App\Models\Process\NonConformitiesActions::class}}"
                                                                                      field="end_date" type="date"
                                                                                      event="endDateModified"
                                                                                      :rules="'required|after:'.$action->start_date"
                                                                                      defaultValue="{{$action->end_date ? $action->end_date->format('Y M d'): 'Seleccione Fecha'}}"
                                                                                      :key="time().$action->id"
                                                />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap w-50 mt-2">
                                            <x-label-detail>{{trans('general.implantation_date')}}</x-label-detail>
                                            <div class="detail">
                                                <livewire:components.date-inline-edit :modelId="$action->id"
                                                                                      class="{{\App\Models\Process\NonConformitiesActions::class}}"
                                                                                      field="implantation_date" type="date"
                                                                                      event="activityCreated"
                                                                                      :rules="'required|date'"
                                                                                      defaultValue="{{$action->implantation_date ? $action->implantation_date->format('Y M d'): 'Seleccione Fecha'}}"
                                                                                      :key="time().$action->id"
                                                />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap w-50 mt-2">
                                            <x-label-detail>{{trans('general.status')}}</x-label-detail>
                                            <div class="detail">
                                                <livewire:components.select-inline-edit :modelId="$action->id"
                                                                                        class="{{\App\Models\Process\NonConformitiesActions::class}}"
                                                                                        field="status"
                                                                                        value="{{$action->status ?? ''}}"
                                                                                        :selectArray="\App\Models\Process\NonConformitiesActions::STATUES"
                                                                                        event="statusModified"
                                                                                        :key="time().$action->id"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-12">
                                <livewire:components.files :modelId="$action->id"
                                                           model="{{\App\Models\Process\NonConformitiesActions::class}}"
                                                           folder="non_conformity_action"
                                                           event="fileAdded"
                                />
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <span class="fs-2x w-40px"><i class="fal fa-comment-dots"></i></span>
                                    <span class="fs-2x fw-700">Observaciones</span>
                                </div>

                                <livewire:components.comments :modelId="$action->id"
                                                              class="{{\App\Models\Process\NonConformitiesActions::class}}"
                                                              identifier="non_conformity_action"
                                                              :key="time().$action->id"/>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
