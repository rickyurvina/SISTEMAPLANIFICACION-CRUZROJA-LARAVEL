<div>
    @include('livewire.indicators.resgisterAdvance')
    <div class="card">
        <x-search route="{{ route('indicators.index') }}"/>
        <div class="table-responsive">
            <table class="table m-0">
                <thead class="bg-primary-50">
                <tr>
                    <th>@sortablelink('code', trans('general.code'))</th>
                    <th>@sortablelink('name', trans('general.name'))</th>
                    <th>@sortablelink('user_id', trans('general.responsible'))</th>
                    <th>@sortablelink('category', trans('general.category'))</th>
                    <th>@sortablelink('state', trans('general.state'))</th>
                    <th>@sortablelink('period_advance', trans('general.period_advance'))</th>
                    <th>@sortablelink('updated_at', trans('general.updated_at'))</th>
                    @can('admin-crud-admin')
                    <th class="text-center color-primary-500">{{ trans('general.actions') }}</th>
                    @endcan
                </tr>
                </thead>
                <tbody>
                @foreach($indicators as $item)
                    <tr>
                        <td><a href="javascript:void(0);" aria-expanded="false" wire:click="$emitTo('indicators.indicator-show', 'open', {{ $item->id }})">{{ $item->code }}</a>
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->category }}</td>
                        <td>
                            <span class="form-label badge {{$item->getStateIndicator()[0]?? null}}  badge-pill">{{$item->getStateIndicator()[1]?? null}}</span>
                        </td>
                        <td>{{ $item->progressIndicator()>0 ?  $item->progressIndicator() : '0.00'}}</td>
                        <td>{{ $item->updated_at }}</td>
                        @can('admin-crud-admin')
                        <td class="text-center w-20">
                            <form action="{{ route('indicators.destroy', $item->id) }}" method="POST">

                                <a href="javascript:void(0);" class="mr-2" aria-expanded="false" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"
                                    wire:click="$emitTo('indicators.indicator-edit', 'open', {{ $item->id }})"> <i
                                            class="fas fa-edit mr-1 text-info"></i>
                                </a>
                                @if($item->isParent())
                                    <a href="javascript:void(0);" class="mr-2" wire:click="registerAdvance({{ $item->id }})" data-toggle="modal"
                                        data-target="#registerAdvance"><i
                                                class="fas fa-check-circle mr-1 text-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Registrar avance"></i>
                                    </a>
                                @endif
                                @csrf
                                @method('DELETE')
                                    <button class="border-0" type="submit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"><i class="fas fa-trash mr-1 text-danger"></i></button>
                            </form>
                        </td>
                        @endcan
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <x-pagination :items="$indicators"/>
    </div>

    <div wire:ignore>
        <livewire:indicators.indicator-edit/>

        <div class="modal fade fade" id="indicator-show-modal" tabindex="-1" style="display: none;" role="dialog" aria-hidden="true">
            <livewire:indicators.indicator-show/>
        </div>
    </div>


</div>
@push('page_script')
    <script>

        Livewire.on('toggleIndicatorShowModal', () => $('#indicator-show-modal').modal('toggle'));

        Livewire.on('toggleIndicatorEditModal', () => $('#indicator-edit-modal').modal('toggle'));

    </script>
@endpush