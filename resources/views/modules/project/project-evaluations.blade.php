@extends('modules.project.project')

@section('project-page')
    <div>
        @can('manage-evaluations-project'||'view-evaluations-project')
            <div wire:ignore>
                <livewire:projects.evaluations.project-evaluations-index :project="$project"/>
            </div>
            @can('manage-evaluations-project')
                <div wire:ignore>
                    <livewire:projects.evaluations.project-create-evaluation :project="$project"/>
                </div>
                <div wire:ignore>
                    <livewire:projects.evaluations.project-edit-evaluation :project="$project"/>
                </div>
            @endcan
        @endcan
    </div>

@endsection

@push('page_script')
    <script>
        Livewire.on('toggleCreateEvaluation', () => $('#project-create-evaluation').modal('toggle'));
        Livewire.on('toggleEditEvaluation', () => $('#project-edit-evaluation').modal('toggle'));

        $('#project-edit-evaluation').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('item-id');
            //Livewire event trigger
            Livewire.emit('openEditEvaluation', id);
        });

    </script>
@endpush