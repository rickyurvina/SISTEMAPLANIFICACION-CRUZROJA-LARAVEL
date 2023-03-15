<div wire:ignore.self class="tab-pane fade" id="addresses" role="tabpanel">
    <br>
    <div class="d-flex position-relative ml-auto w-100">
        <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                data-target="#add_address_modal">
            <i class="fas fa-map-marked-alt mr-1"></i>
            {{ trans('general.title.add', ['type' => trans_choice('general.address', 1)] ) }}
        </button>
    </div>
    <br>
    @if (count($addresses))
    {{-- <x-search route="{{ route('companies.edit',$company) }}"/> --}}
    <div class="card-header pr-2 d-flex align-items-center flex-wrap">
        <div class="d-flex position-relative ml-auto w-100">
            <i class="fal fa-search position-absolute pos-left fs-lg px-3 py-2 mt-1"></i>
            <input type="text" id="searchAddresses" name="search" value="{{ request()->get('search', '') }}" class="form-control bg-subtlelight pl-6"
                   placeholder="{{ trans('general.search_placeholder') }}">
        </div>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table table-hover m-0">
            <thead class="bg-primary-50">
            <tr>
                <th class="d-none">@sortablelink('id', trans('general.id'))</th>
                <th>@sortablelink('country', trans('general.country'))</th>
                <th>@sortablelink('province', trans('general.province'))</th>
                <th>@sortablelink('city', trans('general.city'))</th>
                <th>@sortablelink('street_one', trans('general.street_one'))</th>
                <th>@sortablelink('street_two', trans('general.street_two'))</th>
                <th>@sortablelink('number', trans('general.number'))</th>
                <th>@sortablelink('created_at', trans('general.created'))</th>
                <th>@sortablelink('enabled', trans('general.enabled'))</th>
                @can('admin-crud-admin')
                <th class="text-center color-primary-500">{{ trans('general.actions') }}</th>
                @endcan
            </tr>
            </thead>
            <tbody id="addressesTable">
            @foreach($addresses as $item)
                <tr>
                    <th class="d-none">{{ $item->id }}</th>
                    <th>{{ $item->country }}</th>
                    <td>{{ $item->province }}</td>
                    <td>{{ $item->city }}</td>
                    <td>{{ $item->street_one }}</td>
                    <td>{{ $item->street_two }}</td>
                    <td>{{ $item->number }}</td>
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
                        <a class="mr-2" wire:click="delete({{ $item->id }})" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar">
                            <i class="fas fa-trash mr-1 text-danger"></i>
                        </a>
                        <a  class="mr-2" data-toggle="modal" data-target="#edit_address_modal"
                            wire:click="edit({{ $item->id }})">
                            <i class="fas fa-pencil mr-1 text-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></i>
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
                {{ trans('general.no_addresses_found') }}
            </x-slot>
        </x-empty-content>
    @endif
    <x-pagination :items="$addresses"/>

    <div wire:ignore.self class="modal fade" id="add_address_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
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
                                    <div class="form-group col-md-6 required">
                                        <label class="form-label" for="country">{{ trans('general.country') }}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-right-0">
                                    <i class="fas fa-user"></i>
                                </span>
                                            </div>
                                            <input type="text" wire:model="country"
                                                   class="form-control bg-transparent @error('country') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.country')]) }}">
                                            <div class="invalid-feedback">{{ $errors->first('country') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 required">
                                        <label class="form-label" for="province">{{ trans('general.province') }}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                            </div>
                                            <input type="text" wire:model="province"
                                                   class="form-control bg-transparent @error('province') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.province')]) }}">
                                            <div class="invalid-feedback">{{ $errors->first('province') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 required">
                                        <label class="form-label" for="city">{{ trans('general.city') }}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-phone-alt"></i>
                                    </span>
                                            </div>
                                            <input type="text" wire:model="city"
                                                   class="form-control bg-transparent @error('city') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.city')]) }}">
                                            <div class="invalid-feedback">{{ $errors->first('city') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 required">
                                        <label class="form-label"
                                               for="streetOne">{{ trans('general.street_one') }}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-fax"></i>
                                    </span>
                                            </div>
                                            <input type="text" wire:model="streetOne"
                                                   class="form-control bg-transparent @error('streetOne') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.street_one')])}}">
                                            <div class="invalid-feedback">{{ $errors->first('streetOne') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label"
                                               for="streetTwo">{{ trans('general.street_two')}}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-fax"></i>
                                    </span>
                                            </div>
                                            <input type="text" wire:model="streetTwo"
                                                   class="form-control bg-transparent @error('streetTwo') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.street_two')])}}">
                                            <div class="invalid-feedback">{{ $errors->first('streetTwo') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label"
                                               for="streetThree">{{ trans('general.street_three')}}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-fax"></i>
                                    </span>
                                            </div>
                                            <input type="text" wire:model="streetThree"
                                                   class="form-control bg-transparent @error('streetThree') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.street_three')])}}">
                                            <div class="invalid-feedback">{{ $errors->first('streetThree') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="number">{{ trans('general.number')}}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-fax"></i>
                                    </span>
                                            </div>
                                            <input type="text" wire:model="number"
                                                   class="form-control bg-transparent @error('number') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.number')])}}">
                                            <div class="invalid-feedback">{{ $errors->first('number') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label"
                                               for="postalCode">{{ trans('general.postal_code')}}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-fax"></i>
                                    </span>
                                            </div>
                                            <input type="text" wire:model="postalCode"
                                                   class="form-control bg-transparent @error('postalCode') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.postal_code')])}}">
                                            <div class="invalid-feedback">{{ $errors->first('postalCode') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="latitude">{{ trans('general.latitude')}}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-fax"></i>
                                    </span>
                                            </div>
                                            <input type="text" wire:model="latitude"
                                                   class="form-control bg-transparent @error('latitude') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.latitude')])}}">
                                            <div class="invalid-feedback">{{ $errors->first('latitude') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="longitud">{{ trans('general.longitude')}}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-fax"></i>
                                    </span>
                                            </div>
                                            <input type="text" wire:model="longitude"
                                                   class="form-control bg-transparent @error('longitude') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.longitude')])}}">
                                            <div class="invalid-feedback">{{ $errors->first('longitude') }}</div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i
                                    class="fas fa-times"></i> {{ trans('general.cancel') }}</button>
                        <button class="btn btn-primary">
                            <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="edit_address_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">{{ trans('general.edit') }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="far fa-times"></i></span>
                    </button>
                </div>
                <form wire:submit.prevent="update" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6 required">
                                        <label class="form-label" for="country">{{ trans('general.country') }}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-right-0">
                                    <i class="fas fa-user"></i>
                                </span>
                                            </div>
                                            <input type="text" wire:model="country"
                                                   class="form-control bg-transparent @error('country') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.country')]) }}">
                                            <div class="invalid-feedback">{{ $errors->first('country') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 required">
                                        <label class="form-label" for="province">{{ trans('general.province') }}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                            </div>
                                            <input type="text" wire:model="province"
                                                   class="form-control bg-transparent @error('province') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.province')]) }}">
                                            <div class="invalid-feedback">{{ $errors->first('province') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 required">
                                        <label class="form-label" for="city">{{ trans('general.city') }}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-phone-alt"></i>
                                    </span>
                                            </div>
                                            <input type="text" wire:model="city"
                                                   class="form-control bg-transparent @error('city') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.city')]) }}">
                                            <div class="invalid-feedback">{{ $errors->first('city') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 required">
                                        <label class="form-label"
                                               for="streetOne">{{ trans('general.street_one') }}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-fax"></i>
                                    </span>
                                            </div>
                                            <input type="text" wire:model="streetOne"
                                                   class="form-control bg-transparent @error('streetOne') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.street_one')])}}">
                                            <div class="invalid-feedback">{{ $errors->first('streetOne') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label"
                                               for="streetTwo">{{ trans('general.street_two')}}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-fax"></i>
                                    </span>
                                            </div>
                                            <input type="text" wire:model="streetTwo"
                                                   class="form-control bg-transparent @error('streetTwo') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.street_two')])}}">
                                            <div class="invalid-feedback">{{ $errors->first('streetTwo') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label"
                                               for="streetThree">{{ trans('general.street_three')}}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-fax"></i>
                                    </span>
                                            </div>
                                            <input type="text" wire:model="streetThree"
                                                   class="form-control bg-transparent @error('streetThree') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.street_three')])}}">
                                            <div class="invalid-feedback">{{ $errors->first('streetThree') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="number">{{ trans('general.number')}}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-fax"></i>
                                    </span>
                                            </div>
                                            <input type="text" wire:model="number"
                                                   class="form-control bg-transparent @error('number') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.number')])}}">
                                            <div class="invalid-feedback">{{ $errors->first('number') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label"
                                               for="postalCode">{{ trans('general.postal_code')}}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-fax"></i>
                                    </span>
                                            </div>
                                            <input type="text" wire:model="postalCode"
                                                   class="form-control bg-transparent @error('postalCode') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.postal_code')])}}">
                                            <div class="invalid-feedback">{{ $errors->first('postalCode') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="latitude">{{ trans('general.latitude')}}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-fax"></i>
                                    </span>
                                            </div>
                                            <input type="text" wire:model="latitude"
                                                   class="form-control bg-transparent @error('latitude') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.latitude')])}}">
                                            <div class="invalid-feedback">{{ $errors->first('latitude') }}</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="longitud">{{ trans('general.longitude')}}</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fas fa-fax"></i>
                                    </span>
                                            </div>
                                            <input type="text" wire:model="longitude"
                                                   class="form-control bg-transparent @error('longitude') is-invalid @enderror"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.longitude')])}}">
                                            <div class="invalid-feedback">{{ $errors->first('longitude') }}</div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click="cancel"
                                data-dismiss="modal"><i
                                    class="fas fa-times"></i> {{ trans('general.cancel') }}</button>
                        <button class="btn btn-primary">
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
            $("#searchAddresses").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#addressesTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endpush

