<div class="card mb-g">
    <div class="card-body">
        <h2 class="mb-0 fs-xl">
            {{trans('general.comments')}}
        </h2>
    </div>
    @foreach($user->comments as $comment)
        @if($loop->iteration<=15)
            <div class="card-body pb-0 px-4">

                <div class="d-flex flex-row pb-3 pt-2  border-top-0 border-left-0 border-right-0">
                    <div class="d-inline-block align-middle mr-3">
                        <span class="d-block mt-1"><i class="fas fa-comment"></i></span>
                    </div>
                    <h5 class="mb-0 flex-1 text-dark fw-500">
                        {{ $comment->user->name}}
                    </h5>
                    <span class="text-muted fs-xs opacity-70">
                                                {{ $comment->updated_at->diffForHumans() }}
                                            </span>
                </div>
                <div class="pb-3 pt-2 border-top-0 border-left-0 border-right-0 text-muted">
                    {!! $comment->comment !!}
                </div>
            </div>
        @endif
    @endforeach

</div>