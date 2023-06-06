<x-label-detail>Planificación de Metas</x-label-detail>
<div class="form-group col-lg-12 required">
    <div class="input-group d-flex flex-row  bg-white shadow-inset-2">
        @foreach($task->goals as $goal)
            <div class="p-2">
                <x-form.inputs.text type="number" name="goals[]"
                                    label="{{$goal->period->format('M,Y')}}"
                                    id="goals[]"
                                    wire:model.defer="goals.{{ $goal->id  }}"
                                    value="{{$goal->goal??0}}"/>
            </div>
        @endforeach
    </div>
    <div class="w-30 mx-auto">
        <div class="d-flex justify-content-center">
            <x-label-detail>{{ trans('general.total') }}</x-label-detail>
            <x-content-detail>{{ array_sum(array_column($this->goals,'goal')) }}</x-content-detail>
        </div>
    </div>
    <div class="text-center p-2">
        <button wire:click="updateGoals()"
                class="btn btn-success">
            <i class="fas fa-trash-alt pr-2"></i> {{ trans('general.save') }}
        </button>
    </div>
</div>