@extends('layouts.admin')

@section('title', trans('general.title.edit', ['type' => trans_choice('general.roles', 1)]))

@section('subheader-title')
    <i class="fal fa-edit text-primary"></i> {{ trans('general.title.edit', ['type' => trans_choice('general.roles', 1)]) }}
@endsection

@section('content')
    <x-form action="{{ route('roles.update', $role->id) }}" method="put">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <x-form.inputs.text id="name" label="{{ trans('general.name') }}" class="col-6"
                                        value="{{ $role->name }}" placeholder="{{ trans('general.form.enter', ['field' => trans('general.name')]) }}"/>
                    <div class="custom-control custom-checkbox">
                        <input name="is_project_role" id="is_project_role" type="checkbox" class="custom-control-input"
                               wire:model="is_project_role" value="true">
                        <label class="custom-control-label" for="is_project_role">
                            {{trans('general.project_role')}} </label>
                    </div>
                </div>
            </div>

            <livewire:auth.permission :permissions="$permissions" :actions="$actions" :role="$role"/>
    </x-form>
@endsection