@extends('modules.projectInternal.project')

@section('project-page')
    <div>
        <livewire:projects.activities.project-results-activities :project="$project"/>
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
    <div wire:ignore>
        <livewire:projects.logic-frame.project-create-result-activity :project="$project"/>
    </div>
    <div wire:ignore>
        <livewire:projects.activities.project-show-activity-weight :project="$project"/>
    </div>
    <div wire:ignore>
        <livewire:projects.activities.project-register-advance-activity/>
    </div>
    <div wire:ignore.self>
        <div class="modal fade fade" id="indicator-show-modal" tabindex="-1" style="display: none;" role="dialog" aria-hidden="true">
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

    </script>
@endpush

