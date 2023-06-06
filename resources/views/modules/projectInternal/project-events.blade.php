@extends('modules.projectInternal.project')

@section('project-page')

    <livewire:projects.profile.change-control.project-change-control :projectId="$project->id"/>
@endsection

