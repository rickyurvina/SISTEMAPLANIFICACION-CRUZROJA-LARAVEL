@extends('modules.projectInternal.project')

@section('project-page')
<div class="p-2">
    <livewire:projects.formulation.referential-budget.project-referential-budget :project="$project" :messages="$messages"/>
</div>

@endsection

