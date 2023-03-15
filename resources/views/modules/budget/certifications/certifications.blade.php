@extends('layouts.admin')

@section('title', trans_choice('general.certifications', 2))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fas fa-money-bill"></i> {{ trans_choice('general.certifications', 2) }} {{$transaction->year}}
    </h1>
    <a class="mr-2 border-0  btn btn-sm"
       href="{{route('budget.create-certification', $transaction)}}"
       id="btn-create-certification"
       style="border: 0 !important; background-color: transparent !important;">
        <i class="fas fa-plus mr-1 text-success"></i> {{ trans('general.create_certification') }}
    </a>

@endsection

@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0">
        <li class="breadcrumb-item">
            <a href="{{ route('budgets.index') }}">
                {{trans_choice('budget.budget',2)}}
            </a>
        </li>
        <li class="breadcrumb-item active">{{trans_choice('general.certifications',2)}}</li>
    </ol>
@endsection

@section('content')
    <div wire:ignore>
        <livewire:budget.certifications.budget-certifications-index :transaction="$transaction"/>
    </div>
@endsection
