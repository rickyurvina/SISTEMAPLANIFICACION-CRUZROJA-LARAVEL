@props(['id', 'class' => 'delete', 'dismiss' => 'modal', 'functionOnclick' => 'deleteModel'])

<button type="button"
        id="model-{{ $id }}-{{ $class }}"
        class="btn btn-link {{ $class }}"
        data-model="{{ $id }}"
        data-dismiss="{{ $dismiss }}"
        onclick="{{$functionOnclick}}({{ $id }})">
    <i class="fas fa-trash mr-1 text-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"
       data-original-title="Eliminar"></i>
</button>