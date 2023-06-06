@extends('modules.projectInternal.project')

@section('title', trans('poa.card_reports'))
@section('subheader')

@endsection

@section('project-page')
    <div class="d-flex flex-wrap justify-content-center">
        <h3>Matrices Piat de {{$task->text}}</h3>
    </div>
    <div class="p-2">
        <livewire:piat.poa-activity-piat-matrix-index class="{{\App\Models\Projects\Activities\Task::class}}" :idModel="$task->id"/>
    </div>
@endsection