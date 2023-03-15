<div>
    <div class="row">
        @forelse($planTemplates as $planTemplate)
            <div class="col-sm-3">
                <div class="card border mb-g">
                    <div class="card-header bg-trans-gradient py-2 pr-2 d-flex align-items-center flex-wrap">
                        <div class="card-title text-white">{{ $planTemplate->plan_type }}</div>
                        <span class="badge {{ $planTemplate->status ? 'badge-success' : 'badge-danger' }} badge-pill ml-auto">
                        {{ $planTemplate->status ? __('general.enabled') : __('general.disabled')}}
                    </span>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $planTemplate->description }}</p>
                    </div>
                    @if(Gate::check('strategy-template-crud-strategy') || Gate::check('strategy-crud-strategy'))
                        <div class="card-footer text-right">
                            <x-form.inputs.link route="{{ route('templates.edit', ['template' => $planTemplate->id]) }}"
                                                label="{{ __('general.edit_template_strategy') }}" icon="fa-edit">
                            </x-form.inputs.link>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-12">
                <x-empty-content>
                    <x-slot name="title">
                        No existen plantillas definidas
                    </x-slot>
                </x-empty-content>

            </div>
        @endforelse
        <div wire:ignore.self class="modal fade in" id="new-modal-template" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            {{ __('general.add') . ' ' . trans_choice('general.templates', 1) }}
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
                                <x-form.modal.select id="planType" label="{{ __('general.plan_type') }}" class="form-group col-sm-4" required="required">
                                    <option value="" selected>{{ __('general.select') }}</option>
                                    @foreach($planTypes as $item)
                                        <option value="{{ $item }}">
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </x-form.modal.select>
                                <x-form.modal.text id="description" label="{{ __('general.description') }}" class="form-group col-sm-8" required="required"
                                                   value="{{ old('description') }}" placeholder="{{ trans('general.form.enter', ['field' => trans('general.description')]) }}">
                                </x-form.modal.text>
                            </div>
                            <div class="row">
                                <x-form.modal.checkbox id="vision" label="{{ __('general.vision') }}" class="form-group col-sm-2" value="1"></x-form.modal.checkbox>
                            </div>
                            <div class="row">
                                <x-form.modal.checkbox id="mission" label="{{ __('general.mission') }}" class="form-group col-sm-2" value="1"></x-form.modal.checkbox>
                            </div>
                            <div class="row">
                                <x-form.modal.checkbox id="temporality" label="{{ __('general.temporality') }}" class="form-group col-sm-2" value="1"></x-form.modal.checkbox>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <x-form.modal.footer></x-form.modal.footer>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
