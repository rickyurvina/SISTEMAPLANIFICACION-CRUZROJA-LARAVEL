<div>
    <div wire:ignore.self class="modal fade" id="poa_charge_excel" tabindex="-1" role="dialog" aria-hidden="true"
         data-backdrop="static" data-keyboard="false"
         style="height: 100%;">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div wire:ignore class="modal-header bg-primary text-white">
                    <h5 class="modal-title">{{ trans('general.poa_activity_piat_report_modal') }}</h5>
                    <button type="button" data-dismiss="modal" class="close text-white" aria-label="Close" wire:click="resetModal">
                        <span aria-hidden="true"><i class="far fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <form method="post" enctype='multipart/form-data' wire:submit.prevent="getCsvFile()"
                              id="upload-file">
                            <div class="row">
                                <div class="form-group col-12 pl-6 pt-4">
                                    <x-fileupload wire:model.defer="file"
                                                  allowRevert
                                                  allowRemove
                                                  allowFileSizeValidation
                                                  maxFileSize="4mb"></x-fileupload>
                                    @error('file')
                                    <div class="alert alert-danger fade show" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-12" wire:loading wire:target="getCsvFile">
                                    <div class="demo">
                                        <button class="btn btn-danger rounded-pill waves-effect waves-themed ml-auto" type="button" disabled="">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Subiendo información...No cierre esta ventana mientras se carga el archivo...
                                        </button>
                                    </div>
                                </div>
                                @if($errorsExceptions)
                                    <div class="col-12 text-center ml-4 mr-4">
                                        <x-label-section>
                                            <strong class="bg-red-cre text-center">{{$errorsExceptions}}</strong>
                                        </x-label-section>
                                    </div>
                                @endif
                                @if(isset($errorsListExcel) && $errorsListExcel)
                                    <div class="col-12 text-center ml-4 mr-4">
                                        <x-label-section>
                                            <strong class="bg-red-cre text-center"> Lista de errores al cargar el archivo</strong>

                                        </x-label-section>
                                    </div>
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover m-0">
                                                <thead class="bg-primary-50">
                                                <tr>
                                                    <th>{{ trans('general.row') }}</th>
                                                    <th>{{ trans('general.column') }}</th>
                                                    <th>{{ trans('general.errors') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($errorsListExcel as $fail)
                                                    @if(is_object($fail))
                                                        <tr>
                                                            <td>{{ $fail->row() }}</td>
                                                            <td>{{ $fail->attribute() }}</td>
                                                            <td>
                                                                <ul>
                                                                    @foreach($fail->errors() as $e)
                                                                        <li>
                                                                            {{ $e }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="modal-footer justify-content-center">
                                <x-form.modal.footer data-dismiss="modal"></x-form.modal.footer>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>