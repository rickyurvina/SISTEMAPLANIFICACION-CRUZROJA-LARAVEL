@extends('modules.project.project')

@section('project-page')
<div class="p-2">
    <livewire:projects.profile.articulations.project-show-articulations :project="$project"/>
</div>

@endsection

