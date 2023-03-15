<div class="modal fade" id="project-status-change" style="display: none;"
     data-backdrop="static" data-keyboard="false" wire:ignore.self>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <template x-if="phase">
                    <h3 class="modal-title">{{ trans('general.change_phase') }}</h3>
                </template>
                <template x-if="!phase">
                    <h3 class="modal-title">{{ trans('general.change_status') }}</h3>
                </template>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        x-on:click="show = false; transition=null">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <template x-if="phase">
                    <div class="d-flex align-items-center mb-6">

                        <div class="d-flex align-items-center flex-column">
                            <x-label-section>{{ trans('general.from') }}</x-label-section>
                            <span class="badge {{ $project->phase->color() }} fs-2x mr-3">
                          {{ $project->phase->label() }}
                            </span>
                        </div>

                        <span class="mr-3"><i class="fas fa-arrow-right color-success-500 fa-2x"></i></span>

                        <div class="d-flex align-items-center flex-column">
                            <x-label-section>{{ trans('general.to') }}</x-label-section>
                            <span class="badge @if($transition) {{ $project->phase->to($transition)->color() }}   @else     {{ $project->phase->to()->color() }} @endif fs-2x">
                                    @if($transition)
                                    {{$transition}}
                                @else
                                    {{ $project->phase->to()->label() }}
                                @endif
                            </span>
                        </div>
                    </div>
                </template>
                <template x-if="!phase">
                    <div class="d-flex align-items-center mb-6">
                        <div class="d-flex align-items-center flex-column">
                            <x-label-section>{{ trans('general.phase') }}</x-label-section>
                            <span class="badge fs-2x mr-3">{{ $project->phase }}:</span>
                        </div>

                        <div class="d-flex align-items-center flex-column">
                            <x-label-section>{{ trans('general.from') }}</x-label-section>
                            <span class="badge {{ $project->status->color() }} fs-2x mr-3">
                                {{ $project->status->label() }}
                            </span>
                        </div>

                        <span class="mr-3"><i class="fas fa-arrow-right color-success-500 fa-2x"></i></span>

                        <div class="d-flex align-items-center flex-column">
                            <x-label-section>{{ trans('general.to') }}</x-label-section>
                            <span class="badge @if($transition) {{ $project->status->to($transition)->color() }}   @else     {{ $project->status->to()->color() }} @endif fs-2x">
                                    @if($transition)
                                    {{$transition}}
                                @else
                                    {{ $project->status->to()->label() }}
                                @endif
                            </span>
                        </div>
                    </div>
                </template>
                <x-label-section>{{ trans('general.change_history') }}</x-label-section>

                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-2 content-detail"><span class="fw-700">{{ trans('general.from') }}</span>
                        </div>
                        <div class="col-1"></div>
                        <div class="col-2 content-detail"><span class="fw-700">{{ trans('general.to') }}</span>
                        </div>
                        <div class="col-4 content-detail"><span
                                    class="fw-700">{{ trans('general.updated_by') }}</span></div>
                        <div class="col-3 content-detail"><span class="fw-700">{{ trans('general.date') }}</span>
                        </div>
                    </div>
                    @foreach($project->statusChanges() as $change)
                        <div class="row mb-2">
                            <div class="col-2">
                                    <span class="badge {{ \App\Models\Projects\Project::statusColor($change->properties->get('old')['status']) }} mr-3">
                                        {{ $change->properties->get('old')['status'] }}
                                    </span>
                            </div>
                            <div class="col-1"><i class="fas fa-arrow-right color-success-500"></i></div>
                            <div class="col-2">
                                    <span class="badge {{ \App\Models\Projects\Project::statusColor($change->properties->get('attributes')['status']) }}">
                                        {{ $change->properties->get('attributes')['status'] }}
                                    </span>
                            </div>
                            <div class="col-4">
                                    <span class="mr-2">
                                        <img src="{{ asset_cdn('img/user.svg') }}" class="rounded-circle width-1">
                                    </span>
                                {{ $change->causer->name }}</div>
                            <div class="col-3">{{ company_date($change->created_at) }}</div>
                        </div>
                    @endforeach
                </div>
                <hr>
                <div class="panel-container show">
                    @if($viewOpening)
                        <div class="row">
                            <div class="col-10">
                                <div class="form-group">
                                    <div class="frame-wrap">
                                        <x-form.modal.checkbox id="accountsOpening" label="{{ __('general.accounts_opening') }}"
                                                               class="form-group col-sm-12"></x-form.modal.checkbox>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($viewSignature)
                        <div class="row">
                            <div class="col-10">
                                <div class="form-group">
                                    <div class="frame-wrap">
                                        <x-form.modal.checkbox id="signatureAgreement" label="{{ __('general.signature_of_agreement') }}"
                                                               class="form-group col-sm-12"></x-form.modal.checkbox>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <x-label-section>{{ trans('general.validations') }}</x-label-section>
                    <div class="frame-wrap demo">
                        <div class="demo">
                            @if($departments->validations)
                                @foreach($departments->validations as $index => $department)
                                    <div @if(!in_array($department['id'],$arrayIdsDepartments)) style="pointer-events:none;" @endif>
                                        <x-form.modal.textarea id="justification.{{$index}}"
                                                               label="{{ __('general.poa_request_justification') }}-{{$index}}"
                                                               class="form-group col-12"
                                        >
                                        </x-form.modal.textarea>
                                        <div class="form-group col-12 text-center">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input wire:model="accept.{{$index}}" type="radio"
                                                       class="custom-control-input"
                                                       id="goalAnswerApproved{{$index}}"
                                                       name="accept{{$index}}"
                                                >
                                                <label class="custom-control-label"
                                                       for="goalAnswerApproved{{$index}}">{{ __('general.poa_approved') }}</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input wire:model="decline.{{$index}}" type="radio"
                                                       class="custom-control-input"
                                                       id="golAnswerDenied{{$index}}" name="accept{{$index}}"
                                                >
                                                <label class="custom-control-label"
                                                       for="golAnswerDenied{{$index}}">{{ __('general.poa_denied') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @if($settings)
                        <table id="dt-basic-example"
                               class="table table-bordered table-striped w-100 dataTable no-footer dtr-inline"
                               role="grid"
                               aria-describedby="dt-basic-example_info">
                            <thead>
                            <tr role="row">
                                <th class="text-center"><span>{{trans('general.field')}}</span></th>

                                <th class="text-center">{{trans('general.complete')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($project->get($settings['fields'])->first()->toArray() as $index => $item)
                                <tr>
                                    <td class="text-center">
                                        {{trans('general.'.$index)}}
                                    </td>

                                    <td class="text-center"><i
                                                class="fal {{!$project->{$index}?'fa-ban color-danger-700':'fa-check color-success-700 '}} fa-2x"></i>
                                    </td>

                                </tr>
                            @endforeach
                            @foreach($settings['relations'] as $item)
                                <tr>
                                    <td class="text-center">
                                        {{trans('general.'.$item)}}
                                    </td>
                                    <td class="text-center"><i
                                                class="fal {{$project->{$item}->count()==0 ?'fa-ban color-danger-700':'fa-check color-success-700 '}} fa-2x"></i>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    @endif
                    @if($exists)
                        <div class="alert border-danger bg-transparent text-danger" role="alert">
                            No se puede cambiar de estado hasta que los campos obligatorios esten completos.
                        </div>
                    @else
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary shadow-none" data-dismiss="modal"
                                    x-on:click="show = false; transition=null">{{ trans('general.cancel') }}</button>
                            @if($phase)
                                <button type="button" class="btn btn-success border-0 shadow-none"
                                        wire:click="changePhase">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                                              wire:target="changePhase" wire:loading></span>
                                    {{ trans('general.change') }}
                                </button>
                            @else
                                <button type="button" class="btn btn-success border-0 shadow-none"
                                        wire:click="changeStatus">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                                              wire:target="changeStatus" wire:loading></span>
                                    {{ trans('general.change') }}
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
