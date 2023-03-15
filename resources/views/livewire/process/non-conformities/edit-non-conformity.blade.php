<div>
    <div class="d-flex flex-column">
        <div class="d-flex flex-nowrap">
            <div class="flex-grow-1 w-100" style="overflow: hidden auto">
                <div class="pr-4">
                    <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab-general" role="tab"
                               aria-selected="true">{{ trans('general.general') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-actions" role="tab"
                               aria-selected="false">{{ trans('general.actions') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-general" role="tabpanel">
                            <div class="d-flex flex-wrap">
                                <div class="pl-2 content-detail mt-2 w-20">
                                    <div class="d-flex flex-wrap mt-2">
                                        <x-label-detail>SACP levantada por</x-label-detail>
                                        <div class="detail mt-2">
                                            {{$nonConformity->raised_by? $nonConformity->raisedBy->getFullName():''}}
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap mt-2">
                                        <x-label-detail>Dueño de proceso</x-label-detail>
                                        <div class="detail mt-2">
                                            {{$nonConformity->user_id? $nonConformity->responsible->getFullName():''}}
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap mt-2">
                                        <x-label-detail>{{trans('general.created_at')}}</x-label-detail>
                                        <div class="detail mt-2">
                                            {{$nonConformity->date->format('j F, Y')}}
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap mt-2">
                                        <x-label-detail>Fecha de Verificación de Cierre</x-label-detail>
                                        <div class="detail mt-2">
                                            {{$nonConformity->verification_close_date? $nonConformity->verification_close_date->format('j F, Y'):''}}
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap mt-2">
                                        <x-label-detail>Fecha de Verificación de Eficacia</x-label-detail>

                                        <div class="detail mt-2">
                                            {{$nonConformity->verification_effectiveness_date? $nonConformity->verification_effectiveness_date->format('j F, Y'):''}}
                                        </div>
                                    </div>
                                </div>
                                <div class="pl-2 content-detail mt-2 w-50">
                                    <div class="d-flex flex-wrap w-90">
                                        <x-label-detail>{{__('general.code')}}:</x-label-detail>
                                        <div class="detail">
                                            <livewire:components.input-inline-edit :modelId="$nonConformity->id"
                                                                                   class="\App\Models\Process\NonConformities"
                                                                                   field="code"
                                                                                   :rules="'required|max:5|alpha_num|alpha_dash|unique:non_conformities,code,' . $nonConformity->id . ',id,process_id,' . $nonConformity->process_id. ',deleted_at,NULL'"
                                                                                   type="text"
                                                                                   defaultValue="{{ $nonConformity->code ?? ''}}"
                                                                                   :key="time().$nonConformity->id"/>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap w-100 mt-2">
                                        <x-label-detail>{{trans('general.number')}}</x-label-detail>
                                        <div class="detail">
                                            <livewire:components.input-inline-edit :modelId="$nonConformity->id"
                                                                                   class="\App\Models\Process\NonConformities"
                                                                                   field="number" type="text"
                                                                                   :rules="'required'"
                                                                                   defaultValue="{{$nonConformity->number ?? ''}}"
                                                                                   :key="time().$nonConformity->id"
                                            />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap w-90">
                                        <x-label-detail>{{__('general.type')}}:</x-label-detail>
                                        <div class="detail">
                                            <livewire:components.select-inline-edit :modelId="$nonConformity->id"
                                                                                    class="\App\Models\Process\NonConformities"
                                                                                    field="type"
                                                                                    value="{{$nonConformity->type ?? ''}}"
                                                                                    :selectArray="\App\Models\Process\NonConformities::TYPES"
                                                                                    :key="time().$nonConformity->id"/>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap w-90">
                                        <x-label-detail>{{__('general.description')}}:</x-label-detail>
                                        <div class="detail">
                                            <livewire:components.input-inline-edit :modelId="$nonConformity->id"
                                                                                   class="\App\Models\Process\NonConformities"
                                                                                   field="description"
                                                                                   :rules="'required|max:500'"
                                                                                   type="textarea"
                                                                                   defaultValue="{{ $nonConformity->description ?? ''}}"
                                                                                   :key="time().$nonConformity->id"/>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <x-label-detail>{{ trans('general.evidence') }}</x-label-detail>
                                        <div class="detail">
                                            <livewire:components.input-inline-edit :modelId="$nonConformity->id"
                                                                                   class="\App\Models\Process\NonConformities"
                                                                                   field="evidence"
                                                                                   :rules="'required|max:500'"
                                                                                   type="textarea"
                                                                                   defaultValue="{{ $nonConformity->evidence ?? ''}}"
                                                                                   :key="time().$nonConformity->id"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="pl-4 content-detail mt-2 w-30">
                                    <div class="d-flex flex-wrap">
                                        <livewire:components.list-view-edit title="{{ __('general.causes') }} Raiz"
                                                                            event="causesEdited"
                                                                            componentId="causes"
                                                                            :elements="$causesItems"
                                        />
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="tab-actions" role="tabpanel">
                            <div>
                                <livewire:process.non-conformities.actions.non-conformity-actions-index :nonConformityId="$nonConformity->id"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
