<div wire:ignore.self class="modal fade in" id="user-show-competencies" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 60% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-info">
                    {{trans('general.personal_competences')}} {{$user->getFullName()}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto; height:450px; ">
                @if($user->competencies)
                    <div class="row">
                        @foreach($user->competencies as $item)
                            <div class="col-6">
                                <div class="p-3">
                                    <div class="p-3 d-flex text-primary align-items-center fs-xl">
                                        <h2 class="mb-0 mr-3 fs-xl">
                                            {{$item}}
                                        </h2>
                                        <i class="fas fa-star mr-1"></i>
                                        <i class="fas fa-star mr-1"></i>
                                        <i class="fas fa-star mr-1"></i>
                                        <i class="fas fa-star mr-1"></i>
                                        <i class="fas fa-star mr-1"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>