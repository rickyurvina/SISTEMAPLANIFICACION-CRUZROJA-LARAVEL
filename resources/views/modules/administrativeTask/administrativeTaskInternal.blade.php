@extends('modules.projectInternal.project')

@section('project-page')
    <div class="container-fluid">
        <livewire:administrative-tasks.index-administrative-tasks :idProject="$project->id"/>
    </div>
@endsection
