<div>
    <div class="page-inner" style="margin-top: -2% !important;">
        <main id="js-page-content" role="main" class="w-100">
            <ol class="breadcrumb page-breadcrumb">
                <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
            </ol>
            <div class="subheader">
                @if(\Illuminate\Support\Facades\Auth::user()->id==$user->id)
                    {{$user->id}}
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#edit_contact_modal"
                       data-id="{{ $user->id }}" class="dropdown-item">
                        <h1 class="subheader-title">
                            <i class='subheader-icon fal fa-edit'></i> {{ $user->getFullName() }}
                        </h1>
                    </a>
                @else
                    <h1 class="subheader-title">
                        {{ $user->getFullName() }}
                    </h1>
                @endif
            </div>
            <div class="row">
                <div class="col-lg-6 col-xl-3 order-lg-1 order-xl-1">
                    <!-- profile summary -->
                    <div class="card mb-g rounded-top">
                        <div class="row no-gutters row-grid">
                            @include('modules.user.profile.show-rrss')
                            @include('modules.user.profile.basic-information')
                            @include('modules.user.profile.count-comments-conecctions')
                            @include('modules.user.profile.roles-companies')
                        </div>
                    </div>
                    <!-- photos -->
                    @include('modules.user.profile.poas')
                    @include('modules.user.profile.poa-activities')
                </div>
                <div class="col-lg-12 col-xl-6 order-lg-3 order-xl-2">
                    <!-- post comment -->
                    @include('modules.user.profile.projects')
                    @include('modules.user.profile.comments')
                </div>
                <div class="col-lg-6 col-xl-3 order-lg-2 order-xl-3">
                    <!-- rating -->
                    @include('modules.user.profile.indicators')
                    @include('modules.user.profile.indicators-strategy')
                </div>
            </div>
        </main>
    </div>
    <livewire:user.user-show-comments :id="$user"/>
    <livewire:user.user-show-connections :id="$user"/>
    <livewire:user.user-show-work-experience :id="$user"/>
    <livewire:user.user-show-skills :id="$user"/>
    <livewire:user.user-show-files :id="$user"/>
    <livewire:user.user-competencies :id="$user"/>
    <livewire:poa.reports.poa-show-activity/>

    <div class="modal fade fade" id="indicator-show-modal" tabindex="-1" style="display: none;" role="dialog" aria-hidden="true">
        <livewire:indicators.indicator-show/>
    </div>
    <div wire:ignore.self>
        {{--        <livewire:admin.contact-edit-modal/>--}}
    </div>
    <div wire:ignore.self>
        <livewire:measure.measure-show />
    </div>
</div>
@push('page_script')
    <script>
        Livewire.on('toggleIndicatorShowModal', () => $('#indicator-show-modal').modal('toggle'));
        Livewire.on('toggleShowModal', () => $('#poa-show-activity-modal').modal('toggle'));
        Livewire.on('toggleContactEditModal', () => $('#edit_contact_modal').modal('toggle'));

        $('#edit_contact_modal').on('show.bs.modal', function (e) {
            let id = $(e.relatedTarget).data('id');
            //Livewire event trigger
            Livewire.emit('openContactEditModal', id);
        });

    </script>
    <script>
        Livewire.on('toggleIndicatorShowModal', () => $('#indicator-show-modal').modal('toggle'));
    </script>
    <script>
        $('#measure-show-modal').on('show.bs.modal', function (e) {
            let id = $(e.relatedTarget).data('measure-id');
            window.livewire.emitTo('measure.measure-show', 'show', id);
        });
    </script>
@endpush