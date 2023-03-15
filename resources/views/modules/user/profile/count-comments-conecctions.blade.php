
<div class="col-6">
    <div class="text-center py-3">
        <h5 class="mb-0 fw-700">
            {{$user->comments->count()}}
            <a href="javascript:void(0);" data-toggle="modal" data-target="#user-show-comments"
               data-id="{{$user->id}}" class="btn-link font-weight-bold">{{trans('general.comments')}}</a> <span
                    class="text-primary d-inline-block mx-3">&#9679;</span>
        </h5>
    </div>
</div>
<div class="col-6">
    <div class="text-center py-3">
        <h5 class="mb-0 fw-700">
            {{$user->activityLog->count()}}
            <a href="javascript:void(0);" data-toggle="modal" data-target="#user-show-connections"
               data-id="{{$user->id}}" class="btn-link font-weight-bold">{{trans('general.connections')}}</a> <span
                    class="text-primary d-inline-block mx-3">&#9679;</span>
        </h5>
    </div>
</div>