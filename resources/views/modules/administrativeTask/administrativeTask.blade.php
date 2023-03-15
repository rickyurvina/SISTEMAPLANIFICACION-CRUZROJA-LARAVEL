@extends('modules.project.project')

@section('project-page')
    @can('view-administrativeTasks-project'||'manage-administrativeTasks-project')
        <div class="container-fluid">
            <livewire:administrative-tasks.index-administrative-tasks :idProject="$project->id"/>
        </div>
    @endcan
@endsection
