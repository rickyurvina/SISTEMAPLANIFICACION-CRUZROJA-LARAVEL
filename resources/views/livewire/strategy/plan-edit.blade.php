<div wire:ignore.self class="modal fade in" id="edit-modal-plan" tabindex="-1" role="dialog" aria-hidden="true"
     data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        @if($planId)
            <div class="modal-content">
                <div class="modal-header mb-0 pb-0">
                    <h1 class="text-center fw-700">
                        {{$plan->name}}
                    </h1>
                    <div class="ml-5">
                        @switch($statusEdition)
                            @case(\App\Models\Strategy\Plan::DRAFT)
                            <small class="badge badge-info badge-pill text-center w-100"
                                   style="height: 30px; align-items: center; display: grid">{{ __('general.poa_draft') }}</small>
                            @break
                            @case(\App\Models\Strategy\Plan::ACTIVE)
                            <small class="badge badge-success badge-pill text-center w-100"
                                   style="height: 30px; align-items: center; display: grid">{{ __('general.enabled') }}</small>
                            @break
                            @case(\App\Models\Strategy\Plan::ARCHIVED)
                            <small class="badge badge-primary badge-pill text-center w-100"
                                   style="height: 30px; align-items: center; display: grid">{{ __('general.archived') }}</small>
                            @break
                        @endswitch

                    </div>
                    <button type="button" wire:click="resetModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>

                <div class="modal-body mt-0 pt-0 m-sm-3">
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="accordion accordion-hover" id="js_demo_accordion-1">
                                <div class="card">
                                    <div class="card-header">
                                        <a href="javascript:void(0);" class="card-title" data-toggle="collapse"
                                           data-target="#js_demo_accordion-1a" aria-expanded="true"
                                           wire:ignore>
                                            <h3 class="text-center fw-500"> {{trans('general.general_information')}}</h3>
                                            <span class="ml-auto">
                                                <span class="collapsed-reveal">
                                                    <i class="fal fa-minus-circle text-danger fs-xl"></i>
                                                </span>
                                                <span class="collapsed-hidden">
                                                    <i class="fal fa-plus-circle text-success fs-xl"></i>
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                    <div id="js_demo_accordion-1a" class="collapse show m-sm-3"
                                         data-parent="#js_demo_accordion-1" wire:ignore>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-0">
                                                    <label class="col-form-label col-form-label-sm"><b>{{ trans('general.code') }}</b></label>
                                                    <livewire:components.input-inline-edit :modelId="$planId"
                                                                                           class="\App\Models\Strategy\Plan"
                                                                                           field="code"
                                                                                           defaultValue="{{$plan->code}}"
                                                                                           :key="time().$planId"/>
                                                </div>

                                                <div class="form-group col-md-6 mb-0">
                                                    <label class="col-form-label col-form-label-sm"><b>{{ trans('general.responsable') }}</b></label>

                                                    <livewire:components.select-inline-edit :modelId="$planId"
                                                                                            :fieldId="$plan->responsible->id"
                                                                                            class="\App\Models\Strategy\Plan"
                                                                                            field="responsable"
                                                                                            value="{{$plan->responsible->name??''}}"
                                                                                            :selectClass="$users"
                                                                                            selectField="name"
                                                                                            selectRelation="responsable"
                                                                                            :key="time().$planId"/>
                                                </div>

                                                <div class="form-group col-md-6 mb-0">
                                                    <label class="col-form-label col-form-label-sm"><b>{{ trans('general.name') }}</b></label>
                                                    <livewire:components.input-inline-edit :modelId="$planId"
                                                                                           class="\App\Models\Strategy\Plan"
                                                                                           :rules="'required|max:500|min:5'"
                                                                                           field="name"
                                                                                           defaultValue="{{$plan->name}}"
                                                                                           :key="time().$planId"/>
                                                </div>

                                                <div class="form-group col-md-6 mb-0">
                                                    <label class="col-form-label col-form-label-sm"><b>{{ trans('general.description') }}</b></label>
                                                    <livewire:components.input-inline-edit :modelId="$planId"
                                                                                           class="\App\Models\Strategy\Plan"
                                                                                           field="description"
                                                                                           :rules="'required'"
                                                                                           type="textarea"
                                                                                           rows="10"
                                                                                           defaultValue="{{$plan->description}}"
                                                                                           :key="time().$planId"/>
                                                </div>

                                                @if($showVisionEdition)
                                                    <div class="form-group col-md-6 mb-0">
                                                        <label class="col-form-label col-form-label-sm"><b>{{ trans('general.vision') }}</b></label>
                                                        <livewire:components.input-inline-edit :modelId="$planId"
                                                                                               class="\App\Models\Strategy\Plan"
                                                                                               field="vision"
                                                                                               type="textarea"
                                                                                               rows="10"
                                                                                               defaultValue="{{$plan->vision}}"
                                                                                               :key="time().$planId"/>
                                                    </div>
                                                @endif

                                                @if($showMissionEdition)
                                                    <div class="form-group col-md-6 mb-0">
                                                        <label class="col-form-label col-form-label-sm"><b>{{ trans('general.mission') }}</b></label>
                                                        <livewire:components.input-inline-edit :modelId="$planId"
                                                                                               class="\App\Models\Strategy\Plan"
                                                                                               field="mission"
                                                                                               type="textarea"
                                                                                               defaultValue="{{$plan->mission}}"
                                                                                               :key="time().$planId"/>
                                                    </div>
                                                @endif

                                                @if($showTemporalityEdition)
                                                    <div class="form-group col-md-6 mb-0">
                                                        <label class="col-form-label col-form-label-sm"><b>{{ trans('general.temporality_start') }}</b></label>
                                                        <livewire:components.input-inline-edit :modelId="$planId"
                                                                                               class="\App\Models\Strategy\Plan"
                                                                                               field="temporality_start"
                                                                                               :rules="'numeric'"
                                                                                               defaultValue="{{$plan->temporality_start}}"
                                                                                               :key="time().$planId"/>
                                                    </div>
                                                    <div class="form-group col-md-6 mb-0">
                                                        <label class="col-form-label col-form-label-sm"><b>{{ trans('general.temporality_end') }}</b></label>
                                                        <livewire:components.input-inline-edit :modelId="$planId"
                                                                                               class="\App\Models\Strategy\Plan"
                                                                                               field="temporality_end"
                                                                                               :rules="'numeric'"
                                                                                               defaultValue="{{$plan->temporality_end}}"
                                                                                               :key="time().$planId"/>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <a href="javascript:void(0);" class="card-title collapsed"
                                           data-toggle="collapse" data-target="#js_demo_accordion-1b"
                                           aria-expanded="false" wire:ignore>

                                            <h3 class="text-center fw-500">   {{trans('general.update_plan_status')}}</h3>
                                            <span class="ml-auto">
                                                                    <span class="collapsed-reveal">
                                                                        <i class="fal fa-minus-circle text-danger fs-xl"></i>
                                                                    </span>
                                                                    <span class="collapsed-hidden">
                                                                        <i class="fal fa-plus-circle text-success fs-xl"></i>
                                                                    </span>
                                                                </span>
                                        </a>
                                    </div>
                                    <div id="js_demo_accordion-1b" class="collapse m-sm-3"
                                         data-parent="#js_demo_accordion-1" wire:ignore>
                                        <livewire:strategy.plan-status-update :plan="$plan"/>
                                        <br>
                                    </div>
                                </div>
                                @foreach($elementChildren as $index => $child)
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="javascript:void(0);" class="card-title collapsed"
                                               data-toggle="collapse" data-target="#js_demo_accordion-1{{$index}}"
                                               aria-expanded="false" wire:ignore>

                                                <h3 class="text-center fw-500">
                                                    {{$child->name}}
                                                </h3>
                                                <span class="ml-auto">
                                                <span class="collapsed-reveal">
                                                    <i class="fal fa-minus-circle text-danger fs-xl"></i>
                                                </span>
                                                <span class="collapsed-hidden">
                                                    <i class="fal fa-plus-circle text-success fs-xl"></i>
                                                </span>
                                            </span>
                                            </a>
                                        </div>
                                        <div id="js_demo_accordion-1{{$index}}" class="collapse m-sm-3"
                                             data-parent="#js_demo_accordion-1" wire:ignore>
                                            <div wire:ignore>
                                                <livewire:strategy.plan-show-plan-details :plan="$plan" planRegisteredTemplateDetailId="{{$child->id}}"/>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="card">
                                    <div class="card-header">
                                        <a href="javascript:void(0);" class="card-title collapsed"
                                           data-toggle="collapse" data-target="#js_demo_accordion-1d"
                                           aria-expanded="false" wire:ignore>

                                            <h3 class="text-center fw-500"> Alineaciones</h3>
                                            <span class="ml-auto">
                                                <span class="collapsed-reveal">
                                                    <i class="fal fa-minus-circle text-danger fs-xl"></i>
                                                </span>
                                                <span class="collapsed-hidden">
                                                    <i class="fal fa-plus-circle text-success fs-xl"></i>
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                    <div id="js_demo_accordion-1d" class="collapse m-sm-3"
                                         data-parent="#js_demo_accordion-1" wire:ignore.self>
                                        <div wire:ignore>
                                            <livewire:strategy.strategy-plan-articulations :plan="$plan"/>
                                        </div>
                                        <br>
                                        @if(!$articulate)
                                            <div class="w-100 text-center">
                                                <a href="javascript:void(0);" wire:click="articulate()"
                                                   class="btn btn-success btn-sm w-20 mb-2 mr-2"><span
                                                            class="fas fa-plus mr-1"></span>
                                                    &nbsp;Articular
                                                </a>
                                            </div>
                                        @else
                                            <div class="w-100 text-center mb-2">
                                                <a href="javascript:void(0);" wire:click="articulate()"
                                                   class="btn btn-info btn-sm w-20 mb-2 mr-2">
                                                    &nbsp;Cerrar
                                                </a>
                                            </div>
                                        @endif
                                        @if($articulate)
                                            <div class="mt-2">
                                                <livewire:strategy.plan-articulate :plan="$plan"/>

                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@push('page_script')
    <script>
        window.addEventListener('deletePlanDetail', event => {
            Swal.fire({
                target: document.getElementById('edit-modal-plan'),
                title: '{{ trans('messages.warning.sure') }}',
                text: '{{ trans('messages.warning.delete') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--danger)',
                confirmButtonText: '<i class="fas fa-trash"></i> {{ trans('general.yes') . ', ' . trans('general.delete') }}',
                cancelButtonText: '<i class="fas fa-times"></i> {{ trans('general.no') . ', ' . trans('general.cancel') }}'
            }).then((result) => {
                if (result.value) {
                    Livewire.emit('deletePlanDetailModal', event.detail.id);
                }
            });

        })
    </script>
@endpush