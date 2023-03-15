@extends('layouts.admin')

@section('title', trans_choice('general.plan', 2))

@section('subheader')
    <ol class="breadcrumb bg-transparent breadcrumb-sm pl-0 pr-0">
        <li class="breadcrumb-item active">
            <a href="{{ route('plans.index') }}" class="fs-2x"><i class="fal fa-folder-open mr-1"></i>Planes</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('plans.index') }}" class="fs-2x"><i class="fal fa-folder-open mr-1"></i>{{ $plan->name }}</a>
        </li>
        <li class="breadcrumb-item">
            <a class="fs-2x">Objetivos</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="row row-cols-1 row-cols-md-4 justify-content-center">
        @foreach($children as $child)

            <div class="col mb-4">
                <a href="{{ route('plans.detail',['plan' => $plan->id, 'level' => 1, 'detail' => $child->id]) }}"
                   class="card border-dashed btn-select">
                    <div class="card-body d-flex align-items-center">
                        <h5 class="card-title mx-auto my-3">
                    <span class="fs-xl fw-700 color-fusion-700 d-block">
                        {{ $child->name }}
                    </span>
                        </h5>
                    </div>
                </a>
            </div>

        @endforeach
    </div>
@endsection

