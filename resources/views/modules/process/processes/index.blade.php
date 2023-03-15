@extends('layouts.admin')
@section('title', 'Gerencias')
@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-balance-scale-right text-primary"></i> <span class="fw-300">Gerencias</span>
    </h1>
@endsection
@section('content')
    <livewire:process.index-process/>
@endsection
