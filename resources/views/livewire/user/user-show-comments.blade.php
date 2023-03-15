<div wire:ignore.self class="modal fade in" id="user-show-comments" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 60% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-info">
                    {{trans('general.comments')}} {{trans('general.of')}}  {{$user->getFullName()}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body"  style="overflow-y: auto; height:450px; ">
                @if($user)
                    <div class="d-flex align-items-center flex-column pl-6 comments">
                        @foreach($comments as $comment)
                            <div class="d-flex flex-row w-100 py-3" wire:key="{{ 'c.' . $loop->index }}">
                                <div class="d-inline-block align-middle mr-3">
                                    <span class="d-block mt-1"><i class="fas fa-comment"></i></span>
                                </div>
                                <div class="mb-0 flex-1 text-dark">
                                    <div class="d-flex">
                                        <a href="javascript:void(0);" class="text-dark fw-500">
                                            {{ $comment->user->name }}
                                        </a>
                                        <span class="text-muted fs-xs opacity-70 ml-auto">
                                            {{ $comment->updated_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    {!! $comment->comment !!}
                                </div>
                            </div>
                            <hr class="m-0 w-100">
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>