<div>
    <div wire:ignore.self class="modal fade" id="register-advance-activity" tabindex="-1" role="dialog"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 70rem;">
            @if($task)
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        @include('modules.project.activity.header')
                        <button wire:click="resetForm" type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding-top: 0px !important; margin-top: 0px !important;">
                        <div class="content-detail">
                            <div class="d-flex flex-column">
                                <div class="d-flex flex-nowrap">
                                    @include('modules.project.activity.left-menu-manage-activity')
                                    @include('modules.project.activity.right-menu-manage-activity')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>