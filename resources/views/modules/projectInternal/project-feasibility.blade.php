@extends('modules.projectInternal.project')

@section('project-page')
<!-- this overlay is activated only when mobile menu is triggered -->
<div id="panel-12" class="panel">
    <div class="panel-container">
        <div class="panel-content">
            <div class="row">
                <div class="col-auto">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                            <i class="fal fa-home"></i>
                            <span class="hidden-sm-down ml-1"> {{trans('general.capabilities_rt')}}</span>
                        </a>
                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                            <i class="fal fa-user"></i>
                            <span class="hidden-sm-down ml-1"> {{trans('general.viability_matrix')}}</span>
                        </a>
                        <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                            <i class="fal fa-envelope"></i>
                            <span class="hidden-sm-down ml-1">  {{trans('general.project_profile')}}</span>
                        </a>
                        <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages2" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                            <i class="fal fa-envelope"></i>
                            <span class="hidden-sm-down ml-1"> {{trans_choice('general.project',0)}}</span>
                        </a>
                        <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                            <i class="fal fa-cog"></i>
                            <span class="hidden-sm-down ml-1"> {{trans('general.qualification')}}</span>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <livewire:projects.feasibility.capabilities.project-capability :project="$project->id"/>

                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <livewire:projects.feasibility.viability-matrix.projects-feasibility-matrix :project="$project->id"/>
                        </div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                            <livewire:projects.feasibility.project-profile.project-profile-form-tab :project="$project->id"/>

                        </div>
                        <div class="tab-pane fade" id="v-pills-messages2" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                            <livewire:projects.feasibility.projects.project-feasibility-form-tab :project="$project->id"/>

                        </div>
                        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <livewire:projects.feasibility.qualification.project-feasibility-qualification :projectId="$project->id"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('page_script')

@endpush