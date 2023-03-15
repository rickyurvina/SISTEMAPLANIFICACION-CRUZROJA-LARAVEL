<div>
    <div class="container-fluid">
        <div class="row">
            <div class="form-group col-md-2 mb-0">
                <label class="col-form-label col-form-label-sm"><b>{{ trans('general.code') }}</b></label>

            </div>
            <div class="form-group col-md-8 mb-0">
                <label class="col-form-label col-form-label-sm"><b>{{ trans('general.name') }}</b></label>

            </div>
        </div>
        @foreach($planDetails as $planDetail)
            <div class="row" wire:ignore.self>
                <div class="form-group col-md-2 mb-0">
                    <livewire:components.input-inline-edit :modelId="$plan->id"
                                                           class="\App\Models\Strategy\PlanDetail"
                                                           field="code"
                                                           :rules="'required|max:5|alpha_num|alpha_dash|unique:plan_details,code,' . $planDetail->id . ',id,plan_id,' . $planDetail->plan_id. ',parent_id,NULL'"
                                                           defaultValue="{{$planDetail->code}}"
                                                           :key="time().$plan->id"/>
                </div>

                <div class="form-group col-md-8 mb-0">
                    <livewire:components.input-inline-edit :modelId="$plan->id"
                                                           class="\App\Models\Strategy\PlanDetail"
                                                           field="name"
                                                           :rules="'required|max:255|min:5'"
                                                           defaultValue="{{$planDetail->name}}"
                                                           :key="time().$plan->id"/>
                </div>
                <div class="form-group col-md-2 mb-0">
                    <button wire:click="openModalDelete({{ $planDetail->id }})" class="mr-2 border-0" id="btn-1" data-toggle="tooltip" wire:key="{{$planDetail->id}}"
                            data-placement="top" title="Eliminar {{$planDetail->name}}"
                            data-original-title="Eliminar {{$planDetail->name}}"
                            style="border: 0 !important; background-color: transparent !important;">
                        <i class="fas fa-trash mr-1 text-danger"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="m-2" wire:ignore>
        <livewire:strategy.strategy-plan-detail-create-component :templateDetailId="$template_detail_id" :planId="$plan->id" key="time().$plan_id"/>
    </div>
</div>