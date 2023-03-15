<div>
    <div wire:ignore.self class="modal fade" id="project-files-communication" tabindex="-1" role="dialog"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 70rem;">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Archivos de Plan de Comunicaciones
                        de {{$communication->information_type ?? ''}} </h5>
                    <button type="button" wire:click="resetModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="panel-content">
                        @if($files)
                            <table class="table m-0">
                                <tr class="text-center">
                                    <th class="bold-h4"> Nombre</th>
                                    <th class="bold-h4"> Usuario</th>
                                    <th class="bold-h4"> Fecha</th>
                                </tr>
                                @foreach($files as $file)
                                    <tr class="text-center">
                                        <td>
                                            <a href="#" wire:click="download({{ $file['id'] }})">{{ $file['name'] }}
                                            </a>
                                        </td>
                                        <td>{{$file['user']?$file['user']['name'] : '-'}}</td>
                                        <td>{{$file['date']}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <x-empty-content>
                                <x-slot name="title">
                                    {{ trans('general.no_files') }}
                                </x-slot>
                            </x-empty-content>
                        @endif

                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="col-12">
                                <a class="btn btn-outline-secondary mr-1" type="button" wire:click="resetModal"
                                   class="close"
                                   data-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
