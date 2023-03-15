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
                                <i class="fal fa-search-plus"></i>
                                <span class="hidden-sm-down ml-1"> Datos Generales</span>
                            </a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile"
                               role="tab" aria-controls="v-pills-profile" aria-selected="false">
                                <i class="fal fa-indent"></i>
                                <span class="hidden-sm-down ml-1">Objetivos</span>
                            </a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-purpose"
                               role="tab" aria-controls="v-pills-purpose" aria-selected="false">
                                <i class="fal fa-indent"></i>
                                <span class="hidden-sm-down ml-1"> Articulaciones</span>
                            </a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-purpose"
                               role="tab" aria-controls="v-pills-purpose" aria-selected="false">
                                <i class="fal fa-indent"></i>
                                <span class="hidden-sm-down ml-1">Componentes</span>
                            </a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-purpose"
                               role="tab" aria-controls="v-pills-purpose" aria-selected="false">
                                <i class="fal fa-indent"></i>
                                <span class="hidden-sm-down ml-1">Beneficiarios</span>
                            </a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-purpose"
                               role="tab" aria-controls="v-pills-purpose" aria-selected="false">
                                <i class="fal fa-indent"></i>
                                <span class="hidden-sm-down ml-1">Cronograma</span>
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                 aria-labelledby="v-pills-home-tab">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12">
                                        <div class="row mb-2">
                                            <div class="col-xl-12">
                                                <livewire:components.input-text-editor-inline-editor :modelId="$project->id"
                                                                                                     class="\App\Models\Projects\Project"
                                                                                                     field="experience"
                                                                                                     :defaultValue="$project->experience"
                                                                                                     :key="time().$project->id"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <span class="fs-2x w-40px"><i class="fal fa-comment-dots"></i></span>
                                            <span class="fs-2x fw-700">Comentarios</span>
                                        </div>

                                            <livewire:components.comments :modelId="$project->id"  class="\App\Models\Projects\Project" identifier="experience"
                                                                          :key="time().$project->id"/>
                                    </div>
                                    <div class="col-6">
                                        <livewire:projects.files.project-files :project="$project"  identifier="experience"/>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                 aria-labelledby="v-pills-profile-tab">

                                <div class="col-12 col-sm-12 col-md-12">
                                    <div class="row mb-2">
                                        <div class="col-xl-12">
                                            <livewire:components.input-text-editor-inline-editor :modelId="$project->id"
                                                                                                 class="\App\Models\Projects\Project"
                                                                                                 field="justification"
                                                                                                 :defaultValue="$project->justification"
                                                                                                 :key="time().$project->id"/>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <span class="fs-2x w-40px"><i class="fal fa-comment-dots"></i></span>
                                                <span class="fs-2x fw-700">Comentarios</span>
                                            </div>

                                            <livewire:components.comments :modelId="$project->id"  class="\App\Models\Projects\Project" identifier="justification"
                                                                          :key="time().$project->id"/>
                                        </div>
                                        <hr>
                                        <div class="col-6">
                                            <livewire:projects.files.project-files :project="$project"  identifier="justification"/>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-purpose" role="tabpanel"
                                 aria-labelledby="v-pills-profile-tab">
                                <div class="row w-100 mb-2">

                                    <div class="col-xl-12">

                                        <livewire:components.input-text-editor-inline-editor :modelId="$project->id"
                                                                                             class="\App\Models\Projects\Project"
                                                                                             field="proposed_solution"
                                                                                             :defaultValue="$project->proposed_solution"
                                                                                             :key="time().$project->id"/>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <span class="fs-2x w-40px"><i class="fal fa-comment-dots"></i></span>
                                            <span class="fs-2x fw-700">Comentarios</span>
                                        </div>

                                        <livewire:components.comments :modelId="$project->id"  class="\App\Models\Projects\Project" identifier="proposed_solution"
                                                                      :key="time().$project->id"/>
                                    </div>
                                    <div class="col-6">
                                        <livewire:projects.files.project-files :project="$project"  identifier="proposed_solution"/>

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

