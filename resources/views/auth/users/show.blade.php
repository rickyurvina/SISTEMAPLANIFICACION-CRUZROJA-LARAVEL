@extends('layouts.admin')

@section('title', trans('general.title.show', ['type' => trans_choice('general.users', 1)]))

@section('subheader')

@endsection

@section('content')
    <livewire:user.user-profile :id="$user->id"/>
@endsection