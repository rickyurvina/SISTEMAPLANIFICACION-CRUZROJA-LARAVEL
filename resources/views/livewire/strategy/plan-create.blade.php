<div wire:ignore.self class="modal fade in" id="new-modal-plan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    {{ __('general.add') . ' ' . trans_choice('general.plan', 1) }}
                    <small class="m-0 text-muted">
                        {{ __('general.add_template_description') }}
                    </small>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <form wire:submit.prevent="submit" method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <x-form.modal.select id="planTemplate" label="{{ trans_choice('general.templates', 1)  }}"
                                             class="form-group col-sm-8"
                                             required="required"
                                             wireevent="wire:change=planTemplateSelected()">
                            <option value="" selected>{{ __('general.select') }}</option>
                            @foreach($planTemplates as $item)
                                @if ($item->planTemplateDetails->count() > 0)
                                    <option value="{{ $item->id }}">
                                        {{ $item->description }}
                                    </option>
                                @endif
                            @endforeach
                        </x-form.modal.select>

                        <x-form.modal.text id="code" label="{{ __('general.code') }}" class="form-group col-sm-4" required="required"
                                           placeholder="{{ trans('general.form.enter', ['field' => trans('general.code')]) }}">
                        </x-form.modal.text>

                        <x-form.modal.text id="name" label="{{ __('general.name') }}" class="form-group col-sm-7" required="required"
                                           placeholder="{{ trans('general.form.enter', ['field' => trans('general.name')]) }}">
                        </x-form.modal.text>

                        <x-form.modal.select id="responsable" label="{{ trans('general.responsable')  }}"
                                             class="form-group col-sm-5"
                                             required="required">
                            <option value="" selected>{{ __('general.select') }}</option>
                            @foreach($users as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </x-form.modal.select>

                        <x-form.modal.textarea id="description" label="{{ __('general.description') }}" class="form-group col-sm-12" required="required">
                        </x-form.modal.textarea>

                        @if($showVision)
                            <x-form.modal.textarea id="vision" label="{{ __('general.vision') }}" class="form-group col-sm-12" required="required">
                            </x-form.modal.textarea>
                        @endif

                        @if($showMission)
                            <x-form.modal.textarea id="mission" label="{{ __('general.mission') }}" class="form-group col-sm-12" required="required">
                            </x-form.modal.textarea>
                        @endif

                        @if($showTemporality)
                            <x-form.modal.text id="temporalityStart" label="{{ __('general.temporality_start') }}" class="form-group col-sm-4" required="required"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('general.temporality_start')]) }}">
                            </x-form.modal.text>
                            <x-form.modal.text id="temporalityEnd" label="{{ __('general.temporality_end') }}" class="form-group col-sm-4" required="required"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('general.temporality_end')]) }}">
                            </x-form.modal.text>
                        @endif
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <x-form.modal.footer></x-form.modal.footer>
                </div>
            </form>
        </div>
    </div>
</div>
