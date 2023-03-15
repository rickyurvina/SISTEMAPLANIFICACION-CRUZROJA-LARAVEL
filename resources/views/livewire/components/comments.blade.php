<div
        x-cloak x-data="
        {
                    showEditor: @entangle('showEditor'),
                    answer: @entangle('answer').defer,
                    text: @entangle('text').defer,
                    identifier: @entangle('identifier').defer,
                    init: function () {
                    let quill = new Quill('#editor'+this.identifier+'  .editor', {
                            theme: 'snow',
                            bounds: '#editor'+this.identifier+' .editor',
                            modules: {
                                toolbar: [[{
                                    header: [1, 2, 3, !1]
                                }], [{
                                    font: []
                                }], ['bold', 'italic', 'underline'], [{
                                    list: 'ordered'
                                }, {
                                    list: 'bullet'
                                }, {
                                    align: []
                                }], ['link'], [{
                                    color: []
                                }, {
                                    background: []
                                }], ['clean']]
                            }
                        });
                        quill.on('text-change', () => {
                            this.text = quill.root.innerHTML;
                        });
                    },
                    store: () => {
                        @this.store();
                    }
                }
"
        x-init="
            $watch('showEditor', value => {
                 let container = document.querySelector('#editor'+identifier+' .editor');
                let quill = Quill.find(container);
                if (value) {
                    setTimeout(() => {
                      quill.focus();
                    }, 400)
                } else {
                    quill.setText('');
                }
            });
        "
>

    <div class="d-flex align-items-center flex-column mt-2">
        <div id="editor{{$this->identifier}}" class="pl-6 w-100" wire:ignore x-show="showEditor">
            <div class="editor"></div>
        </div>

        <div class="text-right w-100 mt-2" x-show="showEditor">
            <button class="btn btn-sm btn-outline-default shadow-0" x-on:click="showEditor = false">{{ __('general.cancel') }}</button>
            <button class="btn btn-sm btn-primary shadow-0 ml-2" wire:click="store">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:target="store" wire:loading></span>
                {{ __('general.send') }}
            </button>
        </div>
        <div class="w-100" x-show="!showEditor" x-on:click="showEditor = true">
            <div class="d-flex">
                <div class="d-inline-block align-middle status status-sm status-success mr-3">
                <span class="profile-image profile-image-md rounded-circle d-block mt-1"
                      style="background-image:url('{{ asset_cdn("img/user.svg") }}'); background-size: cover;"></span>
                </div>
                <div class="mb-0 flex-1 text-dark">
                    <div class="cursor-text text-editable align-items-center" style="background-clip: padding-box;
             border: 1px solid #E5E5E5; border-radius: 4px; height: calc(1.47em + 1rem + 2px); padding: 0.5rem 0.875rem">
                        <small style="color: rgb(94, 108, 132); font-size: 12px">{{__('general.add_comment')}}</small>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="d-flex align-items-center flex-column comments">

        @foreach($comments as $comment)
            @if($comment->parent_id == null)
                <div class="d-flex flex-row w-100 py-3" wire:key="{{ 'c.' . $loop->index }}">
                    <div class="d-inline-block align-middle status status-sm status-success mr-3">
                        <span class="profile-image profile-image-md rounded-circle d-block mt-1"
                              style="background-image:url('{{ asset_cdn("img/user.svg") }}'); background-size: cover;"></span>
                    </div>
                    <div class="mb-0 flex-1 text-dark">
                        <div class="d-flex mb-1">
                            <a href="javascript:void(0);" class="text-dark fw-500">
                                {{ $comment->user->name }}
                            </a>
                            <span class="text-muted fs-xs opacity-70 ml-auto">
                                {{ $comment->updated_at->diffForHumans() }}
                            </span>
                        </div>
                        {!! $comment->comment !!}
                        @if($comment->user->id != user()->id)
                            <div x-show="!showEditor" x-on:click="showEditor = true; answer={{ $comment->id }}" class="mt-1">
                                <a href="javascript:void(0);" class="flex-shrink-0">{{ trans('general.answer') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            @foreach($comment->childs as $comment_)
                <div class="d-flex flex-row w-100 py-3 pl-6" wire:key="{{ 'r.' . $loop->index }}">
                    <div class="d-inline-block align-middle status status-sm status-success mr-3">
                                            <span class="profile-image profile-image-md rounded-circle d-block mt-1"
                                                  style="background-image:url('{{ asset_cdn("img/user.svg") }}'); background-size: cover;"></span>
                    </div>
                    <div class="mb-0 flex-1 text-dark">
                        <div class="d-flex">
                            <a href="javascript:void(0);" class="text-dark fw-500">
                                {{ $comment_->user->name }}
                            </a>
                            <span class="text-muted fs-xs opacity-70 ml-auto">
                            {{ $comment_->updated_at->diffForHumans() }}
                        </span>
                        </div>
                        {!! $comment_->comment !!}
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
</div>
