<div>
    <div class="d-flex flex-column">
        <div class="d-flex flex-nowrap">
            <div class="flex-grow-1 w-100" style="overflow: hidden auto">
                <div class="mb-2">
                    <div class="pl-2">
                        <div>
                            <x-label-section><i class="fal fa-ball-pile text-primary"></i> Estructura</x-label-section>
                        </div>
                        <div class="content-detail">
                            <div class="d-flex flex-wrap mt-2">
                                <x-label-detail>Filial Responsable</x-label-detail>
                                <x-content-detail> {{ $subsidiary }}</x-content-detail>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap mt-2" wire:ignore>
                            <x-label-detail>Juntas Ejecutoras:</x-label-detail>
                            <div class="detail ml-2">
                                <select class="form-control select2-hidden-accessible" multiple="" id="select-subsidiary">
                                    @foreach($subsidiaries as $item)
                                        <option value="{{ $item->id }}" {{ in_array($item->id, $subsidiariesAux) ? 'selected' : '' }}>
                                            @if($item->parent)
                                                {{ $item->parent->level > 1 ? $item->parent->name . '/' . $item->name : $item->name }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap mt-2" >
                            <x-label-detail>Áreas Ejecutoras:</x-label-detail>
                            <div class="detail ml-2">
                                <select class="form-control select2-hidden-accessible" multiple="" id="select-areas">
                                    @foreach($executorAreas as $item)
                                        <option value="{{ $item->id }}" {{ in_array($item->id, $executorAreasAux) ? 'selected' : '' }}>
                                            {{ $item->parent ? $item->parent->name . '/' . $item->name : $item->name .' / ' .$item->company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('page_script')
    <script>
        $(document).ready(function () {
            $('#select-subsidiary').select2({
                placeholder: "{{ trans('general.select') }}"
            }).on('change', function (e) {
            @this.set('subsidiariesSelect', $(this).val());
            });

            $('#select-areas').select2({
                placeholder: "{{ trans('general.select') }}"
            }).on('change', function (e) {
            @this.set('executorAreasSelect', $(this).val());
            });
        });
        window.addEventListener('loadAreas', event => {
            $('#select-areas').select2({
                placeholder: "{{ trans('general.select') }}"
            }).on('change', function (e) {
            @this.set('executorAreasSelect', $(this).val());
            });
        });
    </script>
@endpush