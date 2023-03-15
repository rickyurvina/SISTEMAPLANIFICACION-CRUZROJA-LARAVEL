@extends('layouts.admin')

@section('title', trans_choice('general.commitments', 2))

@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0">
        <li class="breadcrumb-item">
            <a href="{{ route('budgets.index') }}">
                {{trans_choice('budget.budget',2)}}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('budgets.commitments', $commitment) }}">
                {{trans_choice('general.commitments',2)}}
            </a>
        </li>

        <li class="breadcrumb-item active">{{trans('general.edit')}} {{trans_choice('general.commitments',1)}}</li>
    </ol>
    <style>
        .breadcrumb {
            margin-bottom: 0 !important;
        }
    </style>
@endsection

@section('subheader')
    <h1 class="subheader-title mb-0">
        <i class="fas fa-money-bill mr-2"></i>{{trans('general.edit')}} {{ trans_choice('general.commitments', 1) }} {{$commitment->type}} {{$commitment->number}}
    </h1>
    <style>
        .subheader {
            margin-bottom: 0 !important;
            margin-top: 0 !important;
        }
    </style>
@endsection


@section('content')
    <div>
        <livewire:budget.commitments.edit-commitment :commitment="$commitment" :certification="$certification"/>
    </div>
@endsection
