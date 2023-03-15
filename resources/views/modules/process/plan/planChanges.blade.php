@extends('modules.process.processes.process')

@section('process-page')
    <div wire:ignore.self>
        <livewire:process.plan-changes.changes-index :processId="$process->id" :page="$page" :subMenu="$subMenu ?? null"/>
    </div>

    <div wire:ignore.self>
        <livewire:process.plan-changes.create-changes :processId="$process->id"/>
    </div>
@endsection
@push('page_script')
    <script>
        Livewire.on('toggleCreateChange', () => $('#plan-create-changes').modal('toggle'));
    </script>
@endpush
