@extends('modules.project.project')

@section('project-page')

    <div class="p-1">
        <div class="d-flex">
            <div>
                <x-label-section>Documento Formulado</x-label-section>
            </div>
            <div>
                <x-tooltip-help message="{{$messages->where('code','documento_forumalado')->first()->description}}"></x-tooltip-help>
            </div>
        </div>

        <div class="p-2">
            <div class="row">
                <div class="col-6 border-right border-dark">
                    <div class="d-flex align-items-center">
                        <span class="fs-2x w-40px"><i class="fal fa-comment-dots"></i></span>
                        <span class="fs-2x fw-700">Comentarios</span>
                    </div>
                    <livewire:components.comments :modelId="$project->id" class="\App\Models\Projects\Project" identifier="documents"
                                                  :key="time().$project->id"/>
                </div>
                <div class="col-6">
                    <livewire:projects.files.project-files :project="$project" identifier="documents"/>
                </div>
            </div>
        </div>
    </div>

@endsection

