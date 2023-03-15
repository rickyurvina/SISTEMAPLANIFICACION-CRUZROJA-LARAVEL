@extends('modules.project.project')

@section('project-page')
    <div id="panel-12" class="panel">
        <div class="panel-container">
            <div class="panel-content">
                <div class="row">
                    <div class="col-auto">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                             aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home"
                               role="tab" aria-controls="v-pills-home" aria-selected="true">
                                <i class="fal fa-file"></i>
                                <span class="hidden-sm-down ml-1"> {{trans('general.implementation_methodology')}}</span>
                            </a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile"
                               role="tab" aria-controls="v-pills-profile" aria-selected="false">
                                <i class="fal fa-indent"></i>
                                <span class="hidden-sm-down ml-1"> Sostenibilidad</span>
                            </a>
                            <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages"
                               role="tab" aria-controls="v-pills-messages" aria-selected="false">
                                <i class="fal fa-users"></i>
                                <span class="hidden-sm-down ml-1">Seguimiento y Evaluación</span>
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                 aria-labelledby="v-pills-home-tab">
                                <livewire:projects.formulation.project-show-implementation-methodology :project="$project"/>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <span class="fs-2x w-40px"><i class="fal fa-comment-dots"></i></span>
                                            <span class="fs-2x fw-700">Comentarios</span>
                                        </div>

                                        <livewire:components.comments :modelId="$project->id"  class="\App\Models\Projects\Project" identifier="implementation-methodology"
                                                                      :key="time().$project->id"/>
                                    </div>
                                    <div class="col-6">
                                        <livewire:projects.files.project-files :project="$project"  identifier="implementation-methodology"/>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                 aria-labelledby="v-pills-profile-tab">
                                <livewire:projects.formulation.project-show-sustainability :project="$project"/>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <span class="fs-2x w-40px"><i class="fal fa-comment-dots"></i></span>
                                            <span class="fs-2x fw-700">Comentarios</span>
                                        </div>

                                        <livewire:components.comments :modelId="$project->id"  class="\App\Models\Projects\Project" identifier="sustainability"
                                                                      :key="time().$project->id"/>
                                    </div>
                                    <div class="col-6">
                                        <livewire:projects.files.project-files :project="$project"  identifier="sustainability"/>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                 aria-labelledby="v-pills-messages-tab">
                                <livewire:projects.formulation.project-show-monitoring :project="$project"/>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <span class="fs-2x w-40px"><i class="fal fa-comment-dots"></i></span>
                                            <span class="fs-2x fw-700">Comentarios</span>
                                        </div>

                                        <livewire:components.comments :modelId="$project->id"  class="\App\Models\Projects\Project" identifier="monitoring"
                                                                      :key="time().$project->id"/>
                                    </div>
                                    <div class="col-6">
                                        <livewire:projects.files.project-files :project="$project"  identifier="monitoring"/>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

