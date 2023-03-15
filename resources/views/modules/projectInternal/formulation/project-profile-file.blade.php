@extends('modules.project.project')

@section('project-page')
    <div>
        <h2 class="text-info text-center fs-1x">Ficha</h2>
    </div>
    <div id="panel-12" class="panel">
        <div class="panel-container">
            <div class="panel-content">
                <div class="row">
                    <div class="col-auto">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                             aria-orientation="vertical">

                            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-summary"
                               role="tab" aria-controls="v-pills-home" aria-selected="true">
                                <i class="fal fa-file-spreadsheet"></i>
                                <span class="hidden-sm-down ml-1"> Resumen Ejecutivo</span>
                            </a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-services"
                               role="tab" aria-controls="v-pills-services" aria-selected="false">
                                <i class="fal fa-search-location"></i>
                                <span class="hidden-sm-down ml-1"> Servicios-Localidad</span>
                            </a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-objectives"
                               role="tab" aria-controls="v-pills-objectives" aria-selected="false">
                                <i class="fal fa-bullseye-pointer"></i>
                                <span class="hidden-sm-down ml-1">Objetivos</span>
                            </a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill"
                               href="#v-pills-beneficiaries"
                               role="tab" aria-controls="v-pills-beneficiaries" aria-selected="false">
                                <i class="fal fa-users"></i>
                                <span class="hidden-sm-down ml-1"> Beneficiarios</span>
                            </a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill"
                               href="#v-pills-articulations"
                               role="tab" aria-controls="v-pills-articulations" aria-selected="false">
                                <i class="fal fa-indent"></i>
                                <span class="hidden-sm-down ml-1">Articulaciones</span>
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-summary" role="tabpanel"
                                 aria-labelledby="v-pills-home-tab">
                                <div class="col-12 col-sm-12 col-md-12">
                                    <div class="row mb-2">
                                        <div class="col-xl-12">
                                            <livewire:components.input-text-editor-inline-editor :modelId="$project->id"
                                                                                                 class="\App\Models\Projects\Project"
                                                                                                 field="executive_summary"
                                                                                                 :defaultValue="$project->executive_summary"
                                                                                                 :key="time().$project->id"/>
                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center">
                                                        <span class="fs-2x w-40px"><i class="fal fa-comment-dots"></i></span>
                                                        <span class="fs-2x fw-700">Comentarios</span>
                                                    </div>

                                                    <livewire:components.comments :modelId="$project->id"  class="\App\Models\Projects\Project" identifier="executive_summary"
                                                                                  :key="time().$project->id"/>
                                                </div>
                                                <div class="col-6">
                                                    <livewire:projects.files.project-files :project="$project"  identifier="executive_summary"/>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-services" role="tabpanel"
                                 aria-labelledby="v-pills-profile-tab">
                                <livewire:projects.formulation.project-show-sheet :project="$project"/>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <span class="fs-2x w-40px"><i class="fal fa-comment-dots"></i></span>
                                            <span class="fs-2x fw-700">Comentarios</span>
                                        </div>

                                        <livewire:components.comments :modelId="$project->id"  class="\App\Models\Projects\Project" identifier="show-sheet"
                                                                      :key="time().$project->id"/>
                                    </div>
                                    <div class="col-6">
                                        <livewire:projects.files.project-files :project="$project"  identifier="show-sheet"/>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-objectives" role="tabpanel"
                                 aria-labelledby="v-pills-profile-tab">
                                <div>
                                    <div>
                                        <livewire:projects.formulation.project-show-objectives :project="$project"/>
                                    </div>
                                    <div wire:ignore>
                                        <livewire:projects.profile.general-information.project-create-specific-objective
                                                :id="$project->id"/>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <span class="fs-2x w-40px"><i class="fal fa-comment-dots"></i></span>
                                                <span class="fs-2x fw-700">Comentarios</span>
                                            </div>

                                            <livewire:components.comments :modelId="$project->id"  class="\App\Models\Projects\Project" identifier="objectives"
                                                                          :key="time().$project->id"/>
                                        </div>
                                        <div class="col-6">
                                            <livewire:projects.files.project-files :project="$project"  identifier="objectives"/>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-beneficiaries" role="tabpanel"
                                 aria-labelledby="v-pills-profile-tab">
                                <div>
                                    <div class="col-12 col-sm-12 col-md-12">
                                        <div class="row mb-2">
                                            <div class="col-xl-12">
                                                <div class="fs-lg font-weight-bold mt-2 mb-3">{{trans('general.description_beneficiaries')}}</div>
                                            </div>
                                            <div class="col-xl-12">
                                                <livewire:components.input-text-editor-inline-editor
                                                        :modelId="$project->id"
                                                        class="\App\Models\Projects\Project"
                                                        field="description_beneficiaries"
                                                        :defaultValue="$project->description_beneficiaries"
                                                        :key="time().$project->id"/>


                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <livewire:projects.profile.beneficiaries.project-beneficiary-management
                                                :id="$project->id"/>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <span class="fs-2x w-40px"><i class="fal fa-comment-dots"></i></span>
                                            <span class="fs-2x fw-700">Comentarios</span>
                                        </div>

                                        <livewire:components.comments :modelId="$project->id"  class="\App\Models\Projects\Project" identifier="description_beneficiaries"
                                                                      :key="time().$project->id"/>
                                    </div>
                                    <div class="col-6">
                                        <livewire:projects.files.project-files :project="$project"  identifier="description_beneficiaries"/>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-articulations" role="tabpanel"
                                 aria-labelledby="v-pills-profile-tab">
                                <livewire:projects.profile.articulations.project-show-articulations
                                        :project="$project"/>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <span class="fs-2x w-40px"><i class="fal fa-comment-dots"></i></span>
                                            <span class="fs-2x fw-700">Comentarios</span>
                                        </div>

                                        <livewire:components.comments :modelId="$project->id"  class="\App\Models\Projects\Project" identifier="articulations"
                                                                      :key="time().$project->id"/>
                                    </div>
                                    <div class="col-6">
                                        <livewire:projects.files.project-files :project="$project"  identifier="articulations"/>

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

@push('page_script')
    <script>
        Livewire.on('toggleCreateObjective', () => $('#project-create-specific-objective').modal('toggle'));
    </script>
@endpush