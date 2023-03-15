<div>
    <form wire:submit.prevent="submitGoals()" method="post" autocomplete="off">
        <div class="d-flex flex-wrap">
            @foreach($goals as $index => $item)
                <div class="d-flex flex-wrap align-items-center justify-content-between w-30 mr-2">
                    <div class="form-group     @if($indicatorUnit->is_for_people===true) w-33 @else w-50 @endif pr-1">
                        <label class="form-label fw-700" for="goals.{{ $loop->index }}.goal">{{ $item['monthName'] }}</label>
                        <input type="number" min="0" id="goals.{{ $loop->index }}.goal" class="form-control" placeholder="Planificado" value="{{$item['goal']}}"
                               wire:model.lazy="goals.{{$loop->index}}.goal" @if($readOnlyGoal) readonly="readonly" @endif>
                        <span class="help-block">
                           Planificado.
                        </span>
                    </div>
                    @if($indicatorUnit->is_for_people===true)
                        <div class="form-group w-33 pr-1 mb-0">
                            <input type="number" min="0" id="goals.{{ $loop->index }}.actual"
                                   class="form-control"
                                   placeholder="Hombres" value="{{$item['men']}}"
                                   wire:model.lazy="goals.{{$loop->index}}.men" @if($readOnlyProgress) readonly="readonly" @endif >
                            <span class="help-block">
                                   Hombres
                             </span>
                        </div>
                        <div class="form-group w-33">
                            <input type="number" min="0" id="goals.{{ $loop->index }}.actual"
                                   class="form-control"
                                   placeholder="Mujeres" value="{{$item['women']}}"
                                   wire:model.lazy="goals.{{$loop->index}}.women" @if($readOnlyProgress) readonly="readonly" @endif >
                            <span class="help-block">
                                   Mujeres
                             </span>
                        </div>
                    @else
                        <div class="form-group w-50">
                            <input type="number" min="0" id="goals.{{ $loop->index }}.actual"
                                   class="form-control"
                                   placeholder="Ejecutado" value="{{$item['actual']}}"
                                   wire:model.lazy="goals.{{$loop->index}}.actual" @if($readOnlyProgress) readonly="readonly" @endif >
                            <span class="help-block">
                                   Ejecutado.
                             </span>
                        </div>
                    @endif
                </div>
            @endforeach
            @if ($errors->count()>0)
                @foreach ($errors->all() as $error)
                    <div class="w-100">
                        <div class="alert alert-danger w-33">
                            {{$error}}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="d-flex flex-wrap w-100 text-xl-center">
            <div class="mx-auto d-flex">
                <div class="d-flex justify-content-start w-50">
                    <x-label-detail>{{ trans('general.goal') .': '. $this->total }}</x-label-detail>
                </div>
                <div class="d-flex justify-content-center w-50">
                    <x-label-detail>{{ trans('general.progress').': '. $this->progress }}</x-label-detail>
                </div>
            </div>
        </div>
        @if (!$activity->program->poa->isClosed())
            <div class="card-footer text-muted py-2 text-center">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                </button>
            </div>
        @endif
    </form>
</div>
