@extends('modules.project.project')

@section('project-page')
    <div wire:ignore>
        <livewire:projects.activities.project-results-activities :project="$project"/>
    </div>
    <div wire:ignore>
        <livewire:indicators.indicator-create/>
    </div>
    <div wire:ignore>
        <livewire:indicators.indicator-edit/>
    </div>
    <div wire:ignore>
        <livewire:indicators.indicator-register-advance/>
    </div>
    <div wire:ignore>
        <livewire:projects.logic-frame.project-create-result-activity :project="$project"/>
    </div>
    <div wire:ignore>
        <livewire:projects.activities.project-show-activities-wbs :projectId="$project->id" />
    </div>
    <div wire:ignore>
        <livewire:projects.activities.project-register-advance-activity/>
    </div>
    <div wire:ignore>
        <livewire:projects.activities.project-show-activity-weight />
    </div>
    <div wire:ignore>
        <livewire:projects.logic-frame.weight-objetives :projectId="$project->id" />
    </div>
    <div wire:ignore>
        <div class="modal fade fade" id="indicator-show-modal" tabindex="-1" style="display: none;" role="dialog"
             aria-hidden="true">
            <livewire:indicators.indicator-show/>
        </div>
    </div>
@endsection
@push('page_script')
    <script>
        Livewire.on('toggleCreateActivity', () => $('#project-create-result-activity').modal('toggle'));
        Livewire.on('toggleRegisterAdvance', () => $('#register-indicator-advance').modal('toggle'));
        Livewire.on('toggleCreateObjective', () => $('#project-create-specific-objective').modal('toggle'));
        Livewire.on('toggleRegisterAdvanceActivity', () => $('#register-advance-activity').modal('toggle'));
        Livewire.on('closeModalResultsWeight', () => $('#project-activities-weight').modal('toggle'));
        Livewire.on('closeModalObjectivesWeight', () => $('#project-objectives-weight').modal('toggle'));

        $('#project-activities-weight').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let objectiveId = $(e.relatedTarget).data('objective-id');
            //Livewire event trigger
            Livewire.emit('newActivity', objectiveId);
        });

    </script>
@endpush

