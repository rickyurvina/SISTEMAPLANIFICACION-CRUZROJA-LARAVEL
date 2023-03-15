<div>
    <div class="d-flex flex-column">
        <div class="d-flex flex-nowrap">
            <div class="flex-grow-1 w-100" style="overflow: hidden auto">
                <div class="pl-2 content-detail">
                    <div class="d-flex flex-wrap w-100">
                        <x-label-detail>Nombre</x-label-detail>
                        <div class="detail">
                            <livewire:components.input-text :modelId="$project->id"
                                                            class="\App\Models\Projects\Project"
                                                            field="name"
                                                            defaultValue="{{$project->name}}"/>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap w-100 mt-2">
                        <x-label-detail>{{trans('general.start_date')}}</x-label-detail>
                        <div class="detail">
                            <livewire:components.date-inline-edit :modelId="$project->id"
                                                                  class="\App\Models\Projects\Project"
                                                                  field="start_date" type="date"
                                                                  defaultValue="{{$project->start_date ? $project->start_date->format('Y M d'): 'Seleccione Fecha'}}"
                                                                  :key="time().$project->id"
                            />
                        </div>
                    </div>
                    <div class="d-flex flex-wrap w-100 mt-2">
                        <x-label-detail>{{trans('general.end_date')}}</x-label-detail>
                        <div class="detail">
                            <livewire:components.date-inline-edit :modelId="$project->id"
                                                                  class="\App\Models\Projects\Project"
                                                                  field="end_date" type="date"
                                                                  defaultValue="{{$project->end_date ? $project->end_date->format('Y M d'): 'Seleccione Fecha'}}"
                                                                  :key="time().$project->id"/>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap w-100 mt-2" wire:ignore>
                        <x-label-detail>Financiadores</x-label-detail>
                        <div class="detail">
                            <select class="form-control" multiple="multiple" id="select2-founders">
                                @if($founders)
                                    @foreach($founders as $item)
                                        <option value="{{ $item->id }}" {{ in_array($item->id, $this->auxFounders) ? 'selected':'' }}>{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap w-100 mt-2" wire:ignore>
                        <x-label-detail>Cooperantes</x-label-detail>
                        <div class="detail">
                            <select class="form-control" multiple="multiple" id="select2-cooperators">
                                @if($cooperators)
                                    @foreach($cooperators as $item)
                                        <option value="{{ $item->id }}" {{ in_array($item->id, $this->auxCooperators) ? 'selected':'' }}>{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap w-100 mt-2" wire:ignore.self>
                        <x-label-detail>{{ trans('general.poa_activity_location') }}</x-label-detail>
                        <div class="detail">
                            <div class="d-flex frame-wrap mt-1">
{{--                                <div class="demo mr-2 mt-2">--}}
{{--                                    <div class="custom-control custom-radio custom-control-inline">--}}
{{--                                        <input type="radio" class="custom-control-input" id="province" name="location" value="PROVINCE" wire:model="selectLocation">--}}
{{--                                        <label class="custom-control-label" for="province">{{trans('general.province')}}</label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <select class="form-control" multiple="multiple" id="select2-location">
                                    @forelse($location as $item)
                                        @if($this->auxLocations)
                                            <option value="{{ $item->id }}" {{ in_array($item->id, $this->auxLocations) ? 'selected':'' }}>{{ $item->getPath() }}</option>
                                        @else
                                            <option value="{{ $item->id }}">{{ $item->getPath() }}</option>
                                        @endif
                                    @empty
                                        <option>Seleccione nivel</option>
                                    @endforelse
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap w-100 mt-2" wire:ignore>
                        <x-label-detail>Plazo: {{$resultTimeEstimated}}-Meses</x-label-detail>
                        <div class="detail">
                            <div class="row">
                                <div class="col-4">
                                    <x-label-detail>{{trans('general.years')}}</x-label-detail>
                                    <select class="custom-select @error('years') is-invalid @enderror" id="years" name="years" wire:model="years">
                                        <option value="0">{{ trans('general.years') }}</option>
                                        @for($j=1;$j<=5;$j++)
                                            <option value="{{$j}}">{{ $j }}-Años</option>
                                        @endfor
                                    </select></div>
                                <div class="col-4">
                                    <x-label-detail>{{trans('general.months')}}</x-label-detail>
                                    <select class="custom-select @error('months') is-invalid @enderror" id="months" name="months" wire:model="months">
                                        <option value="0">{{ trans('general.months') }}</option>
                                        @for($i=1;$i<=48;$i++)
                                            <option value="{{$i}}">{{ $i }}-Meses</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-4">
                                    <x-label-detail>{{trans('general.weeks')}}</x-label-detail>
                                    <select class="custom-select @error('weeks') is-invalid @enderror" id="weeks" name="weeks" wire:model="weeks">
                                        <option value="0">{{ trans('general.weeks') }}</option>
                                        @for($i=1;$i<=40;$i++)
                                            <option value="{{$i}}">{{ $i }}-Semanas</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-nowrap">
            <div class="flex-grow-1 w-100" style="overflow: hidden auto; ">
                <div class="pl-2 content-detail">
                    <livewire:projects.formulation.general-information.project-members-formulation :project="$project" :messages="$messagesList"/>
                </div>
            </div>
        </div>
        <hr>
        <div class="d-flex flex-nowrap">
            <div class="flex-grow-1 w-50" style="overflow: hidden auto">
                <x-label-section>{{ trans('general.comments') }}</x-label-section>
                <livewire:components.comments :modelId="$project->id" class="\App\Models\Projects\Project" identifier="general_data"
                                              :key="time().$project->id"/>
            </div>
            <div class="flex-grow-1 w-50" style="overflow: hidden auto">
                <livewire:projects.files.project-files :project="$project" identifier="general_data"/>
            </div>
        </div>
    </div>
</div>


@push('page_script')
    <script>

        $(document).ready(function () {

            $('#select2-founders').select2({
                placeholder: "{{ trans('general.select').' '.trans_choice('general.funder',2) }}"
            }).on('change', function (e) {
            @this.set('foundersSelect', $(this).val());
            });

            $('#select2-cooperators').select2({
                placeholder: "{{ trans('general.select').' '.trans('general.assistant') }}"
            }).on('change', function (e) {
            @this.set('cooperatorsSelect', $(this).val());
            });

            $('#select-areas').select2({
                placeholder: "{{ trans('general.select') }}"
            }).on('change', function (e) {
            @this.set('executorAreasSelect', $(this).val());
            });

            $('#select2-location').select2({
                placeholder: "{{ trans('general.select') }}"
            }).on('change', function (e) {
            @this.set('locationsSelect', $(this).val());
            });

            window.addEventListener('showLocations', event => {

                $('#select2-location').select2({
                    placeholder: "{{ trans('general.select') }}"
                }).on('change', function (e) {
                @this.set('locationsSelect', $(this).val());
                });


            });

            document.addEventListener('livewire:load', function (event) {
            @this.on('showLocations', function () {
                $('#select2-location').select2({
                    placeholder: "{{ trans('general.select') }}"
                }).on('change', function (e) {
                @this.set('locationsSelect', $(this).val());
                });
            });
            })

        });
    </script>
@endpush