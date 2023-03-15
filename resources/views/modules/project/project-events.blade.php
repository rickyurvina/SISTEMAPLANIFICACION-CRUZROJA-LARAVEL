@extends('modules.project.project')

@section('project-page')
    @can('view-events-project')
        <div class="p-2">
            <div class="panel-1" style="display: contents">
                @if($project->statusChanges())
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-2 content-detail"><span class="fw-700">{{ trans('general.from') }}</span>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-2 content-detail"><span class="fw-700">{{ trans('general.to') }}</span>
                            </div>
                            <div class="col-4 content-detail"><span
                                        class="fw-700">{{ trans('general.updated_by') }}</span></div>
                            <div class="col-3 content-detail"><span class="fw-700">{{ trans('general.date') }}</span>
                            </div>
                        </div>
                        @foreach($project->statusChanges() as $change)
                            <div class="row mb-2">
                                <div class="col-2">
                                    <span class="badge {{ \App\Models\Projects\Project::statusColor($change->properties->get('old')['status']) }} mr-3">
                                        {{ $change->properties->get('old')['status'] }}
                                    </span>
                                </div>
                                <div class="col-1"><i class="fas fa-arrow-right color-success-500"></i></div>
                                <div class="col-2">
                                    <span class="badge {{ \App\Models\Projects\Project::statusColor($change->properties->get('attributes')['status']) }}">
                                        {{ $change->properties->get('attributes')['status'] }}
                                    </span>
                                </div>
                                <div class="col-4">
                                    <span class="mr-2">
                                        <img src="{{ asset_cdn('img/user.svg') }}" class="rounded-circle width-1">
                                    </span>
                                    {{ $change->causer->name }}</div>
                                <div class="col-3">{{ company_date($change->created_at) }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-empty-content>
                        <x-slot name="title">
                            No existen eventos asociados al proyecto
                        </x-slot>
                    </x-empty-content>
                @endif
            </div>
        </div>
    @endcan
@endsection

