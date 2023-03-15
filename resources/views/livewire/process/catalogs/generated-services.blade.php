<div>
    <div class="card">
        <div class="table-responsive">
            <table class="table m-0" id="table_units">
                <thead class="bg-primary-50">
                <tr>
                    <th> {{trans('general.code')}}</th>
                    <th>{{trans('general.name')}}</th>
                    <th>{{trans('general.description')}} </th>
                    <th class="text-center color-primary-500">{{ trans('general.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($generated_services as $item)
                    <tr wire:key="{{time().$item->id}}" wire:ignore>
                        <td>
                            <livewire:components.input-inline-edit :modelId="$item->id"
                                                                   class="\App\Models\Process\Catalogs\GeneratedService"
                                                                   field="code"
                                                                   :rules="'required|max:5|alpha_num|alpha_dash|unique:generated_services,code'"
                                                                   type="text"
                                                                   defaultValue="{{ $item->code ?? ''}}"
                                                                   :key="time().$item->id"/>
                        </td>
                        <td>
                            <livewire:components.input-inline-edit :modelId="$item->id"
                                                                   class="\App\Models\Process\Catalogs\GeneratedService"
                                                                   field="name"
                                                                   :rules="'required|max:200'"
                                                                   type="text"
                                                                   defaultValue="{{ $item->name ?? ''}}"
                                                                   :key="time().$item->id"/>
                        </td>
                        <td>
                            <livewire:components.input-inline-edit :modelId="$item->id"
                                                                   class="\App\Models\Process\Catalogs\GeneratedService"
                                                                   field="description"
                                                                   :rules="'required|max:500'"
                                                                   type="textarea"
                                                                   rows="5"
                                                                   defaultValue="{{ $item->description ?? ''}}"
                                                                   :key="time().$item->id"/>
                        </td>
                        <td class="text-center">
                            <x-delete-link-livewire id="{{ $item->id }}"/>
{{--                            <x-delete-link action="{{ route('generated_services.destroy', $item->id) }}"--}}
{{--                                           id="{{ $item->id }}"/>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div>
    <livewire:process.catalogs.create-generated-service/>
</div>
@push('page_script')
    <script>
        function deleteModel(id) {
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
        }
    </script>
@endpush