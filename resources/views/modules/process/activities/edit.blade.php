@extends('modules.process.processes.process')
@section('title', __('general.edit'))
@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0">
        <li class="breadcrumb-item">
            <a href="{{ route('processes.index') }}">
                Gerencias
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('process.showProcess', $activity->process->department_id) }}">
                {{ trans_choice('process.process',1) .' de '.  $activity->process->department->name }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('process.showActivities',[$activity->process->id, $page]) }}">
                {{ trans_choice('process.process',0) .': '.$activity->process->name }}
            </a>
        </li>
        <li class="breadcrumb-item active" style="overflow: unset"> {{ $activity->name }}</li>
    </ol>
@endsection
@section('process-page')
    <div class="d-flex flex-column">
        <div class="d-flex flex-nowrap">
            <div class="flex-grow-1 w-50" style="overflow: hidden auto">
                <div class="pl-2 content-detail mt-2">
                    <div class="d-flex flex-wrap w-100">
                        <x-label-detail>{{__('general.code')}}:</x-label-detail>
                        <div class="detail">
                            <livewire:components.input-inline-edit :modelId="$activity->id"
                                                                   class="\App\Models\Process\Activity"
                                                                   field="code"
                                                                   :rules="'required|max:5|alpha_num|alpha_dash|unique:process_activities,code,' . $activity->id . ',id,process_id,' . $activity->process_id. ',deleted_at,NULL'"
                                                                   type="text"
                                                                   defaultValue="{{ $activity->code ?? ''}}"
                                                                   :key="time().$activity->id"/>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap w-100">
                        <x-label-detail>{{__('general.name')}}:</x-label-detail>
                        <div class="detail">
                            <livewire:components.input-inline-edit :modelId="$activity->id"
                                                                   class="\App\Models\Process\Activity"
                                                                   field="name"
                                                                   :rules="'required|max:200'"
                                                                   type="text"
                                                                   defaultValue="{{ $activity->name ?? ''}}"
                                                                   :key="time().$activity->id"/>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">
                        <x-label-detail>{{ trans('general.generated_service')}}</x-label-detail>
                        <div class="detail">
                            <livewire:components.select-inline-edit :modelId="$activity->id"
                                                                    :fieldId="$activity->generated_service_id"
                                                                    class="\App\Models\Process\Activity"
                                                                    field="generated_service_id"
                                                                    value="{{ $activity->generatedService->name ??'' }}"
                                                                    :selectClass="$generated_services"
                                                                    selectField="name"
                                                                    selectRelation="generatedService"
                                                                    canBeNull="true"
                                                                    :key="time().$activity->id"/>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap w-100">
                        <x-label-detail>{{__('general.expected_result')}}:</x-label-detail>
                        <div class="detail">
                            <livewire:components.input-inline-edit :modelId="$activity->id"
                                                                   class="\App\Models\Process\Activity"
                                                                   field="expected_result"
                                                                   :rules="'required|max:500'"
                                                                   type="textarea"
                                                                   rows="5"
                                                                   defaultValue="{{ $activity->expected_result ?? ''}}"
                                                                   :key="time().$activity->id"/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="flex-grow-1 w-50" style="overflow: hidden auto">
                <div class="pl-2 content-detail mt-2">
                    <div class="d-flex flex-wrap w-100">
                        <x-label-detail>{{__('general.specs')}}:</x-label-detail>
                        <div class="detail">
                            <livewire:components.input-inline-edit :modelId="$activity->id"
                                                                   class="\App\Models\Process\Activity"
                                                                   field="specifications"
                                                                   defaultValue="{{ $activity->specifications ?? ''}}"
                                                                   :rules="'max:500'"
                                                                   type="textarea"
                                                                   rows="5"
                                                                   :key="time().$activity->id"/>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap w-100">
                        <x-label-detail>{{__('general.cares')}}:</x-label-detail>
                        <div class="detail">
                            <livewire:components.input-inline-edit :modelId="$activity->id"
                                                                   class="\App\Models\Process\Activity"
                                                                   field="cares"
                                                                   defaultValue="{{ $activity->cares ?? ''}}"
                                                                   :rules="'max:500'"
                                                                   type="textarea"
                                                                   rows="5"
                                                                   :key="time().$activity->id"/>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap w-100">
                        <x-label-detail>{{__('general.procedures')}}:</x-label-detail>
                        <div class="detail">
                            <livewire:components.input-inline-edit :modelId="$activity->id"
                                                                   class="\App\Models\Process\Activity"
                                                                   field="procedures"
                                                                   defaultValue="{{ $activity->procedures ?? ''}}"
                                                                   :rules="'max:500'"
                                                                   type="textarea"
                                                                   rows="5"
                                                                   :key="time().$activity->id"/>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap w-100">
                        <x-label-detail>{{__('general.equipment')}}:</x-label-detail>
                        <div class="detail">
                            <livewire:components.input-inline-edit :modelId="$activity->id"
                                                                   class="\App\Models\Process\Activity"
                                                                   field="equipment"
                                                                   defaultValue="{{ $activity->equipment ?? ''}}"
                                                                   :rules="'max:500'"
                                                                   type="textarea"
                                                                   rows="5"
                                                                   :key="time().$activity->id"/>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap w-100">
                        <x-label-detail>{{__('general.supplies')}}:</x-label-detail>
                        <div class="detail">
                            <livewire:components.input-inline-edit :modelId="$activity->id"
                                                                   class="\App\Models\Process\Activity"
                                                                   field="supplies"
                                                                   defaultValue="{{ $activity->supplies ?? ''}}"
                                                                   :rules="'max:500'"
                                                                   type="textarea"
                                                                   rows="5"
                                                                   :key="time().$activity->id"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
