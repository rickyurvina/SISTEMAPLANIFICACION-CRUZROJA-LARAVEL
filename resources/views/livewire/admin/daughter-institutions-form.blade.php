<div class="tab-pane fade" id="daughter_institutions" role="tabpanel">
    <br>
    @if(count($companies))
    {{-- <x-search route="{{ route('companies.edit',$company) }}"/> --}}
    <div class="card-header pr-2 d-flex align-items-center flex-wrap">
        <div class="d-flex position-relative ml-auto w-100">
            <i class="fal fa-search position-absolute pos-left fs-lg px-3 py-2 mt-1"></i>
            <input type="text" id="searchDaughterInst" name="search" value="{{ request()->get('search', '') }}" class="form-control bg-subtlelight pl-6"
                   placeholder="{{ trans('general.search_placeholder') }}">
        </div>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table table-hover m-0">
            <thead class="bg-primary-50">
            <tr>
                <th class="d-none">@sortablelink('id', trans('general.id'))</th>
                <th>@sortablelink('level', trans('general.level'))</th>
                <th>@sortablelink('name', trans('general.name'))</th>
                <th>@sortablelink('identification', trans('general.ruc'))</th>
                <th>@sortablelink('created_at', trans('general.created'))</th>
                <th>@sortablelink('enabled', trans('general.enabled'))</th>
            </tr>
            </thead>
            <tbody id="daughterInstTable">
            @foreach($companies as $item)
                <tr>
                    <th class="d-none"></th>
                    <th>{{ $item->level }}</th>
                    <td><a href="{{ route('companies.edit', $item->id) }}">{{ $item->name }}</a></td>
                    <td>{{ $item->identification }}</td>
                    <td>@date($item->created_at)</td>
                    <td>
                        @if ($item->enabled)
                            <badge rounded type="success" class="mw-60">{{ trans('general.yes') }}</badge>
                        @else
                            <badge rounded type="danger" class="mw-60">{{ trans('general.no') }}</badge>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
        <x-empty-content>
            <x-slot name="title">
                {{ trans('general.no_daughter_institutions_found') }}
            </x-slot>
        </x-empty-content>
    @endif
</div>
@push('page_script')
    <script>
        $(document).ready(function(){
            $("#searchDaughterInst").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#daughterInstTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endpush