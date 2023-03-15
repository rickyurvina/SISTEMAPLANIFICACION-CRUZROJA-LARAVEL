@extends('modules.process.processes.process')

@section('process-page')
   <livewire:process.process-indicators :processId="$process->id" :page="$page">
@endsection
