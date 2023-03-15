<div>
    <div
            x-data="{
                show: @entangle('show'),
                contribution: @entangle('contribution').defer
            }"
            x-init="$watch('show', value => {
            if (value) {
                $('#create-member-modal').modal('show')
            } else {
                $('#create-member-modal').modal('hide');
            }
        })"
            x-on:keydown.escape.window="show = false"
            x-on:close.stop="show = false"
    >

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 d-flex align-items-center mb-2">

                    <x-label-section>Equipo de Proyecto</x-label-section>

                    <button class="btn btn-sm btn-success ml-2 mr-2 mt-2" x-on:click="show = true">
                        <i class="fas fa-plus mr-1"></i>{{ trans('general.add_new') }}
                    </button>
                </div>
                <div class="col-md-4 text-right pr-4">
                    <button class="btn btn-primary btn-sm" wire:click="verifyVisibility"><i class="fas fa-list fa-lg"></i>
                    </button>
                    <button class="btn btn-primary btn-sm" wire:click="verifyVisibility"><i class="fas fa-th fa-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="w-100 d-block">
            <div class="modal fade" id="create-member-modal"
                 data-backdrop="static" data-keyboard="false"
                 tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary color-white">
                            <h3 class="modal-title">Adicionar Miembro al Proyecto</h3>
                            <button type="button" class="close" aria-label="Close" x-on:click="show = false">
                                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="w-50 mx-auto">
                                <div class="w-100">
                                    @if(!$idContact)
                                        <div>
                                            <h4>Buscar</h4>
                                            <div class="input-group bg-white mb-3">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                    <i class="fal fa-search"></i>
                                                </span>
                                                </div>
                                                <input type="text" class="form-control border-left-0 bg-transparent pl-0"
                                                       placeholder="Buscar por nombre..." wire:model="search">
                                            </div>
                                        </div>
                                        @foreach($users as $item)
                                            <div class="bg-gray-200 rounded cursor-pointer" wire:click="$set('idContact', {{ $item->id }})">
                                                <div class="d-flex align-items-center p-3 hover-bg">
                                            <span class="mr-3">
                                                @if (is_object($item->picture))
                                                    <img src="{{ Storage::url($item->picture->id) }}"
                                                         class="rounded-circle width-2" alt="{{ $item->getFullName() }}">
                                                @else
                                                    <img src="{{ asset_cdn("img/user.svg") }}"
                                                         class="rounded-circle width-2" alt="{{ $item->getFullName() }}">
                                                @endif
                                            </span>
                                                    <h5 class="my-0 fw-700">
                                                        {{ $item->getFullName() }}
                                                        <small class="text-muted mb-0">{{ $item->job_title }} en {{ $item->company->name ?? '' }}</small>
                                                    </h5>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                </div>

                                <div class="bg-gray-200 rounded">
                                    <div class="d-flex align-items-center p-3 mb-3">
                                        <span class="mr-3">
                                            @if (is_object($selectedContact->picture))
                                                <img src="{{ Storage::url($selectedContact->picture->id) }}"
                                                     class="rounded-circle width-2" alt="{{ $selectedContact->getFullName() }}">
                                            @else
                                                <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle width-2"
                                                     alt="{{ $selectedContact->getFullName() }}">
                                            @endif
                                        </span>
                                        <h5 class="my-0 fw-700">
                                            {{ $selectedContact->getFullName() }}
                                            <small class="text-muted mb-0">{{ $selectedContact->job_title }}
                                                en {{ $selectedContact->company->name ??''}}</small>
                                        </h5>
                                        <span class="text-danger ml-auto cursor-pointer" wire:click="remove"><i
                                                    class="fa fa-trash"></i></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label required" for="place">Lugar</label>
                                    <select wire:model.defer="place" id="place"
                                            class="form-control @error('place') is-invalid @enderror">
                                        <option selected value=""></option>
                                        @foreach($places[0]->details as $item)
                                            <option value="{{ $item->id }}">{{ $item->description }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">{{ $errors->first('place') }}</div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label required" for="role">Cargo en el Proyecto</label>
                                    <select wire:model.defer="role" id="role"
                                            class="form-control @error('role') is-invalid @enderror">
                                        <option selected value=""></option>
                                        @foreach($userRolesIds as $rol)
                                            <option value="{{ $rol['id']  }}">{{ $rol['name']  }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">{{ $errors->first('role') }}</div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label required" for="responsibilities">Responsabilidades</label>
                                    <textarea id="responsibilities" class="form-control @error('responsibilities') is-invalid @enderror"
                                              wire:model.defer="responsibilities"></textarea>
                                    <div class="invalid-feedback">{{ $errors->first('responsibilities') }}</div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label required" for="contribution">% de aporte al Proyecto</label>
                                    <input type="range" min="0" max="100" step="1" x-model="contribution"
                                           class="custom-range @error('contribution') is-invalid @enderror" id="contribution">
                                    <span class="help-block" x-text="contribution"></span>
                                    <div class="invalid-feedback">{{ $errors->first('contribution') }}</div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button x-on:click="show = false" type="button" class="btn btn-secondary waves-effect waves-themed">
                                {{ trans('general.cancel') }}
                            </button>
                            <button type="button" class="btn btn-primary waves-effect waves-themed" x-on:click="$wire.save()"
                                    @if(!$idContact) disabled @endif>
                                Adicionar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            @if($cardView)
                <div class="row">
                    @foreach($project->members as $item)
                        <div class="col-sm-12 col-md-6 col-xl-3">
                            <div class="card mb-g rounded-top">
                                <div class="row no-gutters row-grid">
                                    <div class="col-12">
                                        <div class="d-flex flex-column align-items-center justify-content-center p-4">
                                            @if (is_object($item->user->picture))
                                                <img src="{{ Storage::url($item->contact->picture->id) }}"
                                                     class="rounded-circle shadow-2 img-thumbnail w-50" alt="{{ $item->user->getFullName() }}">
                                            @else
                                                <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle shadow-2 img-thumbnail w-50"
                                                     alt="{{ $item->user->getFullName() }}">
                                            @endif
                                            <h5 class="mb-0 fw-700 text-center mt-3">
                                                {{ $item->user->getFullName() }}
                                                <small class="text-muted mb-0">{{ $item->role->name }}</small>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center py-3">
                                            <h5 class="mb-0 fw-700">
                                                60
                                                <small class="text-muted mb-0">Actividades/Tareas</small>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center py-3">
                                            <h5 class="mb-0 fw-700">
                                                {{ $item->contribution }}%
                                                <small class="text-muted mb-0">Aporte</small>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row">
                    <div class="col-12 pr-4">
                        <div class="card-body">
                            <table class="table m-0">
                                <thead>
                                <tr>
                                    <th style="vertical-align: middle !important;" scope="col" rowspan="2">N°</th>
                                    <th style="vertical-align: middle !important;" scope="col" rowspan="2">Cargo Dentro del
                                        Proyecto
                                    </th>
                                    <th style="vertical-align: middle !important;" scope="col" rowspan="2">Responsabilidades
                                    </th>
                                    <th style="vertical-align: middle !important;" scope="col" rowspan="2">Costo Patronal</th>
                                    <th style="vertical-align: middle !important;" scope="col" rowspan="2">% de aporte al
                                        proyecto
                                    </th>
                                    <th style="vertical-align: middle !important;" scope="col" rowspan="2">Costo Patronal
                                        Aplicable
                                    </th>
                                    <th style="vertical-align: middle !important;" scope="col" rowspan="2">Lugar(SC, JP o
                                        terreno)
                                    </th>
                                    <th style="vertical-align: middle !important;" scope="col" colspan="4">Perfil Profesional
                                    </th>
                                    <th style="vertical-align: middle !important;" scope="col" colspan="3">Contrato</th>
                                    <th style="vertical-align: middle !important;" scope="col" rowspan="2">Nombre</th>
                                    <th style="vertical-align: middle !important;" scope="col" rowspan="2">Acciones</th>
                                </tr>
                                <tr>
                                    <th style="vertical-align: middle !important;" scope="col">Titulo</th>
                                    <th style="vertical-align: middle !important;" scope="col">Experiencia</th>
                                    <th style="vertical-align: middle !important;" scope="col">Competencias</th>
                                    <th style="vertical-align: middle !important;" scope="col">Habilidades Personales</th>
                                    <th style="vertical-align: middle !important;" scope="col">Tipo</th>
                                    <th style="vertical-align: middle !important;" scope="col">Inicio</th>
                                    <th style="vertical-align: middle !important;" scope="col">Fin</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($project->members as $item)
                                    <tr>
                                        <th scope="row">{{ ++$loop->index }}</th>
                                        <td>{{ $item->role->description }}</td>
                                        <td>{{ $item->responsibilities }}</td>
                                        <td></td>
                                        <td>{{ $item->contribution }}%</td>
                                        <td></td>
                                        <td>{{ $item->place->description }}</td>
                                        <td>{{ $item->user->job_title }}</td>
                                        <td>{{ $item->user->work_experience }}</td>
                                        <td>
                                            <ul style="list-style:none; padding-left: 0px !important;">
                                                @if(isset($item->user->competencies))
                                                    @foreach($item->user->competencies as $competence)
                                                        <li>{{ $competence }}</li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </td>
                                        <td>
                                            <ul style="list-style:none; padding-left: 0px !important;">
                                                @if(isset($item->user->working_skills))
                                                    @foreach($item->user->working_skills as $skill)
                                                        <li>{{ $skill }}</li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </td>
                                        <td>{{ $item->user->contract_type }}</td>
                                        <td>{{ $item->user->contract_start }}</td>
                                        <td>{{ $item->user->contract_end }}</td>
                                        <td>{{ $item->user->getFullName() }}</td>
                                        <td class="text-center">
                                            @if($item->canBeDeleted())
                                                <button class="border-0 bg-transparent"
                                                        wire:click="$emit('teamDelete', '{{ $item->id }}')" data-toggle="tooltip"
                                                        data-placement="top" title="Eliminar"
                                                        data-original-title="Eliminar"><i class="fas fa-trash mr-1 text-danger"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@push('page_script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @this.on('teamDelete', id => {
            Swal.fire({
                title: '{{ trans('messages.warning.sure') }}',
                text: '{{ trans('messages.warning.delete') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--danger)',
                confirmButtonText: '<i class="fas fa-trash"></i> {{ trans('general.yes') . ', ' . trans('general.delete') }}',
                cancelButtonText: '<i class="fas fa-times"></i> {{ trans('general.no') . ', ' . trans('general.cancel') }}'
            }).then((result) => {
                if (result.value) {
                @this.call('delete', id);
                }
            });
        });
        })
    </script>
@endpush