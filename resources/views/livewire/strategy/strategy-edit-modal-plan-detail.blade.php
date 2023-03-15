<div wire:ignore.self class="modal fade in" id="edit-modal-plan-detail" tabindex="-1" role="dialog" aria-hidden="true"
     data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        @if($planDetailId)
            <div class="modal-content">
                <div class="modal-header mb-0 pb-0">
                    <h1 class="text-center fw-700">
                        {{$planDetail->name}}
                    </h1>
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
                                           ire:ignore.self>
                                            <h3 class="text-center fw-500 ">       {{trans('general.general_information')}}</h3>
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
                                         data-parent="#js_demo_accordion-1" wire:ignore.self>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-2 mb-0">
                                                    <label class="col-form-label col-form-label-sm"><b>{{ trans('general.code') }}</b></label>
                                                    <livewire:components.input-inline-edit :modelId="$planDetailId"
                                                                                           class="\App\Models\Strategy\PlanDetail"
                                                                                           field="code"
                                                                                           :rules="$rule"
                                                                                           defaultValue="{{$planDetail->code}}"
                                                                                           :key="time().$planDetailId"/>
                                                </div>

                                                <div class="form-group col-md-10 mb-0">
                                                    <label class="col-form-label col-form-label-sm"><b>{{ trans('general.name') }}</b></label>
                                                    <livewire:components.input-inline-edit :modelId="$planDetailId"
                                                                                           class="\App\Models\Strategy\PlanDetail"
                                                                                           field="name"
                                                                                           :rules="'required|max:255|min:5'"
                                                                                           defaultValue="{{$planDetail->name}}"
                                                                                           :key="time().$planDetailId"/>
                                                </div>
                                                <div class="form-group col-md-10 mb-0 mt-1">
                                                    @if($creObjective)
                                                        <div class="form-group col-sm-12">
                                                            <div class="frame-wrap">
                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                    <input wire:click="updateMissionObjective" type="radio" class="custom-control-input" id="missionObjective"
                                                                           name="objectiveType" {{$missionObjective==true ? 'checked' : ''}} >
                                                                    <label class="custom-control-label" for="missionObjective">{{ __('general.mission_objective') }}</label>
                                                                </div>
                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                    <input wire:click="updateOrganizationalDevelopment" type="radio" class="custom-control-input"
                                                                           id="organizationalDevelopment"
                                                                           name="objectiveType" {{$organizationalDevelopment==true ? 'checked' : ''}}>
                                                                    <label class="custom-control-label"
                                                                           for="organizationalDevelopment">{{ __('general.organizational_development') }}</label>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <x-form.modal.select wire:model="perspective" id="perspective" label="{{ __('general.perspective') }}"
                                                                                     class="form-group col-sm-4"
                                                                                     required="required">
                                                                    <option value="">{{ __('general.select') }}</option>
                                                                    @foreach($perspectives as $item)
                                                                        <option value="{{ $item }}" @if(in_array($perspective,$perspectives->toArray())) selected @endif>
                                                                            {{ $item }}
                                                                        </option>
                                                                    @endforeach
                                                                </x-form.modal.select>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @foreach($children as $index => $child)
                                    <div class="card" wire:ignore.self>
                                        <div class="card-header">
                                            <a href="javascript:void(0);" class="card-title collapsed"
                                               data-toggle="collapse"
                                               data-target="#js_demo_accordion-1{{$index}}" aria-expanded="false">
                                                <h3 class="text-center fw-500 ">{{$child->name}}</h3>
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
                                             data-parent="#js_demo_accordion-1" wire:ignore.self>
                                            @foreach($child->planDetails->where('parent_id',$planDetail->id) as $planElement)
                                                <div class="row">
                                                    <div class="form-group col-md-2 mb-0">
                                                        @if($loop->first)
                                                            <label class="col-form-label col-form-label-sm"><b>{{ trans('general.code') }}</b></label>
                                                        @endif
                                                        <livewire:components.input-inline-edit
                                                                :modelId="$planElement->id"
                                                                class="\App\Models\Strategy\PlanDetail"
                                                                field="code"
                                                                :rules="'required|max:5|alpha_num|alpha_dash|unique:plan_details,code,' . $planElement->id . ',id,plan_id,' . $planElement->plan_id. ',parent_id,'.$planElement->parent_id"
                                                                defaultValue="{{$planElement->code}}"
                                                                :key="time().$planElement->id"/>
                                                    </div>
                                                    <div class="form-group col-md-8 mb-0">
                                                        @if($loop->first)
                                                            <label class="col-form-label col-form-label-sm"><b>{{ trans('general.name') }}</b></label>
                                                        @endif
                                                        <livewire:components.input-inline-edit
                                                                :modelId="$planElement->id"
                                                                class="\App\Models\Strategy\PlanDetail"
                                                                field="name"
                                                                :rules="'required|max:255|min:5'"
                                                                defaultValue="{{$planElement->name}}"
                                                                :key="time().$planElement->id"/>
                                                    </div>
                                                    <button wire:click="$emit('elementDelete', '{{ $planElement->id }}')"
                                                            class="mr-2 border-0" id="btn-1" data-toggle="tooltip"
                                                            data-placement="top" title=""
                                                            data-original-title="Eliminar"
                                                            style="border: 0 !important; background-color: transparent !important;">
                                                        <i class="fas fa-trash mr-1 text-danger"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                            <br>
                                            <livewire:strategy.strategy-plan-detail-create-component
                                                    :templateDetailId="$child->id"
                                                    :planId="$planDetail->plan->id"
                                                    :planDetailId="$planDetail->id"
                                                    :key="time().$child->id"/>
                                        </div>
                                    </div>
                                @endforeach

                                @if($planDetail->planRegistered->articulations)
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="javascript:void(0);" class="card-title collapsed"
                                               data-toggle="collapse" data-target="#js_demo_accordion-1d"
                                               aria-expanded="false">

                                                <h3 class="text-center fw-500 "> Alineaciones</h3>
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
                                        <div id="js_demo_accordion-1d" class="collapse  m-sm-3"
                                             data-parent="#js_demo_accordion-1" wire:ignore.self>
                                            <livewire:strategy.strategy-plan-articulations :plan="$planDetail->plan"
                                                                                           :planDetailId="$planDetail->id"/>
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
                                                <div class="w-100 text-center">
                                                    <a href="javascript:void(0);" wire:click="articulate()"
                                                       class="btn btn-info btn-sm w-20 mb-2 mr-2">
                                                        &nbsp;Cerrar
                                                    </a>
                                                </div>
                                            @endif
                                            @if($articulate)
                                                <livewire:strategy.plan-articulate :plan="$planDetail->plan"
                                                                                   :planDetailId="$planDetail->id"/>
                                            @endif
                                        </div>
                                    </div>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@push('page_script')
    <script defer>
        document.addEventListener('DOMContentLoaded', function () {
        @this.on('elementDelete', id => {
            Swal.fire({
                target: document.getElementById('edit-modal-plan-detail'),
                title: '{{ trans('messages.warning.sure') }}',
                text: '{{ trans('messages.warning.delete') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--danger)',
                confirmButtonText: '<i class="fas fa-trash"></i> {{ trans('general.yes') . ', ' . trans('general.delete') }}',
                cancelButtonText: '<i class="fas fa-times"></i> {{ trans('general.no') . ', ' . trans('general.cancel') }}'
            }).then((result) => {
                if (result.value) {
                @this.call('delete', id);
                }
            });
        });
        })
    </script>
@endpush