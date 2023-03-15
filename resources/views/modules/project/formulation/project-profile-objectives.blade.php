@extends('modules.project.project')

@section('project-page')
        <div class="p-2">
                <livewire:projects.formulation.project-show-objectives :project="$project"/>
        </div>
        <div wire:ignore>
                <livewire:projects.profile.general-information.project-create-specific-objective :id="$project->id"/>
        </div>
@endsection


@push('page_script')
        <script>
                Livewire.on('toggleCreateObjective', () => $('#project-create-specific-objective').modal('toggle'));
        </script>
@endpush