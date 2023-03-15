<div>
    @include('modules.poa.reports.objectives.header')
    <div class="row">
        @if($selectProvinces!=null && $poaFinded==true)
            @include('modules.poa.reports.objectives.by-province')
        @else
            @forelse($poaSelected as $year => $poa)
                @include('modules.poa.reports.objectives.self-company')
            @empty
                <div class="text-center col-12">
                    <x-empty-content>
                        <x-slot name="img">
                            <img src="{{ asset_cdn("img/no_info.png") }}" width="auto" height="auto" alt="No Info">
                        </x-slot>
                    </x-empty-content>
                </div>
            @endforelse
        @endif
    </div>
</div>
