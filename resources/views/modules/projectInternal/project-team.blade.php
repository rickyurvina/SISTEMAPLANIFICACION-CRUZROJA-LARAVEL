@extends('modules.projectInternal.project')

@section('project-page')
    <div class="p-3">
        <livewire:projects-internal.governance.project-members-governance :project="$project"/>
        <livewire:projects-internal.governance.project-members :project="$project"/>
    </div>

@endsection