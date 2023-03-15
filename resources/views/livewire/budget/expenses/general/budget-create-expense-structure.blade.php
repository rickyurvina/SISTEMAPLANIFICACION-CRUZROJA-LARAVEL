<div>
    <div class="panel-container">
        <div class="panel-content">
            <div class="card">
                <div class="panel-tag">
                    <div class="d-flex flex-wrap">
                        <div class="p-3">
                            <x-label-section>{{trans('general.create')}} {{$nameAdd}}</x-label-section>
                        </div>
                    </div>
                </div>
                <div class="p-2">
                    @if($this->parentId)
                        <ol class="breadcrumb bg-transparent pl-0 pr-0 mb-0">
                            <li class="breadcrumb-item">
                                <a href="#">
                                    {{$nameProgram}} <i class="fas fa-arrow-alt-down"></i>
                                </a>
                            </li>
                            @if($nameAdd==trans('general.activity'))
                                <li class="breadcrumb-item active">
                                    <a href="#">
                                        {{$nameSubProgram}} <i class="fas fa-arrow-alt-down"></i>
                                    </a>
                                </li>
                            @endif
                        </ol>
                    @endif
                </div>
                <div class="w-100">
                    <div class="row">
                        <div class="col-6">
                            <x-form.modal.text id="code" label="{{ __('general.code') }}" class="form-group col-sm-12" required="required"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('general.code')]) }}">
                            </x-form.modal.text>

                            <x-form.modal.text id="name" label="{{ __('general.name').' '.$nameAdd }}" class="form-group col-sm-12" required="required"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('general.name')]) .' '.$nameAdd}}">
                            </x-form.modal.text>
                        </div>
                        @if($nameSubProgram)
                            <div class="col-6">
                                <div class="" wire:ignore wire:key="field-{{ $nameSubProgram }}">
                                    <div class="mb-1">
                                        <x-label-detail>Unidad Responsable</x-label-detail>
                                    </div>
                                    <div class="detail">
                                        <select class="form-control select2-hidden-accessible" id="select-responsible">
                                            @foreach($deparments as $item)
                                                <option value="{{ $item->id }}" {{$responsibleUnit==$item->id ? 'selected':''}}>
                                                    {{ $item->parent ? $item->parent->name . '/' . $item->name : $item->name .' / ' .$item->company->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-4" wire:ignore wire:key="field-{{ $nameSubProgram }}">
                                    <div class="mb-1">
                                        <x-label-detail>Unidad Ejecutora</x-label-detail>
                                    </div>
                                    <div class="detail">
                                        <select class="form-control select2-hidden-accessible" id="select-executor">
                                            @foreach($deparments as $item)
                                                <option value="{{ $item->id }}" {{$executingUnit==$item->id ? 'selected':''}}>
                                                    {{ $item->parent ? $item->parent->name . '/' . $item->name : $item->name .' / ' .$item->company->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="col-12 mt-2 mb-2">
                        <button class="btn btn-success" type="button" id="button-addon2" wire:click="save">
                            <i class="fa fa-plus mr2"></i> {{trans('general.save')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('page_script')
    <script>
        window.addEventListener('loadAreas', event => {
            $('#select-responsible').select2({
                placeholder: "{{ trans('general.select') }}"
            }).on('change', function (e) {
            @this.set('responsibleUnit', $(this).val());

            });

            $('#select-executor').select2({
                placeholder: "{{ trans('general.select') }}"
            }).on('change', function (e) {
            @this.set('executingUnit', $(this).val());
            });
        });
    </script>
@endpush