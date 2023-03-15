@extends('modules.projectInternal.project')

@section('project-page')

    <div class="panel-content mt-2">
        <hr>
        <div class="row m-2">
            <div class="col-auto">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                     aria-orientation="vertical">
                    <a class="nav-link  active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-general-data"
                       role="tab" aria-controls="v-pills-general-data" aria-selected="true">
                        <span class="hidden-sm-down ml-1"> Datos Generales</span>
                    </a>
                    <a class="nav-link" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-problem-identified"
                       role="tab" aria-controls="v-pills-general-data" aria-selected="false">

                        <span class="hidden-sm-down ml-1"> Identificación del problema</span>
                    </a>
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-objectives"
                       role="tab" aria-controls="v-pills-objectives" aria-selected="false">

                        <span class="hidden-sm-down ml-1">Objetivos</span>
                    </a>
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-articulations"
                       role="tab" aria-controls="v-pills-articulations" aria-selected="false">

                        <span class="hidden-sm-down ml-1"> Articulaciones</span>
                    </a>
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-beneficiaries"
                       role="tab" aria-controls="v-pills-purpose" aria-selected="false">

                        <span class="hidden-sm-down ml-1">Beneficiarios</span>
                    </a>
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-activities"
                       role="tab" aria-controls="v-pills-activities" aria-selected="false">
                        <span class="hidden-sm-down ml-1">Cronograma</span>
                    </a>
                </div>
            </div>
            <div class="col">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-general-data" role="tabpanel"
                         aria-labelledby="v-pills-home-tab">
                        <div class="mr-2 mw-100 w-100">
                            <livewire:projects-internal.formulation.general-information.project-general-data :project="$project" :messages="$messages"/>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-problem-identified" role="tabpanel"
                         aria-labelledby="v-pills-problem-identified">
                        <div>
                            <livewire:projects.formulation.problem-identified.project-problem-identified :project="$project" :messages="$messages"/>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-objectives" role="tabpanel"
                         aria-labelledby="v-pills-profile-tab">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12">
                                <div class="row mb-2">
                                    <div class="col-xl-12">
                                        <x-label-section> {{trans('general.objective_general')}}
                                            <x-tooltip-help message="{{$messages->where('code','objetivo_general')->first()->description}}"></x-tooltip-help>
                                        </x-label-section>
                                    </div>
                                    <div class="col-xl-12">
                                        <livewire:components.input-text-editor-inline-editor :modelId="$project->id"
                                                                                             class="\App\Models\Projects\Project"
                                                                                             field="general_objective"
                                                                                             :defaultValue="$project->general_objective"
                                                                                             :key="time().$project->id"/>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <livewire:projects-internal.formulation.objectives.project-show-objectives :project="$project" :messages="$messages"/>
                        </div>
                        <div class="row">
                            <div class="col-6 border-right border-dark">
                                <div class="d-flex align-items-center">
                                    <span class="fs-2x w-40px"><i class="fal fa-comment-dots"></i></span>
                                    <span class="fs-2x fw-700">Comentarios</span>
                                </div>

                                <livewire:components.comments :modelId="$project->id" class="\App\Models\Projects\Project" identifier="objectives"
                                                              :key="time().$project->id"/>
                            </div>
                            <div class="col-6">
                                <livewire:projects.files.project-files :project="$project" identifier="objectives" key="time().$project->id"/>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-articulations" role="tabpanel"
                         aria-labelledby="v-pills-profile-tab">
                        <div>
                            <livewire:projects.formulation.articulations.project-show-articulations :project="$project" :messages="$messages"/>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-beneficiaries" role="tabpanel"
                         aria-labelledby="v-pills-profile-tab">
                        <div>
                            <livewire:projects.formulation.beneficiaries.project-beneficiary-management :id="$project->id" :project="$project" :messages="$messages"/>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-activities" role="tabpanel"
                         aria-labelledby="v-pills-profile-tab">
                        <div>
                            <livewire:projects-internal.formulation.activities.project-activities :project="$project" :messages="$messages"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore>
        <livewire:projects.formulation.objectives.project-create-specific-objective
                :id="$project->id"/>
    </div>
    <div wire:ignore>
        <livewire:projects-internal.logic-frame.project-create-result-activity :project="$project" />
    </div>


@endsection


@push('page_script')
    <script>
        Livewire.on('toggleCreateObjective', () => $('#project-create-specific-objective').modal('toggle'));
        Livewire.on('toggleCreateActivity', () => $('#project-create-result-activity').modal('toggle'));



        $('#project-create-specific-objective').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let objectiveId = $(e.relatedTarget).data('objective-id');
            //Livewire event trigger
            if(objectiveId){
                Livewire.emit('editObjective', objectiveId);
            }
        });

        $('#project-create-result-activity').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let objectiveId = $(e.relatedTarget).data('objective-id');
            let activityId = $(e.relatedTarget).data('activity-id');
            //Livewire event trigger
            if(objectiveId){
                Livewire.emit('loadObjective', objectiveId, activityId);
            }
        });

    </script>
@endpush