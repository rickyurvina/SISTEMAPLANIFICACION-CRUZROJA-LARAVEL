<div>
    <div wire:ignore.self class="modal fade in" id="edit-request-modal" tabindex="-1" role="dialog"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-right">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4">{{ __('general.poa_indicator_goal_request_change') }}</h5>
                    <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <form wire:submit.prevent="submitRequest()" method="post" autocomplete="off">
                    <div class="modal-body">
                        <div class="row">
                            @if($itemsRequests)
                                <div class="table-responsive">
                                    <table class="table table-light table-hover">
                                        <thead>
                                        <tr>
                                            <th>Mes</th>
                                            <th>Valor Antiguo</th>
                                            <th>Valor Nuevo</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($itemsRequests as $index => $item)
                                            <tr>
                                                <td>{{ \App\Models\Indicators\Indicator\Indicator::FREQUENCIES[12][$item->period]}}</td>
                                                <td>{{ $item->old_value}}</td>
                                                <td>{{  $item->new_value }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            <x-form.modal.text id="goalRequestUser" label="{{ __('general.poa_request_user') }}"
                                               class="form-group col-6" readonly="readonly">
                            </x-form.modal.text>

                            @if($goalStatus != \App\Models\Poa\PoaIndicatorGoalChangeRequest::STATUS_OPEN)
                                <x-form.modal.text id="goalAnswerUser" label="{{ __('general.poa_answer_user') }}"
                                                   class="form-group col-6" readonly="readonly">
                                </x-form.modal.text>
                            @endif

                            <x-form.modal.textarea id="goalRequestJustification" label="{{ __('general.poa_request_justification') }}"
                                                   class="form-group col-12" readonly="readonly">
                            </x-form.modal.textarea>

                            @if($goalStatus != \App\Models\Poa\PoaIndicatorGoalChangeRequest::STATUS_OPEN)
                                <x-form.modal.textarea id="goalRequestAnswer"
                                                       label="{{ __('general.poa_request_answer') }}"
                                                       class="form-group col-12"
                                                       readonly="readonly">
                                </x-form.modal.textarea>
                            @else
                                <x-form.modal.textarea id="goalRequestAnswer"
                                                       label="{{ __('general.poa_request_answer') }}"
                                                       class="form-group col-12">
                                </x-form.modal.textarea>
                            @endif

                            <div class="d-flex align-items-center pl-6">
                                @if($request)
                                    <ul class="list-group list-group-files list-group-flush w-100">
                                        @foreach($request->media as $media)
                                            <li class="list-group-item d-flex align-items-center justify-content-between show-child-on-hover"
                                                wire:key="{{ $loop->index }}">
                                                <a href="#" wire:click="download({{ $media->id }})">{{ $media->filename }}</a>
                                                <span class="sr-only"></span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            @if($goalStatus == \App\Models\Poa\PoaIndicatorGoalChangeRequest::STATUS_OPEN && !$readOnly)
                                <div class="form-group col-12 pl-6 pt-4">
                                    <x-fileupload
                                            wire:model.defer="files"
                                            allowRevert
                                            allowRemove
                                            allowFileSizeValidation
                                            maxFileSize="4mb">
                                    </x-fileupload>
                                    <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('files',':message') }} </div>
                                </div>

                                <div class="form-group col-12 text-center">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input wire:model.defer="goalAnswer" type="radio"
                                               class="custom-control-input @error($goalAnswer) is-invalid @enderror"
                                               id="goalAnswerApproved" name="goalAnswer"
                                               value="APPROVED">
                                        <label class="custom-control-label" for="goalAnswerApproved">{{ __('general.poa_approved') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input wire:model.defer="goalAnswer" type="radio"
                                               class="custom-control-input @error($goalAnswer) is-invalid @enderror"
                                               id="golAnswerDenied" name="goalAnswer"
                                               value="DENIED">
                                        <label class="custom-control-label" for="golAnswerDenied">{{ __('general.poa_denied') }}</label>
                                    </div>
                                </div>
                            @else
                                @if($goalStatus)
                                    <div class="form-group col-12 text-center">
                                        <h3 class="modal-title font-weight-bold">
                                            <span class="badge fs-2x {{\App\Models\Poa\PoaIndicatorGoalChangeRequest::STATUS_BG[$goalStatus]}} badge-pill">{{ $goalStatus }}</span>
                                        </h3>
                                    </div>
                                @endif
                            @endif
                        </div>
                        @if(!$readOnly)
                            <div class="modal-footer justify-content-center">
                                @if($goalStatus == \App\Models\Poa\PoaIndicatorGoalChangeRequest::STATUS_OPEN)
                                    <x-form.modal.footer wirecancelevent="resetForm">
                                    </x-form.modal.footer>
                                @endif
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
