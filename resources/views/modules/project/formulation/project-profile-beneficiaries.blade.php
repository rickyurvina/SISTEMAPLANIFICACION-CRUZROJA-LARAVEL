@extends('modules.project.project')

@section('project-page')
    <div class="p-2">
        <livewire:projects.profile.beneficiaries.project-beneficiary-management :id="$project->id" :project="$project"/>
    </div>

@endsection

