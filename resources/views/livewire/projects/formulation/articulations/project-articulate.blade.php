<div>
    <div wire:ignore.self class="modal fade in" id="project-articulate-modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 60% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-info">
                        {{ __('general.articulate') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <form wire:submit.prevent="articulate()" method="post" autocomplete="off">
                    <div class="modal-body">
                        @if($plans)
                            <div class="col-12">
                                <div class="w-100">
                                    <h2>{{ trans_choice('general.plan',0)}}
                                    </h2>
                                    <hr>
                                </div>
                                <div class="panel-content">
                                    <div class="frame-wrap">
                                        <div class="demo">
                                            @foreach($plans as $plan)
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" id="selectedPlan.{{$plan->id}}" name="selectedPlan" wire:model="selectedPlan"
                                                           value="{{$plan->id}}">
                                                    <label class="custom-control-label" for="selectedPlan.{{$plan->id}}">{{$plan->name}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @if(!is_null($selectedPlan) && $this->planRegisteredTemplateDetailsSelected)
                                    <div class="w-100">
                                        <h2>{{$planRegisteredTemplateDetailsSelected->name}}</h2>
                                        <hr>
                                    </div>
                                    <div class="panel-content">
                                        <div class="row">
                                            @foreach($planDetailsSelected as $plan)
                                                <div class="col-12 col-lg-12 col-md-12">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="target.{{$plan->id}}" value="{{$plan->id}}"
                                                               wire:model.defer="target.{{$plan->id}}">
                                                        <label class="custom-control-label" for="target.{{$plan->id}}">{{$plan->name}}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if($planDetailsSelected && $planDetailsSelected->count()>0)
                                @if($planDetailsSelected->count()>0)
                                    <div class="card-body p-3">
                                        <div class="modal-footer justify-content-center">
                                            <x-form.modal.footer wirecancelevent="resetForm" class="disabled"></x-form.modal.footer>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
