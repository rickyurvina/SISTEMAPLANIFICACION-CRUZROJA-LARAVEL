<div>
    <div wire:ignore.self class="modal fade" id="project-check-send-communication" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 70rem;">
            @if($communication)
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Enviar Informacion a {{$communication->stakeholder->interested->getFullName()}}</h5>
                        <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="panel-content">
                            <div class="frame-wrap">
                                <div class="d-flex flex-row">
{{--                                    <div class="w-25">--}}
{{--                                        @foreach($reports as $index => $item)--}}
{{--                                            <div class="custom-control custom-radio">--}}
{{--                                                <input type="radio" class="custom-control-input" id="{{$item}}" name="defaultExampleRadios" wire:model="reportSelected" value="{{$item}}">--}}
{{--                                                <label class="custom-control-label" for="{{$item}}">{{$item}}</label>--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                    @if($viewUploadFile)--}}
                                        <div class="w-100">
                                            <div wire:ignore.self>
                                                <div class="d-flex align-items-center">
                                                    <span class="fs-2x w-40px"><i class="fal fa-paperclip"></i></span>
                                                    <span class="fs-2x fw-700">{{trans('general.attachments_files')}}</span>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-12 pl-6 pt-4">
                                                        <x-fileupload
                                                                wire:model.defer="file"
                                                                allowRevert
                                                                allowRemove
                                                                allowFileSizeValidation
                                                                maxFileSize="4mb"></x-fileupload>
                                                        @error('file')
                                                        <div class="alert alert-danger fade show" role="alert">
                                                            {{__('general.file_required')}}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row ml-2">
                                                    <div class="form-group  col-12">
                                                        <label class="form-label"
                                                               for="observation">{{ trans('general.observations') }}</label>
                                                        <textarea wire:model.defer="observation" rows="1" id="observations"
                                                                  class="form-control bg-transparent @error($observation) is-invalid @enderror"></textarea>
                                                        <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('observation',':message') }} </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
{{--                                    @endif--}}
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="justify-content-center">
                        <div class="card-footer text-center">
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-outline-secondary mr-1" wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                                    </a>
                                    <button wire:click="save" class="btn btn-primary">
                                        <i class="fas fa-save pr-2"></i> {{ trans('general.send') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
