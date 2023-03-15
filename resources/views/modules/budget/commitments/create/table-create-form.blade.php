<div class="table-responsive">
    <table class="table table-light table-hover">
        <thead>
        <tr>
            <th class="table-th w-20">{{trans('general.item')}}</th>
            <th class="table-th w-30"> {{trans('general.name')}}</th>
            <th class="table-th w-30"> {{trans('general.description')}}</th>
            <th class="table-th w-10">Por comprometer</th>
            <th class="table-th w-10"><a href="#">{{  trans('general.value') }} a {{trans_choice('general.commitments',1)}}</a></th>
        </tr>
        </thead>
        <tbody>
        @foreach($accounts as $item)
            <tr class="tr-hover">
                <td>
                    <span class="badge {{$item->is_new ? 'badge-warning' : '' }}  badge-pill fs-1x fw-700">{{ $item->code }} {{$item->name}}</span>
                </td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->getCertifiedValues($this->certification->id) }} </td>
                <td>
                    <div class="w-100 content-read-active">
                        <input class="w-100 border-0 fw-400" type="number"
                               wire:model.lazy="commitmentsValues.{{$item->id}}">
                    </div>
                    @error('commitmentsValues.'.$item->id)
                    <div style="color: #fd3995" class="fs-1x fw-700">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
