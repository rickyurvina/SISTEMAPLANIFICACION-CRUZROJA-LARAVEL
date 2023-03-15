@extends('modules.process.processes.process')

@section('process-page')
    <div wire:ignore.self>
        <livewire:process.activities.activities-index :processId="$process->id" :page="$page" :subMenu="$subMenu ?? null"/>
    </div>

    <div wire:ignore.self>
        <livewire:process.activities.create-activity :processId="$process->id"/>
    </div>
@endsection
@push('page_script')
    <script>
        Livewire.on('toggleCreateActivity', () => $('#plan-create-activity').modal('toggle'));
    </script>
@endpush