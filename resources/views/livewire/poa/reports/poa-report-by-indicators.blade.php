<div>
    <div class="d-flex flex-wrap mb-2">
        @include('modules.poa.reports.goals.report-header')
    </div>
    @if($selectProvinces!=null)
        @include('modules.poa.reports.goals.report-by-indicators')
    @else
        @include('modules.poa.reports.goals.report-by-activities')
    @endif
    <div wire:ignore>
        <livewire:poa.reports.poa-show-activity/>
    </div>
</div>
@push('page_script')
    <script>
        Livewire.on('toggleShowModal', () => $('#poa-show-activity-modal').modal('toggle'));
        Livewire.on('toggleDropDownFilter', () => $("#dropdown-filter").removeClass("show"));
    </script>
@endpush