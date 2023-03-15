@extends('layouts.admin')

@section('title', trans('general.title.new', ['type' => trans_choice('general.users', 1)]))

@section('subheader-title')
    <i class="fal fa-plus text-primary"></i> {{ trans('general.title.create', ['type' => trans_choice('general.users', 1)]) }}
@endsection

@section('content')
    <x-form action="{{ route('users.store') }}" method="post" card="true">
        <div class="row">
            <x-form.inputs.text id="name" label="{{ trans('general.name') }}" class="col-6 required"
                                value="{{ old('name') }}" placeholder="{{ trans('general.form.enter', ['field' => trans('general.name')]) }}"/>

            <x-form.inputs.text type="email" id="email" label="{{ trans('general.email') }}" class="col-6 required"
                                value="{{ old('email') }}" placeholder="{{ trans('general.form.enter', ['field' => trans('general.email')]) }}"/>

            <x-form.inputs.text type="password" id="password" label="{{ trans('general.password') }}" class="col-6 required"
                                placeholder="{{ trans('general.form.enter', ['field' => trans('general.password')]) }}"/>

            <x-form.inputs.text type="password" id="password_confirmation" label="{{ trans('auth.password.current_confirm') }}" class="col-6 required"
                                placeholder="{{ trans('general.form.enter', ['field' => trans('general.password')]) }}"/>

            <x-form.inputs.select2 id="companies" label="{{ trans_choice('general.companies', 0) }}" class="col-6 required" multiple="true">
                @foreach($companies as $key => $name)
                    <option value="{{ $key}}" {{ (collect(old('companies'))->contains($key)) ? 'selected':'' }}>{{ $name }}</option>
                @endforeach
            </x-form.inputs.select2>

            <x-form.inputs.radio-enabled id="enabled" label="{{ trans('general.enabled') }}" enabled='true'/>

            <x-form.inputs.checkbox id="roles" label="{{ trans_choice('general.roles', 0) }}" :items="$roles" :actual="old('roles')"/>
        </div>
    </x-form>
@endsection