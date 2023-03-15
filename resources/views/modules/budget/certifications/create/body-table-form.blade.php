<tr class="tr-hover">
    <td><span class="badge {{$item->is_new ? 'badge-warning' : '' }}  badge-pill fs-1x fw-700">{{ $item->code }} {{$item->name}}</span></td>
    <td>{{ $item->name }}</td>
    <td>{{ $item->description }}</td>
    <td>{{ $item->balance }} </td>
    <td>
        <div class="w-100 content-read-active">
            <input class="w-100 border-0 fw-400" type="number" wire:model.lazy="certificationsValues.{{$item->id}}">
        </div>
        @error('certificationsValues.'.$item->id)
        <div style="color: #fd3995" class="fs-1x fw-700">{{ $message }}</div>
        @enderror
    </td>
</tr>