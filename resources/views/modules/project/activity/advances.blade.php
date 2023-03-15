<div class="form-group col-lg-12 required">
    <div class="d-flex flex-wrap">
        <div class="d-flex w-100">
            <div class="card w-100">
                <div class="table-responsive">
                    <table class="table  m-0">
                        <thead class="bg-primary-50">
                        <tr>
                            <th class="w-10">
                                {{trans('general.date')}}
                            </th>
                            <th class="w-10">
                                {{trans('general.goal')}}
                            </th>
                            @if($indicator)
                                @if($indicator->unit->is_for_people)
                                    <th class="w-10">
                                        {{trans_choice('general.men',1)}}
                                    </th>
                                    <th class="w-10">
                                        {{trans_choice('general.women',1)}}
                                    </th>
                                    <th class="w-10">
                                        {{trans('general.advance')}}
                                    </th>
                                @else
                                    <th class="w-10">
                                        {{trans('general.advance')}}
                                    </th>
                                @endif
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($goals as $index => $goal)
                            <tr wire:key="{{time().$index.$goal['id']}}" wire:ignore>
                                <td>{{$goal['period']}}</td>
                                <td>
                                    {{$goal['goal']}}
                                </td>
                                @if($indicator)

                                    @if($indicator->unit->is_for_people)
                                        <td>
                                            {{$goal['men']}}
                                        </td>
                                        <td>
                                            {{$goal['women']}}
                                        </td>
                                        <td>
                                            {{$goal['actual']}}
                                        </td>
                                    @else
                                        <td>
                                            {{$goal['actual']}}
                                        </td>
                                    @endif
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <hr>
        <div class="d-flex w-100 m-4">
            <x-label-section>Escoger periodo para registrar avance</x-label-section>
        </div>
        <div class="d-flex w-100 mt-2">
            <div class="d-flex w-50">
                <x-label-detail>Periodo</x-label-detail>
                <div class="detail">
                    <select class="form-control" id="example-select"
                            wire:model="period">
                        <option value="">Escoger Periodo</option>
                        @foreach($goals as $goal)
                            <option value="{{$goal['id']}}">{{$goal['period']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex w-50">
                <x-label-detail>Sumar Avance</x-label-detail>
                @if($indicator)
                    <div class="detail">
                        @if($indicator->unit->is_for_people)
                            <div class="d-flex flex-wrap align-items-center justify-content-between ml-2">
                                <div class="form-group w-50 pr-1 mb-0">
                                    <input type="number" class="form-control  @error($advance) is-invalid @enderror"
                                           name="advanceMen" id="advanceMen"
                                           wire:model.defer="advanceMen"> <span class="help-block">
                                   Hombres
                             </span>
                                    @error('advanceMen')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group w-50">
                                    <input type="number" class="form-control  @error($advance) is-invalid @enderror"
                                           name="advanceWomen" id="advanceWomen"
                                           wire:model.defer="advanceWomen">
                                    <span class="help-block">
                                   Mujeres
                             </span>
                                    @error('advanceWomen')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @else
                            <input type="number" class="form-control  @error($advance) is-invalid @enderror"
                                   name="advance" id="advance"
                                   wire:model.defer="advance">
                        @endif
                        @error('advance')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if($taskDetail)
        <div class="w-100 mt-2" wire:key="{{time().$taskDetail->id}}">
            <div class="mt-2">
                <livewire:components.files :modelId="$taskDetail->id"
                                           model="{{\App\Models\Measure\MeasureAdvances::class}}"
                                           :key="time().$taskDetail->id"
                                           folder="measureAdvances"/>
            </div>
            <div class="mt-2">
                <x-label-section>{{ trans('general.comments') }}</x-label-section>
                <livewire:components.comments :modelId="$taskDetail->id"
                                              class="{{\App\Models\Measure\MeasureAdvances::class}}"
                                              :key="time().$taskDetail->id"
                                              identifier="measureAdvances"/>
            </div>
        </div>
        <div class="text-center p-2">
            <button wire:click="updateProgress()"
                    class="btn btn-success ">
                <i class="fas fa-save btn-xs pr-2"></i>
                Registrar Avance
            </button>
        </div>
    @endif
</div>
