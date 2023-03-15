<div class="card-body">
    <form wire:submit.prevent="articulate()" method="post" autocomplete="off">
        <div class="modal-body">
            @if($plans->count()>0)
                <div class="row">
                    @if($planRegisteredTemplateDetails)
                        @if($planDetails->count()>1)
                            <div class="col-6">
                                <div class="w-100">
                                    <h2>{{$planRegisteredTemplateDetails->name}}</h2>
                                    <hr>
                                </div>
                                <div class="panel-content">
                                    <div class="frame-wrap">
                                        <div class="demo">
                                            @foreach($planDetails as $plan)
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                           id="source.{{$plan->id}}" name="source" wire:model="source"
                                                           value="{{$plan->id}}">
                                                    <label class="custom-control-label"
                                                           for="source.{{$plan->id}}">{{$plan->name}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class=" @if($planDetails->count()!=1) col-6 @else col-12 @endif">
                            <div class="w-100">
                                <h2>Planes</h2>
                                <hr>
                            </div>
                            <div class="panel-content">
                                <div class="frame-wrap">
                                    <div class="demo">
                                        @forelse($plans as $plan)
                                            @if($plan->canBeRelated())
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                           id="selectedPlan.{{$plan->id}}" name="selectedPlan"
                                                           wire:model="selectedPlan"
                                                           value="{{$plan->id}}">
                                                    <label class="custom-control-label"
                                                           for="selectedPlan.{{$plan->id}}">{{$plan->name}}</label>
                                                </div>
                                            @endif
                                        @empty

                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            @if(!is_null($selectedPlan))
                                <div class="alert alert-light  w-100">
                                    <h2>{{$planRegisteredTemplateDetailsSelected->name}}</h2>
                                    <hr>
                                </div>
                                <div class="panel-content">
                                    <div class="frame-wrap">
                                        <div class="demo mr-2 ml-2" style="display: inline-flex">
                                            <div class="row">
                                                @foreach($planDetailsSelected as $plan)
                                                    <div class="col-lg-4 mb-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                   id="target.{{$plan->id}}" value="{{$plan->id}}"
                                                                   wire:model.defer="target.{{$plan->id}}">
                                                            <label class="custom-control-label"
                                                                   for="target.{{$plan->id}}">{{$plan->name}}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endif
                        </div>
                    @endif
                </div>
                <div class="card-body p-3">
                    <div class="modal-footer justify-content-center">
                        <x-form.modal.footer wirecancelevent="resetForm" class="disabled"></x-form.modal.footer>
                    </div>
                </div>
            @else

                <x-empty-content>
                    <x-slot name="title">
                        No existen planes para articular
                    </x-slot>
                </x-empty-content>


            @endif
        </div>
    </form>
</div>
