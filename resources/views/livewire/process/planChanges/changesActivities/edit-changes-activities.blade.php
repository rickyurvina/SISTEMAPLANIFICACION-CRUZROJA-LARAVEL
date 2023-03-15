<div wire:ignore.self class="modal fade in" id="edit-change-activity" tabindex="-1" role="dialog"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary color-white">
                <h5 class="modal-title h4">{{ __('general.edit_template_strategy') }} {{__('general.activity')}}</h5>
                <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                @if($changeActivity)
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-nowrap">
                            <div class="flex-grow-1 w-100" style="overflow: hidden auto">
                                <div class="pl-2 content-detail">
                                    <div class="d-flex flex-wrap w-100">
                                        <x-label-detail>{{__('general.code')}}:</x-label-detail>
                                        <div class="detail">
                                            <livewire:components.input-inline-edit :modelId="$changeActivity->id"
                                                                                   class="\App\Models\Process\ChangesActivities"
                                                                                   field="code"
                                                                                   type="text"
                                                                                   :rules="'required|max:5|alpha_num|alpha_dash|unique:process_plan_changes_activities,code,' . $changeActivity->id . ',id,process_plan_changes_id,' . $changeActivity->process_plan_changes_id. ',deleted_at,NULL'"
                                                                                   event="activityCreated"
                                                                                   defaultValue="{{ $changeActivity->code ?? ''}}"
                                                                                   :key="time().$changeActivity->id"/>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap w-100">
                                        <x-label-detail>{{__('general.name')}}:</x-label-detail>
                                        <div class="detail">
                                            <livewire:components.input-inline-edit :modelId="$changeActivity->id"
                                                                                   class="\App\Models\Process\ChangesActivities"
                                                                                   field="name"
                                                                                   :rules="'required|max:200'"
                                                                                   type="text"
                                                                                   event="activityCreated"
                                                                                   defaultValue="{{ $changeActivity->name ?? ''}}"
                                                                                   :key="time().$changeActivity->id"/>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <x-label-detail>{{ trans('general.responsible') }}</x-label-detail>
                                        <div class="detail">
                                            <livewire:components.dropdown-user :modelId="$changeActivity->id"
                                                                               modelClass="\App\Models\Process\ChangesActivities"
                                                                               field="user_id"
                                                                               event="activityCreated"
                                                                               :key="time().$changeActivity->id"
                                                                               :user="$changeActivity->responsible"/>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap w-100 mt-2">
                                        <x-label-detail>{{trans('general.start_date')}}</x-label-detail>
                                        <div class="detail">
                                            <livewire:components.date-inline-edit :modelId="$changeActivity->id"
                                                                                  class="\App\Models\Process\ChangesActivities"
                                                                                  field="start_date" type="date"
                                                                                  event="activityCreated"
                                                                                  :rules="'required|before:'.$changeActivity->end_date"
                                                                                  defaultValue="{{$changeActivity->start_date ? $changeActivity->start_date->format('Y M d'): 'Seleccione Fecha'}}"
                                                                                  :key="time().$changeActivity->id"
                                            />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap w-100 mt-2">
                                        <x-label-detail>{{trans('general.end_date')}}</x-label-detail>
                                        <div class="detail">
                                            <livewire:components.date-inline-edit :modelId="$changeActivity->id"
                                                                                  class="\App\Models\Process\ChangesActivities"
                                                                                  field="end_date" type="date"
                                                                                  event="activityCreated"
                                                                                  :rules="'required|after:'.$changeActivity->start_date"
                                                                                  defaultValue="{{$changeActivity->end_date ? $changeActivity->end_date->format('Y M d'): 'Seleccione Fecha'}}"
                                                                                  :key="time().$changeActivity->id"
                                            />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap w-100">
                                        <x-label-detail>{{__('general.description')}}:</x-label-detail>
                                        <div class="detail">
                                            <livewire:components.input-inline-edit :modelId="$changeActivity->id"
                                                                                   class="\App\Models\Process\ChangesActivities"
                                                                                   field="description"
                                                                                   :rules="'required|max:500'"
                                                                                   type="description"
                                                                                   rows="5"
                                                                                   event="activityCreated"
                                                                                   defaultValue="{{ $changeActivity->description ?? ''}}"
                                                                                   :key="time().$changeActivity->id"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-12">
                            <livewire:components.files :modelId="$changeActivity->id"
                                                       model="\App\Models\Process\ChangesActivities"
                                                       folder="change_activity"
                                                       event="fileAdded"
                            />
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <span class="fs-2x w-40px"><i class="fal fa-comment-dots"></i></span>
                                <span class="fs-2x fw-700">Observaciones</span>
                            </div>

                            <livewire:components.comments :modelId="$changeActivity->id"
                                                          class="\App\Models\Process\ChangesActivities"
                                                          identifier="change_activity"
                                                          :key="time().$changeActivity->id"/>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
