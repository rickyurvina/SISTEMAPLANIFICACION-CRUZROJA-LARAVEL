@extends('layouts.admin')

@section('title', trans_choice('budget.structure',1))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-cog"></i> {{trans_choice('budget.structure',1) }}
    </h1>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        {{ trans('budget.incomes') }}
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        {{ trans('budget.expense') }}
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('page_script')
    <script>

    </script>
@endpush