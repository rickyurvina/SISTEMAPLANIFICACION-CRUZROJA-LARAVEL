@extends('modules.project.project')

@section('project-page')

@switch( $project->phase )
    @case( \App\Models\Projects\Project::PHASE_START_UP )
    Fase de formulacion
    @break
    @case( \App\Models\Projects\Project::PHASE_START_UP )
    <livewire:projects.start-up.project-show-start-up :project="$project"/>
    @break
    @case( \App\Models\Projects\Project::PHASE_IMPLEMENTATION )
        IMPLEMENTACION
    @break
    @case( \App\Models\Projects\Project::PHASE_CLOSING )
    CIERRE
    @break
    @default
    @break
@endswitch
{{--    <livewire:projects.summary.project-show-project-summary :project="$project" >--}}
@endsection
