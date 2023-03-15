<div>
    <div class="col-12 col-sm-12 col-md-12">
        <div class="row mb-2">
            <x-label-section> Identificación del Problema
                <x-tooltip-help message="{{$messages->where('code','identificacion_problema')->first()->description}}"></x-tooltip-help>
            </x-label-section>
            <div class="col-xl-12">
                <livewire:components.input-text-editor-inline-editor
                        :modelId="$project->id"
                        class="\App\Models\Projects\Project"
                        field="problem_identified"
                        :defaultValue="$project->problem_identified"
                        :key="time().$project->id"/>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-6 border-right border-dark">
            <x-label-section> Comentarios</x-label-section>
            <livewire:components.comments :modelId="$project->id" class="\App\Models\Projects\Project" identifier="problem_identified"
                                          :key="time().$project->id"/>
        </div>
        <div class="col-6">
            <livewire:projects.files.project-files :project="$project" identifier="problem_identified"/>

        </div>
    </div>
</div>
