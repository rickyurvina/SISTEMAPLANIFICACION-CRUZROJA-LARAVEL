<div class="w-80 text-center">

    @if(!$existPlanActived && !$existsPoaConfigured )
        <div class="row">
            <div class="col-12">
                <table class="table m-0">
                    <thead>
                    <tr>
                        <th>{{ __('general.file_name') }}</th>
                        <th>{{ __('general.observations') }}</th>
                        <th>{{ __('general.state') }}</th>
                        <th>{{ __('general.date') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($filesEdit as $item)
                        <tr>
                            <td>
                                <a href="#" wire:click="download({{ $item['id'] }})">
                                    {{ $item['name'] }}
                                </a>
                            </td>
                            <td>{{ $item['observation'] }}</td>
                            <td>{{ __('general.'. $item['identifier']) }}</td>

                            <td>{{ $item['date'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($plan && $plan->status <> \App\Models\Strategy\Plan::ARCHIVED)
            <div class="d-flex align-items-center">
                <span class="fs-2x w-40px"><i class="fal fa-paperclip"></i></span>
                <span class="fs-2x fw-700">Archivos adjuntos</span>
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

                <div class="form-group text-left required col-6">
                    <label class="form-label"
                           for="filecoments">{{ trans('general.observations') }}</label>
                    <textarea wire:model.defer="observation" rows="3" id="filecoments" class="form-control bg-transparent
                        @error('observation') is-invalid @enderror"></textarea>
                    <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('observation',':message') }} </div>
                </div>
                <div class="col-6 text-center">
                    @switch($oldStatus)
                        @case(\App\Models\Strategy\Plan::DRAFT)
                        <button wire:click="updateStatus" class="btn btn-success mt-3">
                            <i class="fas fa-save pr-2"></i> Activar
                        </button>
                        @break
                        @case(\App\Models\Strategy\Plan::ACTIVE)
                        <button wire:click="updateStatus" class="btn btn-danger mt-3">
                            <i class="fas fa-save pr-2"></i> Archivar
                        </button>
                        @break
                    @endswitch
                </div>
            </div>

        @endif
    @else
        <X-label-detail>{{$existPlanActived?'Ya existe un plan Activado ':''}}{{$existsPoaConfigured?' POAs Asociados':''}}</X-label-detail>
    @endif
</div>
