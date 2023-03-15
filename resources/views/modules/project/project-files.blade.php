@extends('modules.project.project')

@section('project-page')
    <div class="panel-1" style="display: contents">
        <livewire:projects.files.project-files :project="$project"/>
    </div>
@endsection
