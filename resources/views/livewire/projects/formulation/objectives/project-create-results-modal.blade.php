<div wire:ignore.self class="modal fade in" id="project-create-results" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            @if($objective)

                <div class="modal-header bg-primary color-white">
                    <h4 class="modal-title">
                        Crear {{$objective->project->isMisional()? 'Resultado':'Hito'}}  de {{$objective->name}}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <form wire:submit.prevent="submit" method="post" autocomplete="off">
                    <div class="modal-body">
                        <div class="row">
                            <x-form.modal.text id="code" label="{{ __('general.code') }}" class="form-group col-sm-4" required="required"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('general.code')]) }}">
                            </x-form.modal.text>

                            <x-form.modal.text id="name" label="{{ __('general.name') }}" class="form-group col-sm-12" required="required"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('general.name')]) }}">
                            </x-form.modal.text>
                            <x-form.modal.textarea id="description"
                                                   label="{{ __('general.description') }}"
                                                   class="form-group col-12">
                            </x-form.modal.textarea>
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
