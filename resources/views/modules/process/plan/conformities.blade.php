@extends('modules.process.processes.process')

@section('process-page')
    <div wire:ignore.self>
        <livewire:process.non-conformities.non-conformities-index :processId="$process->id" :page="$page" :subMenu="$subMenu ?? null"/>
    </div>

    <div wire:ignore.self>
        <livewire:process.non-conformities.create-non-conformities :processId="$process->id"/>
    </div>
@endsection