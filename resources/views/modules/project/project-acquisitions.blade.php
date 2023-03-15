@extends('modules.project.project')

@section('project-page')

<div class="panel-1" style="display: contents">
    <livewire:projects.acquisitions.project-acquisitions :project="$project"/>
</div>

@endsection
