@extends('modules.process.processes.process')

@section('process-page')
    <div>
        <livewire:risks.index-risks :modelId="$process->id"
                                    class="{{\App\Models\Process\Process::class}}"/>
    </div>
@endsection
