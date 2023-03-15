@extends('modules.process.processes.process')

@section('process-page')
        <div>
                <livewire:components.files :modelId="$process->id"
                                           model="{{\App\Models\Process\Process::class}}"
                                           folder="process"
                                           event="fileAdded"
                />
        </div>
@endsection
