<div class=""
     x-cloak
     x-data="{
        show: @entangle('show').defer,
        phase: @entangle('phase'),
        transition: @entangle('transition')
        }"
     x-init="
            $watch('show', value => {
                if (value) {
                    $('#project-status-change').modal('show');
                } else {
                    $('#project-status-change').modal('hide');
                    phase = false;
                }
            });

"
     x-on:keydown.escape.window="show = false;"
     x-on:close.stop="show = false;"
>
    <div class="frame-wrap m-0">
        <div class="d-flex flex-wrap">
            <div class="w-auto p-2 text-center">
                @include('modules.project.layout.circular-menu')
            </div>
            @include('modules.project.layout.change-status')
        </div>
    </div>
    @include('modules.project.layout.menu-options')
    @include('modules.project.layout.modal-change-phase')
</div>
@push('page_script')
    <script>
        Livewire.on('closeModalValidations', () => $('#project-status-change').modal('toggle'));
    </script>
@endpush