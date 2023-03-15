<div wire:ignore.self class="modal fade in" id="user-show-skills" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 60% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-info">
                    {{trans('general.personal_skills')}} {{trans('general.of')}}  {{$user->getFullName()}}
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto; height:450px; ">
                @if($user->working_skills)
                    <div class="row">
                        @foreach($user->working_skills as $item)
                            <div class="col-6">
                                <div class="p-3">
                                    <div class="fw-500 fs-xs">{{$item}}</div>
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar bg-primary-300 bg-primary-gradient" role="progressbar" style="width: {{rand(70,99)}}%"
                                             aria-valuenow="{{rand(70,99)}}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"></div>
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