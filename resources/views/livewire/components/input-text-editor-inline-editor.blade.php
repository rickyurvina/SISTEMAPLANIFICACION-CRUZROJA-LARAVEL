<div class="content-wrapper"
     x-cloak x-data="
        {
                    showEditor: @entangle('showEditor'),
                    text: @entangle('text').defer,
                    field: @entangle('field').defer,
                    init: function () {
                        let quill = new Quill('#'+this.field+'  .editor', {
                            theme: 'snow',
                            bounds: '#'+this.field+' .editor',
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
                let container = document.querySelector('#'+field+' .editor');
                let quill = Quill.find(container);
                if (value) {
                    setTimeout(() => {
                        quill.clipboard.dangerouslyPasteHTML(0,text);
                        quill.focus();
                    }, 400)
                } else {
                    text = '';
                }
            });
        "
>

    <div class="child-wrapper">
        <div id="{{$field}}" class="w-100" wire:ignore x-show="showEditor">
            <div class="editor"></div>
        </div>

        <div class="text-right w-100 mt-2" x-show="showEditor">
            <button class="btn btn-sm btn-outline-default shadow-0" x-on:click="showEditor = false">{{ __('general.cancel') }}</button>
            <button class="btn btn-sm btn-primary shadow-0 ml-2" wire:click="store">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:target="store" wire:loading></span>
                {{ __('general.send') }}
            </button>
        </div>
        <div class="content-read" x-show="!showEditor" x-on:click="showEditor = true">
            <div class="content-read-view">
                @if(!$value)
                    <span style="color: #5e6c84;">{{ $placeholder ?? __('general.add_description')}}</span>
                @else
                    <div>
                        {!! $value !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>