<div class="row">
    <div class="col-xl-5">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    {{ trans_choice('general.data', 2) . ' ' . trans_choice('general.templates', 1) }}
                </h2>
            </div>
            <div class="panel-container show">
                <form wire:submit.prevent="update" method="post" autocomplete="off">
                    <div class="panel-content">
                        <x-form.modal.text id="planType" label="{{ __('general.plan_type') }}"
                                           class="form-group col-sm-8" value="{{ $planType }}" readonly="readonly"
                                           required="required">
                        </x-form.modal.text>

                        <x-form.modal.text id="description" label="{{ __('general.description') }}"
                                           class="form-group col-sm-12" value="{{ $description }}" required="required">
                        </x-form.modal.text>

                        <div class="row ml-1">
                            <x-form.modal.checkbox id="vision" label="{{ __('general.vision') }}"
                                                   class="form-group col-sm-2" value="1"></x-form.modal.checkbox>
                            <x-form.modal.checkbox id="mission" label="{{ __('general.mission') }}"
                                                   class="form-group col-sm-2" value="1"></x-form.modal.checkbox>
                            <x-form.modal.checkbox id="temporality" label="{{ __('general.temporality') }}"
                                                   class="form-group col-sm-2" value="1"></x-form.modal.checkbox>
                        </div>
                    </div>
                    <div class="panel-content text-right py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0">
                        <div class="row">
                            <div class="col-12">
                                <x-form.inputs.button type="submit" label="{{ __('general.save') }}"
                                                      icon="fa-save"></x-form.inputs.button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-7">
        <div id="panel-4" class="panel">
            <div class="panel-hdr">
                <h2>
                    {{ __('general.specific_elements') }}
                </h2>
                <div class="panel-toolbar">
                    <a href="javascript:void(0);" class="btn btn-success btn-xs btn-icon waves-effect waves-themed"
                       data-toggle="modal" data-target="#new-modal-element">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="widget-body">
                        <div class="tree smart-form">
                            <ul role="tree">
                                <li class="parent_li" role="treeitem">
                                    <span title="Collapse this branch"><i class="fa fa-lg fa-folder-open"></i> {{ trans_choice('general.elements', 2) }}</span>
                                    {!! $htmlTree !!}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade in" id="new-modal-element" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ __('general.add') . ' ' . trans_choice('general.elements', 1) }}
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
                            @if(count($elementsTree)>0)
                                <x-form.modal.select id="parentId" label="{{ __('general.parent_element') }}"
                                                     class="form-group col-sm-4" required="required">
                                    <option value="" selected>{{ __('general.select') }}</option>
                                    <option value="0">{{ trans_choice('general.elements', 2) }}</option>
                                    @foreach($elementsTree as $item)
                                        <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                    @endforeach
                                </x-form.modal.select>
                            @endif
                            <x-form.modal.text id="name" label="{{ __('general.name') }}" class="form-group col-sm-8"
                                               required="required"
                                               value="{{ old('name') }}"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('general.name')]) }}">
                            </x-form.modal.text>
                        </div>
                        <hr>
                        <div class="row">
                            <x-form.modal.checkbox id="indicators" label="{{ __('general.indicator_manage') }}"
                                                   class="form-group col-sm-3" value="1"></x-form.modal.checkbox>
                        </div>


                        @if($hasPrograms<1)
                            <div class="row">
                                <x-form.modal.checkbox id="program" name="program" label="{{ __('general.program_manage') }}"
                                                       class="form-group col-sm-3" value="1"></x-form.modal.checkbox>
                            </div>
                        @endif

                        @if(($hasPoaIndicators<1 && $program) || ($hasPrograms>=1&& $hasPoaIndicators<1))
                            <div class="row">
                                <x-form.modal.checkbox id="poaIndicators" label="{{ __('general.indicator_POA') }}"
                                                       class="form-group col-sm-3" value="1"></x-form.modal.checkbox>
                            </div>
                        @endif

                        @if($hasArticulations<1)
                            <div class="row">
                                <x-form.modal.checkbox id="articulations"
                                                       label="{{ __('general.articulations_manage') }}"
                                                       class="form-group col-sm-3"
                                                       value="1"></x-form.modal.checkbox>
                            </div>
                        @endif

                        @if($crePlanType)
                            <div class="row">
                                <x-form.modal.checkbox id="creObjective"
                                                       label="{{ __('general.cre_strategy_objectives') }}"
                                                       class="form-group col-sm-4" value="1">
                                </x-form.modal.checkbox>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer justify-content-center">
                        <x-form.modal.footer></x-form.modal.footer>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade in" id="edition-modal-element" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ trans_choice('general.data', 2) . ' ' . trans_choice('general.elements', 1) }}
                        <small class="m-0 text-muted">
                            {{ __('general.edit_template_description') }}
                        </small>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <form wire:submit.prevent="elementDelete" method="post" autocomplete="off">
                    <div class="modal-body">
                        <div class="row">
                            <x-form.modal.text id="editionParentName" label="{{ __('general.parent_element') }}"
                                               class="form-group col-sm-4" required="required"
                                               readonly="readonly">
                            </x-form.modal.text>
                            <x-form.modal.text id="editionName" label="{{ __('general.name') }}"
                                               class="form-group col-sm-8" required="required" readonly="readonly">
                            </x-form.modal.text>
                        </div>
                        <div class="row">
                            <x-form.modal.checkbox id="editionIndicators" label="{{ __('general.indicator_manage') }}"
                                                   class="form-group col-sm-3" value="1" disabled="disabled">
                            </x-form.modal.checkbox>
                        </div>
                        <div class="row">
                            <x-form.modal.checkbox id="editionPoaIndicators" label="{{ __('general.indicator_POA') }}"
                                                   class="form-group col-sm-3" value="1" disabled="disabled">
                            </x-form.modal.checkbox>
                        </div>

                        <div class="row">
                            <x-form.modal.checkbox id="editionProgram" label="{{ __('general.program_manage') }}"
                                                   class="form-group col-sm-3" value="1" disabled="disabled">
                            </x-form.modal.checkbox>
                        </div>

                        <div class="row">
                            <x-form.modal.checkbox id="editionArticulations" label="{{ __('general.articulations_manage') }}"
                                                   class="form-group col-sm-3" value="1" disabled="disabled">
                            </x-form.modal.checkbox>
                        </div>

                        @if($crePlanType)
                            <div class="row">
                                <x-form.modal.checkbox id="editionCreObjective"
                                                       label="{{ __('general.cre_strategy_objectives') }}"
                                                       class="form-group col-sm-4" value="1"
                                                       disabled="disabled">
                                </x-form.modal.checkbox>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer justify-content-center">
                        <x-form.modal.footer-delete delete="{{ $editionDelete }}"></x-form.modal.footer-delete>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
