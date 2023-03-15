@extends('layouts.admin')

@section('title', trans_choice('general.commitments', 2))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fas fa-money-bill"></i> {{ trans_choice('general.commitments', 2) }} {{$certification->year}} de {{$certification->type}} {{$certification->number}}
    </h1>
    <a class="mr-2 border-0  btn btn-sm"
       href="{{route('budget.create-commitment', $certification)}}"
       style="border: 0 !important; background-color: transparent !important;">
        <i class="fas fa-plus mr-1 text-success"></i> {{ trans('general.create_commitment') }}
    </a>

@endsection

@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0">
        <li class="breadcrumb-item">
            <a href="{{ route('budgets.index') }}">
                {{trans_choice('budget.budget',2)}}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('budgets.certifications', $certification->id) }}">
                {{trans_choice('general.certifications',2)}}
            </a>
        </li>
        <li class="breadcrumb-item active">{{trans_choice('general.commitments',2)}} de {{$certification->type}} {{$certification->year}}</li>
    </ol>
@endsection

@section('content')
    <div wire:ignore>
        <livewire:budget.commitments.budget-commitment-index :certificationId="$certification->id"/>
    </div>
@endsection
