@extends('modules.project.project')

@section('project-page')
    <div class="p-3">
        <livewire:projects.governance.project-members-governance :project="$project"/>
        <livewire:projects.governance.project-members :project="$project"/>
    </div>

@endsection