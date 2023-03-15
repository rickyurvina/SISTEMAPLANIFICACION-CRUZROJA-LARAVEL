@extends('layouts.admin')

@section('title', trans_choice('general.plan', 2))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-align-left text-primary"></i> <span class="fw-300">{{ __('general.edition') . ' ' . trans_choice('general.elements', 1) . ' - ' . $planDetail->name }}</span>
    </h1>

    <div class="subheader-block d-lg-flex align-items-center">
        <a href="{{ route('plans.index') }}" class="btn btn-info btn-sm"><span class="fas fa-reply mr-1"></span>
            {{ __('general.go_back') }}</a>
    </div>

@endsection

@section('content')



    <div id="panel-6" class="panel">
        <div class="panel-hdr">
            <h2>
                {{ trans_choice('general.data', 2) . ' ' . trans_choice('general.elements', 1) }}
            </h2>
        </div>
        <div class="panel-container show">
            <div class="panel-content p-0">
                <form action="{{ route('plans.detail.update', ['id' => $planDetail->id]) }}" method="post" autocomplete="off">
                    @csrf
                    <div class="panel-content">
                        <div class="row">
                            <div class="form-group col-md-4 mb-3">
                                <label class="form-label required" for="code">{{ __('general.code') }}</label>
                                <input type="text" class="form-control" id="code" name="code" placeholder="{{ __('general.code') }}" value="{{ $planDetail->code }}">
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label class="form-label required" for="name">{{ __('general.name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="__('general.name" value="{{ $planDetail->name }}">
                            </div>

                            @if($planDetail->mission_objective || $planDetail->organizational_development)
                                <div class="form-group col-sm-12">
                                    <div class="frame-wrap">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="missionObjective" name="objectiveType" value="0"
                                                   {{ $planDetail->mission_objective ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="missionObjective">{{ __('general.mission_objective') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="organizationalDevelopment" name="objectiveType" value="1"
                                                    {{ $planDetail->organizational_development ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="organizationalDevelopment">{{ __('general.organizational_development') }}</label>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div id="perspective_block" class="form-group col-sm-4" style="display: {{ $planDetail->organizational_development ? '' : 'none' }}">
                                <label class="form-label required" for="perspective">{{ __('general.perspective') }}</label>
                                <select name="perspective" id="perspective" class="form-control custom-select">
                                    @foreach($perspectives as $item)
                                        <option value="{{ $item->name }}" {{ $item->name == $planDetail->perspective ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row justify-content-center">
                        <div class="row">
                            <div class="col-12">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mr-1">
                                    <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('page_script')
    <script>
        $('#missionObjective').on('click', () => {
            $('#perspective_block').hide();
        });
        $('#organizationalDevelopment').on('click', () => {
            $('#perspective_block').show();
        });
    </script>
@endpush
