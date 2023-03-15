<div class="d-flex flex-wrap mt-1">
    <x-label-section>Sub Tareas</x-label-section>
    <div class="ml-auto mr-3">
        <a href="javascript:void(0);" class="color-black"
           wire:click="$set('showAddActivity', true)">
            <i class="fal fa-plus fa-1x"></i>
        </a>
    </div>
</div>
<div class="d-flex flex-wrap mt-1">
    <div class="w-75">
        <div class="progress">
            <div class="progress-bar progress-bar-striped bg-success"
                 role="progressbar"
                 style="width: {{$progressBarSubActiviites}}%"
                 aria-valuenow="{{$progressBarSubActiviites}}"
                 aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
    <span class="ml-auto fs-1x fw-500 mr-2" style="color: rgb(107, 119, 140)">{{$progressBarSubActiviites}} % Hecho</span>
</div>
@foreach($activitiesTask->take($countActivityTasks) as $index => $activityTask)
    <div id="panel-15.{{$index}}.{{$activityTask->id}}" class="panel panel-collapsed"
         wire:key="{{time().$index.$activityTask->id}}" wire:ignore>
        <div class="panel-hdr text-primary">
            <h2>
                <span class="icon-stack fs-xxl mr-2">
                    <i class="base base-7 icon-stack-3x opacity-100 color-primary-500"></i>
                    <i class="base base-7 icon-stack-2x opacity-100 color-primary-300"></i>
                    <i class="fal  fa-tasks  icon-stack-1x opacity-100 color-white fa-spin"></i>
                </span>
                {{$activityTask->code}}
                <span class="fw-300">
                    <i>{{  substr($activityTask->name,0,50)}}</i>
                </span>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed"
                        data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10"
                        data-original-title="{{trans('general.edit')}}"><i class="fal fa-edit"></i></button>
                <button class="btn btn-panel fs-xl w-auto h-auto rounded-0 waves-effect waves-themed"
                        data-toggle="tooltip" data-offset="0,10"
                        wire:click="deleteSubTaskActivity({{ $activityTask->id }})"
                        data-original-title="{{trans('general.delete')}}"><i class="fal fa-trash text-danger"></i></button>
            </div>
        </div>
        <div class="panel-container collapse">
            <div class="panel-content">
                <div class="pl-2 content-detail">
                    <div class="d-flex flex-wrap" wire:key="{{time().$activityTask->state}}}" wire:ingore.self>
                        <x-label-detail>{{trans('general.close')}}</x-label-detail>
                        <div class="custom-control custom-checkbox custom-control-inline mt-1">
                            <input type="checkbox" class="custom-control-input" id="state{{$activityTask->id}}"
                                   wire:click="updateStateSubTask({{$activityTask->id}})"
                                   @if($activityTask->state==\App\Models\Projects\Activities\ActivityTask::STATE_CLOSED) checked @endif >
                            <label class="custom-control-label" for="state{{$activityTask->id}}"></label>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">
                        <x-label-detail>{{trans('general.code')}}</x-label-detail>
                        <div class="detail">
                            <livewire:components.input-text
                                    :modelId="$activityTask->id"
                                    class="\App\Models\Projects\Activities\ActivityTask"
                                    field="code"
                                    :rules="'required|max:5|alpha_num|alpha_dash'"
                                    :key="time().$activityTask->id"
                                    defaultValue="{{ $activityTask->code }}"/>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">
                        <div class="d-flex w-25">
                            <x-label-detail>{{trans('general.name')}}</x-label-detail>
                        </div>
                        <div class="d-flex w-75">
                            <livewire:components.input-text
                                    :modelId="$activityTask->id"
                                    class="\App\Models\Projects\Activities\ActivityTask"
                                    field="name"
                                    :rules="'required|max:250|min:3'"
                                    :key="time().$activityTask->id"
                                    defaultValue="{{ $activityTask->name }}"/>
                        </div>
                    </div>
                    @if($project->phase instanceof  \App\States\Project\Implementation)
                        <div class="d-flex flex-wrap">
                            <x-label-detail>{{trans('general.status')}}</x-label-detail>
                            <div class="detail">
                                <livewire:components.dropdown-simple
                                        :modelId="$activityTask->id"
                                        modelClass="\App\Models\Projects\Activities\ActivityTask"
                                        :values="\App\Models\Projects\Activities\ActivityTask::STATUSES_DD"
                                        field="status"
                                        :key="time().$activityTask->id"
                                        selfEventEmited="statusUpdatedSubActivity"
                                        :defaultValue="\App\Models\Projects\Activities\ActivityTask::STATUSES_DD[$activityTask->status]"
                                />
                            </div>
                        </div>
                    @endif
                    <div class="d-flex flex-wrap">
                        <x-label-detail>{{trans('general.responsible')}}</x-label-detail>
                        <div class="detail">
                            <livewire:components.dropdown-user
                                    :modelId="$activityTask->id"
                                    modelClass="\App\Models\Projects\Activities\ActivityTask"
                                    field="user_id"
                                    :user="$activityTask->user"
                                    :usersAdd="$users"
                                    event="notifyUser"
                                    :key="time().$activityTask->id"
                            />
                        </div>
                    </div>
                    <div class="d-flex flex-wrap w-100">
                        <div class="detail">
                            <livewire:components.files-in-modal :modelId="$activityTask->id"
                                                                model="\App\Models\Projects\Activities\ActivityTask"
                                                                folder="subTasks"
                                                                event="fileAdded"
                                                                :key="time().$activityTask->id"

                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
@if($activitiesTask->count()>=$countActivityTasks && $activitiesTask->count()>0)
    <div class="d-flex frame-wrap mt-1">
        <div class="col-12">
            <div class="p-3 text-center">
                <a href="javascript:void(0);"
                   wire:click="chargeActivityTask"
                   class="btn-link font-weight-bold">{{trans('general.see_more')}}
                    ({{$activitiesTask->count()-$countActivityTasks}})</a>
            </div>
        </div>
    </div>
@endif
@if($showAddActivity)
    <div class="d-flex flex-wrap" wire:ignore.self>
        <div class="input-group" style="width: 85% !important;">
            <input type="text"
                   class="form-control col-2 @error($codeActivityTask) is-invalid @enderror"
                   placeholder="{{ trans('general.code') }}"
                   id="name-f"
                   wire:model.defer="codeActivityTask">
            <input type="text"
                   class="form-control @error($nameActivityTask) is-invalid @enderror"
                   placeholder="{{ trans('general.name') }}"
                   id="name-l"
                   wire:model.defer="nameActivityTask">
        </div>
        <div class="w-10 mt-1 pl-2">
            <a href="javascript:void(0);"
               wire:click="saveActivityTask({{$task->id}})">
                <i class="fal fa-plus fa-2x color-success-700 mr-2"></i>
            </a>
            <a href="javascript:void(0);"
               wire:click="$set('showAddActivity', false)">
                <i class="fal fa-times fa-2x color-black"></i>
            </a>
        </div>
        @if($errors)
            <div class="row w-100">
                <div class="col-2">
                    @error('codeActivityTask')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-10">
                    @error('nameActivityTask')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        @endif
    </div>
@endif