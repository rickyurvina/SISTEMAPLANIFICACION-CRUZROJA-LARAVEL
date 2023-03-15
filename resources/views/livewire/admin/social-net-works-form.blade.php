<div wire:ignore.self class="tab-pane fade" id="social_profiles" role="tabpanel">
    <br>
    <div class="d-flex position-relative ml-auto w-100">
        <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                data-target="#add_social_network_modal" wire:click="open()">
            <i class="fas fa-share-alt mr-1"></i>
            {{ trans('general.title.add', ['type' => trans('general.social_network')] ) }}
        </button>
    </div>
    <br>
    @if (count($social_networks))
    {{-- <x-search route="{{ route('companies.edit',$company) }}"/> --}}
    <div class="card-header pr-2 d-flex align-items-center flex-wrap">
        <div class="d-flex position-relative ml-auto w-100">
            <i class="fal fa-search position-absolute pos-left fs-lg px-3 py-2 mt-1"></i>
            <input type="text" id="searchSocialProfile" name="search" value="{{ request()->get('search', '') }}" class="form-control bg-subtlelight pl-6"
                   placeholder="{{ trans('general.search_placeholder') }}">
        </div>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table table-hover m-0">
            <thead class="bg-primary-50">
            <tr>
                <th class="d-none">@sortablelink('id', trans('general.id'))</th>
                <th>@sortablelink('type', trans('general.type'))</th>
                <th>@sortablelink('url', trans('general.url'))</th>
                <th>@sortablelink('created_at', trans('general.created'))</th>
                <th>@sortablelink('enabled', trans('general.enabled'))</th>
                @can('admin-crud-admin')
                <th class="text-center color-primary-500">{{ trans('general.actions') }}</th>
                @endcan
            </tr>
            </thead>
            <tbody id="socailProfileTable">
            @foreach($social_networks as $item)
                <tr>
                    <th class="d-none">{{ $item->id }}</th>
                    <th>{{ $item->catalog->description }}</th>
                    <td><a href="{{ $item->url }}" target="_blank">{{ $item->url }}</a></td>
                    <td>@date($item->created_at)</td>
                    <td>
                        @if ($item->enabled)
                            <badge rounded type="success" class="mw-60">{{ trans('general.yes') }}</badge>
                        @else
                            <badge rounded type="danger" class="mw-60">{{ trans('general.no') }}</badge>
                        @endif
                    </td>
                    @can('admin-crud-admin')
                    <td class="text-center w-20">
                        <a class="" data-toggle="modal" data-target="#edit_social_network_modal"
                            wire:click="edit({{ $item->id }})">
                            <i class="fas fa-pencil mr-1 text-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></i>
                        </a>
                        <a class="mr-2" wire:click="delete({{ $item->id }})" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar">
                            <i class="fas fa-trash mr-1 text-danger"></i>
                        </a>
                    </td>
                    @endcan
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
        <x-empty-content>
            <x-slot name="title">
                {{ trans('general.no_social_network_found') }}
            </x-slot>
        </x-empty-content>
    @endif
    <x-pagination :items="$social_networks"/>

    <div wire:ignore.self class="modal fade in" id="add_social_network_modal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">{{ trans('general.add_new') }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="far fa-times"></i></span>
                    </button>
                </div>
                <form wire:submit.prevent="submit" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12 required">
                                        <label class="form-label"
                                               for="url">{{ trans('general.url').' '.trans('general.social_network') }}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="fas fa-link"></i>
                                            </span>
                                            </div>
                                            <input type="text" wire:model="url"
                                                   class="form-control bg-transparent @error('url') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.url').' '.trans('general.social_network')]) }}">
                                            <div class="invalid-feedback">{{ $errors->first('url') }}</div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 required">
                                        <label class="form-label"
                                               for="type">{{ trans('general.type').' '.trans('general.social_network') }}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="fas fa-share-alt"></i>
                                            </span>
                                            </div>
                                            <select wire:model="type"
                                                    class="custom-select bg-transparent @error('type') is-invalid @enderror">
                                                <option value=""
                                                        selected>{{ trans('general.form.select.field', ['field' => trans('general.type').' '.trans('general.social_network')]) }}</option>
                                                @foreach($social_network_types as $social_network_type)
                                                    <option value="{{ $social_network_type->id }}">{{ $social_network_type->description }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">{{ $errors->first('type') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="cancel">
                            <i class="far fa-times pr-2"></i> {{ trans('general.cancel') }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade in" id="edit_social_network_modal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">{{ trans('general.edit') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:white"><i class="far fa-times"></i></span>
                    </button>
                </div>
                <form wire:submit.prevent="update" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12 required">
                                        <label class="form-label"
                                               for="url">{{ trans('general.url').' '.trans('general.social_network') }}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="fas fa-link"></i>
                                            </span>
                                            </div>
                                            <input type="text" wire:model="url"
                                                   class="form-control bg-transparent @error('url') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.url').' '.trans('general.social_network')]) }}">
                                            <div class="invalid-feedback">{{ $errors->first('url') }}</div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 required">
                                        <label class="form-label"
                                               for="type">{{ trans('general.type').' '.trans('general.social_network') }}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="fas fa-share-alt"></i>
                                            </span>
                                            </div>
                                            <select wire:model="type"
                                                    class="custom-select bg-transparent @error('type') is-invalid @enderror">
                                                <option value=""
                                                        selected>{{ trans('general.form.select.field', ['field' => trans('general.type').' '.trans('general.social_network')]) }}</option>
                                                @foreach($social_network_types as $social_network_type)
                                                    <option value="{{ $social_network_type->id }}">{{ $social_network_type->description }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">{{ $errors->first('type') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cancel" data-dismiss="modal">
                            <i class="far fa-times pr-2"></i> {{ trans('general.cancel') }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@push('page_script')
    <script>
        $(document).ready(function(){
            $("#searchSocialProfile").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#socailProfileTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endpush

