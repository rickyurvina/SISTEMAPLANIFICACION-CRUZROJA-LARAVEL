@extends('modules.projectInternal.project')

@section('project-page')
<div class="p-2">
    <div class="panel-1" style="display: contents">
        <div>
            <livewire:projects.logic-frame.project-logic-frame :project="$project" :messages="$messages"/>
        </div>
        <div wire:ignore.self>
            <livewire:indicators.indicator-create/>
        </div>
        <div wire:ignore.self>
            <livewire:indicators.indicator-edit/>
        </div>
        <div wire:ignore.self>
            <livewire:indicators.indicator-register-advance/>
        </div>
        <div wire:ignore.self>
            <livewire:projects.formulation.objectives.project-create-specific-objective
                    :id="$project->id"/>
        </div>
        <div wire:ignore.self>
            <livewire:projects.formulation.objectives.project-create-services/>
        </div>
        <div wire:ignore>
            <livewire:projects.formulation.objectives.project-create-results-modal/>
        </div>

    </div>
</div>


@endsection

@push('page_script')
    <script>

        Livewire.on('toggleCreateService', () => $('#project-create-services').modal('toggle'));
        Livewire.on('toggleCreateObjective', () => $('#project-create-specific-objective').modal('toggle'));
        Livewire.on('toggleCreateResult', () => $('#project-create-results').modal('toggle'));
        Livewire.on('toggleRegisterAdvance', () => $('#register-indicator-advance').modal('toggle'));
        Livewire.on('toggleCreateObjective', () => $('#project-create-specific-objective').modal('toggle'));

        $('#project-create-results').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let objectiveId = $(e.relatedTarget).data('objective-id');
            //Livewire event trigger
            Livewire.emit('loadResults', objectiveId);
        });
    </script>
@endpush