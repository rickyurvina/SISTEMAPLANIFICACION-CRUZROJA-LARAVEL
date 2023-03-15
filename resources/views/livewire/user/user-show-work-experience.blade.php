<div wire:ignore.self class="modal fade in" id="user-show-work-experience" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 60% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-info">
                    {{trans('general.work_experience')}} {{trans('general.of')}}  {{$user->getFullName()}}
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto; height:450px; ">
                <div class="card">
                    <!-- rating -->
                    <div class="card mb-g">
                        <div class="card-body pb-0 px-4">
                            <div class="pb-3 pt-2 border-top-0 border-left-0 border-right-0 text-muted">
                                {{$user->work_experience}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>