<div wire:ignore.self class="modal fade in" id="project-create-result-activity" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            @if($objective)
                <div class="modal-header bg-primary color-white">
                    <h4 class="modal-title">
                        Añadir Hito de {{$objective->name}}
                    </h4>
                    <button type="button" wire:click="resetForm" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <form wire:submit.prevent="submit" method="post" autocomplete="off">
                    <div class="modal-body">
                        <div class="row">
                            <x-form.modal.text id="code" label="{{ __('general.code') }}" class="form-group col-sm-4" required="required"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('general.code')]) }}">
                            </x-form.modal.text>

                            <x-form.modal.text id="name" label="{{ __('general.name') }}" class="form-group col-sm-7" required="required"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('general.name')]) }}">
                            </x-form.modal.text>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <x-form.modal.footer></x-form.modal.footer>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
