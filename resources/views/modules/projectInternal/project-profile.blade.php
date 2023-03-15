{{--@extends('modules.project.project')--}}

{{--@section('project-page')--}}
{{--    <div class="panel-1" style="display: contents">--}}
{{--        <div class="d-flex overflow-auto">--}}
{{--            <ul class="nav nav-tabs-clean color-fusion-50 font-weight-bolder flex-nowrap" id="profile-tab">--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" data-toggle="tab" href="#general_information" role="tab" aria-selected="false" wire:ignore.self>Información General</a></li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" data-toggle="tab" href="#articulate" role="tab" aria-selected="false" wire:ignore.self> Alineación Estratégica</a></li>--}}
{{--                <li class="nav-item"><a class="nav-link" data-toggle="tab" role="tab" aria-selected="false" href="#budget" wire:ignore.self> Presupuesto Referencial</a></li>--}}
{{--                <li class="nav-item"><a class="nav-link" data-toggle="tab" role="tab" aria-selected="false" href="#beneficiaries" wire:ignore.self>--}}
{{--                        Beneficiarios</a></li>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--        <div class="tab-content py-3" style="margin-top: 1%;">--}}
{{--            <div class="tab-pane fade" id="general_information" role="tabpanel" wire:ignore.self>--}}
{{--                <livewire:projects.profile.general-information.project-profile :project="$project"/>--}}
{{--            </div>--}}
{{--            <div class="tab-pane fade" id="articulate" role="tabpanel">--}}
{{--                <livewire:projects.profile.articulations.project-show-articulations :project="$project"/>--}}
{{--            </div>--}}
{{--            <div class="tab-pane fade" id="budget" role="tabpanel" wire:ignore.self>--}}
{{--                <livewire:projects.profile.referential-budget.project-referential-budget :project="$project"/>--}}
{{--            </div>--}}
{{--            <div class="tab-pane fade" id="beneficiaries" role="tabpanel">--}}
{{--                <livewire:projects.profile.beneficiaries.project-beneficiary-management :id="$project->id"/>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div wire:ignore>--}}
{{--            <livewire:indicators.indicator-edit/>--}}
{{--            <livewire:projects.profile.general-information.project-create-specific-objective :id="$project->id"/>--}}
{{--            <livewire:indicators.indicator-register-advance/>--}}
{{--        </div>--}}
{{--    </div>--}}


{{--@endsection--}}

{{--@push('page_script')--}}
{{--    <script>--}}

{{--        Livewire.on('toggleCreateObjective', () => $('#project-create-specific-objective').modal('toggle'));--}}

{{--    </script>--}}
{{--@endpush--}}