@extends('modules.process.processes.process')
@section('title', __('general.edit'))
@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0">
        <li class="breadcrumb-item">
            <a href="{{ route('processes.index') }}">
                Gerencias
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('process.showProcess', $nonConformities->process->department_id) }}">
                {{ trans_choice('process.process',1) .' de '.  $nonConformities->process->department->name }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('process.showConformities',[$nonConformities->process->id, $page]) }}">
                {{ trans_choice('process.process',0) .': '.$nonConformities->process->name }}
            </a>
        </li>
        <li class="breadcrumb-item active" style="overflow: unset"> {{ $nonConformities->number }}</li>
    </ol>
@endsection
@section('process-page')
    <div>
        <livewire:process.non-conformities.edit-non-conformity :idNonConformity="$nonConformities->id" :subMenu="$subMenu" :page="$page"/>
    </div>
@endsection