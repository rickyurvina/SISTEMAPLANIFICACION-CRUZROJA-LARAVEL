@extends('modules.project.project')

@section('project-page')
    <div wire:ignore>
        <livewire:risks.index-risks :modelId="$project->id"
                                    class="{{\App\Models\Projects\Project::class}}"/>
    </div>
@endsection