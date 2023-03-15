<div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex position-relative ml-auto w-100">
                <i class="spinner-border spinner-border-sm position-absolute pos-left mx-3" style="margin-top: 0.75rem"
                   wire:target="search" wire:loading></i>
                <i class="fal fa-search position-absolute pos-left fs-lg mx-3" style="margin-top: 0.75rem"
                   wire:loading.remove></i>
                <input type="text" wire:model.debounce.300ms="search" class="form-control bg-subtlelight pl-6"
                       placeholder="Buscar por Nombre del Producto...">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table m-0">
                <thead class="bg-primary-50">
                <tr>
                    <th>@sortablelink('code', trans('general.code') )</th>
                    <th>@sortablelink('name', trans('general.name') )</th>
                    <th>{{ trans('general.description') }}</th>
                    <th>{{ trans('general.unit_price') }}</th>
                    @can('project-crud-project')
                    <th class="text-center color-primary-500">Acciones</th>
                    @endcan
                </tr>
                </thead>
                <tbody>
                @foreach($public_purchases as $item)
                    <tr>

                        <td>
                            <livewire:components.input-inline-edit :modelId="$item->id"
                                                                   class="\App\Models\Common\CatalogPurchase"
                                                                   field="code"
                                                       defaultValue="{{$item->code}}"
                                                       :key="time().$item->id"/>
              </td>
              <td>
                <livewire:components.input-inline-edit :modelId="$item->id"
                                                       class="\App\Models\Common\CatalogPurchase"
                                                       field="name"
                                                       defaultValue="{{$item->name}}"
                                                       :key="time().$item->id"/>
              </td>
              <td>
                <livewire:components.input-inline-edit :modelId="$item->id"
                                                       class="\App\Models\Common\CatalogPurchase"
                                                       field="description"
                                                       defaultValue="{{$item->description}}"
                                                       :key="time().$item->id"/>

              </td>
              <td>
                <livewire:components.input-inline-edit :modelId="$item->id"
                                                       class="\App\Models\Common\CatalogPurchase"
                                                       field="unit_price"
                                                       defaultValue="{{$item->unit_price}}"
                                                       :key="time().$item->id"/>
              </td>
              @can('project-crud-project')
              <td class="text-center">
                <button class="border-0 bg-transparent" wire:click="$emit('shoppingDelete', '{{ $item->id }}')" data-toggle="tooltip"
                        data-placement="top" title="Eliminar"
                        data-original-title="Eliminar"><i class="fas fa-trash mr-1 text-danger"></i></button>

              </td>
              @endcan
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      <x-pagination :items="$public_purchases"/>
  </div>

  @push('page_script')
        <script>
            Livewire.on('togglePublicPurchaseAddModal', () => $('#add_public_purchases_modal').modal('toggle'));
            document.addEventListener('DOMContentLoaded', function () {

            @this.on('shoppingDelete', id => {
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
</div>
